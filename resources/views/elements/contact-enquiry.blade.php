    <div class="contact-enquiry-modal modal fade" id="contactEnquiryModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="contact-form">
                        <p class="title">Get in Touch</p>
                        <p class="sub-title">Fill in the form below and we will be in contact!</p>
                        <form class="row" action="/send-mail/contact-us" method="post" >
                            {{ csrf_field() }}
                            <div class="form-group col-md-6">
                                <label>Name <span class="required">*</span></label>
                                <input type="text" name="first_name" required>
                                <p>First Name</p>
                            </div>
                            <div class="form-group col-md-6">
                                <label>&nbsp;</label>
                                <input type="text" name="last_name">
                                <p>Last Name</p>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email Address <span class="required">*</span></label>
                                <input type="text" name="email" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Contact No.</label>
                                <input type="text" name="phone">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Choose A Subject <span>*</span></label>
                                <select name="subject">
                                    <option value="Yacht Charter booking">Yacht Charter booking</option>
                                    <option value="Buying & Selling of yachts">Buying & Selling of yachts</option>
                                    <option value="Yacht Maintenance">Yacht Maintenance</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Message <span class="required">*</span></label>
                                <textarea name="message" rows="5" required></textarea>
                            </div>
                            <div class="form-group col-md-12">
                            <script src='https://www.google.com/recaptcha/api.js'></script>
                            <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI" data-callback="verifyCaptcha"></div>
                                           <div id="g-recaptcha-error"></div>
                                            </div>
                            <div class="form-group col-md-12">
                                <button class="button button-highlight">SEND MESSAGE</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>