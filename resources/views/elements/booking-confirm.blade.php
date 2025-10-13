{{--<div class="paypal-confirm-modal modal fade" id="paypalConfirmModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">--}}
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="wire-transfer-box">
          <form action="" id="paypal-confirm-form">
            <p class="title font-title-modal text-center">CONFIRM BOOKING</p>
            <form id="paypal-confirm-form">

               @if(strlen(@$dataAdds['addition_error'])>5)

                <p class="text-danger">Please select another time slot as this has already been taken.</p>
                <button type="button" class="button button-highlight float-right" data-dismiss="modal">CANCEL  </button>
               @else 
              
              @if(isset($dataAdds['book_timing']))
                <p id="confirm-time-slot"><span><strong>Requested Slot: </strong></span>
                @foreach($dataAdds['book_timing'] as $item)
                  Boat Booking for {{$item['date_book']->format('Y-m-d')}} from {{$item['time_from']}} {{$item['time_from_type']}} to {{$item['time_to']}} {{$item['time_to_type']}}
                @endforeach
                </p>
                @if(isset($dataAdds['user_detail']))
                 <p id="confirm-personal-detail"><span><strong>Personal Details: </strong></span>@if(!empty($dataAdds['user_detail']['user_name'])) {{$dataAdds['user_detail']['user_name']}}, @endif {{$dataAdds['user_detail']['user_email']}}</p>
                 @if(!empty($dataAdds['user_detail']['user_address']))
                   <p id="confirm-personal-address"><span><strong>Address: </strong></span>{{$dataAdds['user_detail']['user_address']}}</p>
                 @endif
                @endif
                @if($dataAdds['book_charter']['book_type']=='Skippered')
                <p id="confirm-payment-type"><span><strong>Booking Request Type: </strong></span>{{$dataAdds['book_charter']['book_type']}}</p>  
                @else

                <p id="confirm-payment-type"><span><strong>Payment Type: </strong></span>{{$dataAdds['payment_method']}}</p>
                @endif 
                
                <p id="confirm-charter-rate"><span><strong>Charter Rate: </strong></span> {{$dataAdds['book_charter']['currency']}} {{$dataAdds['book_charter']['timing_price']}}</p>
                <p id="confirm-skipper-price"><span><strong>Skipper Price: </strong></span> {{$dataAdds['book_charter']['currency']}} {{$dataAdds['book_charter']['is_skiper']}}</p>
                <p id="confirm-skipper-check"><span><strong>Skipper: </strong></span>@if ($dataAdds['book_charter']['ifskipper']) Yes @else No @endif </p>
                <p id="confirm-excess-deposit"><span><strong>Excess Deposit: </strong></span> {{$dataAdds['book_charter']['currency']}} {{$dataAdds['book_charter']['excess_deposit']}}</p>
                <p id="confirm-excess-deposit"><span><strong>Country: </strong></span> {{$dataAdds['book_charter']['country']}}</p>
                <p id="confirm-seasports-brochure"><span><strong>Seasports Brochure: </strong></span> {{$dataAdds['book_charter']['currency']}} {{$dataAdds['book_charter']['seasport_price']}}</p>
                
                @php
                if($dataAdds['book_charter']['discount_price'] > 0.1){ 
                  if($dataAdds['book_charter']['discount_type'] ==1){ 
                    $discounttype = 'Membership';
                    $code = $dataAdds['book_charter']['member_plan'];  
                  } else{ 
                    $discounttype = 'Credit'; 
                    $code =$dataAdds['book_charter']['credit_id']; 
                  }  @endphp 

                  <p id="confirm-seasports-brochure"><span><strong>{{$discounttype}}  Discount ({{$code}}) : </strong></span>  {{$dataAdds['book_charter']['currency']}} {{$dataAdds['book_charter']['discount_price']}}   </p>            
                  @php }     @endphp                    
                
                <p id="confirm-total-amount"><span><strong>Total Amount: </strong></span> {{$dataAdds['book_charter']['currency']}} {{($dataAdds['book_charter']['total_price']-$dataAdds['book_charter']['discount_price']) }}</p>


                @if(!empty($dataAdds['addition_request']))
                  <p id="confirm-special-request"><span><strong>Special Request: </strong></span>{{$dataAdds['addition_request']}}</p>
                @endif
                <p id="confirm-boat-note"><span><strong>Boat Note: </strong></span>{!!html_entity_decode($dataAdds['boat_detail']['boatnote'])!!}</p>
                <button type="button" class="button button-highlight" id="btn-proceed-to-checkout">REQUEST BOOKING</button>
                <button type="button" class="button button-highlight float-right" data-dismiss="modal">CANCEL REQUEST</button>
              @endif


               @endif
            </form>
          </form>
        </div>
      </div>
    </div>
  </div>
{{--</div>--}}
