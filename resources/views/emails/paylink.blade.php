<h2>Hello {{ $invoice->passenger->name }},</h2>

<p>Your booking request has been received! Please complete your payment to confirm your booking.</p>

<p><strong>Booking ID:</strong> #{{ $invoice->id }}</p>
<p><strong>Total Fare:</strong> £{{ $invoice->fare }}</p>

<p><a href="{{ $paymentUrl }}" style="background: #3490dc; color: #fff; padding: 10px 20px; text-decoration: none;">Pay Now</a></p>

<hr>
<p><strong>Pick-up:</strong> {{ $invoice->from }}</p>
<p><strong>Drop-off:</strong> {{ $invoice->to }}</p>
<p><strong>Date:</strong> {{ date('D, M d, Y', strtotime($invoice->date)) }}</p>
<p><strong>Time:</strong> {{ date("g:i A", strtotime($invoice->time)) }}</p>
