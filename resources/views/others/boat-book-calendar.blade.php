@extends('index')
@section('content')
    <div class="add-boat-page bottom-background">
        <div class="page-nav account-page-nav">
            <div class="container">
                <div class="wrapper">
                    <div class="breadcrumb-wrapper">
                        <div class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ url('my-boats') }}">My Boats</a></li>
                                <li class="breadcrumb-item active">My Boat Calendar</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-content account-page-content">
            <div class="container">
                <div class="page-wrapper">
                    @if(!empty($boatName))
                    <h1 class="account-page-title">Boat name : {{ $boatName }}</h1>
                        @else
                    <h1 class="account-page-title">Booking of all my boats</h1>
                    @endif
                    <div class="booking-calendar">
                        <div id="boat-calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $('#boat-calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month'
            },
            views: {
                month: {
                    columnFormat:'dddd'
                }
            },
            events: {!! json_encode($bookingData) !!}
        });
    </script>
@endsection