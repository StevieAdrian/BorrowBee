<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
</head>
<body style="font-family: Arial, sans-serif;">

    <h2>New Message From {{ $user->name }}</h2>

    <p><strong>Name:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>

    <hr>

    <p><strong>Message:</strong></p>
    <p>{{ $messageContent }}</p>

    <hr>

    <small>
        Sent automatically from BorrowBee
    </small>

</body>
</html>
