<div class="account-modal modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
    <input name="login_password_hidden" type="hidden" value="">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="login-title">
                                <p class="strong">LOGIN TO</p>
                                <p>YOUR EXISTING ACCOUNT</p>
                            </div>
                            <div class="login-form">
                                <form name="form_login" action="/login" method="post" id="form_login">
                                    {{ csrf_field() }}
                                    <div class="alert alert-danger hidden" role="alert" id="common_error"></div>
                                    <label>Email Address&nbsp;<span>*</span></label>
                                    <div class="alert alert-danger hidden" role="alert" id="login_email_error"></div>
                                    <div class="email-input has-icon">
                                        <input name="login_email" required="required">
                                    </div>
                                    <label>Password&nbsp;<span>*</span></label>
                                    <div class="alert alert-danger hidden" role="alert" id="login_password_error"></div>
                                    <div class="password-input has-icon">
                                        <input name="login_password" type="password">
                                    </div><a data-toggle="collapse" href="#forgotPasswordSection" aria-expanded="false" aria-controls="forgotPasswordSection">Forgot Password?</a>
                                    <button name="login_btn" id="login_btn" required="required">LOGIN</button>
                                </form>
                            </div>
                            <div class="login-reset-wrapper collapse" id="forgotPasswordSection">
                                <div class="login-reset"
                                    <p>Enter your email address and we'll send you a link to reset your password</p>
                                     <form name="forgotpass" action="{{route('forgot_pass')}}" method="post" >
                                         {{ csrf_field() }}
                        
                                        <div class="login-form">
                                            <label>Email Address&nbsp;<span>*</span></label>
                                            <div class="email-reset-input">
                                                <div class="input-group">
                                                    <input type="email" required name="email"><span class="input-group-btn">
                                                        <button type="submit" name="sendnotify">SEND</button></span>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="login-create-account-wrapper">
                                <div class="login-create-account">
                                    <div class="row">
                                        <div class="col-sm-6">No Account Yet?</div>
                                        <div class="col-sm-6"><a class="create-account-btn" href="#">Create Account</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 login-bg"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>