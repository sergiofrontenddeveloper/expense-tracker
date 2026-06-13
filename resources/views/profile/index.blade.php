@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<div class="container-fluid">

    <div class="row g-4">

        <!-- Información del usuario -->
        <div class="col-lg-6">

            <div class="card h-100">

                <div class="card-header">
                    Información del Usuario
                </div>

                <div class="card-body text-center">

                    <div class="mb-4">
                        <i class="bi bi-person-circle display-1 text-secondary"></i>
                    </div>

                    <div class="text-start">

                        <p>
                            <strong>Nombre:</strong>
                            Usuario Demo
                        </p>

                        <p>
                            <strong>Email:</strong>
                            usuario@email.com
                        </p>

                        <p class="mb-0">
                            <strong>Miembro desde:</strong>
                            01/01/2024
                        </p>

                    </div>

                </div>

            </div>

        </div>

        <!-- Editar perfil -->
        <div class="col-lg-6">

            <div class="card h-100">

                <div class="card-header">
                    Editar Perfil
                </div>

                <div class="card-body">

                    <form>

                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Nombre
                            </label>

                            <input
                                type="text"
                                id="name"
                                class="form-control"
                                value="Usuario Demo">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                id="email"
                                class="form-control"
                                value="usuario@email.com">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                Contraseña
                            </label>

                            <input
                                type="password"
                                id="password"
                                class="form-control">
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">
                                Confirmar contraseña
                            </label>

                            <input
                                type="password"
                                id="password_confirmation"
                                class="form-control">
                        </div>

                        <div class="text-end">
                            <button
                                type="submit"
                                class="btn btn-primary">
                                Guardar Cambios
                            </button>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
