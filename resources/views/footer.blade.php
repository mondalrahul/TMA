<footer>
    <div class="footer-columns">
        <div class="container">
            <div class="footer-column-wrapper row">
                <div class="footer-column col-lg-2">
                    <p class="title">QUICK LINKS</p>
                    <p><a href="{{ url('/search/boat') }}">Trident Fleet</a></p>
                    <p><a href="{{ url('/special-packages') }}">Special Packages</a></p>
                    <!-- <p><a href="{{ url('/search/boat') }}">Yacht Brokerage</a></p> -->
                    <p><a href="{{ url('/faq') }}">FAQ</a></p>
                </div>
                <div class="footer-column col-lg-3">
                    <p class="title">CONTACTS</p>
                    <p>+65 6904 8327</p>
                    <p>Republic of Singapore Yacht Club, 52 West Coast Ferry Road, Singapore 126887</p>
                    <p><a href="mailto:sales@tridentmarineasia.com">sales@tridentmarineasia.com</a></p>
                </div>
                <div class="footer-column col-lg-2">
                    <p class="title">BUSINESS HOURS</p>
                    <p>9 a.m till 6 p.m</p>
                </div>
                <div class="footer-column col-lg-2">
                    <p class="title">FOLLOW US</p>
                    <p class="social-links"><a href="https://www.facebook.com/TridentMarineAsia/" target="_blank"><i class="fab fa-facebook" aria-hidden="true"></i></a><a href="https://www.instagram.com/tridentmarineasia/" target="_blank"><i class="fab fa-instagram" aria-hidden="true"></i></a></p>
                </div>
                <div class="footer-column col-lg-3">
                    <p class="title">SUBSCRIBE TO NEWSLETTERS</p>
                    <form class="subscribe-form">
                        <input type="email" placeholder="Email Address *">
                        <button class="button button-highlight">SIGN UP</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-introduce">
        <div class="container">
            <div class="introduce">With over 400 yachts to choose from around the world, be spoilt for choice with Trident Marine Asia.</div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            <div class="row">
                <div class="payment-methods col-lg-7">
                    <li>We accept payment via</li>
                   <!-- <li><img src="../images/visa-icon.png"></li>
                    <li><img src="../images/mastercard-icon.png"></li>
                    <li><img style="width: 40px;" src="../images/AmericanExpress.png"></li>
                    <li><img style="width: 60px;" src="../images/Discover.png"></li>
                    <li><img style="width: 35px;" src="../images/JCBlogo.png"></li>
                    <li><img style="width: 90px;" src="../images/DinersClub.png"></li>-->
                    <li><img src="../images/paypal-icon.png"></li>
                    <li><img style="width: 42px;" src="../images/DBSPaylah.png"></li>
                    <li><img style="width: 90px;" src="../images/PayNow.png"></li>
                    <li><img style="width:50px;" src="../images/B-Transfer.png"></li>
                </div>
                <div class="copyright col-lg-5"><span>&copy; 2017 Trident Marina Asia Pte Ltd. All Rights Reserved.</span></div>
            </div>
        </div>
    </div>
</footer>
@section('forgot_script')
<script>
@if(request()->get('error'))
alert("You are not registered with us, please use your login email address.");
@endif
@if(Session::has('femail'))
alert("Your new password sent to your email adrress.");
@php Session()->forget('femail'); @endphp
@endif
</script>
@endsection
