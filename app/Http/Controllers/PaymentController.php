<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmation;
use App\Mail\BookingPaymentLink;
use App\Models\Fleets;
use App\Models\Passengers;
use App\Models\Trips;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Mockery\Generator\StringManipulation\Pass\Pass;
use Stripe\Checkout\Session;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Stripe\Webhook;
use UnexpectedValueException;

class PaymentController extends Controller
{
    public function create(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        if($request->input('bookingType') != 'hourly'){
            $description = $request->input('distance'). 'Hour(s). Pickup:'. $request->input('pickup');
        }else{
            $description = $request->input('pickup') . "===>>>". $request->input('dropoff');
            if($request->input('hasReturn') == "true"){
                $description = $request->input('pickup') . "<<<===>>>". $request->input('dropoff');
            }
        }
        if($request->input('bookingType') === 'standard'){
            $trip = 1;
        }else if ($request->input('bookingType') === 'hourly'){
            $trip = 3;
        }else{
            $trip = 2;
        }
        $ifPassenger = Passengers::where('email', json_decode($request->input('passenger'))->email)->get();
        if(!$ifPassenger->count()){
            Passengers::insert( [
                'phone' => json_decode($request->input('passenger'))->phone,
                'name' => json_decode($request->input('passenger'))->name,
                'email' => json_decode($request->input('passenger'))->email,
                'address' => "",
                'booked' => 1,
            ]);
        }else{
            Passengers::where('email', json_decode($request->input('passenger'))->email)->increment('booked');
        }
        $passenger_id = Passengers::where('email', json_decode($request->input('passenger'))->email)->value('id');

        $trip_order = Trips::insertGetId([
            'from' => $request->input('pickup'),
            'to' => $request->input('dropoff'),
            'remaining_return' => $request->input('hasReturn')==="true" ? 1 : 0,
            'return_date' => $request->input('hasReturn')==="true" ? $request->input('return_date') : null,
            'return_time' => $request->input('hasReturn')==="true" ? $request->input('return_time') : null,
            'date' => $request->input('date'),
            'time' => $request->input('time'),
            'flight_number' => $request->input('flight_number'),
            'trip_type'=> $trip,
            'distance' => $request->input('distance'),
            'fleets_id' => $request->input('fleet'),
            'passengers_id' => $passenger_id,
            'fare' => $request->input('fare'),
            'people' => json_decode($request->input('passenger'))->people,
            'luggages' => json_decode($request->input('passenger'))->luggages,
            'status' => 0,
        ]);
        $checkout_session = Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'gbp',
                        'product_data' => [
                            'name' => ucwords($request->input('bookingType'). ' Booking'),
                            'description' => $description,
                        ],
                        'unit_amount' => $request->input('fare') * 100, // in pence
                    ],
                    'quantity' => $request->input('hasReturn') == 'true' ? 2 : 1,
                ]
            ],
            'customer_email'=> json_decode($request->input('passenger'))->email,
            'metadata' => [
                'order' => $trip_order,
                'booking_type' => $request->input('bookingType'),
                'pickup' => $request->input('pickup'),
                'dropoff' => $request->input('dropoff'),
                'date' => $request->input('date'),
                'time' => $request->input('time'),
                'fare' => $request->input('fare'),
                'distance' => $request->input('distance'),
                'fleet' => $request->input('fleet'),
                'passenger' => $request->input('passenger'),
                'has_return' => $request->input('has_return'),
                'return_time' => $request->input('return_time'),
                'return_date' => $request->input('return_date'),
            ],
            'mode' => 'payment',
            'success_url' => route('success').'?order='.$trip_order,
            'cancel_url' => route('cancel'),
        ]);
        $update = Trips::where('id', $trip_order)->update(['pay_link'=> $checkout_session->url]);
        if(auth()->user() && $request->input('admin')){
            $invoice = Trips::where('id', $trip_order)->first();
            Mail::to(json_decode($request->input('passenger'))->email)->send(new BookingPaymentLink($invoice, $checkout_session->url));
            return redirect()->to('/admin/trips');
        }
        return redirect()->to($checkout_session->url);
    }
    public function success(Request $request){
        $invoice = Trips::with(['fleet', 'passenger'])->where('id', $request->query('order'))->first();
        if($invoice){
            return view('success',['invoice' => $invoice]);
        }else{
            return redirect('/booking');
        }
    }
    public function cancel(Request $request){
        return view('cancel');
    }
    public function handleStripeWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = env('STRIPE_ENDPOINT_SECRET'); // Add this to your .env

        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );

            if ($event->type === 'checkout.session.completed') {
                $session = $event->data->object;
                // Get trip order ID from metadata
                $trip_id = $session->metadata->order ?? null;
                if ($trip_id) {
                    $trip = Trips::with(['passenger'])->find($trip_id);
                    if ($trip) {
                        $trip->status = 1; // ✅ Mark as paid
                        $trip->save();
                        Mail::to($trip->passenger->email)->send(new BookingConfirmation($trip));
                    }
                }
            }
            return response()->json(['status' => 'Webhook handled'], 200);
        } catch (UnexpectedValueException $e) {
            // Invalid payload
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (SignatureVerificationException $e) {
            // Invalid signature
            return response()->json(['error' => 'Invalid signature'], 400);
        }
    }

    public function updateBooking(Request $request){
        $update = Trips::where("id", $request->input('order'))->update(['status' => $request->input('status')]);
        return redirect()->to('/admin/trips');
    }
}
