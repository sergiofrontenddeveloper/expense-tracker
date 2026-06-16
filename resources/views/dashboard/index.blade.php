@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid">
<div class="d-flex justify-content-end align-items-center gap-5 mb-4">

    <div style="width: 350px;">
        <div class="input-group">
            <span class="input-group-text bg-white">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" id="dashboardSearch" class="form-control" placeholder="Buscar...">
        </div>
    </div>

    <button class="btn btn-light border position-relative">
        <i class="bi bi-bell"></i>
        @if ($unreadNotifications > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $unreadNotifications }}
            </span>
        @endif
    </button>

    <div class="dropdown">
        <button class="btn btn-light border d-flex align-items-center gap-2 dropdown-toggle" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle fs-4"></i>
            <span>Hola, {{ $user->name }}</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('profile') }}">Perfil</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">Cerrar sesión</button>
                </form>
            </li>
        </ul>
    </div>

</div>

    <div class="row g-3">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total Balance</h6>
                    <h3 class="{{ $balance >= 0 ? 'text-success' : 'text-danger' }}">€{{ number_format($balance, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Expenses</h6>
                    <h3>€{{ number_format($totalExpenses, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Revenue</h6>
                    <h3>€{{ number_format($totalRevenue, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Savings</h6>
                    <h3>€{{ number_format($savings, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

<div class="row g-3 m-2">
    <div class="col-12 col-lg-6">
        <div class="card p-3">
            <div style="height: 350px;">
                <canvas id="expensesChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card p-3">
            <div style="height: 350px;">
                <canvas id="lineChart"></canvas>
            </div>
        </div>
    </div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Transacciones recientes</h5>
                    <a href="{{ route('expenses') }}" class="btn btn-sm btn-outline-primary">Ver todas</a>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0" id="transactionsTable">
                        <thead>
                            <tr>
                                <th>Concepto</th>
                                <th>Categoría</th>
                                <th>Fecha</th>
                                <th class="text-end">Importe</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentTransactions as $transaction)
                                <tr>
                                    <td>{{ $transaction['description'] }}</td>
                                    <td>
                                        <span class="badge bg-{{ $transaction['type'] === 'expense' ? 'danger' : 'success' }}">
                                            {{ $transaction['type'] === 'expense' ? 'Gasto' : 'Ingreso' }}
                                        </span>
                                    </td>
                                    <td>{{ $transaction['date']->format('d/m/Y') }}</td>
                                    <td class="text-end text-{{ $transaction['type'] === 'expense' ? 'danger' : 'success' }}">
                                        {{ $transaction['type'] === 'expense' ? '-' : '+' }}{{ number_format($transaction['amount'], 2, ',', '.') }} €
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No hay transacciones recientes.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

</div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const labels = @json($labels);
    const expenseData = @json($expenseData);
    const revenueData = @json($revenueData);

    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                { label: 'Gastos', data: expenseData, borderWidth: 2, tension: 0.3 },
                { label: 'Ingresos', data: revenueData, borderWidth: 2, tension: 0.3 }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' },
                title: { display: true, text: 'Ingresos vs Gastos' }
            },
            scales: { y: { beginAtZero: true } }
        }
    });

    new Chart(document.getElementById('expensesChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{ label: 'Gastos', data: expenseData, borderWidth: 1 }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { title: { display: true, text: 'Gastos mensuales' } },
            scales: { y: { beginAtZero: true } }
        }
    });

    const searchInput = document.getElementById('dashboardSearch');
    const rows = document.querySelectorAll('#transactionsTable tbody tr');

    searchInput?.addEventListener('input', function () {
        const term = this.value.toLowerCase();
        rows.forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
        });
    });
});
</script>

@endsection
