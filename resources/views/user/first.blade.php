<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="first">
            <h3>Welcome to Talk</h3>
            @if (Route::has('login'))
            @auth
            <div class="login">
                <a href="{{ url('/index') }}">Continue to Charts</a>
            </div>
            @else
            <div class="login">
                <a href="{{ route('login') }}">Login</a>
            </div>
            @if (Route::has('register'))
            <div class="reg">
                <a href="{{ route('register') }}">Register</a>
            </div>
            @endif
            @endauth
            @endif
        </div>
    </div>
</body>

</html>