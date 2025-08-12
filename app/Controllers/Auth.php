<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LoginAttempts;
use App\Models\Users;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class Auth extends BaseController
{
    /** @var Users */
    protected $users;

    /** @var LoginAttempts */
    protected $attempts;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->users    = new Users();
        $this->attempts = new LoginAttempts();
    }

    /**
     * GET /login
     */
    public function index()
    {
        return view('auth/login');
    }

    /**
     * POST /login
     */
    public function login()
    {
        $validationRules = [
            'username' => 'required',
            'password' => 'required',
        ];

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = trim($this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        $user = method_exists($this->users, 'findByUsername')
            ? $this->users->findByUsername($username)
            : $this->users->where('username', $username)->first();


        // Cek aktif
        if ((int) ($user['is_active'] ?? 0) !== 1) {
            return redirect()->back()->withInput()->with('error', 'Akun dinonaktifkan. Hubungi admin.');
        }

        // Verifikasi password (diasumsikan sudah di-hash dengan password_hash)
        if (! password_verify($password, $user['password'])) {
            // Catat attempt gagal untuk user yang ditemukan
            try {
                $this->attempts->logAttempt((int) $user['id_users']);
            } catch (\Throwable $e) {
            }
            return redirect()->back()->withInput()->with('error', 'Kredensial tidak valid.');
        }

        // Login sukses -> catat attempt
        try {
            $this->attempts->logAttempt((int) $user['id_users']);
        } catch (\Throwable $e) {
        }

        // Set session
        session()->set([
            'isLoggedIn' => true,
            'auth' => [
                'id_users' => (int) $user['id_users'],
                'name'     => $user['name'] ?? null,
                'username' => $user['username'],
                'level_id' => $user['level_id'] ?? null,
                'image'    => $user['image'] ?? null,
            ],
        ]);

        // Optional: regenerate session ID untuk mencegah fixation
        session()->regenerate(true);

        // Redirect sesuai level
        $level  = (int) ($user['level_id'] ?? 0);
        $target = $level === 1 ? 'dashboard/petugas'
            : ($level === 2 ? 'peserta/dashboard' : '/');

        return redirect()->to(site_url($target)); // arahkan sesuai level atau ke beranda jika tidak dikenali
    }

    /**
     * GET /logout
     */
    public function logout()
    {
        session()->remove(['isLoggedIn', 'auth']);
        session()->destroy();
        return redirect()->to('/')->with('message', 'Anda telah logout.');
    }
}
