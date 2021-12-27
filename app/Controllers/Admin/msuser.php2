<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminController;
use App\Models\Admin\MsUserModel;

class Msuser extends AdminController
{
    protected $MsUserModel;
    public function __construct()
    {
        parent::__construct();
        $this->MsUserModel = new MsUserModel();
    }

    public function index()
    {
        $data['title'] = "Master User";
        return $this->admin_theme('admin/v_ms_user', $data);
    }

    public function get_data()
    {
        $columns = array(
            'mu.user_id',
            'user_fullname',
            'user_name',
            'user_status',
            'user_email',
            "coalesce(gu.total,0) as total_akses",
        );

        $colSearch = [
            'user_fullname',
            'user_name',
            'user_status',
            'user_email',
        ];

        $search = $this->request->getVar('search')['value'];
        $where = "";
        if (isset($search) && $search != "") {
            $where = "AND (";
            for ($i = 0; $i < count($colSearch); $i++) {
                $where .= " LOWER(" . $colSearch[$i] . ") LIKE LOWER('%" . ($search) . "%') OR ";
            }
            $where = substr_replace($where, "", -3);
            $where .= ')';
        }
        $iTotalRecords = intval($this->MsUserModel->get_total($where));
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
        $data = $this->MsUserModel->get_data($limit, $where, $order, $columns);
        $no   = 1 + $start;
        foreach ($data as $row) {
            $action = "";
            $isi = rawurlencode(json_encode($row));
            if ($row->user_status == 1) {
                $status = '<span class="badge badge-success">Aktif</span>';
            } else {
                $status = '<span class="badge badge-danger">Non Aktif</span>';
            }

            $akses = $row->total_akses > 0 ? 'btn-warning' : 'btn-secondary';

            $hapus = '&nbsp;<button onclick="set_del(\'' . $row->user_id . '\')" class="btn btn-sm btn-danger " title="Delete">
                        <i class="fa fa-trash"></i>
                    </button>';

            if ($row->user_id == 1 && $this->userdata->user_id == 1) {
                $action .= '<button onclick="akses(\'' . $row->user_id . '\',\'' . $row->user_fullname . '\')" class="btn btn-sm ' . $akses . ' font-weight-bold" title="Hak Akses">
                                <i class="fa fa-cogs"></i>
                            </button>&nbsp;<button onclick="set_val(\'' . $isi . '\')" class="btn btn-sm btn-primary" title="Edit">
                                <i class="fa fa-pencil-alt"></i>
                            </button>';
            } else if ($row->user_id == 1 && $this->userdata->user_id != 1) {
                $action .= '';
            } else {
                $action .= '<button onclick="akses(\'' . $row->user_id . '\',\'' . $row->user_fullname . '\')" class="btn btn-sm ' . $akses . ' font-weight-bold" title="Hak Akses">
                                <i class="fa fa-cogs"></i>
                            </button>&nbsp;<button onclick="set_val(\'' . $isi . '\')" class="btn btn-sm btn-primary" title="Edit">
                                <i class="fa fa-pencil-alt"></i>
                            </button>';
                if ($row->user_id != $this->userdata->user_id) {
                    $action .= $hapus;
                }
            }

            $records["data"][] = array(
                $no++,
                $row->user_fullname,
                $row->user_name,
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
        $password = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);

        $data = [
            'user_name' => addslashes($this->request->getVar('user_name')),
            'user_fullname' => addslashes($this->request->getVar('user_fullname')),
            'user_email' => addslashes($this->request->getVar('user_email')),
            'user_status' => $this->request->getVar('user_status'),
        ];

        if ($act == 'add') {
            $data['password'] = $password;
            $res = $this->MsUserModel->insert($data);
        } else {
            if ($this->request->getVar('is_ganti') == 1) $data['password'] = $password;

            $id = $this->request->getVar('user_id');
            $res = $this->MsUserModel->update($id, $data);
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
        $res = $this->MsUserModel->delete($id);

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

    public function get_akses()
    {
        $id = $this->request->getVar('id');
        $res = $this->MsUserModel->get_akses($id);
        echo json_encode($res);
    }

    public function save_akses()
    {
        $user_id = $this->request->getVar('user_id');
        $group_id = !empty($this->request->getVar('group_id')) ? $this->request->getVar('group_id') : [];
        $data = [];

        if (count($group_id) > 0) {
            foreach ($group_id as $v) {
                $data[] = [
                    'user_id' => $user_id,
                    'group_id' => $v
                ];
            }
        }

        $res = $this->MsUserModel->delete_akses($user_id);
        if ($res['status'] && count($data) > 0) {
            $res = $this->MsUserModel->save_akses($data);
        }

        echo json_encode($res);
    }
}
