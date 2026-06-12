@extends('layouts.app')

@section('title', 'Files')
@php
    $buttonEntity = 'fichero';
@endphp
@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Files</h4>
        <button class="btn btn-secondary">Upload</button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <p class="text-muted">No hay archivos todavía</p>
        </div>
    </div>

</div>

@endsection
