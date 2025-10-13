<div class="account-modal modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="loginModal"
    aria-hidden="true">
    <input name="user_password_hidden" type="hidden" value="">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <form name="form_register" action="/register" method="post" id="form_register">
                    {{ csrf_field() }}
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-6 left">
                                <div class="register-title">
                                    <p class="strong">REGISTER</p>
                                    <p>A NEW TRIDENT ACCOUNT</p>
                                </div>
                                <div class="register-form">
                                    <label>Full Name&nbsp;<span>*</span></label>
                                    <div class="fullname-input">
                                        <div class="alert alert-danger hidden" role="alert" id="name_error"></div>
                                        <input name="name" required="required" autocomplete="off">
                                    </div>
                                    <label>Email Address&nbsp;<span>*</span></label>
                                    <div class="alert alert-danger hidden" role="alert" id="user_email_error"></div>
                                    <div class="email-input has-icon">
                                        <input name="user_email" required="required" autocomplete="off">
                                    </div>
                                    <label>Password&nbsp;<span>*</span></label>
                                    <div class="alert alert-danger hidden" role="alert" id="user_password_error">
                                    </div>
                                    <div class="password-input has-icon">
                                        <input name="user_password" type="password" id="user_password"
                                            required="required" autocomplete="off">
                                    </div>
                                    <p>Password must contain at least 1 number, at least 1 lower case letter, and at
                                        least 1 upper case letter</p>
                                </div>
                                <div class="register-login-wrapper">
                                    <div class="register-login">
                                        <div class="row">
                                            <div class="col-sm-6">Already have an account?</div>
                                            <div class="col-sm-6"><a class="login-btn" href="#">Login</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 register-bg right">
                                <div class="register-form">
                                    <div class="row">
                                        <div class="col-md-12 register-form-row title">Enter Personal Details Below
                                        </div>
                                        <div class="col-md-12 register-form-row">
                                            <label>Address <span>*</span></label>
                                            <div class="alert alert-danger hidden" role="alert"
                                                id="user_address_error"></div>
                                            <input type="text" name="user_address" required="required"
                                                autocomplete="off">
                                        </div>
                                        <div class="col-md-6 register-form-row">
                                            <label>City</label>
                                            <input name="user_city" autocomplete="off">
                                        </div>
                                        <div class="col-md-6 register-form-row">
                                            <label>Country (Residence)</label>
                                            <div class="alert alert-danger hidden" role="alert"
                                                id="user_country_error"></div>
                                            <select name="user_country" id="user_country" selected="selected">
                                            </select>
                                        </div>
                                        <div class="col-md-6 register-form-row">
                                            <label>State</label>
                                            <div class="alert alert-danger hidden" role="alert" id="user_state_error">
                                            </div>
                                            <select name="user_state" id="user_state">
                                            </select>
                                        </div>
                                        <div class="col-md-6 register-form-row">
                                            <label>Zip</label>
                                            <div class="alert alert-danger hidden" role="alert" id="user_zip_error">
                                            </div>
                                            <input name="user_zip" autocomplete="off">
                                        </div>
                                        <div class="col-md-12 register-form-row">
                                            <label>Phone Number&nbsp;<span>*</span></label>
                                            <div class="alert alert-danger hidden" role="alert" id="user_phone_error">
                                            </div>
                                            <input name="user_phone" required="required" autocomplete="off">

                                        </div>
                                        {{-- <div class="col-md-12 register-form-row">
                                            <script src='https://www.google.com/recaptcha/api.js'></script>
                                            <div class="alert alert-danger hidden" role="alert" id="captcha_error">
                                            </div>
                                            <div class="g-recaptcha"
                                                data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"
                                                data-callback="verifyCaptcha"></div>
                                            <div class="g-recaptcha" data-sitekey="6LfVMroZAAAAAFLnWq0bGRYBYJtcbt5CR5zE11oB" data-callback="verifyCaptcha"></div>
                                            <div id="g-recaptcha-error"></div>
                                        </div> --}}
                                        <div class="col-md-12 register-form-row">
                                            <button type="submit" name="register_btn" id="register_btn"
                                                class="mt-4">CREATE ACCOUNT</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // 6LfVMroZAAAAAB1KEkY5nkF_VBqOR7yQEKSnB45O
</script>
