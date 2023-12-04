<?php

namespace App\Controllers\FormManagement;

use App\Controllers\BaseController;
use CodeIgniter\Database\BaseBuilder;
use Hermawan\DataTables\DataTable;

class KemampuanBidangUmum extends BaseController
{
    public function __construct()
    {
        $this->db = db_connect();
        $this->prodi_model = new \App\Models\ProdiModel();
        $this->fakultas_model = new \App\Models\FakultasModel();
        $this->kemampuan_bidang_umum_model = new \App\Models\FormManagement\KemampuanBidangUmumModel();
        $this->detail_kemampuan_bidang_umum_model = new \App\Models\FormManagement\DetailKemampuanBidangUmumModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Kemampuan Bidang Umum Management',
        ];

        if (in_groups('admin', 'bpm')) {
            $data['prodis'] = $this->prodi_model->findAll();
        } elseif (in_groups('fakultas')) {
            $data['prodis'] = $this->prodi_model->where('fakultas_id', user()->fakultas_id)->findAll();
        } else {
            $data['prodis'] = $this->prodi_model->where('id', user()->prodi_id)->findAll();
        }

        return view('FormManagement/kemampuan_bidang_umum_management/index', $data);
    }

    public function get_all_kemampuan_bidang_umum()
    {
        $builder = $this->db
            ->table('kemampuan_bidang_umum')
            ->select('prodi_id, kemampuan_bidang_umum.id, kemampuan_bidang_umum.created_at, master_prodi.name')
            ->join('master_prodi', 'master_prodi.id = kemampuan_bidang_umum.prodi_id');

        return DataTable::of($builder)
            ->addNumbering('number')
            ->add('action', function ($row) {
                return '<button type="button" class="btn btn-primary btn-sm" id="edit-data" data-id="' . $row->id . '" ><i class="fas fa-edit"></i></button><button type="button" class="btn btn-danger btn-sm ml-2" id="delete-data" data-id="' . $row->id . '" ><i class="fas fa-trash-alt"></i></button>';
            })
            ->postQuery(function ($builder) {

                $builder->orderBy('kemampuan_bidang_umum.id', 'desc');
            })
            ->filter(function ($builder, $request) {

                if (in_groups('fakultas')) {
                    $builder->whereIn('prodi_id', static function (BaseBuilder $builder) {
                        $builder->select('id')->from('master_prodi')->where('fakultas_id', user()->fakultas_id);
                    });
                }

                if (in_groups('prodi')) {
                    $builder->where('prodi_id', user()->prodi_id);
                }
            })
            ->toJson(true);
    }

    public function add_kemampuan_bidang_umum()
    {
        // set validation
        $validation = [
            'prodi_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Prodi harus diisi',
                    'is_unique' => 'Prodi sudah ada'
                ]
            ],
            'kemampuan_bidang_umum.*' => [
                'rules' => 'required|min_length[1]',
                'errors' => [
                    'required' => 'Kemampuan bidang umum harus diisi'
                ]
            ],
            'kemampuan_bidang_umum_en.*' => [
                'rules' => 'required|min_length[1]',
                'errors' => [
                    'required' => 'Kemampuan bidang umum harus diisi'
                ]
            ],
        ];

        if (!$this->validate($validation)) {
            return redirect()->to(base_url('form-management/kemampuan-bidang-umum-management'))->withInput();
        }

        $this->kemampuan_bidang_umum_model->save([
            'prodi_id' => $this->request->getPost('prodi_id'),
        ]);

        $kemampuanBidangUmumId = $this->kemampuan_bidang_umum_model->insertID();

        // handling detail kemampuan bidang umum
        $kemampuanBidangUmum = $this->request->getPost('kemampuan_bidang_umum');
        $kemampuanBidangUmumEn = $this->request->getPost('kemampuan_bidang_umum_en');
        $detailKemampuanBidangUmum = [];

        foreach ($kemampuanBidangUmum as $key => $value) {
            $detailKemampuanBidangUmum[] = [
                'kemampuan_bidang_umum_id' => $kemampuanBidangUmumId,
                'isi_kemampuan_bidang_umum' => $value,
                'isi_kemampuan_bidang_umum_en' => $kemampuanBidangUmumEn[$key]
            ];
        }

        $this->detail_kemampuan_bidang_umum_model->insertBatch($detailKemampuanBidangUmum);

        // set flashdata
        session()->setFlashdata('message-success', 'Data berhasil ditambahkan');

        return redirect()->to(base_url('form-management/kemampuan-bidang-umum-management'));
    }

    public function update_kemampuan_bidang_umum()
    {
        // set validation
        $validation = [
            'prodi_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Prodi harus diisi',
                    'is_unique' => 'Prodi sudah ada'
                ]
            ],
            'kemampuan_bidang_umum.*' => [
                'rules' => 'required|min_length[1]',
                'errors' => [
                    'required' => 'Kemampuan bidang umum harus diisi'
                ]
            ],
            'kemampuan_bidang_umum_en.*' => [
                'rules' => 'required|min_length[1]',
                'errors' => [
                    'required' => 'Kemampuan bidang umum harus diisi'
                ]
            ],
        ];

        if (!$this->validate($validation)) {
            return redirect()->to(base_url('form-management/kemampuan-bidang-umum-management'))->withInput();
        }

        $this->kemampuan_bidang_umum_model->update($this->request->getPost('kemampuan_bidang_umum_id'), [
            'prodi_id' => $this->request->getPost('prodi_id'),
        ]);

        // handling detail kemampuan bidang umum
        $kemampuanBidangUmum = $this->request->getPost('kemampuan_bidang_umum');
        $kemampuanBidangUmumEn = $this->request->getPost('kemampuan_bidang_umum_en');
        $detailKemampuanBidangUmum = [];

        foreach ($kemampuanBidangUmum as $key => $value) {
            $detailKemampuanBidangUmum[] = [
                'kemampuan_bidang_umum_id' => $this->request->getPost('kemampuan_bidang_umum_id'),
                'isi_kemampuan_bidang_umum' => $value,
                'isi_kemampuan_bidang_umum_en' => $kemampuanBidangUmumEn[$key]
            ];
        }

        // deleting old data
        $this->detail_kemampuan_bidang_umum_model->where('kemampuan_bidang_umum_id', $this->request->getPost('kemampuan_bidang_umum_id'))->delete();

        // insert new data
        $this->detail_kemampuan_bidang_umum_model->insertBatch($detailKemampuanBidangUmum);

        // set flashdata
        session()->setFlashdata('message-success', 'Data berhasil diubah');

        return redirect()->to(base_url('form-management/kemampuan-bidang-umum-management'));
    }

    public function delete_kemampuan_bidang_umum()
    {
        $id = $this->request->getPost('id');
        $this->kemampuan_bidang_umum_model->delete($id);

        // delete detail kemampuan bidang umum
        $this->detail_kemampuan_bidang_umum_model->where('kemampuan_bidang_umum_id', $id)->delete();

        return json_encode([
            'status' => true
        ]);
    }

    public function get_kemampuan_bidang_umum()
    {
        $id = $this->request->getPost('id');
        $kemampuanBidangUmum = $this->kemampuan_bidang_umum_model->find($id);
        $detailKemampuanBidangUmum = $this->detail_kemampuan_bidang_umum_model->where('kemampuan_bidang_umum_id', $id)->findAll();

        $data = [
            'kemampuan_bidang_umum' => $kemampuanBidangUmum,
            'detail_kemampuan_bidang_umum' => $detailKemampuanBidangUmum
        ];

        return json_encode($data);
    }
}
