<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <div class="payment-popup">
                    <h3>Payment<i class="fa fa-lock" aria-hidden="true"></i></h3>
                    <div class="visa-card">
                        <div class="row">
                            <div class="col-6">
                                <label>Card number</label>
                                <input type="text" name="card_number">
                            </div>
                            <div class="col-3">
                                <label>Expiry</label>
                                <input type="text" name="expiry" placeholder="MM/YYYY">
                            </div>
                            <div class="col-3">
                                <label>CVV</label>
                                <input type="text" name="cvv" placeholder="***">
                            </div>
                        </div>
                    </div>
                    <div class="price">
                        <p><span>Subtotal</span><span>600$</span></p>
                        <p class="tax"><span>Tax</span><span>0$</span></p>
                        <hr>
                        <p class="total"><span>Total</span><span>600$</span></p>
                    </div>
                    <button class="order">PLACE ORDER</button>
                </div>
            </div>
        </div>
    </div>
</div>