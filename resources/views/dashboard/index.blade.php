@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid">
<div class="d-flex justify-content-end align-items-center gap-5 mb-4">

    {{-- Buscador --}}
    <div style="width: 350px;">

        <div class="input-group">

            <span class="input-group-text bg-white">
                <i class="bi bi-search"></i>
            </span>

            <input
                type="text"
                 id="dashboardSearch"
                class="form-control"
                placeholder="Buscar...">

        </div>

    </div>

    {{-- Notificaciones --}}
    <button class="btn btn-light border">
        <i class="bi bi-bell"></i>
    </button>

    {{-- Usuario --}}
    <button class="btn btn-light border d-flex align-items-center gap-2">

        <i class="bi bi-person-circle fs-4"></i>

        <span>
            Hola, Usuario
        </span>

        <i class="bi bi-chevron-down"></i>

    </button>

</div>
    {{-- GRID DE CARDS --}}
    <div class="row g-3">

        {{-- CARD 1 --}}
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total Balance</h6>
                    <h3>€0.00</h3>
                </div>
            </div>
        </div>

        {{-- CARD 2 --}}
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Expenses</h6>
                    <h3>€0.00</h3>
                </div>
            </div>
        </div>

        {{-- CARD 3 --}}
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Revenue</h6>
                    <h3>€0.00</h3>
                </div>
            </div>
        </div>

        {{-- CARD 4 --}}
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Savings</h6>
                    <h3>€0.00</h3>
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
{{-- TRANSACCIONES RECIENTES --}}
<div class="row mt-4">

    <div class="col-12">

        <div class="card shadow-sm">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h5 class="mb-0">
                        Transacciones recientes
                    </h5>

                    <a href="{{ route('expenses') }}"
                       class="btn btn-sm btn-outline-primary">
                        Ver todas
                    </a>

                </div>

                <div class="table-responsive">

                    <table class="table align-middle mb-0">

                        <thead>

                            <tr>
                                <th>Concepto</th>
                                <th>Categoría</th>
                                <th>Fecha</th>
                                <th class="text-end">Importe</th>
                            </tr>

                        </thead>

                        <tbody>

                            <tr>
                                <td>Netflix</td>
                                <td>
                                    <span class="badge bg-danger">
                                        Gasto
                                    </span>
                                </td>
                                <td>12/06/2026</td>
                                <td class="text-end text-danger">
                                    -12,99 €
                                </td>
                            </tr>

                            <tr>
                                <td>Nómina</td>
                                <td>
                                    <span class="badge bg-success">
                                        Ingreso
                                    </span>
                                </td>
                                <td>10/06/2026</td>
                                <td class="text-end text-success">
                                    +2.100,00 €
                                </td>
                            </tr>

                            <tr>
                                <td>Supermercado</td>
                                <td>
                                    <span class="badge bg-danger">
                                        Gasto
                                    </span>
                                </td>
                                <td>08/06/2026</td>
                                <td class="text-end text-danger">
                                    -74,50 €
                                </td>
                            </tr>

                            <tr>
                                <td>Freelance</td>
                                <td>
                                    <span class="badge bg-success">
                                        Ingreso
                                    </span>
                                </td>
                                <td>05/06/2026</td>
                                <td class="text-end text-success">
                                    +450,00 €
                                </td>
                            </tr>

                            <tr>
                                <td>Spotify</td>
                                <td>
                                    <span class="badge bg-danger">
                                        Gasto
                                    </span>
                                </td>
                                <td>02/06/2026</td>
                                <td class="text-end text-danger">
                                    -10,99 €
                                </td>
                            </tr>

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

    const ctxLine = document.getElementById('lineChart');

    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
            datasets: [
                {
                    label: 'Gastos',
                    data: [120, 190, 300, 250, 180, 220],
                    borderWidth: 2,
                    tension: 0.3
                },
                {
                    label: 'Ingresos',
                    data: [200, 250, 320, 310, 280, 350],
                    borderWidth: 2,
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Ingresos vs Gastos'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const labels = @json($labels ?? []);
    const data = @json($data ?? []);

    const canvas = document.getElementById('expensesChart');

    if (!canvas) {
        console.error('Canvas no encontrado');
        return;
    }

    if (typeof Chart === 'undefined') {
        console.error('Chart NO está cargado (problema en Vite/app.js)');
        return;
    }

    new Chart(canvas, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Gastos',
                data: data,
                borderWidth: 1
            }]
        }
    });
});
</script>

@endsection


