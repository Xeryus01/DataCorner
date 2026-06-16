<?php

// App\Rules\LoginAdminCheck.php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\konsultan;

class LoginKonsultanCheck implements Rule
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function passes($attribute, $value)
    {
        $email = $this->request->input('email');
        $password = $this->request->input('password');

        $konsultan = konsultan::where('email', $email)->first();

        if ($konsultan && Hash::check($password, $konsultan->password)) {
            Session::put('loginStatus', true);
            Session::put('konsultanLogin', $konsultan); // ⬅ simpan data admin ke session
            return true;
        }

        return false;
    }

    public function message()
    {
        return 'Email atau password salah.';
    }
}
