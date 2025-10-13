<?php
namespace App\Services;

use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createPaymentIntent($amount, $currency = 'usd')
    {
        $intent = PaymentIntent::create([
            'amount' => $amount,
            'currency' => $currency,
        ]);

        return $intent;
    }

    public function processPayment($amount, $paymentMethodId, $customerName, $customerEmail)
    {
    

        try {
            // Confirm the payment intent with the provided payment method ID
            $paymentIntent = PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'usd', // Replace 'usd' with the appropriate currency code if needed
            'payment_method' => $paymentMethodId,
            'confirmation_method' => 'manual',
            ]);
            $paymentIntent->metadata = [
                'customer_name' => $customerName,
                'customer_email' => $customerEmail,
            ];
            $paymentIntent->save();
            \Log::info('Stripe API Response:', $paymentIntent->jsonSerialize());
            if ($paymentIntent->status === 'succeeded') { 
                return true;
            } else { 
                \Log::error('Payment Failed:', ['status' => $paymentIntent->status]);
                return false;
            }
            return true;
        } catch (\Exception $e) {

            \Log::error('Payment Error:', ['message' => $e->getMessage()]);
            \Log::error('Payment Failed:', ['error_message' => $e->getMessage()]);

            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    // Add any additional methods here to handle further payment processing logic if needed.
}