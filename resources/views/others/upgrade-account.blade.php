@extends('index')
@section('content')
    <div class="upgrade-account-page bottom-background">
        <div class="page-nav account-page-nav">
          <div class="container">
            <div class="wrapper">
              <div class="breadcrumb-wrapper">
                <div class="page-breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Upgrade Account</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="page-content account-page-content">
          <div class="container">
            <div class="page-wrapper">
              <h1 class="account-page-title">Upgrade Account</h1>
              <p class="color-dark membership-plan font-500">CHOOSE YOUR <span class="color-base">MEMBERSHIP PLAN</span></p>
              <div class="row">
                <div class="col-lg-4">
                  <div class="plan current-plan"><img src="../images/upgrade-account/1.png" alt="">
                    <div class="plan-detail">
                      <p class="plan-title font-700 color-base">CHARTERER</p>
                      <p class="plan-summary color-highlight">Account for Boat Buyers and Browsers</p>
                      <p class="plan-description color-dark">This tier of membership allows you to access our fleet of charter yachts, training materials and RSVP to our activities.</p><a class="button button-disabled button-block text-center" href="#">CURRENT PLAN</a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="plan"><img src="../images/upgrade-account/2.png" alt="">
                    <div class="plan-detail">
                      <p class="plan-title font-700 color-base">BOAT OWNER</p>
                      <p class="plan-summary color-highlight">Upgraded Account for Boat Owners</p>
                      <p class="plan-description color-dark">Upgrade your account to a Boat Owner Account. Having this account allows you to post your boat online and set your own rates and calendar for chartering out your boat.</p>
                      <a class="button button-highlight button-block text-center" href="{{ url('my-boats/add') }}">LIST YOUR BOAT</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection