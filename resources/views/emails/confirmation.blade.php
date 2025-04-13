<h2>Thank you, {{ $invoice->passenger->name }}!</h2>
<p>Your booking has been successfully confirmed. Here are the details:</p>

<ul>
    <li><strong>Order Number:</strong> #{{ $invoice->id }}</li>
    <li><strong>Total Fare:</strong> £{{ $invoice->fare }}</li>
    <li><strong>Pick-Up:</strong> {{ $invoice->from }}</li>
    <li><strong>Drop-Off:</strong> {{ $invoice->to }}</li>
    <li><strong>Date:</strong> {{ date('D, M d, Y', strtotime($invoice->date)) }}</li>
    <li><strong>Time:</strong> {{ date("g:i A", strtotime($invoice->time)) }}</li>
</ul>

<p>If you have any questions, feel free to contact us.</p>
