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
                    <li class="breadcrumb-item active">My Credits</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="page-content account-page-content">
          <div class="container">
            <div class="page-wrapper">
              <h1 class="account-page-title">My Credits</h1>
              <div class="row">
                <div class="col-lg-8">
                  <div class="boat-list-search">
                    <h2>Search Credits</h2>
                    <form>
                      <div class="filter">
                         
                        <div class="row row-item">
                          <div class="col-lg-12"><span class="filter-item">Purchased From:</span><span>From</span>
                            <input name="from_date" value="{{ $filterData['from_date'] }}" class="datepicker-element" required type="text"><span>to</span>
                            <input name="to_date" value="{{ $filterData['to_date'] }}" class="datepicker-element" required type="text"><span>(mm/dd/yyyy)</span>
                          </div>
                        </div>
                      </div>
                      <div class="submit">
                        <button class="button button-highlight">SEARCH</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="boat-list-filter">
                    <div class="row">  
                       <div class="col-md-4 text-left">
                        Found <span class="color-highlight">{{ count($bookData ) }}</span> records.  
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-12">
                  @if (count($bookData ) > 0)
                  <div class="table-responsive">
                    <table class="boat-list-table">
                      <thead>
                        <tr>
                          <th>Credit ID</th>
                          <th>Date Purchased</th>
                          <th>Credit Purchased</th>
                          <th>Credit Balance<br>(Up to date)</th>
                          <th>Expiry Date</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($bookData as $book)

                        @php $deposit_amount = DB::table('boat_user_credits_history')->where('credit_id', $book->credit_id)->sum('deposit_amount'); 
                        $balance = DB::table('boat_user_credits_history')->where('credit_id', $book->credit_id)->sum('balance');
                        @endphp
                        <tr>
                          <td><a href="{{route('credit.details', $book->credit_id)}}">{{$book->credit_id}}</a></td>
                          <td>{{date("d/m/Y", strtotime($book->add_date))}} </td>
                          <td>SGD {{$deposit_amount}}</td>
                          <td>SGD {{$balance}}</td>
                          <td>{{date("d/m/Y", strtotime($book->expiry_date))}} 
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