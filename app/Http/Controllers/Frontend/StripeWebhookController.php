<?php
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Order; // Adjust this to your Order model

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sig_header, 'whsec_54648e32e85a9b3ab1b5069c7e1206031e09ffdc13f695782c49e422c6d64581');
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle the event based on type
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                // Process $session and store information in your database
                $orderId = session('order_id');
                $order = Order::find($orderId);
                if ($order) {
                    $order->update(['payment_status' => 'successful']);
                }

                dd($orderId,$session);
                $order->amount = $session->amount_total / 100; // Convert amount from cents to dollars
                $order->transaction_id = $session->id;
                $order->save();
                break;
            // Handle other event types as needed

            default:
                // Unexpected event type
                return response()->json(['error' => 'Unhandled event type'], 400);
        }

        return response()->json(['success' => true]);
    }
}
