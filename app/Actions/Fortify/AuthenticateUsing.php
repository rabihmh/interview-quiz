<?php

namespace App\Actions\Fortify;

use App\Models\Admin;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class AuthenticateUsing
{
    public function authenticate($request): bool|Admin
    {
        $username = $request->post(Config::get('fortify.username'));
        $password = $request->post('password');
        $user = Admin::where('email', $username)->orWhere('username', $username)
            ->orWhere('phone', $username)->first();
        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }
        return false;
    }
}
