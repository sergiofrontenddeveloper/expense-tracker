<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Expense Tracker</title>
 <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>

<body>
    {{-- Header móvil --}}
<div class="d-lg-none border-bottom bg-white">

    <div class="d-flex align-items-center justify-content-between px-3 py-2">

        {{-- Hamburguesa --}}
        <button
            class="btn btn-outline-dark"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#mobileSidebar">

            ☰

        </button>

        {{-- Logo / Título --}}
        <span class="fw-bold">
            Expense Tracker
        </span>

        {{-- Usuario --}}
        <a href="{{ route('profile') }}"
           class="text-dark text-decoration-none">

            <i class="bi bi-person-circle fs-3"></i>

        </a>

    </div>

</div>

<div class="container-fluid vh-100">

    <div class="row h-100">

        {{-- SIDEBAR --}}
        <x-sidebar />

        {{-- MAIN --}}
<div class="col-12 col-lg-10 d-flex flex-column p-0">

            {{-- NAVBAR --}}
            @if (!request()->routeIs('dashboard'))

    {{-- NAVBAR --}}
    <nav class="navbar navbar-light bg-light border-bottom px-3">

        <span class="navbar-brand mb-0 h1">
            @yield('title', 'Dashboard')
        </span>

        @if(isset($buttonEntity))
            <x-add-button :entity="$buttonEntity" />
        @endif

    </nav>

@endif

            {{-- CONTENT --}}
            <main class="p-4 flex-grow-1 overflow-auto">
                @yield('content')
            </main>

        </div>

    </div>

</div>
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar">

    <div class="offcanvas-header">
        <h5>Expense Tracker</h5>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas">
        </button>
    </div>

    <div class="offcanvas-body">

        <nav class="nav flex-column">

            <a href="{{ route('dashboard') }}" class="nav-link">
                Dashboard
            </a>

            <a href="{{ route('expenses') }}" class="nav-link">
                Expenses
            </a>

            <a href="{{ route('revenue') }}" class="nav-link">
                Revenue
            </a>

            <a href="{{ route('files') }}" class="nav-link">
                Files
            </a>

            <a href="{{ route('profile') }}" class="nav-link">
                Profile
            </a>

        </nav>

    </div>

</div>
</body>
</html>
