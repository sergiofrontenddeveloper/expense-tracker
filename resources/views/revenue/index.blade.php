@extends('layouts.app')
@php $buttonEntity = 'ingreso'; @endphp
@section('title', 'Revenue')

@section('content')

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="container-fluid py-3">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="GET" action="{{ route('revenue') }}" class="card mb-3">
                <div class="card-body">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-5">
                            <input type="text" name="search" class="form-control" placeholder="Buscar ingreso..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-outline-primary w-100">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <table class="table table-hover table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Concepto</th>
                        <th>Fecha</th>
                        <th class="text-end">Importe</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($revenues as $revenue)
                        <tr>
                            <td>{{ $revenue->description }}</td>
                            <td>{{ $revenue->revenue_date->format('d/m/Y') }}</td>
                            <td class="text-end">
                                <span class="fw-semibold text-success">+€{{ number_format($revenue->amount, 2, ',', '.') }}</span>
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $revenue->id }}">Editar</button>
                                <form method="POST" action="{{ route('revenue.destroy', $revenue) }}" class="d-inline" onsubmit="return confirm('¿Eliminar este ingreso?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Borrar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No hay ingresos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-center mt-3">
                {{ $revenues->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('revenue.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Añadir ingreso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Concepto</label>
                        <input type="text" name="description" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Importe</label>
                        <input type="number" step="0.01" min="0" name="amount" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach ($revenues as $revenue)
<div class="modal fade" id="editModal{{ $revenue->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('revenue.update', $revenue) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Editar ingreso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Concepto</label>
                        <input type="text" name="description" class="form-control" value="{{ $revenue->description }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Importe</label>
                        <input type="number" step="0.01" min="0" name="amount" class="form-control" value="{{ $revenue->amount }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="date" class="form-control" value="{{ $revenue->revenue_date->format('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection
