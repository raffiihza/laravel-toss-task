<!DOCTYPE html>
<html lang="en">
<head >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Absensi Guru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            clifford: '#da373d',
          }
        }
      }
    }
  </script>
</head>

<body class=" flex justify-center items-center h-screen" style="background-image: url({{ asset('img/background-login/background_login.png') }}); ">
    <div class="card-container">
      <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl">
        <div class="md:flex-justify">
   
          <div class="md:shrink-0 flex justify-center items-center mx-auto my-auto">
            <img class="w-30 h-24 flex-justify-center" src="{{ asset('img/CourseKita_logo.png') }}" alt="CourseKita">
          </div>
          <hr class="md:m-3" style ="border-color: #56616b; border-width: 3px">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="p-8 flex-center">
            <div class="grid gap-6">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input placeholder="you@example.com" id="email" class="block w-full p-2 text-gray-900 border-bottom border-gray-300 bg-gray-50" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            
        <!-- Password -->
        <div class="mt-">
            <x-input-label for="password" :value="__('Password')" />
            
            <x-text-input placeholder="•••••••••" id="password" class="block w-full p-2 text-gray-900 border-bottom border-gray-300 bg-gray-50"
            type="password"
            name="password"
            required autocomplete="current-password" />
            
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex justify-end">

            {{-- @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
                @endif --}}
        </div>
        <div class="flex justify-start">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>
        <div class="flex justify-center">
                
                <x-primary-button >
                    {{ __('Log in') }}
                </x-primary-button>
        </div>
    </form>
    @if (Route::has('register'))
    <h class="text-sm">
        Don't Have Any Account? <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}">
            {{ __('Register') }}</a>
        </h>
    @endif
</div>
</div>
</div>
</div>
</div>
</body>