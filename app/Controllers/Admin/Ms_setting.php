<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminController;
use App\Models\Admin\MsSettingModel;

class Ms_setting extends AdminController
{
    protected $MsSettingModel;
    public function __construct()
    {
        parent::__construct();
        $this->MsSettingModel = new MsSettingModel();
    }

    public function index()
    {
        $data['title'] = "Master Setting";
        return $this->admin_theme('admin/v_ms_setting', $data);
    }

    public function get_data()
    {
        $columns = array(
            'setting_id',
            'setting_nama',
            'setting_value',
            'setting_ket',
            'setting_status',
        );
        $search = $this->request->getVar('search')['value'];
        $where = "";
        if (isset($search) && $search != "") {
            $where = "AND (";
            for ($i = 0; $i < count($columns); $i++) {
                $where .= " LOWER(" . $columns[$i] . ") LIKE LOWER('%" . ($search) . "%') OR ";
            }
            $where = substr_replace($where, "", -3);
            $where .= ')';
        }
        $iTotalRecords = intval($this->MsSettingModel->get_total($where));
        $length = intval($this->request->getVar('length'));
        $length = $length < 0 ? $iTotalRecords : $length;
        $start  = intval($this->request->getVar('start'));
        $draw      = intval($_REQUEST['draw']);
        $sortCol0 = $this->request->getVar('order')[0];
        $records = array();
        $records["data"] = array();
        $order = "";
        if (isset($start) && $length != '-1') {
            $limit = "limit " . intval($start) . ", " . intval($length);
        }

        if (isset($sortCol0)) {
            $order = "ORDER BY  ";
            for ($i = 0; $i < count($this->request->getVar('order')); $i++) {
                if ($this->request->getVar('columns')[intval($this->request->getVar('order')[$i]['column'])]['orderable'] == "true") {
                    $order .= "" . $columns[intval($this->request->getVar('order')[$i]['column'])] . " " .
                        ($this->request->getVar('order')[$i]['dir'] === 'asc' ? 'asc' : 'desc') . ", ";
                }
            }

            $order = substr_replace($order, "", -2);
            if ($order == "ORDER BY") {
                $order = "";
            }
        }
        $data = $this->MsSettingModel->get_data($limit, $where, $order, $columns);
        $no   = 1 + $start;
        foreach ($data as $row) {
            $isi = rawurlencode(json_encode($row));
            // if ($row->setting_status == 1) {
            //     $status = '<span class="badge badge-success">Aktif</span>';
            // } else {
            //     $status = '<span class="badge badge-danger">Non Aktif</span>';
            // }

            $action = '<button onclick="set_val(\'' . $isi . '\')" class="btn btn-sm btn-primary" title="Edit">
                            <i class="fa fa-pencil-alt"></i>
                        </button>';

            $records["data"][] = array(
                $no++,
                $row->setting_nama,
                $row->setting_value,
                rawurldecode($row->setting_ket),
                $action,
            );
        }

        $records["draw"] = $draw;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;

        echo json_encode($records);
    }

    public function save()
    {
        $act = $this->request->getVar('act');

        $data = [
            'setting_nama' => addslashes($this->request->getVar('setting_nama')),
            'setting_value' => addslashes($this->request->getVar('setting_value')),
            'setting_ket' => rawurlencode($this->request->getVar('setting_ket')),
            'setting_status' => $this->request->getVar('setting_status'),
        ];

        if ($act == 'add') {
            $res = $this->MsSettingModel->insert($data);
        } else {
            $id = $this->request->getVar('setting_id');
            $res = $this->MsSettingModel->update($id, $data);
        }

        if ($res > 0) {
            $response = [
                'status' => true,
                'message' => $act == 'add' ? 'Berhasil menambahkan data!' : 'Berhasil memperbarui data!',
                'title' => 'Success',
            ];
        } else {
            $response = [
                'status' => false,
                'message' => $act == 'add' ? 'Gagal menambahkan data!' : 'Gagal memperbarui data!',
                'title' => 'Error',
            ];
        }

        echo json_encode($response);
    }

    public function hapus()
    {
        $id = $this->request->getVar('id');
        $res = $this->MsSettingModel->delete($id);

        $response = [
            'status' => false,
            'message' => "Data Gagal dihapus"
        ];

        if ($res) {
            $response = [
                'status' => true,
                'message' => "Data Berhasil dihapus"
            ];
        }

        echo json_encode($response);
    }
}
