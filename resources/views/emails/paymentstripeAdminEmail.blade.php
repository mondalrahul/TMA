@extends('emails.indexEmail')
@section('content')
<table width=500 border=0 cellpadding=5>
    <table width=500 border=0 cellpadding=5>
        <tr>
            <td colspan='2' align='left' class='textstyle'>
                @if(isset($contentEmails['book_charter']['id']))
                    <h4>Booking ID: #{{$contentEmails['book_charter']['id']}}</h4>
                @endif
                <h2>Boat Name: {{strtoupper($contentEmails['boat_detail']['boat_name'])}}</h2>
                <h3>Total Cost: ${{$contentEmails['book_charter']['total_price']}}</h3>
                <h4>Charterer Contract: Attached with the Email</h4>
                <h4>Payment Type: Stripe</h4>
                <h4>Status: Paid Payment (Note: this is not a confirmation of your booking. You will receive a confirmation note after the payment is processed)</h4>
                <p>
                    <img alt="" src="https://ci3.googleusercontent.com/proxy/l8TZVw9nb2yPG_oyAcjrnKWZBiSBWIhHtKquqZNM8Tda-pImuvKWje9k6Sz1BWqmsRzuVPwxLs0NicLspnZLRdrQy6wExiELQdw=s0-d-e1-ft#https://www.theboatshopasia.com/images/boat-type.jpg" class="CToWUd">
                    Boat Type: {{$contentEmails['boat_category']['categoryName']}}
                    <img alt="" src="https://ci5.googleusercontent.com/proxy/vu_KldLvd3IxUMJ_82dWIQQ8JzLnMRMZvisVbFQV3-dVn8WQcKf13laYRW0v9Hp2XNkYDeqlVKlbE55qNk0lbB5efCs=s0-d-e1-ft#https://www.theboatshopasia.com/images/pax.jpg" class="CToWUd">
                    Pax: {{$contentEmails['boat_detail']['pax']}}
                    <img alt="" src="https://ci3.googleusercontent.com/proxy/KNhqARNHeZ-aNT6eyTfF1jeb3DQ3fS-mTnDaniM20a--J5qCLmNdbQBxksRM5Vw7kyOdb52ZbGDfc7JF_cR1S-ylr4jr7wpNew=s0-d-e1-ft#https://www.theboatshopasia.com/images/location.jpg" class="CToWUd">
                    Location: {{$contentEmails['boat_detail']['marinas_name']}}
                </p>
                <h4>Booking for: {{$contentEmails['book_charter']['add_date']->format('Y/m/d')}}</h4>
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
                    <p><span style="font-weight: bold">Time: </span> Starts on: {{$item['time_from']}} @if($item['time_from'] > 12) Pm @else Am @endif -- Ends on: {{$item['time_to']}} @if($item['time_to'] > 12) Pm @else Am @endif -- Hours: {{$item['time_to'] - $item['time_from']}}</p>
                @endforeach
                <p>
                    Charter Rate: ${{$contentEmails['book_charter']['timing_price']}}</p>
                <p>
                    Add-Skipper: ${{$contentEmails['book_charter']['is_skiper']}}</p>
                <p>
                    Referrer discount: ${{$contentEmails['book_charter']['referrer_discount']}}</p>
                <p>
                    Excess deposit: ${{$contentEmails['book_charter']['excess_deposit']}}</p>
                <p>
                    Promo Code Discount: $0.00</p>
                <p>
                    Seasport brochure: ${{$contentEmails['seasport_brochure']}}</p>
                <p>
                    Total: ${{$contentEmails['book_charter']['total_price']}}</p>
            </td>
        </tr>
    </table>
</table>
@endsection
