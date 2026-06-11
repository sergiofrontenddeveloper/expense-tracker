<aside class="col-2 bg-dark text-white p-3">

    <h4 class="mb-4">Expense Tracker</h4>

    <nav class="nav flex-column">

        <a href="{{ route('dashboard') }}"
           class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active bg-primary rounded' : '' }}">
            Dashboard
        </a>

        <a href="{{ route('expenses') }}"
           class="nav-link text-white {{ request()->routeIs('expenses') ? 'active bg-primary rounded' : '' }}">
            Expenses
        </a>

        <a href="{{ route('revenue') }}"
           class="nav-link text-white {{ request()->routeIs('revenue') ? 'active bg-primary rounded' : '' }}">
            Revenue
        </a>

        <a href="{{ route('files') }}"
           class="nav-link text-white {{ request()->routeIs('files') ? 'active bg-primary rounded' : '' }}">
            Files
        </a>

        <a href="{{ route('profile') }}"
           class="nav-link text-white {{ request()->routeIs('profile') ? 'active bg-primary rounded' : '' }}">
            Profile
        </a>

    </nav>

</aside>
