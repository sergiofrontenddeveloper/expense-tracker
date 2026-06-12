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

<div class="container mt-4">
    <h4>Dashboard</h4>

    <canvas id="expensesChart"></canvas>
</div>

</div>

</div><div style="width: 600px; margin: 20px auto;">
    <canvas id="expensesChart"></canvas>
    <p>TEST DASHBOARD OK</p>


</div>

<div style="width: 600px; height: 300px; margin: 20px auto;">
    <canvas id="expensesChart"></canvas>
</div>

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


