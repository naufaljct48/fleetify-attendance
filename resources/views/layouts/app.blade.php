<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fleetify Attendance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0/dist/css/tabler.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0/dist/css/tabler-flags.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0/dist/css/tabler-payments.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0/dist/css/tabler-social.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0/dist/css/tabler-vendors.min.css">
    <link href="https://preview.tabler.io/dist/css/demo.min.css?1738448791" rel="stylesheet" />
    <style>
        @import url('https://rsms.me/inter/inter.css');
    </style>
</head>

<body class="theme-dark">
    <script src="https://preview.tabler.io/dist/js/demo-theme.min.js?1738448791"></script>
    <div class="page">
        <div class="page-wrapper">
            <div class="container-xl">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0/dist/js/tabler.min.js"></script>
    <script src="https://preview.tabler.io/dist/js/demo.min.js?1738448791" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    @if(session('swal'))
    <script>
        Swal.fire({
            icon: '{{ session("swal")["type"] }}',
            title: '{{ session("swal")["title"] }}',
            text: '{{ session("swal")["text"] }}'
        });
    </script>
    @endif
</body>

</html>