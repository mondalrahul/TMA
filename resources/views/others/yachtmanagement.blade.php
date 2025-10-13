@extends('index')
@section('content')
    <div class="yacht-management-page">
        <div class="yacht-management-header">
            <div class="background"><img src="{{ env('BANNER_IMAGES_URL') }}yacht/{{$yachtmanagement->main_banner_image}}"></div>
            <div class="container">
                <div class="wrapper">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Yacht Management</li>
                        </ol>
                    </div>
                    <div class="page-title">
                        <div class="title">YACHT&nbsp;<strong>MANAGEMENT</strong></div>
                        <div class="description">
                            <p><strong>Own the yacht</strong>, let us worry about maintaining it for you. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="yacht-management">
            <div class="trident-1 half-split">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="container left-section">
                                <div class="row">
                                <?php
                                    echo html_entity_decode( $yachtmanagement->section1_text);
                                ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 background"><img src="{{ env('BANNER_IMAGES_URL') }}yacht/{{$yachtmanagement->section1_banner_image}}" alt=""></div>
                    </div>
                </div>
            </div>
            <div class="trident-2 half-split">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 background"><img src="{{ env('BANNER_IMAGES_URL') }}yacht/{{$yachtmanagement->section2_banner_image}}" alt=""></div>
                        <div class="col-md-6">
                            <div class="container right-section">
                                <div class="row">
                                    <?php
                                        echo html_entity_decode( $yachtmanagement->section2_text);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="trident-3 half-split">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="container left-section">
                                <div class="row">
                                    <?php
                                        echo html_entity_decode( $yachtmanagement->section3_text);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 background"><img src="{{ env('BANNER_IMAGES_URL') }}yacht/{{$yachtmanagement->section3_banner_image}}" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection