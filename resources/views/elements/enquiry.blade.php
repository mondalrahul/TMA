<div class="enquiry-modal modal fade" id="enquiryModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{ csrf_field() }}
                <div class="enquiry-box">
                    <p class="title">Enquiry Box</p>
                    @if(\Illuminate\Support\Facades\Auth::check())
                        <?php
                            $user = \Illuminate\Support\Facades\Auth::user();
                            $user_name = $user->user_name;
                            $user_email = $user->user_email;
                            $user_phone = $user->user_phone;
                        ?>
                    @else
                        <?php
                            $user_name = '';
                            $user_email = '';
                            $user_phone = '';
                        ?>
                    @endif
                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <div class="alert alert-danger hidden" role="alert" id="enquiry_user_name_error"></div>
                        <input class="form-input form-item" name="enquiry_user_name" value="{{$user_name}}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <div class="alert alert-danger hidden" role="alert" id="enquiry_user_email_error"></div>
                        <input class="form-input form-item" name="enquiry_user_email" value="{{$user_email}}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Contact Number</label>
                        <div class="alert alert-danger hidden" role="alert" id="enquiry_user_phone_error"></div>
                        <input class="form-input form-item" name="enquiry_user_phone" value="{{$user_phone}}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Alternative Contact Number</label>
                        <div class="alert alert-danger hidden" role="alert" id="enquiry_user_alter_phone_error"></div>
                        <input class="form-input form-item" name="enquiry_user_alter_phone">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Selected Date</label>
                        <div class="alert alert-danger hidden" role="alert" id="enquiry_user_selected_date_error"></div>
                        <input class="form-input form-item" name="enquiry_user_selected_date" data-date-format="yyyy-mm-dd" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Other Information</label>
                        <textarea class="form-input form-item" name="enquiry_user_other_info"></textarea>
                    </div>
                    <div class="form-group col-md-12">
                            <script src='https://www.google.com/recaptcha/api.js'></script>
                                        	 
                                           <div class="g-recaptcha" data-sitekey="6LfVMroZAAAAAFLnWq0bGRYBYJtcbt5CR5zE11oB" data-callback="verifyCaptcha"></div>
                                           <div id="g-recaptcha-error"></div>
                                            </div>
                    <button class="button button-highlight" id="btn-send-enquiry">ENQUIRE NOW</button>
                </div>
            </div>
        </div>
    </div>
</div>
