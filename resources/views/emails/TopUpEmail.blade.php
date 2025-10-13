@extends('emails.indexEmail')
@section('content')
<table width=500 border=0 cellpadding=5>
    <tr>
        <td colspan='2' align='left' class='textstyle'>
            <p>Add Topup request from below user to book Boat</p>
            <p>Name : {{$contentEmails['user_name']}}</p>
            <p>Email : {{$contentEmails['user_email']}}</p>
        </td>
    </tr>
</table>
@endsection
