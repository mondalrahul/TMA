@extends('index')
@section('content')
 
    <div class="my-booking-page bottom-background">
        <div class="page-nav account-page-nav">
          <div class="container">
            <div class="wrapper">
              <div class="breadcrumb-wrapper">
                <div class="page-breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{URL('/')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('credits.list')}}">My Credits</a></li>
                    <li class="breadcrumb-item active">Credit Details</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="page-content account-page-content">
          <div class="container">
            <div class="page-wrapper">
              <h1 class="account-page-title">Transaction History :  #{{$id}}</h1>
              <div class="row">
                <div class="col-lg-8">
                  <div class="boat-list-search">
                     
                     
                      <div class="filter">
                         
                        <div class="row row-item">
                          <div class="col-lg-12"><span class="filter-item">Credit ID :</span><span>{{$id}}</span>
                            
                          </div>
                       <div class="col-lg-12"><span class="filter-item">Expiry Date :  </span><span>{{date("d/m/Y", strtotime($exp_date))}}</span>
                            
                          </div>  
                        </div>
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
                          <th>Date Transaction</th>
                          <th>Remarks</th>
                          <th>Credit (Withdrawal)</th>
                          <th>Credit (Deposit)</th>
                          <th>Balance<br>(Up to date)</th>
                           
                        </tr>
                      </thead>
                      <tbody>@php $deposit_amount=0; $balance =0; 
                         $inc=0;  
                         @endphp
                        @foreach($bookData as $book) 

                        
                        <tr>
                          <td> {{$book->credit_id}} </td>
                          <td>{{date("d/m/Y", strtotime($book->add_date))}} </td>
                          <td width="300"> {{  strip_tags(html_entity_decode($book->remarks))  }}</td>
                          <td>SGD {{$book->withdral_amount}}</td>
                          <td>SGD {{$book->deposit_amount}}</td>
                          <td>{{$book->balance}}</td>
                        </tr>
                        @php 
                        if( $inc==0){
                        $deposit_amount =$book->deposit_amount; 
                        }
                        
                        $balance+=$book->balance;
                        $inc++; 
                        @endphp
                        @endforeach 
                        <tr>
                          <td colspan="4">&nbsp;</td>
                          
                          <td><strong>CREDIT AVAILABLE:</strong> </td>
                          <td><strong>SGD {{$balance}}</strong></td>
                        </tr>
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