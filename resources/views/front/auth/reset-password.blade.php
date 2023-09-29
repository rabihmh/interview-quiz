<x-front-layout title="Reset Password">
    <!-- Start Account Login Area -->
    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form class="card login-form" method="POST" action="{{route('password.update')}}">
                        @csrf
                        <div class="card-body">
                            <div class="title">
                                <h3>Reset Password</h3>
                            </div>
                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            <div class="form-group input-group">
                                <label for="reg-fn">Email</label>
                                <input
                                    class="form-control"
                                    type="email"
                                    id="reg-email"
                                    required
                                    value="{{$request->email}}"
                                    name="email"/>
                                @error('email')
                                <span class="text-danger mt-2 ml-2">{{ $message }}</span>
                                @enderror

                            </div>
                            <div class="form-group input-group">
                                <label for="reg-fn">Password</label>
                                <input
                                    class="form-control"
                                    type="password"
                                    id="reg-email"
                                    required
                                    name="password"/>
                                @error('password')
                                <span class="text-danger mt-2 ml-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group input-group">
                                <label for="reg-fn">Email</label>
                                <input
                                    class="form-control"
                                    type="password"
                                    id="reg-email"
                                    required
                                    name="password_confirmation"/>
                                @error('password_confirmation')
                                <span class="text-danger mt-2 ml-2">{{ $message }}</span>
                                @enderror

                            </div>

                            <div class="button">
                                <button class="btn" type="submit"> Reset Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-front-layout>
