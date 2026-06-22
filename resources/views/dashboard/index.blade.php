
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-end align-items-center gap-4 mb-4">

        <div style="width: 300px;">
            <div class="input-group">
                <span class="input-group-text bg-white">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="dashboardSearch" class="form-control" placeholder="Buscar...">
            </div>
        </div>

        <div style="width: 180px;">
            <div class="input-group" title="Configurar límite de gastos mensual">
                <span class="input-group-text bg-white text-secondary">
                    <i class="bi bi-wallet2"></i>
                </span>
                <input type="number"
                       id="monthlyLimitInput"
                       class="form-control"
                       value="{{ auth()->user()->monthly_limit ?? '' }}"
                       placeholder="Límite mensual €"
                       onchange="updateMonthlyLimit(this.value)">
            </div>
        </div>

        <div class="dropdown">
            <button class="btn btn-light border position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-bell"></i>
                @if(auth()->user()->unreadNotifications()->count() > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ auth()->user()->unreadNotifications()->count() }}
                    </span>
                @endif
            </button>

            <div class="dropdown-menu dropdown-menu-end shadow" style="width: 320px; max-height: 400px; overflow-y: auto;">
                <div class="p-2 border-b bg-light d-flex justify-content-between align-items-center">
                    <span class="fw-bold ps-2 text-secondary" style="font-size: 0.9rem;">Notificaciones</span>
                    @if(auth()->user()->unreadNotifications()->count() > 0)
                        <a href="{{ route('notifications.markAllAsRead') }}" class="btn btn-link btn-sm text-decoration-none p-0 pe-2" style="font-size: 0.75rem;">
                            Marcar todo como leído
                        </a>
                    @endif
                </div>

                <div class="list-group list-group-flush">
                    @forelse(auth()->user()->notifications()->take(5)->get() as $notification)
                        <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-start {{ !$notification->is_read ? 'bg-light font-weight-bold' : '' }}">
                            <div class="ms-2 me-auto" style="font-size: 0.85rem;">
                                <div class="fw-bold text-dark">{{ $notification->title }}</div>
                                <span class="text-muted">{{ $notification->message }}</span>
                                <small class="text-black-50 d-block mt-1">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                            @if(!$notification->is_read)
                                <a href="{{ route('notifications.markAsRead', $notification) }}" class="btn btn-sm text-primary p-0 shell-btn" title="Marcar como leída">
                                    <i class="bi bi-check2"></i>
                                </a>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted" style="font-size: 0.85rem;">
                            <i class="bi bi-bell-slash d-block fs-4 mb-1"></i>
                            No tienes notificaciones.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

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

    <div class="row g-3 my-2">
        <div class="col-12 col-lg-6">
            <div class="card p-3">
                <div style="height: 350px; position: relative;">
                    <canvas id="expensesChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card p-3">
                <div style="height: 350px; position: relative;">
                    <canvas id="lineChart"></canvas>
                </div>
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

<script>
// Función para actualizar el límite asíncronamente
function updateMonthlyLimit(value) {
    if(!value || value < 1) return;

    fetch("{{ route('user.updateLimit') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ monthly_limit: value })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            const input = document.getElementById('monthlyLimitInput');
            input.classList.add('is-valid');
            setTimeout(() => input.classList.remove('is-valid'), 1200);
        }
    })
    .catch(error => console.error('Error al actualizar el límite:', error));
}

// Inicialización segura de Chart.js
document.addEventListener('DOMContentLoaded', function () {
    const labels = @json($labels) || [];
    const expenseData = @json($expenseData) || [];
    const revenueData = @json($revenueData) || [];

    const ctxLine = document.getElementById('lineChart');
    if (ctxLine) {
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    { label: 'Gastos', data: expenseData, borderWidth: 2, tension: 0.3, borderColor: '#dc3545', backgroundColor: 'transparent' },
                    { label: 'Ingresos', data: revenueData, borderWidth: 2, tension: 0.3, borderColor: '#198754', backgroundColor: 'transparent' }
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
    }

    const ctxBar = document.getElementById('expensesChart');
    if (ctxBar) {
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{ label: 'Gastos', data: expenseData, borderWidth: 1, backgroundColor: '#dc3545' }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { title: { display: true, text: 'Gastos mensuales' } },
                scales: { y: { beginAtZero: true } }
            }
        });
    }

    // Buscador interactivo de la tabla
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
