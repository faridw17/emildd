<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminController;
use App\Models\Admin\DashboardModel;

class Dashboard extends AdminController
{
    private $DashboardModel;

    public function __construct()
    {
        parent::__construct();
        $this->DashboardModel = new DashboardModel();
    }

    public function index()
    {
        $data['title'] = "Dashboard";
        return $this->admin_theme('admin/v_dashboard', $data);
    }

    public function get_mesin()
    {
        $res = $this->DashboardModel->get_dashboard_mesin();
        echo json_encode($res);
    }

    public function get_grafik()
    {
        $limit = $this->request->getVar('limit');

        $limit = !empty($limit) ? $limit : 10;

        $res = [];

        $sampelBanyakData = [];

        for ($i = 0; $i < $limit; $i++) {
            $sampelBanyakData[$i] = null;
        }

        $res['xaxis'] = $this->DashboardModel->get_label_x($limit);

        $listDevice = $this->DashboardModel->get_dashboard_mesin();

        $res['series'] = [];

        foreach ($listDevice as $key => $value) {
            $res['series'][$key] = [
                'name' => $value->device_nama,
                'data' => $sampelBanyakData,
            ];
        }

        echo json_encode($res);
    }
}
