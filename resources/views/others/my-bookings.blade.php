@extends('index')
@section('content')
    <div class="my-booking-page bottom-background">
        <div class="page-nav account-page-nav">
            <div class="container">
                <div class="wrapper">
                    <div class="breadcrumb-wrapper">
                        <div class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">My Charters</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-content account-page-content">
            <div class="container">
                <div class="page-wrapper">
                    <h1 class="account-page-title">My Bookings</h1>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="boat-list-search">
                                <h2>Search Booking</h2>
                                



                                <form>
                                    <div class="filter">
                                        <div class="row row-item">
                                            <div class="col-lg-12"><span class="filter-item">Boat:</span>
                                                <select name="boat_id">
                                                    <option value="">Select Boat</option>
                                                    @foreach ($boatList as $boat)
                                                        <option value="{{ $boat->boat_id }}"
                                                            {{ $boat->boat_id == $filterData['boat_id'] ? 'selected' : '' }}>
                                                            {{ $boat->boat_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row row-item">
                                            <div class="col-lg-12"><span class="filter-item">Booked
                                                    For:</span><span>From</span>
                                                <input name="from_date" value="{{ $filterData['from_date'] }}"
                                                    class="datepicker-element" type="text"><span>to</span>
                                                <input name="to_date" value="{{ $filterData['to_date'] }}"
                                                    class="datepicker-element" type="text"><span>(mm/dd/yyyy)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="submit">
                                        <button class="button button-highlight">SEARCH NOW</button>
                                    </div>
                                </form>






                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="boat-list-filter">
                                <div class="row">



                                 <div class="col-md-8"><a href="{{ url('my-bookings/?status=0') }}">All
                                            ({{ array_sum($bookStatus) }})</a><span class="separate">|</span><a
                                            href="{{ url('my-bookings/?status=1') }}">Completed
                                            ({{ $bookStatus[1] }})</a><span class="separate">|</span><a
                                            href="{{ url('my-bookings/?status=2') }}">Pending
                                            ({{ $bookStatus[2] }})</a><span class="separate">|</span><a
                                            href="{{ url('my-bookings/?status=3') }}">Cancelled ({{ $bookStatus[3] }})</a>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        Found <span class="color-highlight">{{ $bookData->total() }}</span> records.
                                        Showing <span
                                            class="color-highlight">{{ $bookData->total() ? $bookData->firstItem() : 0 }}</span>
                                        to <span
                                            class="color-highlight">{{ $bookData->total() ? $bookData->lastItem() : 0 }}</span>
                                    </div>



                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            @if ($bookData->total() > 0)
                                <div class="table-responsive">
                                    <table class="boat-list-table">
                                        <thead>
                                            <tr>
                                                <th>Book ID</th>
                                                <th>Boat Name</th>
                                                <th>Payment Price</th>

                                                <th>Status</th>
                                                <th>Date Added</th>
                                                <th>Booked For</th>
                                                <th>Discount Rate</th>
                                                <th>Credit Applied</th>
                                                <th>Print</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bookData as $book)
                                                <tr>
                                                    <td>{{ $book->book_id }}</td>
                                                    <td>{{ $book->boat_name }}</td>
                                                    <td>{{ $book->currency }}
                                                        {{ $book->total_price - $book->discount_price }}</td>

                                                    <td>
                                                        @if ($book->status === 0)
                                                            <span class="payment-status pending">Pending</span>
                                                        @elseif($book->status === 1)
                                                            <span class="payment-status paid">Paid</span>
                                                        @elseif($book->status === 3)
                                                            <span class="payment-status cancelled">Cancelled</span>
                                                        @else
                                                            <span class="payment-status pending">Pending Payment</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $book->add_date }}</td>
                                                    <td>
                                                        <p>{{ $book->date_book }}</p>
                                                        <p>Start:
                                                            {{ \Carbon\Carbon::createFromFormat('H', $book->time_from)->format('h A') }}
                                                        </p>
                                                        <p>End:
                                                            {{ \Carbon\Carbon::createFromFormat('H', $book->time_to)->format('h A') }}
                                                        </p>
                                                        <p>{{ $book->time_to - $book->time_from }} Hours</p>
                                                    </td>
                                                    <td> 
                                                     <?php /*
                           $incidentcount = DB::table('boat_incident')->where([
                            ['order_id', '=', $book->book_id] ,
                            ['boat_id', '=', $book->boat_id]])->get();  
                            if(count($incidentcount)>0){
                            if($incidentcount[0]->charter_fault=='Yes'){
                                echo 'Yes';
                            }else{
                                echo 'No';
                            }
                            }*/
                                                    if ($book->discount_type == 1) {
                                                        $membership = DB::table('boat_membership')
                                                            ->where('membership_id', '=', $book->membership_id)
                                                            ->get();
                                                        echo $membership[0]->title . ' - %' . $membership[0]->price;
                                                    }
                                                    ?>

                                                    </td>
                                                    <td>
                                                        @if ($book->status === 1)
                                                        @if ($book->date_book < date('Y-m-d'))
                                                        {!! $book->rate
                                                            ? \App\Http\Utils\RatingHelper::generateRatingStar($book->rate)
                                                            : sprintf('<a href="%s">Click to rate</a>', url('boat-detail', $book->boat_id) . '?invoice=' . $book->book_id) !!}
                                                    @elseif($book->date_book == date('Y-m-d'))
                                                        Rating will open from tomorrow.
                                                        @endif
                                                        @endif
                                                        @if ($book->discount_type == 2)
                                                            {{ $book->credit_id }}-{{ $book->currency }}{{ $book->discount_price }}
                                                        @endif
                                                    </td>
                                                    <td><a class="print-button" target="_blank"
                                                            href="https://www.theboatshopasia.com/printbook.php?date={{ $book->date_book }}&boat={{ $book->boat_id }}&booking_id={{ $book->book_id }}"></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <p>
                                    {{ $bookData->links('vendor.pagination.bootstrap-4') }}
                                    </p>
                                </div>
                            @else
                                <p class="text-center">No records found</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
