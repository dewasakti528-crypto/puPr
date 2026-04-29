<?php

namespace App\Libraries;

use App\Models\UserModel;
use CodeIgniter\Session\Session;

class AuthLibrary
{
    protected Session $session;
    protected UserModel $userModel;

    public function __construct()
    {
        $this->session = service('session');
        $this->userModel = model(UserModel::class);
    }

    public function check(): bool
    {
        return $this->session->has('user_id');
    }

    public function user(): ?array
    {
        if (!$this->check()) {
            return null;
        }

        $userId = $this->session->get('user_id');
        return $this->userModel->find($userId);
    }

    public function login(string $identity, string $password, bool $remember = false): bool
    {
        $user = $this->userModel->findByEmailOrUsername($identity);
        if (!$user) {
            return false;
        }

        if (!$this->userModel->verifyPassword($password, $user['password_hash'])) {
            return false;
        }

        $this->session->regenerate();
        $this->session->set([
            'user_id' => $user['id'],
            'logged_in' => true,
            'login_time' => time()
        ]);

        return true;
    }

    public function logout(): void
    {
        $this->session->destroy();
    }

    public function hasRole($roles): bool
    {
        $user = $this->user();
        if (!$user) {
            return false;
        }

        $roles = is_array($roles) ? $roles : [$roles];
        return in_array($user['role'], $roles, true);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(['superadmin', 'admin']);
    }

    public function isValidSession(int $maxLifetime = 7200): bool
    {
        if (!$this->check()) {
            return false;
        }

        $loginTime = $this->session->get('login_time');
        if (!$loginTime) {
            return false;
        }

        return (time() - $loginTime) < $maxLifetime;
    }

    public function enforceSessionTimeout(int $maxLifetime = 7200): bool
    {
        if (!$this->isValidSession($maxLifetime)) {
            $this->logout();
            return false;
        }
        return true;
    }
}