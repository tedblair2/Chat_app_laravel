<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/public">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="main">
        <section class="users-area">
            <div class="profile">
                <div class="details">
                    <img src="/profiles/{{$user->image}}" alt="">
                    <div class="names">
                        <h2>{{$user->name}}</h2>
                        <p>{{$user->status}}</p>
                    </div>
                </div>
                <form action="{{url('/logout')}}" method="post">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
            <hr>
            <form action="#">
                @csrf
                <input type="text" name="search" id="searchUser" placeholder="Search User..." class="">
            </form>
            <div class="users">

            </div>
        </section>
        <section class="chat-area">
            <div class="top active">

            </div>
            <div class="chats active">

            </div>
            <div class="actions active">
                <form action="#">
                    {{csrf_field()}}
                    <input type="text" name="message" id="msg" placeholder="Enter Message Here...." autocomplete="off">
                    <button type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                </form>
            </div>
            <div class="cover">
                <div class="landing">
                    <img src="chat.jpeg" alt="">
                    <span>Click on a user to start chatting</span>
                </div>
            </div>
        </section>
    </div>
    <script src="index.js"></script>
</body>

</html>