<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Models\Logics;
use App\Http\Utils\UploadHelper;
use Carbon\Carbon;
use App\Http\Models\Logics\BoatUserLogic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Session;
use App\Http\Models\Logics\BoatCreditLogic;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class AccountController extends Controller
{
    public function myCharterListing(Request $request)
    {
        // dd($request);
        $data['boatList'] = $this->getAllBoatsByStatus('y');
        // dd($data);
        $data['filterData'] = [
            'from_date' => $request->input('from_date'),
            'to_date' => $request->input('to_date'),
            'boat_id' => $request->input('boat_id'),
            'status' => $request->input('status'),
        ];
        // dd($data);
        $data['bookData'] = $this->getCharterList(
            $data['filterData']['boat_id'],
            $data['filterData']['from_date'],
            $data['filterData']['to_date'],
            $data['filterData']['status']
        )->appends(['page']);
        // dd($data);
        $data['bookStatus'] = $this->getCharterListStatus();
        // dd($data);

        return view('others.my-bookings', $data);
    }

    public function getAllBoatsByStatus($status)
    {
            $query = DB::table('boat_tbl_boat')
            ->select(
                'boat_tbl_boat.boat_id',
                'boat_name',
            )
            ->join('boat_tbl_category', 'boat_tbl_category.category_id', '=', 'boat_tbl_boat.boat_type')
            ->where('boat_tbl_boat.status', $status)
            ->orderBy('boat_tbl_boat.add_date', 'DESC')
            ->groupBy('boat_id')
            ->get();



        return $query;
    }

    public function getCharterListStatus()
    {
        $query = DB::table('boat_charter_book')
            ->select(
                'boat_charter_book.status'
            )
            ->join('boat_tbl_book_timing', 'boat_charter_book.book_id', '=', 'boat_tbl_book_timing.booked_id')
            ->leftJoin('boat_user', 'boat_user.user_id', '=', 'boat_charter_book.user_id')
            ->leftJoin('boat_comment', function ($join) {
                $join->on('comment_from', '=', DB::raw(Auth::id()));
                $join->on('invoice', '=', 'boat_charter_book.book_id');
                $join->on('boat_comment.boat_id', '=', 'boat_charter_book.boat_id');
            })
            ->leftJoin('boat_tbl_boat', 'boat_tbl_boat.boat_id', '=', 'boat_charter_book.boat_id')
            ->groupBy('book_id');

        $query = $query->where('boat_charter_book.user_id', Auth::id())
            ->orderBy('boat_charter_book.book_id', 'desc');
        $result = $query->get();
        $status = [
            0 => $result->sum(function ($row) {
                if ($row->status === 0)
                    return 1;
                return 0;
            }),
            1 => $result->sum(function ($row) {
                if ($row->status === 1)
                    return 1;
                return 0;
            }),
            2 => $result->sum(function ($row) {
                if ($row->status !== 0 && $row->status !== 1 && $row->status !== 3)
                    return 1;
                return 0;
            }),
            3 => $result->sum(function ($row) {
                if ($row->status == 3)
                    return 1;
                return 0;
            }),
        ];

        return $status;
    }

    public function getCharterList($boatId = null, $fromDate = null, $toDate = null, $status = null)
    {
        $query = DB::table('boat_charter_book')
            ->select(
                DB::raw('distinct(boat_charter_book.book_id)'),
                'boat_charter_book.boat_id',
                'boat_charter_book.total_price',
                'boat_charter_book.add_date as book_add_date',
                'boat_charter_book.status',
                'boat_charter_book.membership_id',
                'boat_charter_book.discount_type',
                'boat_charter_book.discount_price',
                'boat_charter_book.credit_id',
                'boat_charter_book.currency',
                'boat_charter_book.country',
                'boat_tbl_book_timing.id as timing_id',
                'boat_tbl_book_timing.time_from',
                'boat_tbl_book_timing.time_to',
                'boat_tbl_book_timing.date_book',
                'boat_tbl_book_timing.add_date',
                'user_address',
                'user_country',
                'rate',
                'boat_name',
                'boat_comment.comment',
                'boat_comment.rate as comment_rate'
            )
            ->join('boat_tbl_book_timing', 'boat_charter_book.book_id', '=', 'boat_tbl_book_timing.booked_id')
            ->leftJoin('boat_user', 'boat_user.user_id', '=', 'boat_charter_book.user_id')
            ->leftJoin('boat_comment', function ($join) {
                $join->on('boat_comment.comment_from', '=', DB::raw(Auth::id()));
                $join->on('boat_comment.invoice', '=', 'boat_charter_book.book_id');
                $join->on('boat_comment.boat_id', '=', 'boat_charter_book.boat_id');
            })
            ->leftJoin('boat_tbl_boat', 'boat_tbl_boat.boat_id', '=', 'boat_charter_book.boat_id')
            ->groupBy('book_id');

        if (!empty($boatId)) {
            $query = $query->where('boat_charter_book.boat_id', '=', $boatId);
        }

        if (!empty($fromDate) && !empty($toDate)) {
            try {
                $fromDate = Carbon::createFromFormat('m/d/Y', $fromDate);
                $toDate = Carbon::createFromFormat('m/d/Y', $toDate);
                $query = $query->whereBetween('date_book', [$fromDate, $toDate]);
            } catch (\Exception $e) {
            }
            ;
        }

        if (!empty($status)) {
            $query = $query->where('boat_charter_book.status', '=', $status);
        }

        $query = $query->where('boat_charter_book.user_id', Auth::id())
            ->orderBy('boat_charter_book.book_id', 'desc');
        return $query->paginate(25);
    }


    function myCreditsListing(Request $request)
    {


        $boatCreditLogic = new Logics\BoatCreditLogic();

        $filterData['from_date'] = $request->input('from_date');
        $filterData['to_date'] = $request->input('to_date');

        $data = $boatCreditLogic->getAllCredits($filterData);



        return view('others.my-credits')->with('bookData', $data)->with('filterData', $filterData);
    }
    function myCreditsDetails($id)
    {

        $data = DB::table('boat_user_credits_history')->where('credit_id', $id)->where('user_id', Auth::id())->orderby('cid_his')->paginate(15);
        $exp_date = DB::table('boat_user_credits')->where('credit_id', $id)->pluck('expiry_date')->first();
        $data = [
            'bookData' => $data,
            'id' => $id,
            'exp_date' => $exp_date
        ];

        return view('others.credits-details')->with($data);
    }
    public function myBoats(Request $request)
    {
        // $boatLogic = new Logics\BoatLogic();
        // $boatCategoryTmaLogic = new Logics\BoatCategoryTmaLogic();
        // $boatMarinasLogic = new Logics\BoatMarinasLogic();

        $data['filterData'] = [
            'boat_name' => $request->input('boat_name'),
            'marina' => $request->input('marina'),
            'boat_type' => $request->input('boat_type'),
            'start_with' => $request->input('start_with'),
            'status' => $request->input('status'),
        ];
        // $data['boats'] = $boatLogic->getMyBoats(
        //     $data['filterData']['boat_name'],
        //     $data['filterData']['marina'],
        //     $data['filterData']['boat_type'],
        //     $data['filterData']['status'],
        //     $data['filterData']['start_with']
        // )->appends(Input::except('page'));


        $query = DB::table('boat_tbl_boat')
            ->select(
                'boat_tbl_boat.boat_id',
                'boat_tbl_boat.boat_name',
                'boat_tbl_boat.country',
                'boat_tbl_boat.main_photo',
                'boat_tbl_boat.status',
                'boat_tbl_boat.add_date',
                'boat_tbl_boat.date_updated',
                'boat_tbl_category_tma.category_name',
                'boat_marinas.marinas_name'
            )
            ->leftJoin('boat_tbl_category_tma', 'boat_tbl_category_tma.category_id', '=', 'boat_tbl_boat.boat_type_tma')
            ->leftJoin('boat_marinas', 'boat_marinas.marinas_id', '=', 'boat_tbl_boat.marina')
            ->where('user_id', '=', Auth::user()->user_id);

        if (!empty($data['filterData']['boat_name'])) {
            $query = $query->where('boat_name', 'like', '%' . $data['filterData']['boat_name'] . '%');
        }

        if (!empty($data['filterData']['marina'])) {
            $query = $query->where('marina', '=', $data['filterData']['marina']);
        }

        if (!empty($data['filterData']['boat_type'])) {
            $query = $query->where('boat_type_tma', '=', $data['filterData']['boat_type']);
        }

        if (!empty($data['filterData']['status'])) {
            $query = $query->where('status', '=', $data['filterData']['status']);
        }

        if (!empty($data['filterData']['start_with'])) {
            $query = $query->where('boat_name', 'like', $data['filterData']['start_with'] . '%');
        }


        $query = $query->orderBy('boat_id', 'desc');
        // dd($query);
        $data['boats'] = $query->paginate()->appends($request->input('page'));
        // dd($query->get());


        // $data['marinas'] = $boatMarinasLogic->getMarinasByStatus('y');/
        $data['marinas'] = DB::table('boat_marinas')
            ->where('marinas_status', '=', 'y')
            ->orderBy('marinas_name', 'asc')
            ->get();
        // $data['categories'] = $boatCategoryTmaLogic->getAllBoatCategoryTma();
        $sql = DB::select("SELECT * FROM boat_tbl_category_tma");
        $data['categories'] = collect($sql)->toArray();
        // $data['boatStatus'] = $boatLogic->getMyBoatStatus();
        $query = DB::table('boat_tbl_boat')
            ->select(
                'status',
                DB::raw('count(boat_id) as count')
            )
            ->groupBy('status')
            ->where('user_id', '=', Auth::id());

        $result = $query->get();
        $status = [
            'y' => 0,
            'n' => 0,
            'p' => 0
        ];

        $result->each(function ($row) use (&$status) {
            $status[$row->status] = $row->count;
        });

        $data['boatStatus'] = $status;
        // dd($data);

        return view('others/my-boats', $data);
    }

    public function LoginWithId($user_id)
    {


        // $boatUserLogic = new BoatUserLogic();
        // $ifuser = $boatUserLogic->getUserData($user_id);
        $ifuser = DB::select("SELECT bu.* FROM boat_user bu WHERE bu.user_id = ".$user_id);
        $ifuser = json_decode(json_encode($ifuser), true);

        if (!empty($ifuser)) {
            try {
                //dd($ifuser[0]['user_email']);

                $credentials = [
                    'user_email' => $ifuser[0]['user_email'],
                    'password' => base64_decode($ifuser[0]['user_password']),
                ];
                if (Auth::attempt($credentials, true)) {
                    DB::table('boat_user_loginlog')->insert([
                        'user_email' => $ifuser[0]['user_email'],
                        'last_login' => date('Y-m-d')
                    ]);

                    $boatCommentLogic = new \App\Http\Models\Logics\BoatCommentLogic();
                    $notComment = $boatCommentLogic->getNotComment();

                    Session::put('adminlogin', 'yes');

                    return redirect('/search/boat');
                }
            } catch (\Exception $e) {

                echo 'Caught exception: ', $e->getMessage(), "\n";
            }
        } else {
            return redirect('/');
        }
    }

    public function deleteMyBoats(Request $request)
    {
        $boatIds = $request->input('boatIds');
        if (!is_array($boatIds) || empty($boatIds)) {
            return ['success' => false];
        }

        $boatLogic = new Logics\BoatLogic();
        $boatLogic->deleteBoatsById($boatIds);
        return ['success' => true];
    }

    public function addBoatPage()
    {
        // $boatCountryLogic = new Logics\BoatCountryLogic();
        // $boatMarinasLogic = new Logics\BoatMarinasLogic();
        // $boatCategoryTmaLogic = new Logics\BoatCategoryTmaLogic();

        // $data['countries'] = $boatCountryLogic->getAllCountry();
        $data['countries'] = DB::table('boat_country')->get()->toArray();
        $data['countries'] = json_decode(json_encode($data['countries']), true);
        // $data['marinas'] = $boatMarinasLogic->getMarinasByStatus('y');
        $data['marinas'] = DB::table('boat_marinas')->where('marinas_status', '=', 'y')->orderBy('marinas_name', 'asc')->get();
        ;
        // $data['categories'] = $boatCategoryTmaLogic->getAllBoatCategoryTma();
        $data['categories'] = DB::table("boat_tbl_category_tma")->get()->toArray();
        $data['categories'] = json_decode(json_encode($data['categories']), true);

        // dd($data);
        return view('others.add-boat', $data);
    }

    public function addBoat(Request $request)
    {
        $boatData = $request->input('boatData');
        $filteredBoatData = array_filter($boatData, function ($key) {
            return in_array($key, [
                'boat_name',
                'boat_reg',
                'mmsi',
                'insurance_no',
                'insurar',
                'insurance_exp',
                'last_inspection',
                'next_inspection',
                'country',
                'boat_type_tma',
                'marina',
                'fuel_type',
                'fuel_consumption',
                'pax',
                'manage',
                'party',
                'fishing',
                'wakeboarding',
                'cruising',
                'vhf',
                'fishfinder',
                'gps',
                'aircon',
                'head',
                'engine_type',
                'self_drive',
                'no_engine',
                'beam',
                'length',
                'year_create',
                'other',
                'last_maintain',
                'last_engine_hour',
                'boat_details',
                'boatnote',
            ]);
        }, ARRAY_FILTER_USE_KEY);
        $filteredBoatData['user_id'] = Auth::id();
        $filteredBoatData['add_date'] = Carbon::now()->toDateString();

        // Process file
        if ($request->hasFile('contractpaper')) {
            $filteredBoatData['contractpaper'] = UploadHelper::uploadFile($request->file('contractpaper'), 'pdf')['fileName'];
        }

        if ($request->hasFile('contractpdf')) {
            $filteredBoatData['contractpdf'] = UploadHelper::uploadFile($request->file('contractpdf'), 'pdf')['fileName'];
        }

        if ($request->hasFile('contractpdf1')) {
            $filteredBoatData['contractpdf1'] = UploadHelper::uploadFile($request->file('contractpdf1'), 'pdf')['fileName'];
        }

        if ($request->hasFile('contractpdf2')) {
            $filteredBoatData['contractpdf2'] = UploadHelper::uploadFile($request->file('contractpdf2'), 'pdf')['fileName'];
        }

        if ($request->hasFile('main_photo')) {
            $filteredBoatData['main_photo'] = UploadHelper::uploadFile($request->file('main_photo'), 'images/product')['fileName'];
        }

        if ($request->hasFile('photo1')) {
            $filteredBoatData['photo1'] = UploadHelper::uploadFile($request->file('photo1'), 'images/product')['fileName'];
        }

        if ($request->hasFile('photo2')) {
            $filteredBoatData['photo2'] = UploadHelper::uploadFile($request->file('photo2'), 'images/product')['fileName'];
        }

        if ($request->hasFile('photo3')) {
            $filteredBoatData['photo3'] = UploadHelper::uploadFile($request->file('photo3'), 'images/product')['fileName'];
        }

        if ($request->hasFile('photo4')) {
            $filteredBoatData['photo4'] = UploadHelper::uploadFile($request->file('photo4'), 'images/product')['fileName'];
        }

        if ($request->hasFile('photo5')) {
            $filteredBoatData['photo5'] = UploadHelper::uploadFile($request->file('photo5'), 'images/product')['fileName'];
        }

        $boatLogic = new Logics\BoatLogic();

        $boatLogic->addBoats($filteredBoatData);

        return redirect()->back();
    }

    public function updateBoatPage($boatId)
    {
        $boatLogic = new Logics\BoatLogic();
        $boatCountryLogic = new Logics\BoatCountryLogic();
        $boatMarinasLogic = new Logics\BoatMarinasLogic();
        $boatCategoryTmaLogic = new Logics\BoatCategoryTmaLogic();

        $boatData = $boatLogic->getBoatByID($boatId);
        if (!$boatData) {
            abort(404);
        }

        $data['boat'] = $boatData;
        $data['countries'] = $boatCountryLogic->getAllCountry();
        $data['marinas'] = $boatMarinasLogic->getMarinasByStatus('y');
        $data['categories'] = $boatCategoryTmaLogic->getAllBoatCategoryTma();
        return view('others.update-boat', $data);
    }

    public function updateBoat(Request $request)
    {
        $boatData = $request->input('boatData');
        $boatId = $request->input('boat_id');
        $filteredBoatData = array_filter($boatData, function ($key) {
            return in_array($key, [
                'boat_name',
                'boat_reg',
                'mmsi',
                'insurance_no',
                'insurar',
                'insurance_exp',
                'last_inspection',
                'next_inspection',
                'country',
                'boat_type_tma',
                'marina',
                'fuel_type',
                'fuel_consumption',
                'pax',
                'manage',
                'party',
                'fishing',
                'wakeboarding',
                'cruising',
                'vhf',
                'fishfinder',
                'gps',
                'aircon',
                'head',
                'engine_type',
                'self_drive',
                'no_engine',
                'beam',
                'length',
                'year_create',
                'other',
                'last_maintain',
                'last_engine_hour',
                'boat_details',
                'boatnote',
            ]);
        }, ARRAY_FILTER_USE_KEY);
        $filteredBoatData['user_id'] = Auth::id();
        $filteredBoatData['date_updated'] = Carbon::now()->toDateString();

        // Process file
        if ($request->hasFile('contractpaper')) {
            $filteredBoatData['contractpaper'] = UploadHelper::uploadFile($request->file('contractpaper'), 'pdf')['fileName'];
        }

        if ($request->hasFile('contractpdf')) {
            $filteredBoatData['contractpdf'] = UploadHelper::uploadFile($request->file('contractpdf'), 'pdf')['fileName'];
        }

        if ($request->hasFile('contractpdf1')) {
            $filteredBoatData['contractpdf1'] = UploadHelper::uploadFile($request->file('contractpdf1'), 'pdf')['fileName'];
        }

        if ($request->hasFile('contractpdf2')) {
            $filteredBoatData['contractpdf2'] = UploadHelper::uploadFile($request->file('contractpdf2'), 'pdf')['fileName'];
        }

        if ($request->hasFile('main_photo')) {
            $filteredBoatData['main_photo'] = UploadHelper::uploadFile($request->file('main_photo'), 'images/product')['fileName'];
        } else if ($request->input('remove_main_photo') == '1') {
            $filteredBoatData['main_photo'] = '';
        }

        if ($request->hasFile('photo1')) {
            $filteredBoatData['photo1'] = UploadHelper::uploadFile($request->file('photo1'), 'images/product')['fileName'];
        } else if ($request->input('remove_photo1') == '1') {
            $filteredBoatData['photo1'] = '';
        }

        if ($request->hasFile('photo2')) {
            $filteredBoatData['photo2'] = UploadHelper::uploadFile($request->file('photo2'), 'images/product')['fileName'];
        } else if ($request->input('remove_photo2') == '1') {
            $filteredBoatData['photo2'] = '';
        }

        if ($request->hasFile('photo3')) {
            $filteredBoatData['photo3'] = UploadHelper::uploadFile($request->file('photo3'), 'images/product')['fileName'];
        } else if ($request->input('remove_photo3') == '1') {
            $filteredBoatData['photo3'] = '';
        }

        if ($request->hasFile('photo4')) {
            $filteredBoatData['photo4'] = UploadHelper::uploadFile($request->file('photo4'), 'images/product')['fileName'];
        } else if ($request->input('remove_photo4') == '1') {
            $filteredBoatData['photo4'] = '';
        }

        if ($request->hasFile('photo5')) {
            $filteredBoatData['photo5'] = UploadHelper::uploadFile($request->file('photo5'), 'images/product')['fileName'];
        } else if ($request->input('remove_photo5') == '1') {
            $filteredBoatData['photo5'] = '';
        }

        $boatLogic = new Logics\BoatLogic();

        $boatLogic->updateBoat($boatId, $filteredBoatData);

        return redirect()->back();
    }

    public function boatBookCalendarPage($boatId = null)
    {
        $boatLogic = new Logics\BoatLogic();
        $boatCharterLogic = new Logics\BoatCharterLogic();

        if ($boatId === null) {
            $boatIds = $boatLogic->getBoatCreateByCurrentUser()->map(function ($boat) {
                return $boat->boat_id;
            })->toArray();
        } else {
            $boatIds = [$boatId];
            $data['boatName'] = $boatLogic->getBoatByID($boatId)->boat_name;
        }

        $bookings = $boatCharterLogic->getCalendarCharter($boatIds);

        $data['bookingData'] = $bookings->map(function ($booking) {
            $time_from = \Carbon\Carbon::createFromFormat('Y-m-d H', $booking->date_book . ' ' . $booking->time_from);
            $time_to = \Carbon\Carbon::createFromFormat('Y-m-d H', $booking->date_book . ' ' . $booking->time_to);
            return [
                'title' => "{$booking->boat_name} #Order:{$booking->booked_id}",
                'start' => $time_from->toIso8601String(),
                'end' => $time_to->toIso8601String(),
                'allDay' => false
            ];
        });

        return view('others.boat-book-calendar', $data);
    }

    public function submitReview(Request $request)
    {
        $data = $request->only([
            'comment_title',
            'comment_from',
            'boat_id',
            'parent',
            'comment',
            'invoice',
            'rate'
        ]);

        $data = $data + [
            'add_date' => date('Y-m-d'),
            'rank' => 0
        ];

        $boatCommentLogic = new \App\Http\Models\Logics\BoatCommentLogic();
        $boatCommentLogic->insertComment($data);

        return redirect()->back();
    }

    public function SendEmailToAdmin()
    {

        $boatUserLogic = new BoatUserLogic();
        $ifuser = $boatUserLogic->getUserData(Auth::id());
        if (!empty($ifuser)) {
            $dataAdds['user_name'] = $ifuser[0]['user_name'];
            $dataAdds['user_email'] = $ifuser[0]['user_email'];

            Mail::send('emails.TopUpEmail', ['contentEmails' => $dataAdds], function ($message) use ($dataAdds) {
                $message->setContentType('text/html');
                $message->from($dataAdds['user_email'], $dataAdds['user_name']);
                $message->to('sales@tridentmarineasia.com');
                $message->bcc('testing.web017@gmail.com');
                $message->subject("Request for Credit Top-Up");
            });
            Session::put('request-sent', 'yes');
            return redirect()->back();
        }
    }
}