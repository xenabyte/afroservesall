<!DOCTYPE html>
<html>

<head>
    <title>Payment Notification</title>
</head>

<body>
    <h1>Thank you for your purchase!</h1>

    <p>Dear {{ $customerName }},</p>

    <p>We are writing to confirm that we have received your payment for the following product:</p>

    <table>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Total Price</th>
        </tr>
        <tr>
            <td>{{ $productName }}</td>
            <td>{{ $quantity }}</td>
            <td>{{ $totalPrice }}</td>
        </tr>
    </table>

    <p>Your payment has been processed successfully by Stripe. The transaction ID for your payment is
        {{ $transactionId }}.</p>

    <p>Thank you for shopping with us!</p>

    <p>Best regards,</p>
    <p>Your Company Name</p>
</body>

</html>
