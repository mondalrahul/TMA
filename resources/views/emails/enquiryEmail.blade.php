@extends('emails.indexEmail')
@section('content')
<table width=500 border=0 cellpadding=5>
    <tr>
        <td colspan='2' align='left' class='textstyle'>
            <p>
                Name : {{$contentEmails['enquiry_user_name']}}</p>
            <p>
                Email : {{$contentEmails['enquiry_user_email']}}</p>
            @if(isset($contentEmails['enquiry_user_phone']) && $contentEmails['enquiry_user_phone'])
                <p>
                    Contact Number : {{$contentEmails['enquiry_user_phone']}}</p>
            @endif
            @if(isset($contentEmails['enquiry_user_alter_phone']) && $contentEmails['enquiry_user_alter_phone'])
                <p>
                    Contact Alternative Number : {{$contentEmails['enquiry_user_alter_phone']}}</p>
            @endif
            @if(isset($contentEmails['enquiry_user_selected_date']) && $contentEmails['enquiry_user_selected_date'])
                <p>
                    Selected date : {{$contentEmails['enquiry_user_selected_date']}}</p>
            @endif
            @if(isset($contentEmails['enquiry_user_other_info']) && $contentEmails['enquiry_user_other_info'])
                <p>
                    Other info : {{$contentEmails['enquiry_user_other_info']}}</p>
            @endif
            @if(isset($contentEmails['enquiry_book_boat_name']) && $contentEmails['enquiry_book_boat_name'])
                <p>
                    Boat name : {{$contentEmails['enquiry_book_boat_name']}}</p>
            @endif
            @if(isset($contentEmails['sea_sports_list']) && !empty($contentEmails['sea_sports_list']))
                <p>
                    Charter Add-ons : {{implode(', ', $contentEmails['sea_sports_list'])}}</p>
            @endif
        </td>
    </tr>
</table>
@endsection
