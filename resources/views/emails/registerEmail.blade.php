@extends('emails.indexEmail')
@section('content')
<table width=500 border=0 cellpadding=5>
    <tr>
        <td colspan='2' align='left' class='textstyle'>
            <p>
                &nbsp;<span>{{$contentEmails['name']}}</span></p>
            <p>
                Thank you for signing up with Trident Marine Asia. Please click on the bellow link to activate your account.</p>
            <p>
                Activate your account: <span><a href='{{$contentEmails['link_active']}}}'>Click Here</a></span></p>
            <p>
                Name : {{$contentEmails['name']}}</p>
            <p>
                Email : {{$contentEmails['user_email']}}</p>
            <p>
                Password : Your Choosen Password</p>
            <p>
                Address : {{$contentEmails['user_address']}}</p>
            <p>
                Phone : {{$contentEmails['user_phone']}}</p>
            <p>
                Zip: {{$contentEmails['user_zip']}}</p>
        </td>
    </tr>
</table>
@stop