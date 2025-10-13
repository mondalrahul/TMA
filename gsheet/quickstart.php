<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
 
print_r( $_REQUEST);  
//require __DIR__ . '/vendor/autoload.php';

 

require   'vendor/autoload.php';

if (php_sapi_name() != 'cli') {

   // throw new Exception('This application must be run on the command line.');

}

define('SCOPES', implode(' ', array(

    Google_Service_Sheets::SPREADSHEETS,

    Google_Service_Sheets::DRIVE,

    Google_Service_Sheets::DRIVE_FILE) 

));

/**

 * Returns an authorized API client.

 * @return Google_Client the authorized client object

 */

function getClient()

{

    $client = new Google_Client();

    $client->setApplicationName('Google_Sheets_TBSA');

   // $client->setScopes(Google_Service_Sheets ::SPREADSHEETS,  Google_Service_Sheets::DRIVE, Google_Service_Sheets::DRIVE_FILE);

    $client->setScopes(SCOPES);



    $client->setAuthConfig('credentials.json');

    $client->setAccessType('offline');

    $client->setPrompt('select_account consent');



    // Load previously authorized token from a file, if it exists.

    // The file token.json stores the user's access and refresh tokens, and is

    // created automatically when the authorization flow completes for the first

    // time.

    $tokenPath = 'token.json';

    if (file_exists($tokenPath)) {

        $accessToken = json_decode(file_get_contents($tokenPath), true);

        

        $client->setAccessToken($accessToken);

    }

    

    



    // If there is no previous token or it's expired.

    if ($client->isAccessTokenExpired()) {

        // Refresh the token if possible, else fetch a new one.

        if ($client->getRefreshToken()) {

            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());

        } else {

            // Request authorization from the user.

            $authUrl = $client->createAuthUrl();

            printf("Open the following link in your browser:\n%s\n", $authUrl);

            print 'Enter verification code: ';

            $authCode = trim(fgets(STDIN));



            // Exchange authorization code for an access token.

            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

            $client->setAccessToken($accessToken);



            // Check to see if there was an error.

            if (array_key_exists('error', $accessToken)) {

                throw new Exception(join(', ', $accessToken));

            }

        }

        // Save the token to a file.

        if (!file_exists(dirname($tokenPath))) {

            mkdir(dirname($tokenPath), 0700, true);

        }

        file_put_contents($tokenPath, json_encode($client->getAccessToken()));

    }

    return $client;

}

$client = getClient();
$service = new Google_Service_Sheets($client);
$spreadsheetId = '1usQTfuMP4pT8izKPkM-k3z4rpccbEkxvQpMAxnHRbUU';
$range = 'Sheet1!A2:B';
/*
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues();
if (empty($values)) {
    print "No data found.\n";
} else {
     print "Name, Email:\n";
    foreach ($values as $row) {
        // Print columns A and E, which correspond to indices 0 and 4.
        printf("%s, %s\n", $row[0], $row[1]);
    }
}
*/
$options = array('valueInputOption' => 'RAW');
$values = [
     ["fffs", "hello@gmail.com", "16 Pasir Ris Link, Ripple Bay, #12-60", "Singapore", "518166", "94518832", "2", "y"] 
];

$body   = new Google_Service_Sheets_ValueRange(['values' => $values]);
$result = $service->spreadsheets_values->append($spreadsheetId, 'A1:I1', $body, $options);

print($result );