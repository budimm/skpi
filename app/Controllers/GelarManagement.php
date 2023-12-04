<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Hermawan\DataTables\DataTable;

class GelarManagement extends BaseController
{
    public function __construct()
    {
        $this->db = db_connect();
        $this->prodi_model = new \App\Models\ProdiModel();
        $this->fakultas_model = new \App\Models\FakultasModel();
        $this->gelar_model = new \App\Models\GelarModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Gelar Management',
            'fakultases' => $this->fakultas_model->findAll(),
            'prodis' => $this->prodi_model->findAll()
        ];

        return view('gelar_management/index', $data);
    }

    public function get_all_gelar()
    {
        $builder = $this->db->table('master_gelar')
            ->select('id,name_en,name,prodi,fakultas');

        return DataTable::of($builder)
            ->addNumbering('number')
            ->add('action', function ($row) {
                return '<button type="button" class="btn btn-primary btn-sm" id="edit-gelar" data-id="' . $row->id . '" ><i class="fas fa-edit"></i></button><button type="button" class="btn btn-danger btn-sm ml-2" id="delete-gelar" data-id="' . $row->id . '" ><i class="fas fa-trash-alt"></i></button>';
            })
            ->toJson(true);
    }

    public function add_gelar()
    {
        // set validation
        $validation = [
            'name' => [
                'rules' => 'required|is_unique[master_gelar.name]',
                'errors' => [
                    'required' => 'Nama gelar harus diisi',
                    'is_unique' => 'Nama gelar sudah ada'
                ]
            ],
            'name_en' => [
                'rules' => 'required|is_unique[master_gelar.name_en]',
                'errors' => [
                    'required' => 'Nama gelar (english) harus diisi',
                    'is_unique' => 'Nama gelar (english) sudah ada'
                ]
            ],
            'prodi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Prodi harus diisi'
                ]
            ],
            'fakultas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Fakultas harus diisi'
                ]
            ]
        ];

        // check validation
        if (!$this->validate($validation)) {
            return redirect()->to(base_url('gelar-management'))->withInput();
        }

        // insert data
        $this->gelar_model->save([
            'name' => $this->request->getPost('name'),
            'name_en' => $this->request->getPost('name_en'),
            'prodi' => $this->request->getPost('prodi'),
            'fakultas' => $this->request->getPost('fakultas')
        ]);

        // set flashdata
        session()->setFlashdata('message-success', 'Gelar berhasil ditambahkan');

        return redirect()->to(base_url('gelar-management'));
    }

    public function get_gelar()
    {
        $id = $this->request->getPost('id');
        $gelar = $this->gelar_model->find($id);

        return json_encode($gelar);
    }

    public function edit_gelar()
    {
        // set validation
        $validation = [
            'name' => [
                'rules' => 'required|is_unique[master_gelar.name,id,' . $this->request->getPost('gelar_id') . ']',
                'errors' => [
                    'required' => 'Nama gelar harus diisi',
                    'is_unique' => 'Nama gelar sudah ada'
                ]
            ],
            'name_en' => [
                'rules' => 'required|is_unique[master_gelar.name_en,id,' . $this->request->getPost('gelar_id') . ']',
                'errors' => [
                    'required' => 'Nama gelar (english) harus diisi',
                    'is_unique' => 'Nama gelar (english) sudah ada'
                ]
            ],
            'prodi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Prodi harus diisi'
                ]
            ],
            'fakultas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Fakultas harus diisi'
                ]
            ]
        ];

        // check validation
        if (!$this->validate($validation)) {
            return redirect()->to(base_url('gelar-management'))->withInput();
        }

        // update data
        $data = [
            'name' => $this->request->getPost('name'),
            'name_en' => $this->request->getPost('name_en'),
            'prodi' => $this->request->getPost('prodi'),
            'fakultas' => $this->request->getPost('fakultas')
        ];

        $this->gelar_model->update($this->request->getPost('gelar_id'), $data);

        // set flashdata
        session()->setFlashdata('message-success', 'Gelar berhasil diubah');

        return redirect()->to(base_url('gelar-management'));
    }

    public function delete_gelar()
    {
        $id = $this->request->getPost('id');
        $this->gelar_model->delete($id);

        return json_encode(['status' => true]);
    }
}
