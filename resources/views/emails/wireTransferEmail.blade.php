@extends('emails.indexEmail')
@section('content')
<table width=650 border=0 cellpadding=5>
    <tr>
        <td colspan='2' align='left' class='textstyle'>
            @if(isset($contentEmails['book_charter']['id']))
            <h4>Booking ID: #{{$contentEmails['book_charter']['id']}}</h4>
            @endif
            <h2>Boat Name: {{strtoupper($contentEmails['boat_detail']['boat_name'])}}</h2>
            <h3>Total Cost: {{$contentEmails['book_charter']['currency']}} {{($contentEmails['book_charter']['total_price']-$contentEmails['book_charter']['discount_price'])}}</h3>
            <h4>Charterer Contract: Attached with the Email</h4>
            <h4>Payment Type: Bank Account Transfer</h4>
            <?php
            if($contentEmails['book_charter']['status']=='1'){
 
$statustext = 'Status : Confirmed (please print out a copy of this chit and bring along for your charter or show this on your
mobile device to the skipper)';
 
}elseif($contentEmails['book_charter']['status']=='0'){
	$statustext =   'Status : Pending Booking Confirmation (Note: this is not a confirmation of your booking. You will receive a confirmation note after the payment is processed. Your booking is valid for the next 48 hours. Please make payment within 48 hours or the booking will be automatically cancelled by the system. By making payment for this charter and embarking on the charter, you have accepted the terms and conditions of the charterer contract attached to this email)'; 
}else{
	$statustext =   'Status : Pending Payment (Note: this is not a confirmation of your booking. You will receive a confirmation note after the payment is processed. Your booking is valid for the next 48 hours. Please make payment within 48 hours or the booking will be automatically cancelled by the system. By making payment for this charter and embarking on the charter, you have accepted the terms and conditions of the charterer contract attached to this email)'; 
}
						?>
            <h4>{{$statustext}}</h4>
            <p>
                <img alt="" src="https://www.theboatshopasia.com/images/boat-type.jpg" class="CToWUd">
                Boat Type: {{$contentEmails['boat_category']['category_name']}}
                <img alt="" src="https://www.theboatshopasia.com/images/pax.jpg" class="CToWUd">
                Pax: {{$contentEmails['boat_detail']['pax']}}
                <img alt="" src="https://www.theboatshopasia.com/images/location.jpg" class="CToWUd">
                Location: {{$contentEmails['boat_detail']['marinas_name']}}
            </p>
                <h4>Booking for: {{$contentEmails['book_timing'][0]['date_book']->format('Y/m/d')}}</h4>
            @if(\Illuminate\Support\Facades\Auth::check())
            <h4>Membership Details</h4>
            <p>
                Membership Name: {{$contentEmails['user_detail']['user_name']}}</p>
            <p>
                Membership Type: {{$contentEmails['user_detail']['user_type']}}</p>
            <p>
            @else
            <p>
                <strong>Membership Details: Not Registered</strong></p>
            @endif
            <h4>Payment Details: </h4>
            @foreach($contentEmails['book_timing'] as $item)
                <p><span style="font-weight: bold">Time: </span> Starts on: @if($item['time_from'] > 12) {{$item['time_from']-12}} @else {{$item['time_from']}} @endif  @if($item['time_from'] > 12) Pm @else Am @endif -- Ends on: @if($item['time_to'] > 12) {{$item['time_to'] - 12}} @else {{$item['time_to']}} @endif @if($item['time_to'] > 12) Pm @else Am @endif -- Hours: {{$item['time_to'] - $item['time_from']}}</p>
            @endforeach
            <p>
                    Country:  {{$contentEmails['book_charter']['country']}}</p>
               
            <p>
                Charter Rate:  {{$contentEmails['book_charter']['currency']}} {{$contentEmails['book_charter']['timing_price']}}</p>
            <p>
                Add-Skipper:  {{$contentEmails['book_charter']['currency']}} {{$contentEmails['book_charter']['is_skiper']}}</p>
            <p>
                Referrer discount:  {{$contentEmails['book_charter']['currency']}} ${{$contentEmails['book_charter']['referrer_discount']}}</p>
            <p>
                Excess deposit:  {{$contentEmails['book_charter']['currency']}} {{$contentEmails['book_charter']['excess_deposit']}}</p>
            <p>
                Promo Code Discount:  {{$contentEmails['book_charter']['currency']}} 0.00</p>
            <p>
                Seasports brochure:  {{$contentEmails['book_charter']['currency']}} {{$contentEmails['seasport_brochure']}}</p>
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
            <p>
                Total:  {{$contentEmails['book_charter']['currency']}} {{($contentEmails['book_charter']['total_price']-$contentEmails['book_charter']['discount_price'])}}</p>
            <h4>Additional Request: {{$contentEmails['comment'] }} </h4> 
            
           @if($contentEmails['book_charter']['country']=='Malaysia')
            <h4>Name : The Boat Shop Asia (Malaysia) Sdn Bhd
Bank : United Overseas Bank (Jalan Imbi Branch)<br>
Account : 258-302-975-5 </h4>
         @else
         <h4><!--Bank Transfer to The Boat Shop Pte Ltd, DBS Bank Ltd., Account Number (Current Account): 0489041307 -->
                Trident Marine Asia Holdings Pte Ltd' via PayNow at UEN 201714561M011 or DBS Bank (current account) 0709024491
            </h4>
         @endif
            <h5>[NOTE : Your booking is valid for the next 48 hours. Please make payment within 48 hours or your booking will be automatically cancelled]</h5>
        </td>
    </tr>
</table>
@endsection
