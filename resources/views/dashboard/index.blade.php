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

</div>

@endsection
