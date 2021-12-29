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
        // if ($this->request->getVar('token') != '12345678') {
        //     return $this->response->setStatusCode(403);
        // }

        $id = $this->request->getVar('id');
        $jam = $this->request->getVar('jam');
        $kondisi = $this->request->getVar('kondisi');

        $data_mesin = [];
        $data_status = [];
        $tgl = date("Y-m-d");

        foreach ($id as $k => $v) {
            $data_mesin[] = [
                "device_id" => $v,
                "jam" => $jam[$k],
                "tanggal" => $tgl,
            ];

            $data_status[] = [
                "device_id" => $v,
                "device_kondisi" => $kondisi[$k],
            ];
        }

        if (count($data_mesin) > 0) {
            $this->APIModel->insert_mesin_data($data_mesin);
        }

        if (count($data_status) > 0) {
            $this->APIModel->update_status_mesin($data_status);
        }

        return $this->response->setStatusCode(201, 'Created');
    }

    public function insert_test()
    {
        $this->APIModel->insert_test(['data' => json_encode($this->request->getVar())]);
    }
}
