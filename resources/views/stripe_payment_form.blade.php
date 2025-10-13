@extends('index')
@section('content')
<div class="container" style="margin:220px 0 50px 100px;">         
    <div class="row">
   
       <div class="col-md-6 col-md-offset-3">
          <div class="panel panel-default credit-card-box">
             <div class="panel-heading" >
                <div class="row" >
                   <h3 style="margin-left: 170px">Payment Details</h3>
                   <div>                            
                      <img class="img-responsive pull-right" src="https://www.edigitalagency.com.au/wp-content/uploads/new-stripe-logo-png-860x361.png" width="35px">
                   </div>
                </div>
             </div>
             <div class="panel-body">
                @if (Session::has('success'))
                <div class="alert alert-success text-center">
                   <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                   <p>{{ Session::get('success') }}</p><br>
                </div>
                @endif
                <br>
                <form role="form" action="{{ route('stripe.capture') }}" method="post" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{ config('common.STRIPE_KEY') }}" id="payment-form">
                   {{ csrf_field() }}
                   <div class='form-row row'>
                      <div class='col-xs-12 col-md-6 form-group required'>
                         <label class='control-label'>Name on Card</label> 
                         <input class='form-control' size='4' type='text'>
                      </div>
                      <div class='col-xs-12 col-md-6 form-group required'>
                         <label class='control-label'>Card Number</label> 
                         <input autocomplete='off' class='form-control card-number' size='20' type='text'>
                      </div>                           
                   </div>                        
                   <div class='form-row row'>
                      <div class='col-xs-12 col-md-4 form-group cvc required'>
                         <label class='control-label'>CVC</label> 
                         <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text'>
                      </div>
                      <div class='col-xs-12 col-md-4 form-group expiration required'>
                         <label class='control-label'>Expiration Month</label> 
                         <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
                      </div>
                      <div class='col-xs-12 col-md-4 form-group expiration required'>
                         <label class='control-label'>Expiration Year</label> 
                         <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
                      </div>
                   </div>
                 {{-- <div class='form-row row'>
                    <div class='col-md-12 error form-group hide'>
                       <div class='alert-danger alert'>Please correct the errors and try
                          again.
                       </div>
                    </div>
                 </div> --}}
                   <div class="form-row row">
                      <div class="col-xs-12">
                         <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now</button>
                      </div>
                   </div>
                </form>
             </div>
          </div>
       </div>
    </div>
 </div>
</body>   

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
$(function() {
  var $form = $(".require-validation");
  $('form.require-validation').bind('submit', function(e) {
    var $form = $(".require-validation"),
    inputSelector = ['input[type=email]', 'input[type=password]', 'input[type=text]', 'input[type=file]', 'textarea'].join(', '),
    $inputs = $form.find('.required').find(inputSelector),
    $errorMessage = $form.find('div.error'),
    valid = true;
    $errorMessage.addClass('hide');
    $('.has-error').removeClass('has-error');
    $inputs.each(function(i, el) {
        var $input = $(el);
        if ($input.val() === '') {
            $input.parent().addClass('has-error');
            $errorMessage.removeClass('hide');
            e.preventDefault();
        }
    });
    if (!$form.data('cc-on-file')) {
      e.preventDefault();
      Stripe.setPublishableKey($form.data('stripe-publishable-key'));
      Stripe.createToken({
          number: $('.card-number').val(),
          cvc: $('.card-cvc').val(),
          exp_month: $('.card-expiry-month').val(),
          exp_year: $('.card-expiry-year').val()
      }, stripeResponseHandler);
    }
  });

  function stripeResponseHandler(status, response) {
      if (response.error) {
          $('.error')
              .removeClass('hide')
              .find('.alert')
              .text(response.error.message);
              alert(response.error.message);
      } else {
          var token = response['id'];
          $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
      }
  }
});
</script>
@endsection