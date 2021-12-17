<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AuthModel;

class Auth extends BaseController
{
    private $AuthModel;
    private $session_data;

    public function __construct()
    {
        $this->session_data = session();
        $this->AuthModel = new AuthModel();
    }

    public function index()
    {
        $userdata = $this->session_data->get('userdata');
        if ($userdata && $userdata->is_login == 1) {
            return redirect()->to(base_url() . '/admin/dashboard');
        }
        echo view('auth/login');
    }

    public function login()
    {
        $res = [
            'status' => false,
            'message' => 'Gagal Login'
        ];

        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $userdata = $this->AuthModel->get_user_data($username);

        if ($userdata) {
            if ($userdata->user_status == 1) {
                if (password_verify($password, $userdata->password)) {
                    $session = session();

                    $setting = $this->AuthModel->get_setting();
                    unset($userdata->password);
                    $userdata->is_login = 1;

                    $sess_data = [
                        'setting' => $setting,
                        'userdata' => $userdata,
                    ];

                    $session->set($sess_data);

                    $res = [
                        'status' => true,
                        'message' => 'Berhasil!',
                        'url' => base_url() . '/admin/dashboard',
                    ];
                } else {
                    $res = [
                        'status' => false,
                        'message' => 'Password Salah!'
                    ];
                }
            } else {
                $res = [
                    'status' => false,
                    'message' => 'User Tidak Aktif!'
                ];
            }
        } else {
            $res = [
                'status' => false,
                'message' => 'User Belum Terdaftar!'
            ];
        }

        echo json_encode($res);
    }

    function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url() . '/auth');
    }
}
