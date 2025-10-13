@extends('index')
@section('content')
    <div class="special-packages-page">
        <div class="package-header-wrapper">
            {{-- {{dd($tridentexperience->main_banner_image)}} --}}
            <div class="background"><img src="{{ env('BANNER_IMAGES_URL') }}{{$tridentexperience->main_banner_image}}"></div>
            <div class="wrapper">
                <div class="container">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Trident Experiences</li>
                        </ol>
                    </div>
                    <div class="page">
                        <div class="title">TRIDENT&nbsp;<strong>EXPERIENCES</strong></div>
                        <div class="description">
                            <p>Looking for something more with your charter? <br />Check out the myriad of packages we have <strong>available for you!</strong></p>
                        </div><img class="arrow-down" src="../images/special-packages/arrow-down.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="special-packages">
            <div class="package weekend-gateway">
                <div class="background"><img src="{{ env('BANNER_IMAGES_URL') }}{{$tridentexperience->section1_banner_image}}" alt=""></div>
                <div class="wrapper">
                    <div class="container">
                        <div class="row justify-content-end">
                            <?php
                                echo html_entity_decode( $tridentexperience->section1_text);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="package solemnization">
                <div class="background"><img src="{{ env('BANNER_IMAGES_URL') }}{{$tridentexperience->section2_banner_image}}" alt=""></div>
                <div class="wrapper">
                    <div class="container">
                        <div class="row">
                            <?php
                                echo html_entity_decode( $tridentexperience->section2_text);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="package team-building">
                <div class="background"><img src="{{ env('BANNER_IMAGES_URL') }}{{$tridentexperience->section3_banner_image}}" alt=""></div>
                <div class="wrapper">
                    <div class="container">
                        <div class="row justify-content-end">
                            <?php
                                echo html_entity_decode( $tridentexperience->section3_text);
                            ?>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="custom-trip">
            <div class="background"><img src="{{ env('BANNER_IMAGES_URL') }}{{$tridentexperience->section4_banner_image}}"></div>
            <div class="wrapper">
                <?php
                    echo html_entity_decode( $tridentexperience->section4_text);
                ?>  
            </div>
        </div>
    </div>
@endsection
