
@extends('layouts.app')

@section('content')

@extends('layouts.auth')



<div class="container vh-100">

    <div class="row h-100 justify-content-center align-items-center">

        <div class="col-12 col-md-6 col-lg-4">

            <div class="card">

                <div class="card-body">

                    <h2 class="text-center mb-4">
                        Expense Tracker
                    </h2>

                    <form>

                        <div class="mb-3">
                            <label class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                class="form-control">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">
                                Password
                            </label>

                            <input
                                type="password"
                                class="form-control">
                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100">
                            Login
                        </button>

                    </form>

                    <div class="text-center mt-3">

                        <a href="{{ route('register') }}">
                            Create account
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
