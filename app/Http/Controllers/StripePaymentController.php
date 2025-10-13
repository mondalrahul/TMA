<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StripeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Stripe\PaymentIntent; // or Stripe\SetupIntent
use App\Http\Controllers\Controller;
use App\Http\Controllers\Search\SearchController;
use App\Http\Models\Logics\BoatCategoryTmaLogic;
use App\Http\Models\Logics\BoatCharterLogic;
use App\Http\Models\Logics\BoatLogic;
use App\Http\Models\Logics\BoatSeaSportsLogic;
use App\Http\Models\Logics\BoatTimePriceLogic;
use App\Http\Models\Logics\BoatUserLogic;
use Illuminate\Support\Facades\Mail;
use App\Mail\TbsaSendMail;
use Illuminate\Support\Facades\Log;
use App\Services\StripeService as StripeSvc;
use App\Http\Models\Entities\BoatCharterBook;
use App\BoatcharterbookModel;
use App\BoatbooktimeModel;
use App\Exceptions\StripeNotSupportedException;

class StripePaymentController extends Controller
{
    private $stripeSvc;

    public function __construct(StripeSvc $stripeSvc)
    {
        $this->middleware('auth');
        $this->stripeSvc = $stripeSvc;
        $this->charterLogic = new BoatCharterLogic();
    }

    public function process(Request $request)
    {
        return view('stripe_payment_form');  
    }

    public function capture(Request $request)
    {
        throw new StripeNotSupportedException();

        $params = Session::get('my_array_key');
        print_r($params);
        // Check error params here
        // Process
        $user = Auth::user();
        $user_id = $user->getAttributes()->user_id;
        $user_name = $user->getAttributes()->name;
        $sessionData = session('book_boat_' . $user_name . '_' . $user_id);
        $boatId = $sessionData['boat_id'];
        echo $boatId;

        $boatTimePriceLogic = new BoatTimePriceLogic();
        $boatTimePriceList = $boatTimePriceLogic->getDataBaseOnDateAndBoat($params['book-time-date'], $params['boat_id']);
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
            $boatSeaSportsLogic = new BoatSeaSportsLogic();
            $boatSeaSportsCheckedLists = $boatSeaSportsLogic->getSeaSportsListBaseOnIds($params['hidden-lists-sea-sports-ids']);

            // Wrong data
            if (count($boatSeaSportsCheckedLists) !== count($params['hidden-lists-sea-sports-ids'])) {
                return redirect('/');
            }
        }
        $countTimeSlots = 0;
        foreach ($dataBookTimeList as $item) {
            $countTimeSlots++;
            $currency = $item['currency'];
            // Sea sport
            if (isset($params['book-sea-sports-list']) && $params['book-sea-sports-list'] === 'on' && count($boatSeaSportsCheckedLists) > 0) {
                foreach($boatSeaSportsCheckedLists as $key => $value) {
                    $seaSportPrice += $value['price'];
                }
            }

            $skipperPrice += $item['skipperPrice'];
            $excessDeposit += $item['excessDeposit'];
            $timingPrice += $item['price'];
            if ($params['book-skipper'] === '1') {
                $totalPrice += ($item['price'] + $item['skipperPrice']);
            } else {
                $totalPrice += ($item['price'] + $item['excessDeposit']);
            }

            $params['book_timing'][] = [
                'time_id'   => $item['id'],
                'boat_id'   => $item['boatId'],
                'time_from' => $item['timeFrom'],
                'time_to'   => $item['timeTo'],
                'date_book' => new \DateTime($params['book-time-date']),
                'add_date'  => new \DateTime(date('Y-m-d')),
                'user_id'   => $user_id,
                'price'     => $item['price'],
                'booktime'  => time(),
                'booked_id' => 0
            ];
        }
        foreach ($boatSeaSportsCheckedLists as $key => $item) {
            $seaSportBrochure[$item['name']] = $item['price'] * $countTimeSlots;
        }

        $totalPrice = ($totalPrice + $seaSportPrice);
        $params['seasport_brochure'] = $seaSportPrice;
        $params['book_charter']= [
            'total_price'       => $totalPrice,
            'boat_id'           => $params['boat_id'],
            'user_id'           => $user_id,
            'add_date'          => new \DateTime(date('Y-m-d')),
            'status'            => 1,
            'is_skiper'         => ($params['book-skipper'] === '1') ? $skipperPrice : 0.00,
            'is_coupon'         => 0,
            'timing_price'      => $timingPrice,
            'comment'           => '',
            'excess_deposit'    => ($params['book-skipper'] !== '1') ? $excessDeposit : 0.00,
            'referrer_discount' => 0,
            'user_manager'      => '',
            'ifskipper'         => (isset($params['book-skipper']) && $params['book-skipper'] === '1') ? 1 : 0,
            'ratingyes'         => 0
        ];

        $seaSportBrochure = array_filter($seaSportBrochure);
        $dataTemp = '';
        if (!empty($seaSportBrochure)) {
            foreach($seaSportBrochure as $key => $price) {
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

        $transactionDescription = "Yacht Charter: " . $params['book-boat-name'];
        $boatId = $sessionData['boat_id'];
        $lastbooked = BoatcharterbookModel::max('last_booked');
        $boatLogic = new BoatLogic();
        $boatDetail = $boatLogic->getBoatDetail($boatId);
        
        $boatCategoryTmaLogic = new BoatCategoryTmaLogic();
        if (isset($boatDetail[0]['boat_type_tma'])) {
            $boatTypeData = $boatCategoryTmaLogic->getBoatCategoryTma($boatDetail[0]['boat_type_tma']);
        }
        else{
            $boatLogic = new BoatLogic();
            $boatDetail = $boatLogic->getBoatDetail($boatId);
            $boatTypeData = $boatCategoryTmaLogic->getBoatCategoryTma($boatDetail[0]['boat_type_tma']);
        }
        
        $boatUserLogic = new BoatUserLogic();
        $boatUserOwner = $boatUserLogic->getUserData($boatDetail[0]['user_id']);
        $sessionData['boat_category'] = $boatTypeData[0] ?? [];
        $sessionData['boat_detail'] = $boatDetail[0];
        $sessionData['boat_owner'] = $boatUserOwner[0];
        $sessionData['book_charter']['contract'] = $boatDetail[0]['contractpdf'];
            $bookdet = $params['book_charter'];
            $booktim = $params['book_timing'][0];
            // print_r($booktim);
            $value = Session::get('stripepay');
            \Stripe\Stripe::setApiKey(config('common.STRIPE_SECRET'));
            $stpay = \Stripe\Charge::create ([
                    "amount" => 100*$totalPrice,
                    "currency" => "usd",
                    "source" => $request->stripeToken,
                    "description" => "",
            ]);
        if($stpay){
          $total_price = $bookdet['total_price'];
          $boat_id = $bookdet['boat_id'];
          $last_booked = $lastbooked+1;
          $user_id = $bookdet['user_id'];
          $add_date =$bookdet['add_date'];
          $status = $bookdet['status'];
          $is_skiper = $bookdet['is_skiper'];
          $is_coupon = $bookdet['is_coupon'];
          $timing_price = $bookdet['timing_price'];
          $comment = $bookdet['comment'];
          $excess_deposit = $bookdet['excess_deposit'];
          $referrer_discount = $bookdet['referrer_discount'];
          $user_manager = $bookdet['user_manager'];
          $payment_type = 'Stripe';
          $ifskipper = $bookdet['ifskipper'];
          $ratingyes = $bookdet['ratingyes'];
          $seasport_brochure = $bookdet['seasport_brochure'];
          $data2 = array('total_price'=>$total_price,'boat_id' => $boat_id,'last_booked' => $last_booked, 'user_id' => $user_id,'add_date' => $add_date, 
          'status' => $status, 'is_skiper' => $is_skiper,'is_coupon' => $is_coupon, 
          'timing_price' => $timing_price, 'comment' => $comment,'excess_deposit' => $excess_deposit, 
          'referrer_discount' => $referrer_discount, 'user_manager' => $user_manager,'payment_type'=>$payment_type,'ifskipper' => $ifskipper, 
          'ratingyes' => $ratingyes, 'seasport_brochure' => $seasport_brochure);
          $add = BoatcharterbookModel :: create($data2);
            $boatcrid = $add->id;
            
          $time_id =  $booktim['time_id'];
          $boat_id =  $booktim['boat_id'];
          $time_from =  $booktim['time_from'];
          $time_to =  $booktim['time_to'];
          $date_book =  $booktim['date_book'];
          $add_date =  $booktim['add_date'];
          $user_id =  $booktim['user_id'];
          $price =  $booktim['price'];
          $booktime =  $booktim['booktime'];
          $booked_id =  $boatcrid;
          $data3 = array('time_id'=>$time_id,'boat_id' => $boat_id,'time_from' => $time_from, 'time_to' => $time_to,'date_book' => $date_book, 
          'add_date' => $add_date, 'user_id' => $user_id,'price' => $price,'booktime' => $booktime, 'booked_id' => $booked_id);
          $add2 = BoatbooktimeModel :: create($data3);
          $sessionData['book_charter']['id'] = $boatcrid;
          $sessionData['user_detail'] = [
            'user_name' => $user_name,
            'user_email' => $user->getAttributes()->user_email,
            'user_address' => $user->getAttributes()->user_address,
            'user_type' => 'Charterer'
        ];
        //   foreach ($sessionData['book_timing'] as $key => $item) {
        //     $lastInsertBookTimingList[$item['time_id']] = $charterLogic->insertBookTiming($item);
        //     $sessionData['book_timing'][$key]['id'] = $lastInsertBookTimingList[$item['time_id']];
        // }

        // // Insert data to charter boat
        // $lastInsertBoatCharter = null;
        // if (!empty($lastInsertBookTimingList)) {
        //     $sessionData['book_charter']['last_booked'] = max($lastInsertBookTimingList);
        //     $lastInsertBoatCharter = $charterLogic->insertBoatCharter($sessionData['book_charter']);
        // }

         if($add2){
            $this->sendMailToAdmin($sessionData);
            $this->sendMailToClient($sessionData);
            }   
            session()->forget('book_boat_' . $user_name . '_' . $user_id);
            return(redirect('/'));
    }
    else{ 
        Session::flash('message_checkout', 'Process was failed. Please try again!');
        return redirect('/boat-detail/' . $params['boat_id']);
    }
}
    private function sendMailToAdmin($sessionData)
    {
        // Config content
        $sessionData['subject'] = 'Order ID: ' . $sessionData['book_charter']['id'];
        $sessionData['email_template'] = 'paymentstripeAdminEmail';
        try {
            // send Email
            Mail::to('webgrity164@gmail.com')->cc($sessionData['boat_owner']['user_email'])->send(new TbsaSendMail($sessionData));
        } catch (\Exception $e) {
            Log::error('Send payment admin mail failed. Detail: ' . $e->getMessage());
        }
    }

    private function sendMailToClient($sessionData)
    {
        // Config content
        $sessionData['subject'] = 'Order ID: ' . $sessionData['book_charter']['id'];
        $sessionData['email_template'] = 'paymentstripeClientEmail';
        try {
            // send Email
            Mail::to('mailsudipkaran@webgrity.net')->send(new TbsaSendMail($sessionData));
        } catch (\Exception $e) {
            Log::error('Send payment client mail failed. Detail: ' . $e->getMessage());
        }
    }
}

