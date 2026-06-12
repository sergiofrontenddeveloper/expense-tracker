<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Expense Tracker</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container-fluid vh-100">

    <div class="row h-100">

        {{-- SIDEBAR --}}
        <x-sidebar />

        {{-- MAIN --}}
        <div class="col-10 d-flex flex-column p-0">

            {{-- NAVBAR --}}
            <nav class="navbar navbar-light bg-light border-bottom px-3">
                <span class="navbar-brand mb-0 h1">
                    @yield('title', 'Dashboard')
                </span>

           @if(isset($buttonEntity))
    <x-add-button :entity="$buttonEntity" />
@endif
            </nav>

            {{-- CONTENT --}}
            <main class="p-4 flex-grow-1 overflow-auto">
                @yield('content')
            </main>

        </div>

    </div>

</div>

</body>
</html>
