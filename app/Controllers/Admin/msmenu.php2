<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminController;
use App\Models\Admin\MsMenuModel;

class Msmenu extends AdminController
{

    protected $MsMenuModel;
    public function __construct()
    {
        parent::__construct();
        $this->MsMenuModel = new MsMenuModel();
    }

    public function index()
    {
        $data['title'] = "Master Menu";
        $data['modul'] = $this->MsMenuModel->get_modul();
        return $this->admin_theme('admin/v_ms_menu', $data);
    }

    public function get_data()
    {
        $columns = array(
            "mm.menu_id",
            "mm.menu_kode",
            "mm.menu_nama",
            "mm.menu_ikon",
            "mm.menu_url",
            "parent.menu_nama as menu_parent_nama",
            "mm.menu_status",
            "mm.menu_parent_id",
            "mm.modul_id",
            "coalesce(child.total,0) as total",
        );

        $search = $this->request->getVar('search')['value'];
        $fil_modul = $this->request->getVar('fil_modul');

        $where = "";

        if (!empty($fil_modul)) {
            $where .= " AND mm.modul_id = $fil_modul ";
        }

        if (isset($search) && $search != "") {
            $where .= " AND (";
            for ($i = 0; $i < count($columns); $i++) {
                if ($i == 1 || $i == 2 || $i == 3 || $i == 4  || $i == 8) {
                    $where .= " LOWER(" . $columns[$i] . ") LIKE LOWER('%" . ($search) . "%') OR ";
                } elseif ($i == 5) {
                    $where .= " LOWER(parent.menu_nama) LIKE LOWER('%" . ($search) . "%') OR ";
                }
            }
            $where = substr_replace($where, "", -3);
            $where .= ')';
        }

        $iTotalRecords = intval($this->MsMenuModel->get_total($where));
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
                    if (intval($this->request->getVar('order')[$i]['column']) != 5) {
                        $order .= "" . $columns[intval($this->request->getVar('order')[$i]['column'])] . " " .
                            ($this->request->getVar('order')[$i]['dir'] === 'asc' ? 'asc' : 'desc') . ", ";
                    } else {
                        $order .= " parent.menu_nama " .
                            ($this->request->getVar('order')[$i]['dir'] === 'asc' ? 'asc' : 'desc') . ", ";
                    }
                }
            }

            $order = substr_replace($order, "", -2);
            if ($order == "ORDER BY") {
                $order = "";
            }
        }
        $data = $this->MsMenuModel->get_data($limit, $where, $order, $columns);
        $no   = 1 + $start;
        foreach ($data as $row) {
            $isi = rawurlencode(json_encode($row));
            if ($row->menu_status == 1) {
                $status = '<span class="badge badge-success">Aktif</span>';
            } else {
                $status = '<span class="badge badge-danger">Non Aktif</span>';
            }

            $aksi_hapus = "";

            if ($row->total < 1) {
                $aksi_hapus = ' <button onclick="set_del(\'' . $row->menu_id . '\')" class="btn btn-sm btn-danger " title="Delete">
                                    <i class="fa fa-trash"></i>
                                </button>';
            }

            $action = '';

            if ($row->menu_id <= 4 && $this->userdata->user_id == 1) {
                $action .= '<button onclick="set_val(\'' . $isi . '\')" class="btn btn-sm btn-primary" title="Edit">
                                <i class="fa fa-pencil-alt"></i>
                            </button>';
            } else if ($row->menu_id <= 4 && $this->userdata->user_id != 1) {
                $action .= '';
            } else {
                $action .= '<button onclick="set_val(\'' . $isi . '\')" class="btn btn-sm btn-primary" title="Edit">
                                <i class="fa fa-pencil-alt"></i>
                            </button>' . $aksi_hapus;
            }

            $records["data"][] = array(
                $no++,
                $row->menu_kode,
                $row->menu_nama,
                $row->menu_ikon,
                $row->menu_url,
                !empty($row->menu_parent_nama) ? $row->menu_parent_nama : 'ROOT',
                $status,
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
            'menu_kode' => addslashes($this->request->getVar('menu_kode')),
            'menu_nama' => addslashes($this->request->getVar('menu_nama')),
            'menu_url' => addslashes($this->request->getVar('menu_url')),
            'menu_ikon' => addslashes($this->request->getVar('menu_ikon')),
            'menu_parent_id' => !empty($this->request->getVar('menu_parent_id')) ? $this->request->getVar('menu_parent_id') : 0,
            'menu_status' => $this->request->getVar('menu_status'),
            'modul_id' => $this->request->getVar('modul_id'),
        ];

        if ($act == 'add') {
            $res = $this->MsMenuModel->insert($data);
        } else {
            $id = $this->request->getVar('menu_id');
            $res = $this->MsMenuModel->update($id, $data);
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
        $res = $this->MsMenuModel->delete($id);

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

    public function get_parent()
    {
        $modul_id = $this->request->getVar('modul_id');
        $res = $this->MsMenuModel
            ->where('menu_status', 1)
            ->where('modul_id', $modul_id)
            ->orderBy('menu_kode', 'asc')
            ->findAll();

        echo json_encode($res);
    }
}
