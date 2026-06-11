
@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <h1>Expense Tracker</h1>

    <form>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" class="form-control">
        </div>

        <div class="mb-3">
            <label>Contraseña</label>
            <input type="contraseña" class="form-control">
        </div>

        <button class="btn btn-primary">
            Login
        </button>

    </form>

</div>



@endsection

