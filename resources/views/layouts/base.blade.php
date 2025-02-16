<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - EduTend</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="flex min-h-screen">
        @include('layouts.partials.sidebar')

        <div class="flex-1 flex flex-col">
            @include('layouts.partials.navbar')

            <main class="p-6 flex-1 overflow-auto">
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>
