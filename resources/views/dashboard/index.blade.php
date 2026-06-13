@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid">

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

<div class="row g-3">
    <div class="col-md-6">
        <canvas id="expensesChart"></canvas>
    </div>

    <div class="col-md-6">
        <canvas id="lineChart"></canvas>
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


