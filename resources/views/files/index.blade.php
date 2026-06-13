@extends('layouts.app')

@section('title', 'Files')
@php
    $buttonEntity = 'fichero';
@endphp
@section('content')

<div class="container-fluid">

    <div class="row g-4">

        <!-- Upload Area -->
        <div class="col-lg-4">

            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">

                    <i class="bi bi-cloud-arrow-up display-1 mb-3"></i>

                    <p class="mb-4">
                        Arrastra y suelta tu archivo aquí
                    </p>

                    <button type="button" class="btn btn-primary">
                        Seleccionar Archivo
                    </button>

                </div>
            </div>

        </div>

        <!-- Files Table -->
        <div class="col-lg-8">

            <div class="card">

                <div class="card-body p-0">

                    <table class="table table-hover align-middle mb-0">

                        <thead>
                            <tr>
                                <th>Archivo</th>
                                <th>Fecha</th>
                                <th>Cantidad</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td>balance_mayo.pdf</td>
                                <td>01/06/2024</td>
                                <td>1.2 MB</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>balance_junio.pdf</td>
                                <td>01/07/2024</td>
                                <td>1.1 MB</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>balance_julio.pdf</td>
                                <td>01/08/2024</td>
                                <td>1.0 MB</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <div class="row mt-4">

        <div class="col-12">

            <small class="text-muted">
                Formatos permitidos: PDF, CSV, XLSX (Máx. 10 MB)
            </small>

        </div>

    </div>

</div>
@endsection
