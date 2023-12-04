<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\DataTables;
use Hermawan\DataTables\DataTable;

class ProdiFakultasManagement extends BaseController
{
    public function __construct()
    {
        $this->db = db_connect();
        $this->prodi_model = new \App\Models\ProdiModel();
        $this->fakultas_model = new \App\Models\FakultasModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Prodi & Fakultas Management',
            'fakultases' => $this->fakultas_model->findAll(),
        ];

        return view('prodi_fakultas_management/index', $data);
    }

    public function get_all_prodi()
    {
        $builder = $this->db->table('master_prodi')
            ->select('master_prodi.id,master_prodi.name as nama_prodi,master_fakultas.name as nama_fakultas')
            ->join('master_fakultas', 'master_fakultas.id = master_prodi.fakultas_id');

        return DataTable::of($builder)
            ->addNumbering('number')
            ->add('action', function ($row) {
                return '<button type="button" class="btn btn-primary btn-sm" id="edit-prodi" data-id="' . $row->id . '" ><i class="fas fa-edit"></i></button><button type="button" class="btn btn-danger btn-sm ml-2" id="delete-prodi" data-id="' . $row->id . '" ><i class="fas fa-trash-alt"></i></button>';
            })
            ->toJson(true);
    }

    public function get_prodi()
    {
        $id = $this->request->getPost('id');
        $data = $this->prodi_model->find($id);
        return json_encode($data);
    }

    public function add_prodi()
    {
        // set validation 
        $validation = [
            'nama_prodi' => [
                'rules' => 'required|is_unique[master_prodi.name]',
                'errors' => [
                    'required' => 'Nama prodi harus diisi',
                    'is_unique' => 'Nama prodi sudah ada'
                ]
            ],
            'fakultas_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Fakultas harus diisi'
                ]
            ]
        ];

        // check validation
        if (!$this->validate($validation)) {
            return redirect()->to(base_url('prodi-fakultas-management'))->withInput();
        }

        // insert data
        $data = [
            'name' => $this->request->getPost('nama_prodi'),
            'fakultas_id' => $this->request->getPost('fakultas_id'),
        ];
        $this->prodi_model->insert($data);

        // set flashdata
        session()->setFlashdata('message-success', 'Data prodi berhasil ditambahkan');

        return redirect()->to(base_url('prodi-fakultas-management'));
    }

    public function edit_prodi()
    {
        // set validation
        $validation = [
            'nama_prodi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama prodi harus diisi',
                ]
            ],
            'fakultas_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Fakultas harus diisi'
                ]
            ]
        ];

        // check validation
        if (!$this->validate($validation)) {
            return redirect()->to(base_url('prodi-fakultas-management'))->withInput();
        }

        // update data
        $id = $this->request->getPost('id_prodi');

        $data = [
            'name' => $this->request->getPost('nama_prodi'),
            'fakultas_id' => $this->request->getPost('fakultas_id'),
        ];

        $this->prodi_model->update($id, $data);

        // set flashdata
        session()->setFlashdata('message-success', 'Data prodi berhasil diubah');

        return redirect()->to(base_url('prodi-fakultas-management'));
    }

    public function delete_prodi()
    {
        $id = $this->request->getPost('id');
        $this->prodi_model->delete($id);

        return json_encode(['status' => true]);
    }

    public function get_all_fakultas()
    {
        $builder = $this->db->table('master_fakultas')
            ->select('id,name,name_en,dekan,dekan_nidn');

        return DataTable::of($builder)
            ->addNumbering('number')
            ->add('action', function ($row) {
                return '<button type="button" class="btn btn-primary btn-sm" id="edit-fakultas" data-id="' . $row->id . '" ><i class="fas fa-edit"></i></button><button type="button" class="btn btn-danger btn-sm ml-2" id="delete-fakultas" data-id="' . $row->id . '" ><i class="fas fa-trash-alt"></i></button>';
            })
            ->toJson(true);
    }

    public function get_fakultas()
    {
        $id = $this->request->getPost('id');
        $data = $this->fakultas_model->find($id);
        return json_encode($data);
    }

    public function add_fakultas()
    {
        // set validation
        $validation = [
            'nama_fakultas' => [
                'rules' => 'required|is_unique[master_fakultas.name]',
                'errors' => [
                    'required' => 'Nama fakultas harus diisi',
                    'is_unique' => 'Nama fakultas sudah ada'
                ]
            ],
            'nama_fakultas_en' => [
                'rules' => 'required|is_unique[master_fakultas.name_en]',
                'errors' => [
                    'required' => 'Nama fakultas (english) harus diisi',
                    'is_unique' => 'Nama fakultas (english) sudah ada'
                ]
            ],
            'nama_dekan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dekan harus diisi'
                ]
            ],
            'dekan_nidn' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'NIDN Dekan harus diisi'
                ]
            ]
        ];

        // check validation
        if (!$this->validate($validation)) {
            return redirect()->to(base_url('prodi-fakultas-management'))->withInput();
        }

        // insert data
        $data = [
            'name' => $this->request->getPost('nama_fakultas'),
            'name_en' => $this->request->getPost('nama_fakultas_en'),
            'dekan' => $this->request->getPost('nama_dekan'),
            'dekan_nidn' => $this->request->getPost('dekan_nidn'),
        ];

        $this->fakultas_model->insert($data);

        // set flashdata
        session()->setFlashdata('message-success', 'Data fakultas berhasil ditambahkan');

        return redirect()->to(base_url('prodi-fakultas-management'));
    }

    public function edit_fakultas()
    {
        // set validation 
        $validation = [
            'nama_fakultas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama fakultas harus diisi',
                ]
            ],
            'nama_fakultas_en' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama fakultas (english) harus diisi',
                ]
            ],
            'nama_dekan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dekan harus diisi'
                ]
            ],
            'dekan_nidn' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'NIDN Dekan harus diisi'
                ]
            ]
        ];

        // check validation
        if (!$this->validate($validation)) {
            return redirect()->to(base_url('prodi-fakultas-management'))->withInput();
        }

        // update data
        $id = $this->request->getPost('id_fakultas');
        $data = [
            'name' => $this->request->getPost('nama_fakultas'),
            'name_en' => $this->request->getPost('nama_fakultas_en'),
            'dekan' => $this->request->getPost('nama_dekan'),
            'dekan_nidn' => $this->request->getPost('dekan_nidn'),
        ];

        $this->fakultas_model->update($id, $data);

        // set flashdata
        session()->setFlashdata('message-success', 'Data fakultas berhasil diubah');

        return redirect()->to(base_url('prodi-fakultas-management'));
    }

    public function delete_fakultas()
    {
        $id = $this->request->getPost('id');
        $this->fakultas_model->delete($id);

        return json_encode(['status' => true]);
    }
}
