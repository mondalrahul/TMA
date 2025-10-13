<?php

use \App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Stripe\StripePaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

Route::get('/', 'Home\\HomeController@index')->name('home')->middleware(['cors']);
Route::post('/register', 'Controller@registerUser');
Route::post('/login', 'Controller@login');

Route::get('/login-book/{user_id}', 'Account\AccountController@LoginWithId')->where('user_id', '[0-9]+');
Route::post('/forgotpass', 'Home\HomeController@forgotpass')->name("forgot_pass");
Route::get('/logout', 'Controller@logout');
Route::post('/send-mail/contact-us', 'Controller@sendMailContact');
Route::post('/send-mail/enquiry-box', 'Controller@sendMailEnquiry');
Route::post('/send-mail/wire-transfer', 'Controller@sendMailWireTransfer');
Route::get('/boat-book/booking-confirm', 'Controller@getConfirmBox');
// Search boat base on boat type
Route::get('/trident-fleet/{boat_type}', 'Search\SearchController@search');
// Search boat from some conditions
Route::get('/search/boat', 'Search\SearchController@searchProductHome');
// Get boat detail
Route::get('/boat-detail/{boatId}', 'Search\SearchController@boatDetail');
// Get boat detail
Route::get('/boat-detail-test/{boat_id}', 'Search\SearchController@boatDetailTest');
Route::post('/submit-review', 'Account\AccountController@submitReview');
// Validate date from boat detail
Route::get('/boat-book/validDate', function (Request $request) {
    $controller = new \App\Http\Controllers\Search\SearchController();
    return $controller->validDateBoatDetail($request);
});
// Filter valid range date of specific boat
Route::get('/boat-book/filterDate', function (Request $request) {
    $controller = new \App\Http\Controllers\Search\SearchController();
    return $controller->getValidRangeDate($request);
});
// Calculate price when book boat
Route::get('/boat-book/getCalPrice', function (Request $request) {
    $controller = new \App\Http\Controllers\Search\SearchController();
    return $controller->calBoatPrice($request);
});
// Download file
Route::get('/download/{file_name}', function ($fileName) {
    $controller = new \App\Http\Controllers\DownloadController();
    return $controller->download($fileName);
});
// Read file
Route::get('/read/{file_name}', function ($fileName) {
    $controller = new \App\Http\Controllers\DownloadController();
    return $controller->download($fileName, true);
});
// Some static pages
//Route::get('/trident-life-style', function () {
//    return view('others/tridentlifestyle');
//});
Route::get('/trident-experiences', 'ExperienceController@trident_experience');
Route::get('/f&b', function () {
    return view('others/f&b');
});
Route::get('/yacht-brokerage', function () {
    return view('others/yachtbrokerage');
});
Route::get('/yacht-management', function () {
    $controller = new \App\Http\Controllers\YachtManagementController();
    return $controller->trident_experience();
});
Route::get('/contact-us', function () {
    return view('others/contactus');
});
Route::get('/faq', function () {
    $controller = new \App\Http\Controllers\FaqController();
    return $controller->faq();
});
Route::get('/my-bookings', 'Account\AccountController@myCharterListing');
Route::get('/my-credits', 'Account\AccountController@myCreditsListing')->name('credits.list');
Route::get('/credits/{cid}', 'Account\AccountController@myCreditsDetails')->name('credit.details');
Route::get('/my-boats', 'Account\AccountController@myBoats');
Route::post('/my-boats/delete', 'Account\AccountController@deleteMyBoats');
Route::get('/my-boats/add', 'Account\AccountController@addBoatPage');
Route::post('/my-boats/add', 'Account\AccountController@addBoat');
Route::get('/my-boats/update/{boat_id}', 'Account\AccountController@updateBoatPage');
Route::post('/my-boats/update/{boat_id}', 'Account\AccountController@updateBoat');

Route::get('/sendemail-to-admin', 'Account\AccountController@SendEmailToAdmin');

Route::get('/upgrade-account', function () {
    return view('others/upgrade-account');
});
Route::get('/boat-book-calendar', 'Account\AccountController@boatBookCalendarPage');
Route::get('/boat-book-calendar/{boat_id}', 'Account\AccountController@boatBookCalendarPage');
Route::post('/payment', function (Request $request) {
    $params = $request->all();
    Session::put('my_array_key', $params);
    if ($params['payment_method'] === 'paypal') {
        $paypalSrv = new \App\Services\PayPalService();
        $paypalController = new \App\Http\Controllers\PayPal\PaypalController($paypalSrv);
        return $paypalController->process($request, $params);
    } elseif ($params['payment_method'] === 'stripe') {
        return app()->make(StripePaymentController::class)->stripeCheckout($request);
    } else {
        // Handle unsupported payment method
        return response()->json(['error' => 'Unsupported payment method'], 400);
    }
});
Route::get('/paypal/status', 'PayPal\PaypalController@status');
Route::get('/stripe/status', 'Stripe\StripePaymentController@status')->name('stripe.status');
Route::get('/my-account', 'Controller@myAccount');
Route::post('/update-account', 'Controller@updateMyAccount');
Route::get('/admin', function () {
    return Redirect::to('https://www.theboatshopasia.com/admin-22-tbsa/');
});
// updated at 28/07
Route::post('/payment/processcom', 'StripePaymentController@processcom')->name('payment.processcom');
Route::get('/payment-confirmation', [StripePaymentController::class, 'paymentConfirmation'])->name('payment.confirmation');
Route::post('/capture', "StripePaymentController@capture")->name('stripe.capture');
