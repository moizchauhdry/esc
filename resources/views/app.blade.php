<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="semi-dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    {{--
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.5.4/socket.io.js"
        integrity="sha512-YeeA/Qxn5hYdkukScTCNNOhTrv1C2RubAGButJ1rmgQwZf/HdRaCGl+JAVkqsqaNRaYNHdheiuKKuPf9mDcqKg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    @auth
    let user_id = "{{ auth()->user()->id }}";
    let ip_address = 'http://127.0.0.1';
    let socket_port = '8006';
    let socket = io(ip_address + ':' + socket_port);
    socket.on('connect', function() {
        socket.emit('user_connected', user_id);
        console.log(user_id);
    });
    socket.on('userUpdateStatus', (data) => {
        console.log(data)
    });  
    @endauth
</script>

</html>