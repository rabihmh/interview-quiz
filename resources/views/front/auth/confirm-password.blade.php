<x-front-layout title="Confirm Password">
    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form class="card login-form" method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="card-body">
                            <div class="title">
                                <h3>Confirm Your Password</h3>
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

                            <div class="button">
                                <button class="btn" type="submit"> Confirm Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-front-layout>
