<!DOCTYPE html>
<html>

<head>

    <title>Restaurante QR</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


</head>

<body>

    <nav class="navbar navbar-dark bg-dark">

        <div class="container">

            <a class="navbar-brand" href="#">
                Restaurante
            </a>

        </div>

    </nav>

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
