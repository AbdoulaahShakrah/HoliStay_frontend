<!-- layout.blade.php -->
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HOLISTAY')</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('layout/css/host-layout.css') }}">
</head>

<body>
    
    @include('components.host-navbar')
       
    <div class="container">

        @include('components.host-sidebar')

        <main>
            @yield('content')
        </main>

    </div>
    
    @include('components.footer')

</body>

</html>