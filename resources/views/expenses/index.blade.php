
@extends('layouts.app')

@section('title', 'Expenses')

@section('content')

<div class="container-fluid py-3">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Expenses</h4>

        <button class="btn btn-primary">
            + Añadir gasto
        </button>
    </div>

    {{-- CARD TABLE --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <table class="table table-hover table-striped align-middle">

                <thead class="table-light">
                    <tr>
                        <th>Concepto</th>
                        <th>Fecha</th>
                        <th>Categoría</th>
                        <th class="text-end">Importe</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    {{-- EJEMPLO 1 --}}
                    <tr>
                        <td>Supermercado</td>
                        <td>10/06/2026</td>
                        <td>Food</td>
                        <td class="text-end">
                            <span class="fw-semibold text-danger">-€45.20</span>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-primary">Editar</button>
                            <button class="btn btn-sm btn-outline-danger">Borrar</button>
                        </td>
                    </tr>

                    {{-- EJEMPLO 2 --}}
                    <tr>
                        <td>Gasolina</td>
                        <td>09/06/2026</td>
                        <td>Transport</td>
                        <td class="text-end">
                            <span class="fw-semibold text-danger">-€60.00</span>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-primary">Editar</button>
                            <button class="btn btn-sm btn-outline-danger">Borrar</button>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection
