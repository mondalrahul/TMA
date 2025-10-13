<?php

namespace App\Http\Controllers\PayPal;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Search\SearchController;
use App\Http\Models\Logics\BoatCategoryTmaLogic;
use App\Http\Models\Logics\BoatCharterLogic;
use App\Http\Models\Logics\BoatLogic;
use App\Http\Models\Logics\BoatSeaSportsLogic;
use App\Http\Models\Logics\BoatTimePriceLogic;
use App\Http\Models\Logics\BoatUserLogic;
use App\Services\PayPalService as PayPalSvc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\TbsaSendMail;
use Illuminate\Support\Facades\Log;
use App\Http\Helpers\ConvertCurrency;
use Illuminate\Support\Facades\DB;

class PaypalController extends Controller
{
    private $paypalSvc;

    public function __construct(PayPalSvc $paypalSvc)
    {
        $this->middleware('auth');
        $this->paypalSvc = $paypalSvc;
        $this->charterLogic = new BoatCharterLogic();
    }

    public function process($request, $params)
    {
        // Check error params here
        // Process
        $r_param = $request->all();
        // dd($r_param);
        $comment =  $r_param['additional_info'];
        if ($comment == "") {
            $comment =  @$r_param['addition_request'];
        }
        if ($comment == "") {
            $comment =  @$r_param['comment'];
        }
        $user = Auth::user();
        $user_id = $user->user_id;
        $user_name = $user->name;
        $user_extend = DB::table('boat_user_extend')->where('user_id', $user_id)->first();
        $additional_deposite = $user_extend->additional_deposite;


        $discount_price = $r_param['discount_price'];
        $discount_type = $r_param['discount_type'];
        $membership_id = $r_param['membership_id'];
        $credit_id = $r_param['credit_id'];

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
                foreach ($boatSeaSportsCheckedLists as $key => $value) {
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
        if ($skipperPrice > 0) {
            $additional_deposite = '0.00';
        }
        $excessDeposit = ($excessDeposit +  $additional_deposite);
        $totalPrice = ($totalPrice + $seaSportPrice) + (($totalPrice + $seaSportPrice) * 5) / 100;

        //$totalPrice = ($totalPrice -$discount_price);
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

        /* ----------- Changes 11.08.2022 ------*/
        $sgdRatePath = config_path('SGDRates.json');
        $convertCurrency = new ConvertCurrency($sgdRatePath);
        if ($currency == "MYR") {
            $totalPrice = ($convertCurrency->convertToSGD($totalPrice, $currency)) ? $convertCurrency->convertToSGD($totalPrice, $currency) : 0;
            $currency = 'SGD';
        }
        $totalPrice = ($totalPrice - $discount_price);
        /* ----------- Changes 11.08.2022 ------*/
        $data = [
            [
                'name' => "Yacht Charter: " . $params['book-boat-name'],
                'quantity' => 1,
                'price' => $totalPrice, //$totalPrice
                'sku' => $user_id . '_' . $params['boat_id']
            ],
        ];


        $transactionDescription = "Yacht Charter: " . $params['book-boat-name'];
        $paypalCheckoutUrl = $this->paypalSvc
            ->setCurrency($currency)
            ->setReturnUrl(url('/paypal/status'))
            ->setCancelUrl(url('/boat-detail/' . $params['boat_id']))
            ->setItem($data)
            ->createPayment($transactionDescription);
        if ($paypalCheckoutUrl) {
            session(['book_boat_' . $user_name . '_' . $user_id => $params]);
            return redirect($paypalCheckoutUrl);
        } else {
            Session::flash('message_checkout', 'Process was failed. Please try again!');
            return redirect('/boat-detail/' . $params['boat_id']);
        }
    }

    public function status(Request $request)
    {
        $params = $request->all();
        $user = Auth::user();
        $user_id = $user->user_id;
        $user_name = $user->name;
        $sessionData = session('book_boat_' . $user_name . '_' . $user_id);
        $boatId = $sessionData['boat_id'];
        // Execute payment
        $paymentStatus = $this->paypalSvc->getPaymentStatus($request);
        if (!$paymentStatus) {
            Session::flash('message_checkout', 'Process was failed. Please try again!');
            return redirect('/boat-detail/' . $boatId);
        }
        // Get payment detail
        $paymentDetail = json_decode($this->paymentDetail($params['paymentId']));

        if ($paymentDetail->state === 'failed') {
            Session::flash('message_checkout', 'Process was failed. Please try again!');
        } else {
            // Get boat detail
            $boatLogic = new BoatLogic();
            $boatDetail = $boatLogic->getBoatDetail($boatId);
            $boatCategoryTmaLogic = new BoatCategoryTmaLogic();
            $boatTypeData = $boatCategoryTmaLogic->getBoatCategoryTma($boatDetail[0]['boat_type_tma']);
            $boatUserLogic = new BoatUserLogic();
            $boatUserOwner = $boatUserLogic->getUserData($boatDetail[0]['user_id']);
            $sessionData['boat_category'] = $boatTypeData[0];
            $sessionData['boat_detail'] = $boatDetail[0];
            $sessionData['boat_owner'] = !empty($boatUserOwner) && isset($boatUserOwner[0]) ? $boatUserOwner[0] : '';
            $sessionData['book_charter']['contract'] = $boatDetail[0]['contractpdf'];
            $sessionData['book_charter']['country'] = $boatDetail[0]['country'];
            $sessionData['book_charter']['currency'] = app('App\Http\Controllers\Controller')->getCurrency($boatDetail[0]['country']);
            // Insert data to book timing
            $lastInsertBookTimingList = [];
            $charterLogic = new BoatCharterLogic();
            foreach ($sessionData['book_timing'] as $key => $item) {
                $lastInsertBookTimingList[$item['time_id']] = $charterLogic->insertBookTiming($item);
                $sessionData['book_timing'][$key]['id'] = $lastInsertBookTimingList[$item['time_id']];
            }

            // Insert data to charter boat
            $lastInsertBoatCharter = null;
            if (!empty($lastInsertBookTimingList)) {
                $sessionData['book_charter']['last_booked'] = max($lastInsertBookTimingList);
                $lastInsertBoatCharter = $charterLogic->insertBoatCharter($sessionData['book_charter']);
            }

            if ($lastInsertBoatCharter) {
                foreach ($sessionData['book_timing'] as $item) {
                    $item['booked_id'] = $lastInsertBoatCharter;
                    $charterLogic->updateBookTiming($item);
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
                    $addtining .= ', Date: ' . date('jS F,Y', strtotime($item['date_book'])) . ' (';
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
                        'credit_id' => $credit_id, 'remarks' => 'Booking ID #' . $oderId . ' - ' . $addtining,
                        'deposit_amount' => '0', 'withdral_amount' => $discount_price, 'booking_id' => $lastInsertBoatCharter,
                        'balance' => '-' . $discount_price, 'user_id' =>  $user_id, 'add_date' => date("Y-m-d")
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
        //return redirect('/boat-detail/' . $boatId);
        return redirect('/');
    }

    public function paymentDetail($paymentId)
    {
        return $this->paypalSvc->getPaymentDetails($paymentId);
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
            } else {
                Mail::to('sales@tridentmarineasia.com')->cc($sessionData['boat_owner']['user_email'])->send(new TbsaSendMail($sessionData));
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
        $sessionData['from'] = 'info@theboatshopasia.com';
        try {
            // send Email
            Mail::to($sessionData['user_detail']['user_email'])->send(new TbsaSendMail($sessionData));
        } catch (\Exception $e) {
            Log::error('Send payment client mail failed. Detail: ' . $e->getMessage());
        }
    }
}
