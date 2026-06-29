@extends('layouts.app')

@section('title', 'Files')

@section('content')

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<div class="container-fluid">
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                    <i class="bi bi-cloud-arrow-up display-1 mb-3"></i>
                    <p class="mb-4">Arrastra y suelta tu archivo aquí</p>
                    <form method="POST" action="{{ route('files.store') }}" enctype="multipart/form-data" id="uploadForm">
                        @csrf
                        <input type="file" name="file" id="fileInput" class="d-none" accept=".pdf,.csv,.xlsx">
                        <button type="button" class="btn btn-primary" onclick="document.getElementById('fileInput').click()">
                            Seleccionar Archivo
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Archivo</th>
                                <th>Fecha</th>
                                <th>Tamaño</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($files as $file)
                                <tr>
                                    <td>{{ $file->original_name }}</td>
                                    <td>{{ $file->created_at->format('d/m/Y') }}</td>
                                    <td>{{ number_format($file->size / 1024 / 1024, 1) }} MB</td>
                                    <td class="text-center">
                                        <a href="{{ route('files.download', $file) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-download"></i>
                                        </a>
                                        <form method="POST" action="{{ route('files.destroy', $file) }}" class="d-inline" onsubmit="return confirm('¿Eliminar este archivo?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No hay archivos subidos.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <small class="text-muted">Formatos permitidos: PDF, CSV, XLSX (Máx. 10 MB)</small>
        </div>
    </div>
</div>
<div class="card p-4">
    <h3>Descargar Gastos del Mes</h3>
    <p>Exporta tus datos en formato CSV compatible con Excel.</p>

    <!-- Ejemplo para descargar el mes actual (Junio 2026) -->
    <a href="{{ route('expenses.export', ['year' => 2026, 'month' => 6]) }}" class="btn btn-success">
        📊 Descargar Gastos de Junio 2026
    </a>
</div>
<script>
document.getElementById('fileInput')?.addEventListener('change', function () {
    if (this.files.length) {
        document.getElementById('uploadForm').submit();
    }
});
</script>

@endsection
