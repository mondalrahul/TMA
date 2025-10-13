@extends('emails.indexEmail')
@section('content')
<table width=500 border=0 cellpadding=5>
    <tr>
        <td colspan='2' align='left' class='textstyle'>
            <p>
                Name : {{$contentEmails['first_name']}} {{$contentEmails['last_name']}}</p>
            <p>
                Email : {{$contentEmails['email']}}</p>
            @if(isset($contentEmails['phone']))
                <p>
                    Contact Number: {{$contentEmails['phone']}}.</p>
            @endif
            <p>
                Subject: {{$contentEmails['subject']}} 
            </p>
            <p>
                Message : {{$contentEmails['message']}}</p>
        </td>
    </tr>
</table>
@endsection
