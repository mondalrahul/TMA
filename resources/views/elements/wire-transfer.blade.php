<div class="wire-transfer-modal modal fade" id="wireTransferModal" tabindex="-1" role="dialog" aria-labelledby=""
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <div class="wire-transfer-box">
                    <form action="" id="wire-transfer-form">
                        @if ($data['curBoatDetail']->book_type != 'Skippered')
                            <p class="title">Bank Transfer</p>
                        @endif
                        <form id="wire-transfer-form">
                            @if (\Illuminate\Support\Facades\Auth::check())
                                <?php
                                $user = \Illuminate\Support\Facades\Auth::user();
                                $user_email = $user->user_email;
                                ?>
                            @else
                                <?php
                                $user_email = '';
                                ?>
                            @endif
                            <div class="alert alert-danger hidden" role="alert" id="wire_transfer_email_error"></div>
                            <input
                                @if ($user_email === '') placeholder="Please enter your email address" @endif
                                name="wire_transfer_email" value="{{ $user_email }}">
                            @if ($data['curBoatDetail']->book_type == 'Skippered')
                                <button type="button" class="button button-highlight"
                                    id="btn-send-wire-transfer">CONFIRM REQUEST</button>
                            @else
                                <button type="button" class="button button-highlight" id="btn-send-wire-transfer">SEND
                                    ACCOUNT DETAILS</button>
                            @endif
                        </form>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
