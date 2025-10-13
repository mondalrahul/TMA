<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ConvertCurrency;
use App\Mail\TbsaSendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Stripe\StripeClient;

class StripePaymentController extends Controller
{
    public function stripeCheckout(Request $request)
    {
        // if($request->session()->get('adminlogin') == 'Yes'){
        //     return redirect('http://google.com');
        // }

        $r_param = $request->all();
        $params = $request->all();
        // dd($r_param);
        $comment = $r_param['additional_info'];
        if ($comment == "") {
            $comment = @$r_param['addition_request'];
        }
        if ($comment == "") {
            $comment = @$r_param['comment'];
        }
        $user = Auth::user();
        $user_id = $user->user_id;
        $user_name = $user->name;
        $user_email = $user->user_email;
        $user_extend = DB::table('boat_user_extend')->where('user_id', $user_id)->first();
        if ($user_extend) {
            $additional_deposite = $user_extend->additional_deposite;
        }

        $discount_price = $r_param['discount_price'];
        $discount_type = $r_param['discount_type'];
        $membership_id = $r_param['membership_id'];
        $credit_id = $r_param['credit_id'];

        // $boatTimePriceLogic = new BoatTimePriceLogic();
        // $boatTimePriceList = $boatTimePriceLogic->getDataBaseOnDateAndBoat($params['book-time-date'], $params['boat_id']);
        $boatTimePriceList = DB::select("SELECT btp.id, btp.time_id, btp.date_for, btp.price, btp.time_from, btp.time_to, btp.boat_id, btp.excess_deposit, btp.skipper_price, btp.currency FROM boat_time_price btp WHERE btp.boat_id = " . $params['boat_id'] . " AND btp.date_for = '" . $params['book-time-date'] . "' ORDER BY btp.id DESC");
        $boatTimePriceList = json_decode(json_encode($boatTimePriceList), true);
        if (empty($boatTimePriceList)) {
            return redirect('/');
        }

        $bookTimeList = explode(',', $params['book-time-list']);
        $dataBookTimeList = [];
        foreach ($boatTimePriceList as $item) {
            if (in_array($item['id'], $bookTimeList)) {
                $dataBookTimeList[$item['id']] = $item;
            }
        }
        // Check valid book time list data
        if (count($bookTimeList) != count($dataBookTimeList)) {
            return redirect('/');
        }

        // Process total price
        $totalPrice = 0;
        $skipperPrice = 0;
        $excessDeposit = 0;
        $timingPrice = 0;
        $seaSportPrice = 0;
        $currency = null;
        $seaSportBrochure = [];
        $boatSeaSportsCheckedLists = [];
        if (isset($params['book-sea-sports-list']) && $params['book-sea-sports-list'] === 'on') {
            // Get lists sea sports
            // $boatSeaSportsLogic = new BoatSeaSportsLogic();
            // $boatSeaSportsCheckedLists = $boatSeaSportsLogic->getSeaSportsListBaseOnIds($params['hidden-lists-sea-sports-ids']);
            $boatSeaSportsCheckedLists = DB::select("SELECT bs.* FROM boat_seasports_brochure bs WHERE bs.id IN(" . implode(",", $params['hidden-lists-sea-sports-ids']) . ") ORDER BY bs.id ASC");
            $boatSeaSportsCheckedLists = json_decode(json_encode($boatSeaSportsCheckedLists), true);

            $checkedAddOns = DB::select("SELECT bs.* FROM boat_seasports_brochure bs WHERE bs.id IN(" . implode(",", $params['all-checked-add-ons']) . ") ORDER BY bs.id ASC");
            // dd($checkedAddOns);
            // dd($boatSeaSportsCheckedLists);

            // Wrong data
            if (count($boatSeaSportsCheckedLists) !== count($params['hidden-lists-sea-sports-ids'])) {
                return redirect('/');
            }
        }
        $countTimeSlots = 0;
        //$singletimeprice = 0;
        $singletime = true;
        if (count($dataBookTimeList) > 1) {
            $singletime = false;
        }

        foreach ($dataBookTimeList as $item) {
            $countTimeSlots++;
            $currency = $item['currency'];
            // Sea sport
            if (isset($params['book-sea-sports-list']) && $params['book-sea-sports-list'] === 'on' && count($checkedAddOns) > 0) {
                foreach ($checkedAddOns as $key => $value) {
                    $seaSportPrice += $value->price;
                }
            }
            $skipperPrice += $item['skipper_price'];
            $excessDeposit += $item['excess_deposit'];
            $timingPrice += $item['price'];
            if ($params['book-skipper'] === '1') {
                $totalPrice += ($item['price'] + $item['skipper_price']);
            } else {
                $totalPrice += ($item['price'] + $item['excess_deposit']);
            }
        }

        if (isset($params['book-sea-sports-list']) && $params['book-sea-sports-list'] === 'on' && count($checkedAddOns) > 0) {
            foreach ($checkedAddOns as $key => $item) {
                $seaSportBrochure[$item->name] = $item->price * $countTimeSlots;
            }
        }
        if ($skipperPrice > 0) {
            $additional_deposite = '0.00';
        }
        $excessDeposit = ($excessDeposit +  $additional_deposite);
        // 3% charge
        $totalPrice = ($totalPrice + $seaSportPrice) + (($totalPrice + $seaSportPrice) * 3) / 100;
        // $totalPrice = $totalPrice + $seaSportPrice;

        // dd($totalPrice);
        //$totalPrice = ($totalPrice -$discount_price);

        /* ----------- Changes 11.08.2022 ------*/
        $sgdRatePath = config_path('SGDRates.json');
        $convertCurrency = new ConvertCurrency($sgdRatePath);
        if ($currency == "MYR") {
            $totalPrice = ($convertCurrency->convertToSGD($totalPrice, $currency)) ? $convertCurrency->convertToSGD($totalPrice, $currency) : 0;
            $currency = 'SGD';
        }
        $discount_price = (float)$discount_price;
        $totalPrice = $totalPrice - $discount_price;
        /* ----------- Changes 11.08.2022 ------*/

        foreach ($dataBookTimeList as $item) {
            // dd($totalPrice);
            if ($singletime == true) {
                $singletimeprice = $totalPrice;
            } else {
                $singletimeprice = ($totalPrice / 2);
            }

            //dd($singletimeprice);

            $params['book_timing'][] = [
                'time_id'   => $item['id'],
                'boat_id'   => $item['boat_id'],
                'time_from' => $item['time_from'],
                'time_to'   => $item['time_to'],
                'date_book' => new \DateTime($params['book-time-date']),
                'add_date'  => new \DateTime(date('Y-m-d')),
                'user_id'   => $user_id,
                'price'     => $totalPrice,
                'singleprice' => $singletimeprice,
                'booktime'  => time(),
                'booked_id' => 0
            ];
        }


        $params['seasport_brochure'] = $seaSportPrice;
        $params['book_charter'] = [
            'total_price'       => $totalPrice,
            'boat_id'           => $params['boat_id'],
            'user_id'           => $user_id,
            'add_date'          => new \DateTime(date('Y-m-d')),
            'status'            => 1,
            'is_skiper'         => ($params['book-skipper'] === '1') ? $skipperPrice : 0.00,
            'is_coupon'         => 0,
            'timing_price'      => $timingPrice,
            'comment'           => $comment,
            'excess_deposit'    => ($params['book-skipper'] !== '1') ? $excessDeposit : $additional_deposite,
            'referrer_discount' => 0,
            'user_manager'      => '',
            'currency'          => $currency,
            'ifskipper'         => (isset($params['book-skipper']) && $params['book-skipper'] === '1') ? 1 : 0,
            'ratingyes'         => 0,
            'discount_price'    => $discount_price,
            'discount_type'     => $discount_type,
            'membership_id'     => $membership_id,
            'credit_id'         => $credit_id
        ];

        $seaSportBrochure = array_filter($seaSportBrochure);
        $dataTemp = [];
        if (!empty($seaSportBrochure)) {
            foreach ($seaSportBrochure as $key => $price) {
                $dataTemp[] = $key . ':' . $price;
            }
        }
        $params['book_charter']['seasport_brochure'] = (!empty($dataTemp)) ? implode(',', $dataTemp) : '';

        $data = [
            [
                'name' => "Yacht Charter: " . $params['book-boat-name'],
                'quantity' => 1,
                'price' => $totalPrice, //$totalPrice
                'sku' => $user_id . '_' . $params['boat_id']
            ],
        ];

        // dd($data);

        // var_dump($totalPrice);
        // dd($totalPrice);

        // Stripe Start
        // $user = Auth::user();
        // dd($user->user_id);
        if ($user->user_id == 28056 || $user->user_id == 29741) {
            $stripe = new StripeClient(env('STRIPE_SECRET_TEST'));
        } else {
            $stripe = new StripeClient(env('STRIPE_SECRET'));
        }
        $redirectUrl = route('stripe.status') . '?session_id={CHECKOUT_SESSION_ID}';
        $total_price_for_stripe = 100 * number_format($totalPrice, 2, '.', '');
        $total_price_for_stripe = (int) $total_price_for_stripe;
        // var_dump($total_price_for_stripe);
        // $total_price_for_stripe = (float) number_format($totalPrice, 2) * 100;
        // exit;
        $response = $stripe->checkout->sessions->create([
            'success_url' => $redirectUrl,
            'customer_email' => $user_email,
            'payment_method_types' => ['link', 'card'],
            'line_items' => [
                [
                    'price_data' => [
                        'product_data' => [
                            'name' => "Yacht Charter: " . $params['book-boat-name'],
                        ],
                        'unit_amount' => $total_price_for_stripe,
                        'currency' => $currency,
                    ],
                    'quantity' => 1
                ],
            ],

            'mode' => 'payment',
            'allow_promotion_codes' => true,
        ]);

        session(['book_boat_' . $user_name . '_' . $user_id => $params]);
        return redirect($response['url']);
    }

    public function status(Request $request)
    {
        $user = Auth::user();
        if ($user->user_id == 28056 || $user->user_id == 29741) {
            $stripe = new StripeClient(env('STRIPE_SECRET_TEST'));
        } else {
            $stripe = new StripeClient(env('STRIPE_SECRET'));
        }

        $response = $stripe->checkout->sessions->retrieve($request->session_id);
        // dd($response->toArray());
        // dd($response);

        // custom
        $params = $request->all();
        $user = Auth::user();
        $user_id = $user->user_id;
        $user_name = $user->name;
        $sessionData = session('book_boat_' . $user_name . '_' . $user_id);
        $boatId = $sessionData['boat_id'];
        $oderId = $params['session_id'];

        // dd($sessionData);

        // Execute payment
        // $paymentStatus = $this->paypalSvc->getPaymentStatus($request);
        if ($response->status != 'complete') {
            Session::flash('message_checkout', 'Process was failed. Please try again!');
            return redirect('/boat-detail/' . $boatId);
        }
        // Get payment detail
        // $paymentDetail = json_decode($this->paymentDetail($params['paymentId']));
        if ($response->status != 'complete') {
            Session::flash('message_checkout', 'Process was failed. Please try again!');
        } else {
            // Get boat detail
            // $boatLogic = new BoatLogic();
            // $boatDetail = $boatLogic->getBoatDetail($boatId);
            if ($boatId == '615') {
                $query = DB::select("SELECT bo.*, btp.currency, btp.boatPrice, bm.marinas_name, bm.country AS marinas_country, tma.air_conditioning, tma.shower, tma.toilet, tma.jet_skis, tma.karaoke, tma.cooler_boxes, tma.kayak, tma.standup_paddle, tma.bbq_pit, tma.tender, tma.chiller, tma.wifi, tma.microwave, tma.jacuzzi, tma.water_donut, tma.sound_system FROM boat_tbl_boat bo LEFT JOIN (SELECT btp.boat_id AS boatId, btp.currency AS currency, MIN(NULLIF(btp.price, 0)) AS boatPrice FROM boat_time_price btp INNER JOIN boat_tbl_boat bo ON btp.boat_id = bo.boat_id AND btp.date_for >= NOW()WHERE btp.boat_id = " . $boatId . " GROUP BY btp.currency) AS btp ON btp.boatId = bo.boat_id LEFT JOIN boat_marinas bm ON bo.marina = bm.marinas_id LEFT JOIN tma_facilities tma ON tma.boat_id = bo.boat_id WHERE bo.boat_id = " . $boatId . " AND bo.status = 'y'");
            } else {
                $query = DB::select("SELECT bo.*, btp.currency, btp.price, bo.book_type, bo.credit_available, bm.marinas_name, bm.country AS marinas_country, tma.air_conditioning, tma.shower, tma.toilet, tma.jet_skis, tma.karaoke, tma.cooler_boxes, tma.kayak, tma.standup_paddle, tma.bbq_pit, tma.tender, tma.chiller, tma.wifi, tma.microwave, tma.jacuzzi, tma.water_donut, tma.sound_system FROM boat_tbl_boat bo LEFT JOIN boat_time_price btp ON btp.boat_id = bo.boat_id LEFT JOIN boat_marinas bm ON bo.marina = bm.marinas_id LEFT JOIN tma_facilities tma ON tma.boat_id = bo.boat_id WHERE bo.boat_id = " . $boatId . " AND bo.status = 'y' GROUP BY btp.currency;");
            }
            $boatDetail = json_decode(json_encode($query), true);
            // $boatCategoryTmaLogic = new BoatCategoryTmaLogic();
            // $boatTypeData = $boatCategoryTmaLogic->getBoatCategoryTma($boatDetail[0]['boat_type_tma']);
            $boatTypeData = DB::select("SELECT bct.* FROM boat_tbl_category_tma bct WHERE bct.category_id = " . $boatDetail[0]['boat_type_tma']);
            $boatTypeData = json_decode(json_encode($boatTypeData), true);
            // $boatUserLogic = new BoatUserLogic();
            // $boatUserOwner = $boatUserLogic->getUserData($boatDetail[0]['user_id']);
            $boatUserOwner = DB::select("SELECT bu.* FROM boat_user bu WHERE bu.user_id = " . $boatDetail[0]['user_id']);
            $boatUserOwner = json_decode(json_encode($boatUserOwner), true);
            $sessionData['boat_category'] = $boatTypeData[0];
            $sessionData['boat_detail'] = $boatDetail[0];
            $sessionData['boat_owner'] = !empty($boatUserOwner) && isset($boatUserOwner[0]) ? $boatUserOwner[0] : '';
            $sessionData['book_charter']['contract'] = $boatDetail[0]['contractpdf'];
            $sessionData['book_charter']['country'] = $boatDetail[0]['country'];
            $sessionData['book_charter']['currency'] = app('App\Http\Controllers\Controller')->getCurrency($boatDetail[0]['country']);
            // Insert data to book timing
            $lastInsertBookTimingList = [];
            // $charterLogic = new BoatCharterLogic();
            foreach ($sessionData['book_timing'] as $key => $item) {
                // $lastInsertBookTimingList[$item['time_id']] = $charterLogic->insertBookTiming($item);
                // insert data
                $defaultData = [
                    'time_id' => 0,
                    'boat_id' => 0,
                    'time_from' => 0,
                    'time_to' => 0,
                    'date_book' => new \DateTime(date('Y-m-d')),
                    'add_date' => new \DateTime(date('Y-m-d')),
                    'user_id' => 0,
                    'price' => 0,
                    'type' => 0,
                    'is_cancel' => 0,
                    'booktime' => '',
                    'booked_id' => 0
                ];

                $defaultData = array_merge($defaultData, $item);
                $lastInsertId = DB::table('boat_tbl_book_timing')->insertGetId([
                    'time_id' => $defaultData['time_id'],
                    'boat_id' => $defaultData['boat_id'],
                    'time_from' => $defaultData['time_from'],
                    'time_to' => $defaultData['time_to'],
                    'date_book' => $defaultData['date_book'],
                    'add_date' => $defaultData['add_date'],
                    'user_id' => $defaultData['user_id'],
                    'price' => $defaultData['price'],
                    'type' => $defaultData['type'],
                    'booktime' => $defaultData['booktime'],
                    'booked_id' => $defaultData['booked_id']
                ]);
                $lastInsertBookTimingList[$item['time_id']] = $lastInsertId;
                $sessionData['book_timing'][$key]['id'] = $lastInsertBookTimingList[$item['time_id']];
            }

            // Insert data to charter boat
            $lastInsertBoatCharter = null;
            if (!empty($lastInsertBookTimingList)) {
                $sessionData['book_charter']['last_booked'] = max($lastInsertBookTimingList);
                $defaultData = [
                    'total_price' => 0,
                    'boat_id' => 0,
                    'last_booked' => 0,
                    'user_id' => 0,
                    'add_date' => date('Y-m-d'),
                    'status' => 1,
                    'is_skiper' => 0,
                    'is_coupon' => 0.00,
                    'timing_price' => 0.00,
                    'comment' => '',
                    'excess_deposit' => 0.00,
                    'contract' => '',
                    'referrer_discount' => 0.00,
                    'user_manager' => '',
                    'payment_type' => 'Stripe',
                    'ifskipper' => 0,
                    'user_extrainfo' => '',
                    'ratingyes' => 0,
                    'seasport_brochure' => '',
                    'book_type' => '',
                    'discount_type' => '',
                    'credit_id' => 0,
                    'discount_price' => 0.00,
                    'membership_id' => 0
                ];
                $defaultData = array_merge($defaultData, $sessionData['book_charter']);
                $total_price = $defaultData['total_price'] - $defaultData['discount_price'];
                $lastInsertId = DB::table('boat_charter_book')->insertGetId([
                    'total_price' => $total_price,
                    'boat_id' => $defaultData['boat_id'],
                    'last_booked' => $defaultData['last_booked'],
                    'user_id' => $defaultData['user_id'],
                    'add_date' => $defaultData['add_date'],
                    'status' => $defaultData['status'],
                    'is_skiper' => $defaultData['is_skiper'],
                    'is_coupon' => $defaultData['is_coupon'],
                    'timing_price' => $defaultData['timing_price'],
                    'comment' => $defaultData['comment'] != null ? $defaultData['comment'] : 'N/A',
                    'excess_deposit' => $defaultData['excess_deposit'],
                    'contract' => $defaultData['contract'],
                    'referrer_discount' => $defaultData['referrer_discount'],
                    'user_manager' => $defaultData['user_manager'],
                    'payment_type' => $defaultData['payment_type'],
                    'ifskipper' => $defaultData['ifskipper'],
                    'user_extrainfo' => $defaultData['user_extrainfo'],
                    'ratingyes' => $defaultData['ratingyes'],
                    'seasport_brochure' => $defaultData['seasport_brochure'],
                    'book_type' => $defaultData['book_type'],
                    'discount_type' => $defaultData['discount_type'],
                    'credit_id' => $defaultData['credit_id'],
                    'discount_price' => $defaultData['discount_price'],
                    'membership_id' => $defaultData['membership_id']
                ]);
                // $lastInsertBoatCharter = $charterLogic->insertBoatCharter($sessionData['book_charter']);
                $lastInsertBoatCharter = $lastInsertId;
            }

            if ($lastInsertBoatCharter) {
                foreach ($sessionData['book_timing'] as $key => $item) {
                    $item['booked_id'] = $lastInsertBoatCharter;
                    // $charterLogic->updateBookTiming($item);
                    $defaultData = [
                        'time_id' => 0,
                        'boat_id' => 0,
                        'time_from' => 0,
                        'time_to' => 0,
                        'date_book' => date('Y-m-d'),
                        'add_date' => date('Y-m-d'),
                        'user_id' => 0,
                        'price' => 0,
                        'type' => 0,
                        'is_cancel' => 0,
                        'booktime' => '',
                        'booked_id' => 0
                    ];
                    $defaultData = array_merge($defaultData, $item);
                    if (is_object($defaultData['date_book'])) {
                        $defaultData['date_book'] = $defaultData['date_book']->format('Y-m-d');
                        $defaultData['type'] = '1';
                        $defaultData['add_date'] = $defaultData['add_date']->format('Y-m-d');
                    }
                    DB::table('boat_tbl_book_timing')->where('id', $sessionData['book_timing'][$key]['id'])->update($defaultData);
                }
            }
            $sessionData['book_charter']['id'] = $lastInsertBoatCharter;

            $discount_price =  $sessionData['book_charter']['discount_price'];
            $discount_type = $sessionData['book_charter']['discount_type'];
            $membership_id = $sessionData['book_charter']['membership_id'];
            $credit_id = $sessionData['book_charter']['credit_id'];

            DB::table('boat_charter_book')->where('book_id', $lastInsertBoatCharter)->update(['country' => $boatDetail[0]['country'], 'currency' => $sessionData['book_charter']['currency']]);
            if ($discount_type > 0) {
                $addtining = $boatDetail[0]['boat_name'];
                foreach ($sessionData['book_timing'] as $item) {
                    // dd($item['date_book']->format('d/m/Y'));
                    $addtining .= ', Date: ' . date('jS F,Y', strtotime($item['date_book']->format('d/m/Y'))) . ' (';
                    if ($item['time_from'] > 12) {
                        $addtining .=  ($item['time_from'] - 12);
                    } else {
                        $addtining .= $item['time_from'];
                    }
                    if ($item['time_from'] > 12) {
                        $addtining .= 'Pm';
                    } else {
                        $addtining .= 'Am';
                    }
                    $addtining .= ' - ';
                    if ($item['time_to'] > 12) {
                        $addtining .= $item['time_to'] - 12;
                    } else {
                        $addtining .= $item['time_to'];
                    }
                    if ($item['time_to'] > 12) {
                        $addtining .= 'Pm';
                    } else {
                        $addtining .= 'Am';
                    }
                    $addtining .= ') Hours: ' . ($item['time_to'] - $item['time_from']) . '  ';
                }

                DB::table('boat_user_credits_history')->insert(
                    [
                        'credit_id' => $credit_id,
                        'remarks' => 'Booking ID #' . $oderId . ' - ' . $addtining,
                        'deposit_amount' => '0',
                        'withdral_amount' => $discount_price,
                        'booking_id' => $lastInsertBoatCharter,
                        'balance' => '-' . $discount_price,
                        'user_id' =>  $user_id,
                        'add_date' => date("Y-m-d")
                    ]
                );
            }

            Session::flash('message_checkout', 'Process was success.');
            // Send mail
            $sessionData['user_detail'] = [
                'user_name' => $user_name,
                'user_email' => $user->user_email,
                'user_address' => $user->user_address,
                'user_type' => 'Charterer'
            ];

            $this->sendMailToAdmin($sessionData);
            $this->sendMailToClient($sessionData);
        }
        session()->forget('book_boat_' . $user_name . '_' . $user_id);
        return redirect('/');
    }

    private function sendMailToAdmin($sessionData)
    {
        // Config content
        $sessionData['subject'] = 'Order ID: ' . $sessionData['book_charter']['id'];
        $sessionData['email_template'] = 'paymentAdminEmail';
        try {
            // send Email
            if ($sessionData['book_charter']['id'] == 615 && $sessionData['boat_owner']['user_email'] == 'leemingying@gmail.com') {
                Mail::to('sales@tridentmarineasia.com')->send(new TbsaSendMail($sessionData));
                // Mail::to('webgrity164@gmail.com')->send(new TbsaSendMail($sessionData));
            } else {
                Mail::to('sales@tridentmarineasia.com')->cc($sessionData['boat_owner']['user_email'])->send(new TbsaSendMail($sessionData));
                // Mail::to('webgrity164@gmail.com')->send(new TbsaSendMail($sessionData));
            }
        } catch (\Exception $e) {
            Log::error('Send payment admin mail failed. Detail: ' . $e->getMessage());
        }
    }

    private function sendMailToClient($sessionData)
    {
        // Config content
        $sessionData['subject'] = 'Order ID: ' . $sessionData['book_charter']['id'];
        $sessionData['email_template'] = 'paymentClientEmail';
        $sessionData['from'] = 'info@tridentmarineasia.com';
        try {
            // send Email
            Mail::to($sessionData['user_detail']['user_email'])->send(new TbsaSendMail($sessionData));
        } catch (\Exception $e) {
            Log::error('Send payment client mail failed. Detail: ' . $e->getMessage());
        }
    }
}
