<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            position: relative;
            background: linear-gradient(rgba(39, 170, 222, 0.5), rgba(39, 170, 222, 0.5)),
                url('{{ asset('images/klinik.jpg') }}');
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
            background-size: cover;
        }

        .login-title {
            font-size: 28px;
            font-weight: bold;
            color: rgb(253, 255, 255);
            margin-bottom: 20px;
            text-align: center;
        }

        .wrapper {
            background-color: rgb(255, 255, 255);
            padding: 40px;
            width: 350px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgb(11, 180, 226);
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .input-box {
            position: relative;
            margin-bottom: 20px;
            width: 100%;
        }

        .input-box input {
            width: 100%;
            padding: 10px 40px;
            padding-left: 40px;
            border: 1px solid skyblue;
            border-radius: 20px;
            font-size: 14px;
            background: transparent;
            outline: none;
        }

        .input-box input::placeholder {
            color: rgba(0, 0, 0, 0.5);
        }

        .input-box i {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: rgb(126, 123, 123);
            font-size: 18px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            background-color: skyblue;
            color: rgb(255, 255, 255);
            border-radius: 20px;
            cursor: pointer;
            width: 100%;
        }

        .btn:hover {
            background-color: #1d82ca;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
    <h1 class="login-title">Login</h1>
    <div class="wrapper">
        @if ($errors->has('login_error'))
        <p style="color: red">{{ $errors->first('login_error') }}</p>
    @endif
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
    </div>
</body>
</html>
