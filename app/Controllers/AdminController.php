<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Admin\AdminModel;

class AdminController extends BaseController
{
    protected $AdminModel;
    protected $session_data;
    protected $userdata;
    protected $setting;
    protected $judul_website;
    protected $judul_ikon;

    public function __construct()
    {
        $this->session_data = session();
        $this->userdata = $this->session_data->get('userdata');
        $this->setting = $this->session_data->get('setting');
        if (!($this->userdata && $this->userdata->is_login == 1)) {
            return redirect()->to(base_url() . '/auth');
        }
        foreach ($this->setting as  $v) {
            if ($v->setting_nama == 'judul_website') {
                $this->judul_website = $v->setting_value;
            } else if ($v->setting_nama == 'judul_ikon') {
                $this->judul_ikon = $v->setting_value;
            }
        }
        $this->AdminModel = new AdminModel();
    }

    public function admin_theme($url, $data = [])
    {
        if (!($this->userdata && $this->userdata->is_login == 1)) {
            return redirect()->to(base_url() . '/auth');
        }

        $mainData = $data;
        $navbar = [
            'user_fullname' => $this->userdata->user_fullname,
        ];
        $sidebar = [];

        $sidebarMenu = $this->AdminModel->get_sidebar($this->userdata->user_id, 1, 0);

        $sidebar['sidebar'] = $sidebarMenu;
        $sidebar['judul'] = $this->judul_website;
        $sidebar['judul_ikon'] = $this->judul_ikon;

        $mainData['title'] = !empty($data['title']) ? $data['title'] . " | Administrator" : "Administrator";
        $mainData['navbar'] = view('template/navbar', $navbar);
        $mainData['sidebar'] = view('template/sidebar', $sidebar);
        $mainData['footer'] = [
            'judul' => $this->judul_website
        ];
        $mainData['content'] = view($url, $data);

        echo view('template/admin_template', $mainData);
    }
}
