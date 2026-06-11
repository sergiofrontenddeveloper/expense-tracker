@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <h1>Crear Cuenta</h1>

    <form>

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" class="form-control">
        </div>

        <div class="mb-3">
            <label>Contraseña</label>
            <input type="password" class="form-control">
        </div>

        <div class="mb-3">
            <label>Confirmar Contraseña</label>
            <input type="password" class="form-control">
        </div>

        <button class="btn btn-success">
            Crear Cuenta
        </button>

    </form>

</div>
@endsection
