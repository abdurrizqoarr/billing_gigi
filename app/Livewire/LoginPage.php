<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginPage extends Component
{
    public $username;
    public $password;

    protected $rules = [
        'username' => 'required|string',
        'password' => 'required|string|min:6',
    ];

    public function login()
    {
        $this->validate();

        if (Auth::guard('pegawai')->attempt(['username' => $this->username, 'password' => $this->password])) {
            session()->regenerate();
            return redirect()->intended('/dashboard'); // arahkan ke dashboard
        }

        $this->addError('username', 'Username atau password salah.');
    }

    public function render()
    {
        return view('livewire.login-page');
    }
}
