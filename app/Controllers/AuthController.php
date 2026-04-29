<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\AuthLibrary;

class AuthController extends BaseController
{
    protected $auth;

    public function __construct()
    {
        $this->auth = new AuthLibrary();
    }

    public function login()
    {
        if ($this->auth->check()) {
            return redirect()->to('/admin');
        }
        return view('auth/index');
    }

    public function attemptLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');



        if ($this->auth->login($username, $password)) {
            return redirect()->to('/admin')->with('success', 'Login berhasil.');
        }

        return redirect()->back()->with('error', 'Username atau password salah.');
    }

    public function logout()
    {
        $this->auth->logout();
        return redirect()->to('/login')->with('success', 'Anda telah logout.');
    }
}