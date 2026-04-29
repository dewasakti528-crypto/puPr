<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\AuthLibrary;
use Config\Services;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $auth = new AuthLibrary();
        
        if (!$auth->check()) {
            $_SESSION['redirect_url'] = current_url();
            return redirect()->to('/login')->with('error', 'Silakan login untuk mengakses halaman ini.');
        }

        $user = $auth->user();
        if (!$user || !isset($user['role'])) {
            session()->destroy();
            return redirect()->to('/login')->with('error', 'Sesi tidak valid. Silakan login ulang.');
        }

        $userRole = $user['role'];
        $allowedRoles = $arguments ?? [];

        if (empty($allowedRoles)) {
            return;
        }

        if ($userRole === 'superadmin') {
            return;
        }

        if (!in_array($userRole, $allowedRoles)) {
            log_message('warning', "User ID {$user['id']} (role: {$userRole}) mencoba mengakses {$request->uri} tanpa izin.");

            if ($request->isAJAX()) {
                return Services::response()
                    ->setStatusCode(403)
                    ->setJSON(['success' => false, 'message' => 'Akses ditolak.']);
            }

            return redirect()->to('/dashboard')
                ->with('error', 'Anda tidak memiliki izin untuk mengakses halaman tersebut.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu aksi setelah
    }
}