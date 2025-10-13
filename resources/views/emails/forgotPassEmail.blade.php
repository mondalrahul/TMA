@extends('emails.indexEmail')
@section('content')
<table width=500 border=0 cellpadding=5>
    <tr>
        <td colspan='2' align='left' class='textstyle'>
            <p>
                Name : {{$contentEmails['name']}}  </p>
            <p>
                Email : {{$contentEmails['user_email']}}</p>
            
            <p>
                New Password: {{$contentEmails['password']}} 
            </p>
             
        </td>
    </tr>
</table>
@endsection
