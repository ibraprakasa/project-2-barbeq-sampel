<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSS Bootstrap -->
    <link rel="stylesheet" href="/bootstrap-5.2.2-dist/css/bootstrap.min.css">
    <!-- My Style -->
    <link rel="stylesheet" href="/css/style.css">
    <!-- cdnlink awesome Icons -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>{{ $title }}</title>
</head>
<body>


    {{-- @include('partials.nav') --}}

    <!-- Block untuk kontent-->
    <div class="container mt-4">
        @yield('magang')
    </div>


</body>
<!-- Javascript Bootstrap-->
<script src="/bootstrap-5.2.2-dist/js/bootstrap.bundle.min.js"></script>
</html>
