@extends('index')
@section('content')
<div class="home-wrapper">
    <div class="slider-filter-wrapper">
        <div class="home-image-slider">
            <div class="image-slider-wrapper">
                <div class="image-slider">
                @foreach($data['boat_sliders'] as $slide)
                  <!--  <div class="image-slider-item"><a href="{{ $slide['sliderLink'] }}"><img src="{{ asset('images/slider_home/' . $slide['sliderName']) }}"></a></div>-->
                  <div class="image-slider-item"><a href="{{ $slide['sliderLink'] }}"><img src="{{ asset('images/home-slider/' . $slide['sliderName']) }}"></a></div>
                @endforeach
                </div>
            </div>
        </div>
        <div class="filter-form">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12 col-lg-10 content">
                        <h1 class="site-title">WELCOME TO <strong>TRIDENT MARINE ASIA</strong></h1>
                        <div class="filter-title text-center">Your charter starts here</div>
                        <div class="filter-inputs">
                            <form id="form-search-product" name="form-search-product" method="get" action="/search/boat">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <select class="selectpicker filter-input" name="people_number" title="NO. OF PEOPLE">
                                            <option value="0">NO. OF PEOPLE</option>
                                            @foreach($data['no_of_people_search'] as $key => $item)
                                                <option value="{{$key}}">{{$item}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <select class="selectpicker filter-input" name="occasion" title="OCCASION">
                                            <option value="">OCCASION</option>
                                            @foreach ($data['occasion_search'] as $key => $item)
                                                 <option value="{{$key}}">{{$item}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <select class="selectpicker filter-input boat-type" name="boat_type" title="BOAT TYPE">
                                            <option value="">BOAT TYPE</option>
                                            @foreach ($data['boat_type_search'] as $key => $item)
                                                <option value="{{$key}}" data-subtext="- {{$item}}">{{$item}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <select class="selectpicker filter-input" name="country"  data-dropup-auto="false">
                                        <option value="" > COUNTRY </option>
                                        <option value="" > Show All </option>
                                            @foreach ($data['country_search'] as $item)
                                                <option value="{{$item}}" @if($data['country_search'] == 'Singapore') selected @endif>{{$item}}</option>
                                            @endforeach
                                             
                                        </select>
                                    </div>
                                    <div class="col-sm-12">
                                        <button class="search-btn button button-highlight">SEARCH</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="home-introduce text-center">
        <div class="logo"><img src="../images/logo.png"></div>
        <div class="content">
            <p class="home-block-title big">Discover<strong>&nbsp;a whole new world&nbsp;</strong>on the high seas</p>
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <p class="home-block-title">With over 400 yachts to choose from around the world, be spoilt for choice with Trident Marine Asia. Whether it’s just a leisure gathering with friends, a corporate function for clients, a solemnization party, or even a weekend getaway to nearby Islands, there is a suitable yacht for every group and every occasion. </p>
                        <p class="home-block-title sub">Enquire with us and embark on your sea voyage today!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="promotion" style="display: none;">
        <div class="promotion-slider-wrapper">
            <div class="promotion-slider">
                <div class="promotion-slider-item">
                    <div class="promotion-wrapper"><img class="promotion-img" src="../images/promotion-slider/1.png">
                        <div class="promotion-detail-wrapper">
                            <div class="container">
                                <div class="row justify-content-end">
                                    <div class="col-lg-4">
                                        <div class="promotion-detail">
                                            <div class="month">AUG</div>
                                            <div class="promotion-title">
                                                <p class="big">QUARTERLY</p>
                                                <p>CHARTER PROMOTION</p>
                                            </div>
                                            <div class="promotion-boat">
                                                <div class="promotion-boat-title">Yacht Name</div>
                                                <div class="promotion-boat-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi!</div>
                                            </div>
                                            <div class="discover-btn"><a href="#">DISCOVER NOW</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="promotion-slider-item">
                    <div class="promotion-wrapper"><img class="promotion-img" src="../images/promotion-slider/1.png">
                        <div class="promotion-detail-wrapper">
                            <div class="container">
                                <div class="row justify-content-end">
                                    <div class="col-lg-4">
                                        <div class="promotion-detail">
                                            <div class="month">AUG</div>
                                            <div class="promotion-title">
                                                <p class="big">QUARTERLY</p>
                                                <p>CHARTER PROMOTION</p>
                                            </div>
                                            <div class="promotion-boat">
                                                <div class="promotion-boat-title">Yacht Name</div>
                                                <div class="promotion-boat-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi!</div>
                                            </div>
                                            <div class="discover-btn"><a href="#">DISCOVER NOW</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="instagram text-center">
        <div class="logo"><img src="../images/home-instagram-icon.png"></div>
        <div class="content">
            <p class="home-block-title big">FOLLOW US <strong>ON INSTAGRAM</strong></p>
            <p class="home-block-title">Celebrate your charter memories with us!</p>
        </div>
        <div class="instagram-photos">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="instagram-photos-block">
                            <div class="row insposts">
                            	
                            	
                                @foreach($data['instagram_images'] as $image)
                                <div class="col-md-4 col-sm-6 col-12">
                                    <div class="instagram-photo">
                                        <a href="http://instagr.am/p/{{ $image->node->shortcode }}" target="_blank">
                                            <img src="{{ $image->node->thumbnail_resources[2]->src }}">
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="instagram-follow"><a href="https://www.instagram.com/tridentmarineasia/" target="_blank" class="button button-highlight">FOLLOW @TRIDENTMARINEASIA</a></div>
    </div>
</div>
</main>
@if($data['forgetRating'] === true)
<div class="account-modal modal fade" id="forgotRating" tabindex="-1" role="dialog" aria-labelledby="forgotRating" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="forgot-password text-center">
                    <h4>Welcome</h4>
                    <p>{!! \App\Http\Utils\RatingHelper::generateRatingStar(5) !!}</p>
                    <p>You seem to have forgotten to rate some of your booking, please <a href="/my-bookings">Click Here</a> to provide your feedback and rating.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
