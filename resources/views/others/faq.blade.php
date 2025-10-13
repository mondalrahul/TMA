@extends('index')
@section('content')
<div class="faq-page">
    <div class="faq-nav">
        <div class="container">
            <div class="wrapper">
                <div class="faq-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">FAQ</li>
                    </ol>
                </div>
                <div class="contact-share">Follow Us On <a href="https://www.facebook.com/TridentMarineAsia/" target="_blank"><i style="color: #00cccd; font-size: 20px; margin-right: 18px; margin-left: 10px;" class="fa fa-facebook" aria-hidden="true"></i></a><a href="https://www.instagram.com/tridentmarineasia/" target="_blank"><i style="color: #00cccd; font-size: 20px;" class="fa fa-instagram" aria-hidden="true"></i></a></div>
            </div>
        </div>
    </div>
    <div class="content-wrapper">
        <div class="container">
            <div class="content">
                <div class="faq-title">
                    <p class="title">Got a question? We've got answers.</p>
                    <p class="sub-title">
                        To save you time, we've put answers to the most common inquiries here. Just click on the category and look for your question.
                    </p>
                </div>
                <div class="faqs">
                    <div id="faq_list" role="tablist">
                        @foreach($faqs as $faq)
                        <div class="faq">
                            <div class="faq-header" data-toggle="collapse" href="#faq{{$faq->id}}" aria-expanded="true">
                                {!! $faq->question !!}
                            </div>
                            <div class="collapse" id="faq{{$faq->id}}" role="tabpanel" data-parent="#faq_list">
                                <div class="faq-body">
                                   <?php
                                    echo html_entity_decode($faq->answer);
                                   ?>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="contact">
                    <p>If you can't find what you're looking for in our FAQ, feel free to contact us.</p>
                    <div class="buttons"><a class="email" href="/contact-us">EMAIL US NOW</a>
                        <!-- or<span></span><a class="enquiry" href="#">ENQUIRY FORM</a>--><span>or</span><a class="call" href="tel:+65 6904 8327">Call +65 6904 8327  </a></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
