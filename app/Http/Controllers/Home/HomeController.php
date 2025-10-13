<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Models\Logics;
use Illuminate\Http\Request;
use App\Http\Models\Logics\BoatUserLogic;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\TextPart;

class HomeController extends Controller
{
    const MAIL_INFO_TRIDENT = 'info@theboatshopasia.com';
    const OCCASION_SEARCH = [
        'Show All',
        'Leisure' => 'Leisure',
        'Birthday' => 'Birthday',
        'Wedding' => 'Wedding',
        'Corporate Event' => 'Corporate Event',
        'Overseas' => 'Overseas'
    ];
    const BOAT_TYPE_SEARCH = [
        'Show All',
        'Monohull' => 'Monohull',
        'Catamaran' => 'Catamaran',
        'Super Yacht' => 'Super Yacht'
    ];
    const NUMBER_USER_SEARCH = [
        'Show All',
        1 => '1 - 10',
        11 => '11 - 20',
        21 => '21 - 30',
        31 => '31 - 40',
        41 => '41 - 50',
        51 => 'More than 50'
    ];
    const COUNTRY_SEARCH = [
        'Singapore',
        'Antigua and Barbuda',
        'Australia',
        'Bahamas',
        'Brazil',
        'British Virgin Islands',
        'Croatia',
        'Cuba',
        'France',
        'Guadeloupe',
        'Grenada',
        'Greece',
        'Indonesia',
        'Italy',
        'Malaysia',
        'Martinique',
        'Mauritius',
        'Mexico',
        'New Caledonia',
        'Puerto Rico',
        'Thailand',
        'Seychelles',
        'St. Vincent And The Greadines',
        'Spain',
        'St.Martin',
        'Sweden',
        'Tahiti',
        'Turkey',
        'United Kingdom (Great Britain)',
        'United States'
    ];
    /*
    const COUNTRY_SEARCH = [
        'Singapore','Afghanistan','Albania','Algeria','American Samoa','Andorra','Angola','Anguilla','Antarctica','Antigua and Barbuda','Argentina','Armenia','Aruba','Australia','Austria','Azerbaijan','Bahamas','Bahrain','Bangladesh','Barbados','Belarus','Belgium','Belize','Benin','Bermuda','Bhutan','Bolivia','Bosnia and Herzegowina','Botswana','Bouvet Island','Brazil','British Indian Ocean Territory','British Virgin Islands','Brunei Darussalam','Bulgaria','Burkina Faso','Burundi','Cambodia','Cameroon','Canada',
'Cape Verde','Cayman Islands','Central African Republic','Chad','Chile','China','Christmas Island','Cocos (Keeling) Islands','Colombia','Comoros','Congo','Cook Islands','Costa Rica','Cote D\'ivoire',
'Croatia','Cuba','Cyprus','Czech Republic','Czechoslovakia','Denmark','Djibouti','Dominica','Dominican Republic','East Timor','Ecuador','Egypt','El Salvador','Equatorial Guinea','Eritrea,Estonia',
'Ethiopia','Falkland Islands (Malvinas)','Faroe Islands','Fiji','Finland','France','France','French Guiana','French Polynesia','French Southern Territories','Gabon','Gambia',
'Georgia','Germany','Ghana','Gibraltar','Greece','Greenland','Grenada','Guadeloupe','Guam','Guatemala','Guinea','Guinea-Bissau','Guyana','Haiti','Heard and McDonald Islands','Honduras','Hong Kong',
'Hungary','Iceland','India','Indonesia','Iraq','Ireland','Islamic Republic of Iran','Israel','Italy','Jamaica','Japan','Jordan','Kazakhstan','Kenya','Kiribati','Korea','Korea','Republic of
Kuwait','Kyrgyzstan','Laos','Latvia','Lebanon','Lesotho','Liberia','Libyan Arab Jamahiriya','Liechtenstein','Lithuania','Luxembourg','Macau','Macedonia','Madagascar','Malawi','Malaysia','Maldives',
'Mali','Malta','Marshall Islands','Martinique','Mauritania','Mauritius','Mayotte', 'Metropolitan','Mexico','Micronesia','Moldova','Republic of Monaco','Mongolia','Montserrat','Morocco','Mozambique','Myanmar','Namibia',
'Nauru','Nepal','Netherlands','Netherlands Antilles','New Caledonia','New Zealand','Nicaragua','Niger','Nigeria','Niue','Norfolk Island','Northern Mariana Islands','Norway','Oman','Pakistan','Palau',
'Panama','Papua New Guinea','Paraguay','Peru','Philippines','Pitcairn','Poland','Portugal','Puerto Rico','Qatar','Reunion','Romania','Russian Federation','Rwanda','Saint Lucia','Samoa','San Marino',
'Sao Tome and Principe','Saudi Arabia','Senegal','Seychelles','Sierra Leone','Slovakia','Slovenia','Solomon Islands','Somalia','South Africa','Spain','Sri Lanka','St. Helena','St. Kitts And Nevis','St. Martin','St. Pierre and Miquelon','St. Vincent And The Greadines','Sudan','Suriname,Svalbard and Jan Mayen Islands','Swaziland','Sweden','Switzerland','Syrian Arab Republic','Tahiti','Taiwan',
'Tajikistan','Tanzania','Thailand','Togo','Tokelau','Tonga','Trinidad and Tobago','Tunisia','Turkey','Turkmenistan','Turks and Caicos Islands','Tuvalu','Uganda','Ukraine','United Arab Emirates',
'United Kingdom (Great Britain)','United States','United States Virgin Islands','Uruguay','Uzbekistan','Vanuatu','Vatican City State','Venezuela','Viet Nam','Wallis And Futuna Islands',
'Western Sahara','Yemen','Yugoslavia','Zaire','Zambia','Zimbabwe'

    ];
    */
    const PRICE_SEARCH = [
        'asc' => 'Ascending',
        'des' => 'Descending',
    ];

    /**
     * Homepage
     *
     * @author vduong daiduongptit090@gmail.com
     */
    public function index(Request $request)
    {
        //check auth and auth user id
        if (Auth::check() && Auth::user()->id == 475) {
            Session::put('adminlogin', 'yes');
        }


        // try {
        //     $dataAdds['user_name'] = 'Testing Web';
        //     $dataAdds['user_email'] = 'postmaster@theboatshopasia.com';

        //     $mail = Mail::send('emails.TopUpEmail', ['contentEmails' => $dataAdds], function ($message) use ($dataAdds) {
        //         // $message->setContentType('text/html');
        //         $message->from($dataAdds['user_email'], $dataAdds['user_name']);
        //         $message->to('d.baidya0012@gmail.com');
        //         $message->subject("Request for Credit Top-Up");
        //     });
        //     // if ($mail) {
        //     //     echo '<script>alert("Mail Send Succesfully");</script>';
        //     // } else {
        //     //     echo '<script>alert("Mail does Send Succesfully!");</script>';
        //     // }
        // } catch (\Exception $e) {
        //     dd($e);
        // }


        // Mail::raw('Hello World!', function ($msg) {
        //     $msg->from('admin@gardenstatesoapstone.com')->to('testing.web017@gmail.com')->subject('Test Email');
        // });

        $boatTimePriceList = DB::select("SELECT btp.id, btp.time_id, btp.date_for, btp.price, btp.time_from, btp.time_to, btp.boat_id, btp.excess_deposit, btp.skipper_price, btp.currency FROM boat_time_price btp WHERE btp.boat_id = 35 AND btp.date_for = '2023-9-17' ORDER BY btp.id DESC");
        $boatTimePriceList = collect($boatTimePriceList)->toArray();
        if (empty($boatTimePriceList)) {
            dd($boatTimePriceList);
        }

        // Create logic
        $boatCategoryLogic = new Logics\BoatCategoryLogic();
        $boatCountryLogic = new Logics\BoatCountryLogic();
        $boatNewsLetterLogic = new Logics\BoatNewsLetterLogic();
        $boatHomeSliderLogic = new Logics\BoatHomeSliderTmaLogic();
        header("Access-Control-Allow-Origin: *");
        // Get occation
        $data['occasion_search'] = self::OCCASION_SEARCH;

        // Get number user
        $data['no_of_people_search'] = self::NUMBER_USER_SEARCH;

        // Get all boat categories
        $data['boat_type_search'] = self::BOAT_TYPE_SEARCH;

        // Get defualt boat country
        $data['country_search'] = self::COUNTRY_SEARCH;

        // Get all slider active
        $data['boat_sliders'] = $boatHomeSliderLogic->getAllHomeSliderActive();

        $data['instagram_images'] = [];

        $data['forgetRating'] = $request->session()->pull('forgetRating') ? true : false;



        try {
            $url = "https://www.instagram.com/tridentmarineasia";
            $html = file_get_contents($url);
            $arr = explode('window._sharedData = ', $html);
            $arr = explode(';</script>', $arr[1]);
            $insta = json_decode($arr[0]);
            $items = $insta->entry_data->ProfilePage[0]->graphql->user->edge_owner_to_timeline_media->edges;
            $items = array_slice($items, 0, 6);
            $data['instagram_images'] = $items;
        } catch (\Exception $e) {
        }
        return view('home.index', ['data' => $data]);
    }


    /**
     * Forgot Password
     *
     * @author vduong daiduongptit090@gmail.com
     */
    public function forgotpass(Request $request)
    {
        $dataAdds = $request->all();
        // Check if the email exists
        $ifuser = User::where('user_email', '=', $request->email)->first();
        if (!empty($ifuser)) {
            try {
                $dataAdds = $ifuser;
                $dataAdds['password'] = $this->uniqpass();
                DB::table('boat_user')->where('user_id', $dataAdds['user_id'])->update(['user_password' => base64_encode($dataAdds['password'])]);

                Mail::send('emails.forgotPassEmail', ['contentEmails' => $dataAdds], function ($message) use ($dataAdds) {
                    // $message->setContentType('text/html');
                    $message->from(self::MAIL_INFO_TRIDENT, "Trident Marine Asia");
                    $message->to($dataAdds['user_email'], $dataAdds['name']);
                    $message->subject("Recovery Password : Trident Marine Asia");
                });
                Session()->put('femail', 'success');
                return redirect('/');
            } catch (\Exception $e) {
                // Redirect the user to the forgot password page with an error message
                // return redirect('/?error=email');
                dd($e);
            }
        } else {
            // Redirect the user to the forgot password page with an error message
            return redirect('/?error=email');
        }
    }

    public function uniqpass()
    {
        $comb = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $combLen = strlen($comb) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $combLen);
            $pass[] = $comb[$n];
        }
        return (implode($pass));
    }
}
