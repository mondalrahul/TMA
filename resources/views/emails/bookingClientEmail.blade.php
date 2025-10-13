@extends('emails.indexEmail')
@section('content')
    <table width=650 border=0 cellpadding=5>
        <tr>
            <td  align='left' class='textstyle'>
                 
                <h4>Dear {{$contentEmails['user_detail']['user_name']}}</h4>
                <h3>Thank you for sending your booking request! </h3>

                <h2>Your booking details are as follows:</h2>
                <h4>Name: {{$contentEmails['user_detail']['user_name']}}</h4>
                <h4>Boat Name: {{strtoupper($contentEmails['boat_detail']['boat_name'])}}</h4>
                <h4>Country:  {{$contentEmails['boat_detail']['country']}}</h4>
                
                <h4>Date : {{$contentEmails['book_timing'][0]['date_book']->format('Y/m/d')}}</h4>
                 
                 
               @foreach($contentEmails['book_timing'] as $item)
                <p><span style="font-weight: bold">Time: </span> Starts on: @if($item['time_from'] > 12) {{$item['time_from']-12}} @else {{$item['time_from']}} @endif  @if($item['time_from'] > 12) Pm @else Am @endif -- Ends on: @if($item['time_to'] > 12) {{$item['time_to'] - 12}} @else {{$item['time_to']}} @endif @if($item['time_to'] > 12) Pm @else Am @endif -- Hours: {{$item['time_to'] - $item['time_from']}}</p>
            @endforeach
            @php
                if($contentEmails['book_charter']['discount_price'] > 0.1){ 
                  if($contentEmails['book_charter']['discount_type'] ==1){ 
                    $discounttype = 'Membership';
                    $code = $contentEmails['book_charter']['member_plan'];  
                  } else{ 
                    $discounttype = 'Credit'; 
                    $code =$contentEmails['book_charter']['credit_id']; 
                  }  @endphp 

                  <p id="confirm-seasports-brochure"><span><strong>{{$discounttype}}  Discount ({{$code}}) : </strong></span>  {{$contentEmails['book_charter']['currency']}} {{$contentEmails['book_charter']['discount_price']}}   </p>            
                  @php }     @endphp 
                <h4>Price :  {{$contentEmails['book_charter']['currency']}} {{$contentEmails['book_charter']['total_price']-$contentEmails['book_charter']['discount_price']}}</h4> 
                <h4>Status: Pending </h4> 
                <h4>Additional Request:  {{$contentEmails['comment'] }}  </h4> 
                   
            </td> </tr>
  <tr>
            <td  align='left' class='textstyle'>
           <p> Our team will contact you for the booking confirmation soon! </p>
</td>
        </tr>
    </table>
@endsection
