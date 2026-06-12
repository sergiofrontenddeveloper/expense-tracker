@extends('layouts.app')
@php
    $buttonEntity = 'ingreso';
@endphp
@section('content')

<div class="container-fluid py-3">

    {{-- CARD TABLE --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="card mb-3">
    <div class="card-body">
        <div class="row g-2 align-items-center">

            {{-- Buscador --}}
            <div class="col-md-5">
                <input
                    type="text"
                    class="form-control"
                    placeholder="Buscar gasto..."
                >
            </div>

            {{-- Categorías --}}
            <div class="col-md-3">
                <select class="form-select">
                    <option selected>Todas las categorías</option>
                    <option>Alimentación</option>
                    <option>Transporte</option>
                    <option>Suscripciones</option>
                </select>
            </div>

            {{-- Fecha --}}
            <div class="col-md-3">
                <input
                    type="date"
                    class="form-control"
                >
            </div>

            {{-- Icono calendario --}}
            <div class="col-md-1 text-center">
                <i class="fa-solid fa-calendar-days fs-5"></i>
            </div>

        </div>
    </div>
</div>
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

        </div><div class="d-flex justify-content-center align-items-center mt-3">

    <button class="btn btn-sm btn-light border me-2">
        <i class="fa-solid fa-chevron-left"></i>
    </button>

    <span class="mx-2">1</span>
    <span class="mx-2">2</span>
    <span class="mx-2">3</span>
    <span class="mx-2">...</span>
    <span class="mx-2">10</span>

    <button class="btn btn-sm btn-light border ms-2">
        <i class="fa-solid fa-chevron-right"></i>
    </button>

</div>
    </div>

</div>

@endsection
