<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\Webhook;
use App\Models\Purchase;
use Illuminate\Http\Request;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Stripe::setApiKey(config('stripe.secret'));

        $endpoint_secret = config('stripe.webhook_secret');

        $payload = $request->getContent();
        $sig_header = $request->server('HTTP_STRIPE_SIGNATURE');

        try{
            $event = Webhook::constructEvent(
                $payload,$sig_header,$endpoint_secret
            );
        }catch (\UnexpectedValueException $e){
            return response('Invalid payload',400);
        }catch (\Stripe\Exception\SignatureVerificationException $e){
            return response('Invalid signature',400);

        }

        if ($event->type === 'checkout.session.completed'){
            $session = $event->data->object;
        
            Purchase::create([
                'profile_id'=> $session->metadata->profile_id,
                'item_id'=> $session->metadata->item_id,
                'payment_method'=>$session->payment_method_types[0] === 'card'? 2: 1,
            ]);
        }

        return response('Webhook handle',200);
    }
}
