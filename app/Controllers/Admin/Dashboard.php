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
        $sampelBanyakTanggal = [];

        for ($i = 0; $i < $limit; $i++) {
            $sampelBanyakData[$i] = null;
        }

        $tanggal = '';
        $label_x = [];

        for ($i = 0; $i < $limit; $i++) {
            $tanggal = date('d-m-Y', strtotime(date('Y-m-d')) - ($limit - $i - 1) * 60 * 60 * 24);
            $sampelBanyakTanggal[$tanggal] = $i;
            $label_x[] = $tanggal;
        }

        $res['xaxis'] = $label_x;

        $listDevice = $this->DashboardModel->get_dashboard_mesin();

        $res['series'] = [];

        foreach ($listDevice as $key => $value) {
            $res['series'][$key] = [
                'name' => $value->device_nama,
                'data' => $sampelBanyakData,
            ];

            $get_data = $this->DashboardModel->get_line_data($value->device_id, $limit);

            foreach ($get_data as $k => $v) {
                $res['series'][$key]['data'][$sampelBanyakTanggal[$v->tanggal]] = floatval($v->jam);
            }
        }

        echo json_encode($res);
    }
}
