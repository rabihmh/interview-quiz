@extends('layouts.dashboard-auth-layout')
@section('title')
    {{config('app.name')}} - Confirm Password
@endsection
@section('content')
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2">Confirm Your Password?</h1>

                                </div>
                                <form class="user" method="POST" action="{{ route('password.confirm') }}">
                                    @csrf
                                    <div class="form-group">
                                        <x-input-a name="password" type="password" placeholder="Enter Your Password"/>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Reset Password
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
