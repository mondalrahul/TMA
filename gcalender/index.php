<?php

 
require_once 'vendor/autoload.php';

$client = new Google_Client();
//The json file you got after creating the service account
putenv('GOOGLE_APPLICATION_CREDENTIALS=tbsa-04032021-1c79ab0b167f.json');
$client->useApplicationDefaultCredentials();
$client->setApplicationName("TBSA_calendar");
$client->setScopes(Google_Service_Calendar::CALENDAR);
$client->setAccessType('online');

$service = new Google_Service_Calendar($client);

$calendarList = $service->calendarList->listCalendarList();
print_r($calendarList);

$event = new Google_Service_Calendar_Event(array(
  'summary' => 'Test Event',
  'description' => 'Test Event',
  'start' => array(
    'dateTime' => '2021-06-02T09:00:00',
    'timeZone' => 'Asia/Singapore',
  ),
  'end' => array(
    'dateTime' => '2021-06-2T013:00:00',
    'timeZone' => 'Asia/Singapore',
  ),
  'attendees' => array(
    array('email' => 'lpage@example.com'),
    array('email' => 'sbrin@example.com'),
  )
));

$calendarId = 'qig4uu76dnlknsppugmj6bc1os@group.calendar.google.com';
$event = $service->events->insert($calendarId, $event);
printf('Event created: %s\n', $event->htmlLink);
?>