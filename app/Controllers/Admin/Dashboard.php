<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminController;

class Dashboard extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['title'] = "Dashboard";
        return $this->admin_theme('admin/v_dashboard', $data);
    }
}
