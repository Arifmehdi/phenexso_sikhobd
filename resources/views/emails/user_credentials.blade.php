<!DOCTYPE html>
<html>
<head>
    <title>Your Account Credentials</title>
</head>
<body>
    <h2>Welcome to {{ config('app.name') }}!</h2>
    <p>Hello {{ $user->name }},</p>
    <p>Your account has been created successfully. You can now login to access your courses.</p>
    <p><strong>Login Details:</strong></p>
    <ul>
        <li><strong>Email/Mobile:</strong> {{ $user->email ?? $user->mobile }}</li>
        <li><strong>Password:</strong> {{ $password }}</li>
    </ul>
    <p>You can login here: <a href="{{ route('login') }}">{{ route('login') }}</a></p>
    <p>We recommend changing your password after your first login.</p>
    <p>Thank you!</p>
</body>
</html>
