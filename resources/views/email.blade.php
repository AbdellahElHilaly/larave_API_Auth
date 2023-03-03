<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Activation</title>
</head>
<body>
    <h1>Activate your account</h1>
    <p>Thank you for signing up. To activate your account, please click on the link below:</p>
    <p><a href="{{ $activationLink }}">Activate my account</a></p>
    <p>Your activation code is: {{ $activationCode }}</p>
</body>
</html>
