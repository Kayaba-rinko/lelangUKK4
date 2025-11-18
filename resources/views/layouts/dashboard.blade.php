<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard || @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('build/assets/css/dashboard.css') }}">
</head>

<body>

    <div class="dashboard-container">

        @include('components.sidebar')

        @yield('content')

    </div>

</body>

</html>
