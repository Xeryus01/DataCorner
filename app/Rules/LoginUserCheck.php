<?php

namespace App\Rules;

use Closure;
use App\Models\akunuser;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Validation\ValidationRule;

class LoginUserCheck implements ValidationRule
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $no_hp = $this->request->input('no_hp');
        $nama = $this->request->input('nama');
        $loginStatus = false;

        // Cari berdasarkan no_hp dan nama
        $user = akunuser::where('no_hp', $no_hp)
            ->where('nama', $nama)
            ->first();

        if ($user) {
            $loginStatus = true;
            Session::put('loginStatus', true);
            Session::put('ambilUser', $user);
        }

        if (! $loginStatus) {
            $fail('nomor hp atau Username salah.');
        }
    }
}
