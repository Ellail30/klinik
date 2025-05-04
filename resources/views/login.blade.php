<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script> <!-- Tailwind CSS CDN -->
</head>

<body class="bg-cover bg-center" style="background-image: url('{{ asset('images/klinik.jpg') }}');">

    <div class="flex justify-center items-center min-h-screen bg-black bg-opacity-50">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">

            <h1 class="text-3xl font-bold text-center text-blue-600 mb-6">Login</h1>

            @if ($errors->has('login_error'))
                <div class="text-red-500 text-center mb-4">{{ $errors->first('login_error') }}</div>
            @endif

            <form action="{{ route('processLogin') }}" method="POST">
                @csrf

                <!-- Username Input with Floating Label -->
                <div class="relative z-0 w-full mb-6 group">
                    <input type="text" id="username" name="username" required
                        class="peer block w-full appearance-none bg-transparent border-2 border-gray-300 px-2 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md mt-2 transition-all duration-200 ease-in-out" />
                    <label for="username"
                        class="absolute text-gray-500 text-sm left-2 top-3 transition-all duration-200 ease-in-out origin-[0] scale-100 peer-placeholder-shown:scale-100 peer-placeholder-shown:top-3 peer-focus:top-1 peer-focus:text-blue-500 peer-focus:scale-75 peer-focus:left-2 peer-placeholder-shown:text-base peer-focus:text-xs">Username</label>
                </div>

                <!-- Password Input with Floating Label -->
                <div class="relative z-0 w-full mb-6 group">
                    <input type="password" id="password" name="password" required
                        class="peer block w-full appearance-none bg-transparent border-2 border-gray-300 px-2 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md mt-2 transition-all duration-200 ease-in-out" />
                    <label for="password"
                        class="absolute text-gray-500 text-sm left-2 top-3 transition-all duration-200 ease-in-out origin-[0] scale-100 peer-placeholder-shown:scale-100 peer-placeholder-shown:top-3 peer-focus:top-1 peer-focus:text-blue-500 peer-focus:scale-75 peer-focus:left-2 peer-placeholder-shown:text-base peer-focus:text-xs">Password</label>
                </div>

                <!-- Login Button -->
                <button type="submit"
                    class="w-full py-3 bg-blue-600 text-white font-bold rounded-md hover:bg-blue-700 transition duration-300">
                    Login
                </button>

            </form>

            <div class="mt-6 text-center">
                <a href="#" class="text-blue-500 text-sm">Forgot Password?</a>
            </div>
        </div>
    </div>

</body>

</html>
