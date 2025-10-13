@extends('index')
@section('content')
    <div class="contact-page">
        <div class="contact-nav">
            <div class="container">
                <div class="wrapper">
                    <div class="contact-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href=".">Home</a></li>
                            <li class="breadcrumb-item active">Contact Us</li>
                        </ol>
                    </div>
                    <div class="contact-share">Follow Us On <a href="https://www.facebook.com/TridentMarineAsia/" target="_blank"><i style="color: #00cccd; font-size: 20px;" class="fa fa-facebook" aria-hidden="true"></i></a><a href="https://www.instagram.com/tridentmarineasia/" target="_blank"><i style="color: #00cccd; font-size: 20px;" class="fa fa-instagram" aria-hidden="true"></i></a></div>
                </div>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="contact-form">
                            <p class="title">Get in Touch</p>
                            <p class="sub-title">Fill in the form below and we will be in contact!</p>
                            @if (\Illuminate\Support\Facades\Session::has('message_send'))
                                <div class="alert alert-success">
                                    <strong>{!! \Illuminate\Support\Facades\Session::get('message_send') !!}</strong>
                                </div>
                            @endif
                            <form class="row" name="form_contact" action="/send-mail/contact-us" method="post" id="form_contact">
                                {{ csrf_field() }}
                                <div class="form-group col-md-6">
                                    <div class="alert alert-danger hidden" role="alert" id="first_name_error"></div>
                                    <label>Name <span class="required">*</span></label>
                                    <input type="text" name="first_name">
                                    <p>First Name</p>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="alert alert-danger hidden" role="alert" id="last_name_error"></div>
                                    <label>&nbsp;</label>
                                    <input type="text" name="last_name">
                                    <p>Last Name</p>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="alert alert-danger hidden" role="alert" id="email_error"></div>
                                    <label>Email Address <span class="required">*</span></label>
                                    <input type="text" name="email">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Contact No.</label>
                                    <input type="text" name="phone">
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="alert alert-danger hidden" role="alert" id="subject_error"></div>
                                    <label>Choose A Subject <span>*</span></label>
                                    <select name="subject">
                                        <option value="Yacht Charter booking">Yacht Charter booking</option>
                                        <option value="Buying & Selling of yachts">Buying & Selling of yachts</option>
                                        <option value="Yacht Maintenance">Yacht Maintenance</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="alert alert-danger hidden" role="alert" id="message_error"></div>
                                    <label>Message <span class="required">*</span></label>
                                    <textarea name="message" rows="5"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                            <script src='https://www.google.com/recaptcha/api.js'></script>
                            <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI" data-callback="verifyCaptcha"></div>
                                           <div id="g-recaptcha-error"></div>
                                            </div>
                                <div class="form-group col-md-12">
                                    <button type="submit" class="button button-highlight" name="btn-send-contact" id="btn-send-contact">SEND MESSAGE</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="contact-info">
                            <p class="title">Contact Details</p>
                            <p class="business-time"><span class="underline">Business Hours:</span> 9am to 6pm</p>
                            <p class="contact-number"><a href="tel:+ 65 6904 8327">+ 65 6904 8327</a></p>
                            <p class="address"><span>Republic of Singapore Yacht Club, </span><span>52 West Coast Ferry Road,</span><span>Singapore 126887</span></p>
                            <p class="email"><a href="mailto:sales@tridentmarineasia.com">sales@tridentmarineasia.com</a></p>
                            <div class="map"><img src="../images/contact/map.jpg" alt=""></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
