<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\APIModel;

class APIController extends BaseController
{
    private $APIModel;

    public function __construct()
    {
        $this->APIModel = new APIModel();
    }

    public function index()
    {
        echo 'ok';
    }

    public function insert_mesin()
    {
        if ($this->request->getVar('token') != '12345678') {
            echo json_encode(['status' => false, 'msg' => 'Insert tidak diijinkan']);
            return;
        }

        // echo '<pre>';
        // print_r($this->request->getVar());
        // die;

        $input_mesin = $this->request->getVar('data_mesin');
        $status_mesin = $this->request->getVar('status_mesin');

        $data_mesin = [];
        $data_status = [];

        foreach ($input_mesin as $v) {
            $data_mesin[] = [
                "device_id" => $v->device_id,
                "jam" => $v->jam,
                "tanggal" => $v->tgl,
            ];
        }

        foreach ($status_mesin as $v) {
            $data_status[] = [
                "device_id" => $v->device_id,
                "device_kondisi" => $v->status,
            ];
        }

        if (count($data_mesin) > 0) {
            $this->APIModel->insert_mesin_data($data_mesin);
        }

        if (count($data_status) > 0) {
            $this->APIModel->update_status_mesin($data_status);
        }
    }

    public function insert_test()
    {
        $this->APIModel->insert_test(['data' => json_encode($this->request->getVar())]);
    }
}
