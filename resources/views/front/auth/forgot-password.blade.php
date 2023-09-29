<x-front-layout title="Login">
    <x-slot:breadcrumbs>
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Login</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{route('home')}}"><i class="lni lni-home"></i> Home</a></li>
                            <li><a href="">Forgot Password</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </x-slot:breadcrumbs>
    <!-- Start Account Login Area -->
    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form class="card login-form" method="POST" action="{{route('password.email')}}">
                        @csrf

                        <div class="card-body">

                            <div class="form-group input-group">
                                <label for="reg-fn">Email</label>
                                <input
                                    class="form-control"
                                    type="email"
                                    id="reg-email"
                                    required
                                    name="email"/>
                                @error('email')
                                <span class="text-danger mt-2 ml-2">{{ $message }}</span>
                                @enderror

                            </div>
                            @if (session('status'))
                                <div class="mb-4 font-medium text-sm text-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="button">
                                <button class="btn" type="submit"> Reset Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Start Account Login Area -->
</x-front-layout>
