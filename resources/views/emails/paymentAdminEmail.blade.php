@extends('emails.indexEmail')
@section('content')
    <table width=650 border=0 cellpadding=5>
        <tr>
            <td colspan='2' align='left' class='textstyle'>
                @if (isset($contentEmails['book_charter']['id']))
                    <h4>Booking ID: #{{ $contentEmails['book_charter']['id'] }}</h4>
                @endif
                <h2>Boat Name: {{ strtoupper($contentEmails['boat_detail']['boat_name']) }}</h2>
                <h3>Total Cost: {{ $contentEmails['book_charter']['currency'] }}
                    {{ $contentEmails['book_charter']['total_price'] - $contentEmails['book_charter']['discount_price'] }}
                </h3>
                <h4>Charterer Contract: Attached with the Email</h4>
                <h4>Payment Type: Paypal</h4>
                <h4>Status: Confirmed (please print out a copy of this chit and bring along for your charter or show
                    this on your mobile device to the skipper) </h4>
                <p>
                    {{-- <img alt="" src="https://www.theboatshopasia.com/images/boat-type.jpg" class="CToWUd"> --}}
                    {{-- Boat Type: {{ data_get($contentEmails, 'boat_category.categoryName', '') }} --}}
                    <img alt="" src="https://www.theboatshopasia.com/images/pax.jpg" class="CToWUd">
                    Pax: {{ $contentEmails['boat_detail']['pax'] }}
                    <img alt="" src="https://www.theboatshopasia.com/images/location.jpg" class="CToWUd">
                    Location: {{ $contentEmails['boat_detail']['marinas_name'] }}
                </p>
                <h4>Booking for: {{ $contentEmails['book_timing'][0]['date_book']->format('Y/m/d') }}</h4>
                @if (\Illuminate\Support\Facades\Auth::check())
                    <h4>Membership Details</h4>
                    <p>
                        Membership Name: {{ $contentEmails['user_detail']['user_name'] }}</p>
                    <p>
                        Membership Type: {{ $contentEmails['user_detail']['user_type'] }}</p>
                    <p>
                    @else
                    <p>
                        <strong>Membership Details: Not Registered</strong>
                    </p>
                @endif
                <h4>Payment Details: </h4>
                @foreach ($contentEmails['book_timing'] as $item)
                    <p><span style="font-weight: bold">Time: </span> Starts on: {{ $item['time_from'] }} @if ($item['time_from'] > 12)
                            Pm
                        @else
                            Am
                            @endif -- Ends on: {{ $item['time_to'] }} @if ($item['time_to'] > 12)
                                Pm
                            @else
                                Am
                            @endif -- Hours: {{ $item['time_to'] - $item['time_from'] }}</p>
                @endforeach
                <p>
                    Country: {{ $contentEmails['book_charter']['country'] }}</p>

                <p>
                    Charter Rate: {{ $contentEmails['book_charter']['currency'] }}
                    {{ $contentEmails['book_charter']['timing_price'] }}</p>
                <p>
                    Add-Skipper: {{ $contentEmails['book_charter']['currency'] }}
                    {{ $contentEmails['book_charter']['is_skiper'] }}</p>
                <p>
                    Referrer discount: {{ $contentEmails['book_charter']['currency'] }}
                    {{ $contentEmails['book_charter']['referrer_discount'] }}</p>
                <p>
                    Excess deposit: {{ $contentEmails['book_charter']['currency'] }}
                    {{ $contentEmails['book_charter']['excess_deposit'] }}</p>
                <p>
                    Promo Code Discount: {{ $contentEmails['book_charter']['currency'] }} 0.00</p>
                <p>
                    Seasport brochure: {{ $contentEmails['book_charter']['currency'] }}
                    {{ $contentEmails['seasport_brochure'] }}</p>
                <p>
                    Total: {{ $contentEmails['book_charter']['currency'] }}
                    {{ $contentEmails['book_charter']['total_price'] - $contentEmails['book_charter']['discount_price'] }}
                </p>

                <h4>Additional Request: {{ $contentEmails['book_charter']['comment'] }} </h4>
            </td>
        </tr>
    </table>
@endsection
