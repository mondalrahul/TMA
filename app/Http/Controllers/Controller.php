<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Search\SearchController;
use App\Http\Models\Logics\BoatCategoryTmaLogic;
use App\Http\Models\Logics\BoatCharterLogic;
use App\Http\Models\Logics\BoatLogic;
use App\Http\Models\Logics\BoatSeaSportsLogic;
use App\Http\Models\Logics\BoatTimePriceLogic;
use App\Http\Models\Logics\BoatUserLogic;
use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const PATTERN_USER_NAME = '/[a-zA-Z\s]$/';
    const PATTERN_USER_PASS = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/';
    const SITE_URL = 'https://tridentmarineasia.com.com/';
    // const MAIL_SALE_TRIDENT = 'sales@tridentmarineasia.com';
    const MAIL_SALE_TRIDENT = 'webgrity164@gmail.com';
    const MAIL_POSTMASTER_TRIDENT = 'postmaster@theboatshopasia.com';
    const MAIL_INFOSALE_TRIDENT = 'info@theboatshopasia.com';

    const DEFAULT_USER_SUBSCRIPTION = 0;
    const DEFAULT_USER_TYPE = 0;
    const DEFAULT_USER_DISCOUNT = 0;
    const DEFAULT_USER_REFERRER_ID = 0;
    const DEFAULT_USER_NEWSCHECK = 0;

    /**
     * Register new user
     *
     * @param Request $request
     * @return json
     * @author vduong daiduongptit090@gmail.com
     */
    public function registerUser(Request $request)
    {
        // default params
        $defaultParams = [
            'name'              => '',
            'user_email'        => '',
            'user_name'         => '',
            'user_password'     => '',
            'user_subscription' => self::DEFAULT_USER_SUBSCRIPTION,
            'user_address'      => '',
            'user_country'      => '',
            'user_city'         => '',
            'user_state'        => '',
            'user_zip'          => '',
            'user_status'       => '',
            'user_phone'        => '',
            'user_type'         => self::DEFAULT_USER_TYPE,
            'discount'          => self::DEFAULT_USER_DISCOUNT,
            'referrer_id'       => self::DEFAULT_USER_REFERRER_ID,
            'newscheck'         => self::DEFAULT_USER_NEWSCHECK,
            'profile_pic'       => '',
            'timezone'          => null,
            'referrer'          => null,
            'add_date'          => date('Y-m-d'),
            'add_updated'       => date('Y-m-d')
        ];

        $validator = Validator::make($request->all(), [
            'name'          => 'required|regex:' . self::PATTERN_USER_NAME,
            'user_email'    => 'required|email|unique:App\Http\Models\Entities\BoatUser,userEmail',
            'user_password' => 'required',
            'user_city'     => 'nullable',
            'user_address'  => 'required|string',
            'user_country'  => 'required|string',
            'user_state'    => 'required|string',
            'user_zip'      => 'nullable|numeric',
            'user_phone'    => 'nullable|numeric',
            // 'captcha' => 'required',
        ]);
        if ($validator->fails()) {
            return json_encode(['result' => false, 'errors' => $validator->errors()]);
        }

        // get params request
        $dataAdds = $request->all();
        $dataAdds['user_password'] = base64_encode($dataAdds['user_password']);
        if (!$dataAdds['user_zip']) {
            $dataAdds['user_zip'] = '';
        }
        if (!$dataAdds['user_city']) {
            $dataAdds['user_city'] = 'NA';
        }
        // Insert to table
        // $boatUserLogic = new BoatUserLogic();
        // $lastInsertId = $boatUserLogic->insertData($dataAdds);/
        $data = array_merge($defaultParams, $dataAdds);

        $boatUer = new User();
        $boatUer->name = $data['name'];
        $boatUer->user_email = $data['user_email'];
        $boatUer->user_name = $data['name'];
        $boatUer->user_password = $data['user_password'];
        $boatUer->user_subscription = $data['user_subscription'];
        $boatUer->user_address = $data['user_address'];
        $boatUer->user_country = $data['user_country'];
        $boatUer->user_city = $data['user_city'];
        $boatUer->user_state = $data['user_state'];
        $boatUer->user_zip = $data['user_zip'];
        $boatUer->user_status = $data['user_status'];
        $boatUer->user_phone = $data['user_phone'];
        $boatUer->user_type = $data['user_type'];
        $boatUer->discount = $data['discount'];
        $boatUer->referrer_id = $data['referrer_id'];
        $boatUer->referrer = $data['referrer'];
        $boatUer->newscheck = $data['newscheck'];
        $boatUer->profile_pic = $data['profile_pic'];
        $boatUer->timezone = $data['timezone'];
        $boatUer->save();
        $lastInsertId = $boatUer->user_id;
        DB::table('boat_user_membership')->insert(
            [
                'membership_id' => '3', 'user_id' => $lastInsertId,
                'add_date' => date("Y-m-d"), 'expiry' => date('Y-m-d', strtotime('+5 years'))
            ]
        );

        // return json_encode(['result' => true]);
        // $dataAdds['link_active']='https://www.theboatshopasia.com/login.php?ses='.session_id().'&u='.$lastInsertId;
        $dataAdds['link_active'] = 'https://www.tridentmarineasia.com?u=' . $lastInsertId;
        if ($lastInsertId) {
            $dataAdds['subject'] = sprintf('Thank you for registering with %s',  'Tridentmarineasia');
            try {
                Mail::send('emails.registerEmail', ['contentEmails' => $dataAdds], function ($message) use ($dataAdds) {
                    // $message->setContentType('text/html');
                    $message->from(self::MAIL_POSTMASTER_TRIDENT);
                    $message->to(self::MAIL_SALE_TRIDENT);
                    $message->bcc(self::MAIL_INFOSALE_TRIDENT);
                    $message->subject($dataAdds['subject']);
                });
                Mail::send('emails.registerEmail', ['contentEmails' => $dataAdds], function ($message) use ($dataAdds) {
                    // $message->setContentType('text/html');
                    $message->from(self::MAIL_POSTMASTER_TRIDENT);
                    $message->to($dataAdds['user_email']);
                    $message->subject($dataAdds['subject']);
                });
                return json_encode(['result' => true, 'message' => 'Thank you for creating a new account with us, Please check your email for activation your account.']);
            } catch (\Exception $e) {
                return json_encode(['result' => false, 'message' => 'Send mail failed. Please try again.' . $e]);
            }

            $defaultParams = [
                'user_id' => $lastInsertId,
                'charter_contract' => '',
                'ppcdl'        => '',
                'next_kin'         => '',
                'next_kin_contact'     => '',
                'self_drive' => '0',
                'activity_preference'      => '',
                'referrer_id'      => '0',
                'referrer_discount'         => '0.00',
                'loyalty_discount'        => '0.00',
                'last_update'          => date("Y-m-d"),
                'status'       => 'n'
            ];

            $userextend = DB::table('user_extend')->insert($defaultParams);
        }
    }

    /**
     * Login
     *
     * @param Request $request
     * @return json
     * @author vduong daiduongptit090@gmail.com
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login_email'    => 'required|email|exists:App\Http\Models\Entities\BoatUser,userEmail',
            'login_password' => 'required'
        ]);

        if ($validator->fails()) {
            return json_encode(['result' => false, 'errors' => $validator->errors()]);
        }

        $dataPosts = $request->all();
        $credentials = [
            'user_email' => $dataPosts['login_email'],
            'password' => $dataPosts['login_password'],
        ];

        if (Auth::attempt($credentials, true)) {
            DB::table('boat_user_loginlog')->insert([
                'user_email' => $request->input('login_email'),
                'last_login' =>  date('Y-m-d')
            ]);

            $notComment = DB::table('boat_charter_book')->where('ratingyes', '=', 0)->where('user_id', '=', Auth::id());
            if ($notComment->count() > 0) {
                $request->session()->put('forgetRating', true);
            }
            return json_encode(['result' => true]);
        }

        return json_encode(['result' => false]);
    }

    /**
     * Logout
     *
     * @return json
     * @author vduong daiduongptit090@gmail.com
     */
    public function logout()
    {
        Auth::logout();
        Session::forget('adminlogin');
        //return json_encode(['result' => true]);
        return redirect('/');
    }

    /**
     * Register new user
     *
     * @param Request $request
     * @return json
     * @author vduong daiduongptit090@gmail.com
     */
    public function sendMailContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'   => 'required|string',
            'last_name'    => 'required|string',
            'email'        => 'required|email',
            'phone'        => 'nullable',
            'subject'      => 'required|string',
            'message'      => 'required|string',
        ]);
        if ($validator->fails()) {
            return json_encode(['result' => false, 'errors' => $validator->errors()]);
        }
        $dataAdds = $request->all();
        $response = $dataAdds["g-recaptcha-response"];

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array(
            'secret' => '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe',
            'response' => $_POST["g-recaptcha-response"]
        );
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' =>
                "Content-Type: application/x-www-form-urlencoded\r\n",

                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $verify = file_get_contents($url, false, $context);
        $captcha_success = json_decode($verify);

        if ($captcha_success->success == false) {
            Session::flash('message_send', 'Captcha is required');
            return redirect('/contact-us');
        } else if ($captcha_success->success == true) {


            // send Email
            $dataAdds['subject'] = 'Email contact';
            try {
                Mail::send('emails.contactEmail', ['contentEmails' => $dataAdds], function ($message) use ($dataAdds) {
                    // $message->setContentType('text/html');
                    $message->from($dataAdds['email'], $dataAdds['first_name']);
                    $message->to(self::MAIL_SALE_TRIDENT);
                    $message->bcc(self::MAIL_INFOSALE_TRIDENT);
                    $message->subject($dataAdds['subject']);
                });
                Session::flash('message_send', 'Your enquiry has been sent successfully. Please allow 24 hours for the team to get back to you.  <br/> For urgent matters, please contact + 65 6904 8327.');
                return redirect('/contact-us');
            } catch (\Exception $e) {
                Session::flash('message_send', 'Failed to send email. Please try again.');
                return redirect('/contact-us');
            }
        }
    }

    /**
     * Send enquiry email
     *
     * @param Request $request
     * @return json
     * @author vduong daiduongptit090@gmail.com
     */
    public function sendMailEnquiry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'enquiry_user_name'          => 'required|string',
            'enquiry_user_email'         => 'required|email',
            'enquiry_user_phone'         => 'nullable|numeric',
            'enquiry_user_alter_phone'   => 'nullable|numeric',
            'enquiry_user_selected_date' => 'required|date',
            'enquiry_user_other_info'    => 'nullable|string',
            'enquiry_book_boat_name'     => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return json_encode(['result' => false, 'errors' => $validator->errors()]);
        }

        // get params request
        $dataAdds = $request->all();

        // sea sports
        if (isset($dataAdds['charter_agreement']) && $dataAdds['charter_agreement'] === 'true') {
            // Get lists sea sports
            $boatSeaSportsLogic = new BoatSeaSportsLogic();
            $seaSportsIds = explode(',', trim($dataAdds['charter_seas_sports_lists_ids']));
            $boatSeaSportsCheckedLists = $boatSeaSportsLogic->getSeaSportsListBaseOnIds($seaSportsIds);

            // Wrong data
            if (count($boatSeaSportsCheckedLists) !== count($seaSportsIds)) {
                return json_encode(['result' => false, 'message' => 'Wrong data. Please try again!']);
            }

            // Then
            $dataAdds['sea_sports_list'] = array_column($boatSeaSportsCheckedLists, 'name');
        }

        // send Email
        $dataAdds['subject'] = sprintf('Enquiry for %s on %s', $dataAdds['enquiry_book_boat_name'], $dataAdds['enquiry_user_selected_date']);
        try {
            Mail::send('emails.enquiryEmail', ['contentEmails' => $dataAdds], function ($message) use ($dataAdds) {
                // $message->setContentType('text/html');
                $message->from($dataAdds['enquiry_user_email']);
                $message->to(self::MAIL_SALE_TRIDENT);
                $message->bcc(self::MAIL_INFOSALE_TRIDENT);
                $message->subject($dataAdds['subject']);
            });
            return json_encode(['result' => true, 'message' => 'Email successfully sent!']);
        } catch (\Exception $e) {
            return json_encode(['result' => false, 'message' => 'Send mail failed. Please try again.' . $e]);
        }
    }

    /**
     * Send wia transfer email
     *
     * @param Request $request
     * @return json
     * @author vduong daiduongptit090@gmail.com
     */
    public function sendMailWireTransfer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'wire_transfer_email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return json_encode(['result' => false, 'errors' => $validator->errors()]);
        }

        // get params request
        $dataAdds = $request->all();

        // Process add charter boat
        $userData = '';
        if (Auth::check()) {
            $userData = Auth::user();
        }
        $dataAddsDACB = $this->prepareDataAddCharterBoat($dataAdds, $userData);
        if (isset($dataAddsDACB['result'])) {
            if ($dataAddsDACB['result'] == false) {
                return json_encode($dataAddsDACB);
            }
        }

        // dd($dataAddsDACB);
        if (Auth::check()) {
            $dataAdds = $this->addCharterBoatBankTransfer($dataAddsDACB);
            // return ['result' => false, 'message' => $dataAdds['boat_category']];
        }

        // Config content
        $memberplan = DB::table('boat_membership')->where('membership_id', $dataAdds['membership_id'])->first();
        $oderId = (isset($dataAdds['book_charter']['id'])) ? $dataAdds['book_charter']['id'] : 'Not Registered';
        $dataAdds['subject']  = 'Order ID: ' . $oderId;
        $discount_price = $dataAdds['book_charter']['discount_price'] = $dataAdds['discount_price'];
        $discount_type = $dataAdds['book_charter']['discount_type'] = $dataAdds['discount_type'] ?? 0;
        $membership_id = $dataAdds['book_charter']['membership_id'] = $dataAdds['membership_id'];
        $credit_id = $dataAdds['book_charter']['credit_id'] =  $dataAdds['credit_id'];
        $member_plan = $dataAdds['book_charter']['member_plan'] = !empty($memberplan->title) ? $memberplan->title : 'NA';

        DB::table('boat_charter_book')->where('book_id', $oderId)->update(['comment' => $dataAdds['comment'], 'country' => $dataAdds['book_charter']['country'], 'currency' => $dataAdds['book_charter']['currency'], 'book_type' => $dataAdds['book_charter']['book_type']]);
        if ($discount_type > 0) {
            DB::table('boat_charter_book')->where('book_id', $oderId)->update(['discount_price' => $discount_price, 'discount_type' => $discount_type, 'membership_id' => $membership_id, 'credit_id'     => $credit_id]);
            $addtining = $dataAdds['boat_detail']['boat_name'];
            foreach ($dataAdds['book_timing'] as $item) {
                $addtining .= ', Date: ' . date('jS F,Y', strtotime($dataAdds['booked_time_date'])) . ' (';
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
                    'deposit_amount' => '0', 'withdral_amount' => $discount_price, 'booking_id' => $oderId,
                    'balance' => '-' . $discount_price, 'user_id' =>   Auth::id(), 'add_date' => date("Y-m-d")
                ]
            );
        }

        if ($dataAdds['book_charter']['book_type'] == 'Skippered') {
            try {
                Mail::send('emails.bookingClientEmail', ['contentEmails' => $dataAdds], function ($message) use ($dataAdds) {
                    // $message->setContentType('text/html');
                    $message->from(self::MAIL_POSTMASTER_TRIDENT);
                    $message->to($dataAdds['wire_transfer_email']);
                    //$message->bcc('sales@tridentmarineasia.com', $dataAdds['boat_owner']['user_email'] ); 
                    $message->subject('Booking Request: ' . $dataAdds['book_charter']['id']);
                });
                Mail::send('emails.bookingAdminEmail', ['contentEmails' => $dataAdds], function ($message) use ($dataAdds) {
                    // $message->setContentType('text/html');
                    $message->from(self::MAIL_POSTMASTER_TRIDENT);
                    $message->to(self::MAIL_SALE_TRIDENT);
                    $message->cc($dataAdds['boat_owner']['user_email']);
                    $message->subject('Booking Request: ' .  $dataAdds['book_charter']['id']);
                });
                return json_encode(['result' => true, 'message' => 'Email successfully sent!']);
            } catch (\Exception $e) {
                return json_encode(['result' => true, 'message' => 'Send mail failed. Please try again!' .  $e->getMessage()]);
            }
        } else {
            try {
                // send Email
                Mail::send('emails.wireTransferEmail', ['contentEmails' => $dataAdds], function ($message) use ($dataAdds) {
                    // $message->setContentType('text/html');
                    $message->from(self::MAIL_POSTMASTER_TRIDENT);
                    $message->to($dataAdds['wire_transfer_email']);
                    $message->bcc('testing.web017@gmail.com');
                    $message->subject($dataAdds['subject']);
                    if ($dataAdds['boat_detail']['charterer_contract_checkbox'] == 'on') {
                        $filePath = public_path('images/product/' . $dataAdds['boat_detail']['contractpaper']);
                        if (file_exists($filePath)) {
                            $message->attach($filePath);
                        }
                    }
                    if ($dataAdds['boat_detail']['operating_manual'] != "") {
                        $filePath = public_path('images/product/' . $dataAdds['boat_detail']['operating_manual']);
                        if (file_exists($filePath)) {
                            $message->attach($filePath);
                        }
                    }
                    if ($dataAdds['boat_detail']['charterer_sop'] != "") {
                        $filePath = public_path('images/product/' . $dataAdds['boat_detail']['charterer_sop']);
                        if (file_exists($filePath)) {
                            $message->attach($filePath);
                        }
                    }
                });
                Mail::send('emails.wireTransferEmail', ['contentEmails' => $dataAdds], function ($message) use ($dataAdds) {
                    // $message->setContentType('text/html');
                    $message->from(self::MAIL_POSTMASTER_TRIDENT);
                    $message->to(self::MAIL_SALE_TRIDENT);
                    $message->cc($dataAdds['boat_owner']['user_email']);
                    $message->bcc('testing.web017@gmail.com');
                    $message->subject($dataAdds['subject']);
                    if ($dataAdds['boat_detail']['charterer_contract_checkbox'] == 'on') {
                        $filePath = public_path('images/product/' . $dataAdds['boat_detail']['contractpaper']);
                        if (file_exists($filePath)) {
                            $message->attach($filePath);
                        }
                    }
                    if ($dataAdds['boat_detail']['operating_manual'] != "") {
                        $filePath = public_path('images/product/' . $dataAdds['boat_detail']['operating_manual']);
                        if (file_exists($filePath)) {
                            $message->attach($filePath);
                        }
                    }
                    if ($dataAdds['boat_detail']['charterer_sop'] != "") {
                        $filePath = public_path('images/product/' . $dataAdds['boat_detail']['charterer_sop']);
                        if (file_exists($filePath)) {
                            $message->attach($filePath);
                        }
                    }
                });

                return json_encode(['result' => true, 'message' => 'Email successfully sent!']);
            } catch (\Exception $e) {
                return json_encode(['result' => true, 'message' => 'Send mail failed. Please try again!' .  $e->getMessage() . " On Line: " . $e->getLine() . " Code: " . $e->getCode(), 'Trace' => $e->getTrace()]);
            }
        }
    }

    /**
     * Go to myAccount
     *
     * @return view
     * @author vduong daiduongptit090@gmail.com
     */
    public function myAccount(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/');
        }
        $userData = Auth::user();
        $userName = $this->filterUserName($userData);
        $avatarPath = 'images/avatar/';

        $userloginlast =  DB::table('boat_user_loginlog')
            ->select('last_login')
            ->where('user_email', '=', $userData->user_email)
            ->orderBy('logid', 'desc')->limit(2)
            ->get();

        $Membership =  DB::table('boat_user_membership')
            ->select('*')
            ->join('boat_membership', 'boat_membership.membership_id', '=', 'boat_user_membership.membership_id')
            ->where('boat_user_membership.user_id', '=', $userData->user_id)
            ->orderBy('mid', 'desc')->limit(1)
            ->get();

        $courses = DB::table('boat_user_course')
            ->select('course')
            ->where('user_id', '=', $userData->user_id)
            ->orderBy('cid', 'desc')
            ->get();

        $expire_on = DB::table('boat_user_membership')
            ->select('expiry')
            ->where('user_id', '=', $userData->user_id)
            ->get();

        $membership_id = DB::table('boat_user_membership')
            ->select('membership_id')
            ->where('user_id', '=', $userData->user_id)
            ->get();

        //print_r($membership_id);

        if (count($userloginlast) > 1) {
            $lastLoginDateTime = $userloginlast[1]->last_login;
        } else {
            $lastLoginDateTime = $userData->last_login;
        }
        $rangeLogin = date_diff(date_create($lastLoginDateTime), date_create(date('Y-m-d H:i:s')));
        
        if (isset($membership_id[0])) {
            $member_value = $membership_id[0]->membership_id;
        } else {
            $member_value = 3; 
        }

        if(isset($expire_on[0])){
            $expiry = $expire_on[0]->expiry;
        }else{
            $expiry = "2055-05-30";
        }
        
        // dd($Membership);
        return view('account.myaccount', ['last_login' => $rangeLogin, 'Membership' => $Membership, 'courses' => $courses, 'avatar_path' => ['path' => $avatarPath], 'expire_on' => $expiry, 'membership_id' => $member_value]);
    }

    /**
     * Update myAccount
     *
     * @return view
     * @author vduong daiduongptit090@gmail.com
     */
    public function updateMyAccount(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $userData = Auth::user();
        $dataAdds = $request->all();

        $validateEmail = '';
        if ($request->all()['user_email'] !== $userData->user_email) {
            $validateEmail = '||unique:App\Http\Models\Entities\BoatUser,userEmail';
        }
        $dataAdds['user_address'] = $dataAdds['user_address'];

        $validator = Validator::make($dataAdds, [
            'user_name'     => 'required|regex:' . self::PATTERN_USER_NAME,
            'user_email'    => 'required|email' . $validateEmail,
            'user_password' => 'required',
            'user_city'     => 'required',
            'user_address'  => 'required|string',
            'user_country'  => 'required|string',
            'user_state'    => 'nullable|string',
            'user_zip'      => 'nullable|numeric',
            'user_phone'    => 'nullable|numeric',
            // 'self_drive' => 'nullable|numeric'
        ]);
        if ($validator->fails()) {
            return json_encode(['result' => false, 'errors' => $validator->errors()]);
        }

        // if exist upload avatar
        if (isset($dataAdds['avatar']) && !empty($dataAdds['avatar'])) {
            $avatarObj = $request->file('avatar');

            // Check file is image
            if (!$imageSize = getimagesize($avatarObj->getPathname())) {
                Session::flash('message_send', 'Image file is wrong format. Please check again.');
                return redirect('/my-account');
            }

            // Image size info
            if (filesize($avatarObj->getPathname()) > 4 * 1024 * 1024) {
                Session::flash('message_send', 'Image file size is too big. Please choose another image.');
                return redirect('/my-account');
            }

            // Create dir if need then move to that folder
            $userName = $this->filterUserName($userData);
            $avatarPath = public_path("images/avatar/");

            if (!file_exists($avatarPath)) {
                mkdir($avatarPath, 0777, true);
            }
            // Create with new name
            $fileName = 'avatar_' . $userData->user_id . '_' . time() . '.' . $avatarObj->getClientOriginalExtension();
            $avatarObj->move($avatarPath, $fileName);
            $dataAdds['profile_pic'] = $fileName;
        }

        // get params request
        $dataAdds['user_password'] = base64_encode($dataAdds['user_password']);
        if (!$dataAdds['user_zip']) {
            $dataAdds['user_zip'] = '';
        }
        // get user id
        $dataAdds['user_id'] = $userData->user_id;

        // Update to table
        $boatUserLogic = new BoatUserLogic();
        $boatUserLogic->updateData($dataAdds);
        Session::flash('message_send', 'Upload success.');
        return redirect()->back();
    }

    private function filterUserName($userData)
    {
        $userName = $userData->user_name;
        $userName = explode(' ', $userName);
        foreach ($userName as $key => $value) {
            if (empty($value)) {
                unset($userName[$key]);
            }
        }
        return implode('_', $userName);
    }

    private function addCharterBoatBankTransfer(array $dataAdds)
    {
        // Insert data to book timing
        $lastInsertBookTimingList = [];
        foreach ($dataAdds['book_timing'] as $key => $item) {
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
            $dataAdds['book_timing'][$key]['id'] = $lastInsertBookTimingList[$item['time_id']];
        }

        // Insert data to charter boat
        $lastInsertBoatCharter = null;
        if (!empty($lastInsertBookTimingList)) {
            $dataAdds['book_charter']['last_booked'] = max($lastInsertBookTimingList);
            $dataAdds['book_charter']['book_type'] = $dataAdds['book_charter']['book_type'];
            $dataAdds['book_charter']['country'] = $dataAdds['book_charter']['country'];
            $dataAdds['book_charter']['currency'] = $this->getCurrency($dataAdds['book_charter']['country']);
            $adminOrder = '';
            if (Session::has('adminlogin')) {
                $adminOrder = 'By Admin';
            }
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
                'user_manager' => $adminOrder,
                'payment_type' => 'Stripe',
                'ifskipper' => 0,
                'user_extrainfo' => '',
                'ratingyes' => 0,
                'seasport_brochure' => '',
                'book_type' => '',
            ];
            $defaultData = array_merge($defaultData, $dataAdds['book_charter']);
            $lastInsertId = DB::table('boat_charter_book')->insertGetId([
                'total_price' => $defaultData['total_price'],
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
                'book_type' => $defaultData['book_type']
            ]);
            $lastInsertBoatCharter = $lastInsertId;
        }

        if ($lastInsertBoatCharter) {
            foreach ($dataAdds['book_timing'] as $key => $item) {
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
                DB::table('boat_tbl_book_timing')->where('id', $dataAdds['book_timing'][$key]['id'])->update($defaultData);
            }
        }
        $dataAdds['book_charter']['id'] = $lastInsertBoatCharter;
        return $dataAdds;
    }

    public function getConfirmBox(Request $request)
    {
        // dd($request->all());
        // get params request
        $dataAdds = $request->all();
        $dataAdds['addition_error'] = 'NA';
        // Process add charter boat
        if (Auth::check()) {
            $userData = Auth::user();
            $dataAdds['user_detail'] = [
                'user_name' => $userData->user_name,
                'user_email' => ($dataAdds['payment_method'] === 'Paypal' || $dataAdds['payment_method'] === 'Stripe') ? $userData->user_email : trim($dataAdds['wire_transfer_email']),
                'user_address' => $userData->user_address,
            ];
        } else {
            $dataAdds['user_detail'] = [
                'user_name' => '',
                'user_email' => ($dataAdds['payment_method'] === 'Paypal' || $dataAdds['payment_method'] === 'Stripe') ? '' : trim($dataAdds['wire_transfer_email']),
                'user_address' => '',
            ];
        }

        $query = DB::table('boat_time_price')->select('id', 'time_id', 'date_for', 'price', 'time_from', 'time_to', 'boat_id', 'excess_deposit', 'skipper_price', 'currency')->where('boat_id', '=', $dataAdds['boat_id'])->where('date_for', '=', $dataAdds['booked_time_date'])->orderBy('id', 'DESC')->get();

        $boatTimePriceList = $query->toArray();
        if (empty($boatTimePriceList)) {
            $error = ['result' => false, 'message' => 'No time slots found!'];
            return $error;
        }

        // Get boat detail
        if ($dataAdds['boat_id'] == '615') {
            $query = DB::select("SELECT bo.*, btp.currency, btp.boatPrice, bm.marinas_name, bm.country AS marinas_country, tma.air_conditioning, tma.shower, tma.toilet, tma.jet_skis, tma.karaoke, tma.cooler_boxes, tma.kayak, tma.standup_paddle, tma.bbq_pit, tma.tender, tma.chiller, tma.wifi, tma.microwave, tma.jacuzzi, tma.water_donut, tma.sound_system FROM boat_tbl_boat bo LEFT JOIN (SELECT btp.boat_id AS boatId, btp.currency AS currency, MIN(NULLIF(btp.price, 0)) AS boatPrice FROM boat_time_price btp INNER JOIN boat_tbl_boat bo ON btp.boat_id = bo.boat_id AND btp.date_for >= NOW()WHERE btp.boat_id = " . $dataAdds['boat_id'] . " GROUP BY btp.currency) AS btp ON btp.boatId = bo.boat_id LEFT JOIN boat_marinas bm ON bo.marina = bm.marinas_id LEFT JOIN tma_facilities tma ON tma.boat_id = bo.boat_id WHERE bo.boat_id = " . $dataAdds['boat_id'] . " AND bo.status = 'y'");
        } else {
            $query = DB::select("SELECT bo.*, btp.currency, btp.price, bo.book_type, bo.credit_available, bm.marinas_name, bm.country AS marinas_country, tma.air_conditioning, tma.shower, tma.toilet, tma.jet_skis, tma.karaoke, tma.cooler_boxes, tma.kayak, tma.standup_paddle, tma.bbq_pit, tma.tender, tma.chiller, tma.wifi, tma.microwave, tma.jacuzzi, tma.water_donut, tma.sound_system FROM boat_tbl_boat bo LEFT JOIN boat_time_price btp ON btp.boat_id = bo.boat_id LEFT JOIN boat_marinas bm ON bo.marina = bm.marinas_id LEFT JOIN tma_facilities tma ON tma.boat_id = bo.boat_id WHERE bo.boat_id = " . $dataAdds['boat_id'] . " AND bo.status = 'y' GROUP BY btp.currency;");
        }

        $boatDetail = collect($query[0]);
        // print_r($boatDetail);

        $dataAdds['boat_detail'] = $boatDetail->toArray();

        $bookTimeList = explode(',', $dataAdds['booked_time_list']);
        $dataBookTimeList = [];
        $charterBookedData = DB::select("SELECT btt.* FROM
        boat_tbl_book_timing btt WHERE btt.boat_id = " . $dataAdds['boat_id'] . " AND btt.date_book = '" . $dataAdds['booked_time_date'] . "' AND btt.is_cancel = '0'");
        $charterBookedData = collect($charterBookedData)->toArray();

        foreach ($boatTimePriceList as $item) {
            if (in_array($item->id, $bookTimeList)) {
                $dataBookTimeList[$item->id] = $item;
                if (!empty($charterBookedData)) {

                    if (array_key_exists($item->id, $charterBookedData)) {
                        if ($charterBookedData[$item->id]['isCancel'] == 0) {
                            $dataAdds['addition_error'] .= 'Choose Another Timeslot';
                        } else {
                            $dataAdds['addition_error'] .= '';
                        }
                    }
                }
            }
        }

        // // Check valid book time list data
        if (count($bookTimeList) != count($dataBookTimeList)) {
            $error = ['result' => false, 'message' => 'No time slots found!'];
            return $error;
        }

        $boatSeaSportsCheckedLists = [];
        if (isset($dataAdds['charter_agreement']) && $dataAdds['charter_agreement'] === 'true') {
            // Get lists sea sports
            $seaSportsIds = explode(',', trim($dataAdds['charter_seas_sports_lists_ids']));
            //$boatSeaSportsCheckedLists = DB::select('SELECT bs.* FROM boat_seasports_brochure bs WHERE bs.id IN(' . implode(",", $seaSportsIds) ?? [] . ') ORDER BY bs.id ASC');

            $boatSeaSportsCheckedLists = DB::table('boat_seasports_brochure')->whereIn('id', $seaSportsIds)->orderBy('id', 'asc')->get();
            $boatSeaSportsCheckedLists = $boatSeaSportsCheckedLists->toArray();



            // Wrong data
            if (count($boatSeaSportsCheckedLists) !== count($seaSportsIds)) {
                $error = ['result' => false, 'message' => 'Wrong data. Please try again!'];
                return $error;
            }
        }

        // Process total price
        $totalPrice = 0;
        $skipperPrice = 0;
        $excessDeposit = 0;
        $timingPrice = 0;
        $seaSportPrice = 0;
        $seaSportBrochure = [];

        $countTimeSlots = 0;
        foreach ($dataBookTimeList as $item) {
            $countTimeSlots++;
            // Sea sport
            if (isset($dataAdds['charter_agreement']) && $dataAdds['charter_agreement'] === 'true' && count($boatSeaSportsCheckedLists) > 0) {
                foreach ($boatSeaSportsCheckedLists as $key => $value) {
                    $seaSportPrice += $value->price;
                }
            }

            $skipperPrice += $item->skipper_price;
            $excessDeposit += $item->excess_deposit;
            $timingPrice += $item->price;
            if ($dataAdds['booked_skipper'] === '1') {
                $totalPrice += ($item->price + $item->skipper_price);
            } else {
                $totalPrice += ($item->price + $item->excess_deposit);
            }

            $dataAdds['book_timing'][] = [
                'time_from' => $item->time_from,
                'time_from_type' => ($item->time_from > 12) ? 'pm' : 'am',
                'time_to'   => $item->time_to,
                'time_to_type' => ($item->time_to > 12) ? 'pm' : 'am',
                'date_book' => new \DateTime($dataAdds['booked_time_date']),
                'add_date'  => new \DateTime($dataAdds['booked_time_date']),
            ];
        }

        if ($dataAdds['payment_method'] === 'Paypal' || $dataAdds['payment_method'] === 'Stripe') {
            $totalPrice = ($totalPrice + $seaSportPrice) + (($totalPrice + $seaSportPrice) * 3) / 100;
        } else {
            $totalPrice = ($totalPrice + $seaSportPrice);
        }

        foreach ($boatSeaSportsCheckedLists as $key => $item) {
            $seaSportBrochure[$item->name] = $item->price * $countTimeSlots;
        }

        $totalPrice = ($totalPrice + $dataAdds['additional_deposite']);
        $excessDeposit = ($dataAdds['additional_deposite'] + $excessDeposit);
        $dataAdds['book_charter'] = [
            'total_price'       => $totalPrice,
            'is_skiper'         => (isset($dataAdds['booked_skipper']) && $dataAdds['booked_skipper'] === '1') ? $skipperPrice : 0.00,
            'timing_price'      => $timingPrice,
            'excess_deposit'    => (isset($dataAdds['booked_skipper']) && $dataAdds['booked_skipper'] !== '1') ? $excessDeposit : $dataAdds['additional_deposite'],
            'referrer_discount' => 0,
            'ifskipper'         => (isset($dataAdds['booked_skipper']) && $dataAdds['booked_skipper'] === '1') ? 1 : 0,
            'seasport_price'    => $seaSportPrice
        ];
        $dataAdds['book_charter']['book_type'] = $boatDetail['book_type'];
        $dataAdds['book_charter']['country'] = $boatDetail['country'];
        $dataAdds['book_charter']['currency'] = $this->getCurrency($boatDetail['country']);
        $dataAdds['addition_request'] = trim($dataAdds['addition_request']);
        $member_plan = DB::table('boat_membership')->where('membership_id', $dataAdds['membership_id'])->first();

        // $dataAdds['book_charter']['discount_price'] = ($totalPrice * $member_plan['price'] ) / 100;
        // parseFloat(parseFloat(parseFloat(charter_price) * parseFloat(percentage)) / 100);
        $dataAdds['book_charter']['discount_price'] = $dataAdds['discount_price'];


        // return ['result' => false, 'message' => $dataAdds];
        $dataAdds['book_charter']['discount_type'] = $dataAdds['discount_type'] ?? 0;
        $dataAdds['book_charter']['membership_id'] = $dataAdds['membership_id'];
        $dataAdds['book_charter']['credit_id'] = $dataAdds['credit_id'];
        $dataAdds['book_charter']['member_plan'] = !empty($member_plan->title) ? $member_plan->title : 'NA';
        return view('elements.booking-confirm', compact('dataAdds'));
    }

    // Controller Function
    // public function getConfirmBox(Request $request)
    // {
    //     $dataAdds = $request->all();
    //     $dataAdds['addition_error'] = 'NA';

    //     // Process add charter boat
    //     $userData = Auth::user();
    //     $dataAdds['user_detail'] = [
    //         'user_name' => $userData->user_name ?? '',
    //         'user_email' => in_array($dataAdds['payment_method'], ['Paypal', 'Stripe']) ? $userData->user_email ?? '' : trim($dataAdds['wire_transfer_email']),
    //         'user_address' => $userData->user_address ?? '',
    //     ];

    //     // Retrieve Boat Time Price List
    //     $boatTimePriceList = DB::table('boat_time_price')
    //         ->select('id', 'time_id', 'date_for', 'price', 'time_from', 'time_to', 'boat_id', 'excess_deposit', 'skipper_price', 'currency')
    //         ->where('boat_id', $dataAdds['boat_id'])
    //         ->where('date_for', $dataAdds['booked_time_date'])
    //         ->orderBy('id', 'DESC')
    //         ->get();

    //     if ($boatTimePriceList->isEmpty()) {
    //         return ['result' => false, 'message' => 'No time slots found!'];
    //     }

    //     // Get Boat Detail
    //     $boatDetailQuery = "
    //         SELECT bo.*, btp.currency, btp.price, bm.marinas_name, bm.country AS marinas_country, 
    //             tma.air_conditioning, tma.shower, tma.toilet, tma.jet_skis, tma.karaoke, tma.cooler_boxes, 
    //             tma.kayak, tma.standup_paddle, tma.bbq_pit, tma.tender, tma.chiller, tma.wifi, tma.microwave, 
    //             tma.jacuzzi, tma.water_donut, tma.sound_system 
    //         FROM boat_tbl_boat bo 
    //         LEFT JOIN boat_time_price btp ON btp.boat_id = bo.boat_id 
    //         LEFT JOIN boat_marinas bm ON bo.marina = bm.marinas_id 
    //         LEFT JOIN tma_facilities tma ON tma.boat_id = bo.boat_id 
    //         WHERE bo.boat_id = :boat_id AND bo.status = 'y' 
    //         GROUP BY btp.currency
    //     ";
    //     $boatDetail = collect(DB::select($boatDetailQuery, ['boat_id' => $dataAdds['boat_id']]))->first();

    //     if (!$boatDetail) {
    //         return ['result' => false, 'message' => 'Boat details not found!'];
    //     }

    //     $dataAdds['boat_detail'] = (array) $boatDetail;

    //     // Process Booked Time List
    //     $bookTimeList = explode(',', $dataAdds['booked_time_list']);
    //     $dataBookTimeList = $boatTimePriceList->filter(fn($item) => in_array($item->id, $bookTimeList));

    //     $charterBookedData = DB::table('boat_tbl_book_timing')
    //         ->where('boat_id', $dataAdds['boat_id'])
    //         ->where('date_book', $dataAdds['booked_time_date'])
    //         ->where('is_cancel', '0')
    //         ->get()
    //         ->keyBy('id');

    //     foreach ($dataBookTimeList as $item) {
    //         if (isset($charterBookedData[$item->id]) && $charterBookedData[$item->id]->isCancel == 0) {
    //             $dataAdds['addition_error'] .= 'Choose Another Timeslot';
    //         }
    //     }

    //     if (count($bookTimeList) != count($dataBookTimeList)) {
    //         return ['result' => false, 'message' => 'No time slots found!'];
    //     }

    //     // Get Sea Sports Lists
    //     $boatSeaSportsCheckedLists = [];
    //     if (isset($dataAdds['charter_agreement']) && $dataAdds['charter_agreement'] === 'true') {
    //         $seaSportsIds = array_filter(explode(',', trim($dataAdds['charter_seas_sports_lists_ids'])));
    //         $boatSeaSportsCheckedLists = DB::table('boat_seasports_brochure')
    //             ->whereIn('id', $seaSportsIds)
    //             ->orderBy('id', 'asc')
    //             ->get();

    //         if (count($boatSeaSportsCheckedLists) !== count($seaSportsIds)) {
    //             return ['result' => false, 'message' => 'Wrong data. Please try again!'];
    //         }
    //     }

    //     // Calculate Prices
    //     $totalPrice = 0;
    //     $skipperPrice = 0;
    //     $excessDeposit = 0;
    //     $timingPrice = 0;
    //     $seaSportPrice = 0;
    //     $countTimeSlots = $dataBookTimeList->count();

    //     foreach ($dataBookTimeList as $item) {
    //         $skipperPrice += $item->skipper_price;
    //         $excessDeposit += $item->excess_deposit;
    //         $timingPrice += $item->price;
    //         $totalPrice += ($dataAdds['booked_skipper'] === '1') ? ($item->price + $item->skipper_price) : ($item->price + $item->excess_deposit);
    //     }

    //     foreach ($boatSeaSportsCheckedLists as $value) {
    //         $seaSportPrice += $value->price;
    //     }

    //     if (in_array($dataAdds['payment_method'], ['Paypal', 'Stripe'])) {
    //         $totalPrice = ($totalPrice + $seaSportPrice) * 1.03;
    //     } else {
    //         $totalPrice += $seaSportPrice;
    //     }

    //     $totalPrice += $dataAdds['additional_deposite'];
    //     $excessDeposit += $dataAdds['additional_deposite'];

    //     $member_plan = DB::table('boat_membership')->where('membership_id', $dataAdds['membership_id'])->first();

    //     $dataAdds['book_charter'] = [
    //         'total_price'       => $totalPrice,
    //         'is_skiper'         => ($dataAdds['booked_skipper'] === '1') ? $skipperPrice : 0.00,
    //         'timing_price'      => $timingPrice,
    //         'excess_deposit'    => ($dataAdds['booked_skipper'] === '1') ? 0.00 : $excessDeposit,
    //         'referrer_discount' => 0,
    //         'ifskipper'         => ($dataAdds['booked_skipper'] === '1') ? 1 : 0,
    //         'seasport_price'    => $seaSportPrice,
    //         'book_type'         => $boatDetail->book_type,
    //         'country'           => $boatDetail->marinas_country,
    //         'currency'          => $this->getCurrency($boatDetail->marinas_country),
    //         'discount_price'    => $dataAdds['discount_price'],
    //         'discount_type'     => $dataAdds['discount_type'] ?? 0,
    //         'membership_id'     => $dataAdds['membership_id'],
    //         'credit_id'         => $dataAdds['credit_id'],
    //         'member_plan'       => $member_plan->title ?? 'NA',
    //     ];

    //     $dataAdds['addition_request'] = trim($dataAdds['addition_request']);

    //     return view('elements.booking-confirm', compact('dataAdds'));
    // }



    private function prepareDataAddCharterBoat(array $dataAdds, $userData)
    {
        $userId = '';


        if (!empty($userData)) {
            $userId = $userData->user_id;
            $dataAdds['user_detail'] = [
                'user_name' => $userData->user_name,
                'user_type' => 'Charterer'
            ];
        }

        $user_extend = DB::table('boat_user_extend')->where('user_id',  $userId)->first();
        if ($user_extend) {
            $additional_deposite = $user_extend->additional_deposite;
        } else {
            $additional_deposite = 0;
        }
        // Prepare params and insert to database
        // $boatTimePriceLogic = new BoatTimePriceLogic();
        // $boatTimePriceList = $boatTimePriceLogic->getDataBaseOnDateAndBoat($dataAdds['booked_time_date'], $dataAdds['boat_id']);
        $boatTimePriceList = DB::select("SELECT btp.id, btp.time_id, btp.date_for, btp.price, btp.time_from, btp.time_to, btp.boat_id, btp.excess_deposit, btp.skipper_price, btp.currency FROM boat_time_price btp WHERE btp.boat_id = " . $dataAdds['boat_id'] . " AND btp.date_for = '" . $dataAdds['booked_time_date'] . "' ORDER BY btp.id DESC");
        $boatTimePriceList = collect($boatTimePriceList)->toArray();
        if (empty($boatTimePriceList)) {
            $error = ['result' => false, 'message' => "No open slot available."];
            return $error;
        }

        // return ['result' => false, 'message' => print_r($boatTimePriceList)];
        $bookTimeList = explode(',', $dataAdds['booked_time_list']);
        $dataBookTimeList = [];
        foreach ($boatTimePriceList as $item) {
            if (in_array($item->id, $bookTimeList)) {
                $dataBookTimeList[$item->id] = $item;
            }
        }
        // Check valid book time list data
        if (count($bookTimeList) != count($dataBookTimeList)) {
            $error = ['result' => false, 'message' => 'No time slots found!'];
            return $error;
        }

        $boatSeaSportsCheckedLists = [];
        if (isset($dataAdds['charter_agreement']) && $dataAdds['charter_agreement'] === 'true') {
            // Get lists sea sports
            $seaSportsIds = explode(',', trim($dataAdds['charter_seas_sports_lists_ids']));
            // $boatSeaSportsLogic = new BoatSeaSportsLogic();
            // $boatSeaSportsCheckedLists = $boatSeaSportsLogic->getSeaSportsListBaseOnIds($seaSportsIds);
            // $boatSeaSportsCheckedLists = DB::select("SELECT bs.* FROM boat_seasports_brochure bs WHERE bs.id IN(" . implode(",", $seaSportsIds) ?? [] . ") ORDER BY bs.id ASC");
            $boatSeaSportsCheckedLists = DB::table('boat_seasports_brochure')->whereIn('id', $seaSportsIds)->orderBy('id', 'asc')->get();
            $boatSeaSportsCheckedLists = $boatSeaSportsCheckedLists->toArray();

            // Wrong data
            if (count($boatSeaSportsCheckedLists) !== count($seaSportsIds)) {
                $error = ['result' => false, 'message' => 'Wrong data. Please try again!'];
                return $error;
            }
        }

        // Process total price
        $totalPrice = 0;
        $skipperPrice = 0;
        $excessDeposit = 0;
        $timingPrice = 0;
        $seaSportPrice = 0;
        $seaSportBrochure = [];
        $countTimeSlots = 0;

        foreach ($dataBookTimeList as $item) {
            $countTimeSlots++;
            // Sea sport
            if (isset($dataAdds['charter_agreement']) && $dataAdds['charter_agreement'] === 'true' && count($boatSeaSportsCheckedLists) > 0) {
                foreach ($boatSeaSportsCheckedLists as $key => $value) {
                    $seaSportPrice += $value->price;
                }
            }

            $skipperPrice += $item->skipper_price;
            $excessDeposit += $item->excess_deposit;
            $timingPrice += $item->price;
            if ($dataAdds['booked_skipper'] === '1') {
                $totalPrice += ($item->price + $item->skipper_price);
            } else {
                $totalPrice += ($item->price + $item->excess_deposit);
            }

            $dataAdds['book_timing'][] = [
                'time_id'        => $item->id,
                'boat_id'        => $item->boat_id,
                'time_from'      => $item->time_from,
                'time_to'        => $item->time_to,
                'date_book'      => new \DateTime($dataAdds['booked_time_date']),
                'add_date'       => new \DateTime(date('Y-m-d')),
                'user_id'        => $userId,
                'price'          => $item->price,
                'booktime'       => time(),
                'booked_id'      => 0
            ];
        }
        if ($skipperPrice > 0) {
            $additional_deposite = '0.00';
        }
        $excessDeposit = ($additional_deposite + $excessDeposit);
        $totalPrice = ($totalPrice + $seaSportPrice + $additional_deposite);
        foreach ($boatSeaSportsCheckedLists as $key => $item) {
            $seaSportBrochure[$item->name] = $item->price * $countTimeSlots;
        }
        $dataAdds['seasport_brochure'] = $seaSportPrice;
        $isPay = 'Stripe';
        $adminOrder = '';
        if (Session::has('adminlogin')) {
            $adminOrder = 'By Admin';
            $totalPrice = 0;

            // foreach ($dataBookTimeList as $item) {

            //     // Sea sport
            //     if (isset($dataAdds['charter_agreement']) && $dataAdds['charter_agreement'] === 'true' && count($boatSeaSportsCheckedLists) > 0) {
            //         foreach ($boatSeaSportsCheckedLists as $key => $value) {
            //             $seaSportPrice += $value->price;
            //         }
            //     }

            //     $skipperPrice += $item->skipper_price;
            //     $excessDeposit += $item->excess_deposit;
            //     $timingPrice += $item->price;
            //     if ($dataAdds['booked_skipper'] === '1') {
            //         $totalPrice += ($item->price + $item->skipper_price);
            //     } else {
            //         $totalPrice += ($item->price + $item->excess_deposit);
            //     }
            // }

            // $totalPrice = ($totalPrice + $seaSportPrice + $additional_deposite);
            // $totalPrice = ($totalPrice + $seaSportPrice) + (($totalPrice + $seaSportPrice) * 3) / 100;
            // $totalPrice = 500;

            $seaSportPrice = 0;
            $skipperPrice = 0;
            $excessDeposit = 0;
            $timingPrice = 0;
            foreach ($dataBookTimeList as $item) {
                $countTimeSlots++;
                // Sea sport
                if (isset($dataAdds['charter_agreement']) && $dataAdds['charter_agreement'] === 'true' && count($boatSeaSportsCheckedLists) > 0) {
                    foreach ($boatSeaSportsCheckedLists as $key => $value) {
                        $seaSportPrice += $value->price;
                    }
                }

                $skipperPrice += $item->skipper_price;
                $excessDeposit += $item->excess_deposit;
                $timingPrice += $item->price;
                if ($dataAdds['booked_skipper'] === '1') {
                    $totalPrice += ($item->price + $item->skipper_price);
                } else {
                    $totalPrice += ($item->price + $item->excess_deposit);
                }

                $dataAdds['book_timing'][] = [
                    'time_id'        => $item->id,
                    'boat_id'        => $item->boat_id,
                    'time_from'      => $item->time_from,
                    'time_to'        => $item->time_to,
                    'date_book'      => new \DateTime($dataAdds['booked_time_date']),
                    'add_date'       => new \DateTime(date('Y-m-d')),
                    'user_id'        => $userId,
                    'price'          => $item->price,
                    'booktime'       => time(),
                    'booked_id'      => 0
                ];
            }
            if ($skipperPrice > 0) {
                $additional_deposite = '0.00';
            }
            $totalPrice = ($totalPrice + $seaSportPrice);
            $totalPrice = $totalPrice + (($totalPrice * 3) / 100);
            $isPay = 'Admin Ordered';
        }


        $dataAdds['book_charter'] = [
            'total_price'       => $totalPrice,
            'boat_id'           => $dataAdds['boat_id'],
            'user_id'           => $userId,
            'add_date'          => new \DateTime(date('Y-m-d')),
            'status'            => 0,
            'is_skiper'         => (isset($dataAdds['booked_skipper']) && $dataAdds['booked_skipper'] === '1') ? $skipperPrice : 0.00,
            'is_coupon'         => 0,
            'timing_price'      => $timingPrice,
            'comment'           => '',
            'excess_deposit'    => (isset($dataAdds['booked_skipper']) && $dataAdds['booked_skipper'] !== '1') ? $excessDeposit : $additional_deposite,
            'referrer_discount' => 0,
            'user_manager'      => $adminOrder,
            'ifskipper'         => (isset($dataAdds['booked_skipper']) && $dataAdds['booked_skipper'] === '1') ? 1 : 0,
            'ratingyes'         => 0,
            'payment_type'      => $isPay,
        ];

        $seaSportBrochure = array_filter($seaSportBrochure);
        $dataTemp = [];
        if (!empty($seaSportBrochure)) {
            foreach ($seaSportBrochure as $key => $price) {
                $dataTemp[] = $key . ':' . $price;
            }
        }
        $dataAdds['book_charter']['seasport_brochure'] = (!empty($dataTemp)) ? implode(',', $dataTemp) : '';

        // Get boat detail
        if ($dataAdds['boat_id'] == '615') {
            $query = DB::select("SELECT bo.*, btp.currency, btp.boatPrice, bm.marinas_name, bm.country AS marinas_country, tma.air_conditioning, tma.shower, tma.toilet, tma.jet_skis, tma.karaoke, tma.cooler_boxes, tma.kayak, tma.standup_paddle, tma.bbq_pit, tma.tender, tma.chiller, tma.wifi, tma.microwave, tma.jacuzzi, tma.water_donut, tma.sound_system FROM boat_tbl_boat bo LEFT JOIN (SELECT btp.boat_id AS boatId, btp.currency AS currency, MIN(NULLIF(btp.price, 0)) AS boatPrice FROM boat_time_price btp INNER JOIN boat_tbl_boat bo ON btp.boat_id = bo.boat_id AND btp.date_for >= NOW()WHERE btp.boat_id = " . $dataAdds['boat_id'] . " GROUP BY btp.currency) AS btp ON btp.boatId = bo.boat_id LEFT JOIN boat_marinas bm ON bo.marina = bm.marinas_id LEFT JOIN tma_facilities tma ON tma.boat_id = bo.boat_id WHERE bo.boat_id = " . $dataAdds['boat_id'] . " AND bo.status = 'y'");
        } else {
            $query = DB::select("SELECT bo.*, btp.currency, btp.price, bo.book_type, bo.credit_available, bm.marinas_name, bm.country AS marinas_country, tma.air_conditioning, tma.shower, tma.toilet, tma.jet_skis, tma.karaoke, tma.cooler_boxes, tma.kayak, tma.standup_paddle, tma.bbq_pit, tma.tender, tma.chiller, tma.wifi, tma.microwave, tma.jacuzzi, tma.water_donut, tma.sound_system FROM boat_tbl_boat bo LEFT JOIN boat_time_price btp ON btp.boat_id = bo.boat_id LEFT JOIN boat_marinas bm ON bo.marina = bm.marinas_id LEFT JOIN tma_facilities tma ON tma.boat_id = bo.boat_id WHERE bo.boat_id = " . $dataAdds['boat_id'] . " AND bo.status = 'y' GROUP BY btp.currency;");
        }

        $boatDetail = collect($query[0])->toArray();
        $boatTypeData = DB::select("SELECT bct.* FROM boat_tbl_category_tma bct WHERE bct.category_id = " . $boatDetail['boat_type_tma']);
        $boatTypeData = collect($boatTypeData[0])->toArray();
        $boatUserOwner = DB::select("SELECT bu.* FROM boat_user bu WHERE bu.user_id = " . $boatDetail['user_id']);
        $boatUserOwner = collect($boatUserOwner[0])->toArray();

        $dataAdds['boat_detail'] = $boatDetail;
        $dataAdds['boat_owner'] = $boatUserOwner;
        $dataAdds['boat_category'] = $boatTypeData;
        $dataAdds['book_charter']['contract'] = $boatDetail['contractpdf'];
        $dataAdds['book_charter']['book_type'] = $boatDetail['book_type'];
        $dataAdds['book_charter']['country'] = $boatDetail['country'];
        $dataAdds['book_charter']['currency'] = $this->getCurrency($boatDetail['country']);
        return $dataAdds;
    }

    // function getCurrency($country)
    // {
    //     $url = 'https://restcountries.com/v3/name/' . $country;
    //     $curl = curl_init($url);
    //     curl_setopt($curl, CURLOPT_URL, $url);
    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    //     $resp = curl_exec($curl);
    //     $resp = json_decode($resp);
    //     return $resp[0]->currencies[0]->code . ' ';
    //     // return 'SG';
    // }

    function getCurrency($country)
    {
        $url = 'https://raw.githubusercontent.com/samayo/country-json/master/src/country-by-currency-code.json';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $resp = curl_exec($curl);
        $resp = json_decode($resp);

        foreach ($resp as $value) {
            if (ucfirst($value->country) === ucfirst($country)) {
                return $value->currency_code;
            }
        }
        
        return 'SGD';
    }
}
