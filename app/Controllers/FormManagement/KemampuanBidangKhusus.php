<?php

namespace App\Controllers\FormManagement;

use App\Controllers\BaseController;
use CodeIgniter\Database\BaseBuilder;
use Hermawan\DataTables\DataTable;

class KemampuanBidangKhusus extends BaseController
{
    public function __construct()
    {
        $this->db = db_connect();
        $this->prodi_model = new \App\Models\ProdiModel();
        $this->fakultas_model = new \App\Models\FakultasModel();
        $this->kemampuan_bidang_khusus_model = new \App\Models\FormManagement\KemampuanBidangKhususModel();
        $this->detail_kemampuan_bidang_khusus_model = new \App\Models\FormManagement\DetailKemampuanBidangKhususModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Kemampuan Bidang Khusus Management',
        ];

        if (in_groups('admin', 'bpm')) {
            $data['prodis'] = $this->prodi_model->findAll();
        } elseif (in_groups('fakultas')) {
            $data['prodis'] = $this->prodi_model->where('fakultas_id', user()->fakultas_id)->findAll();
        } else {
            $data['prodis'] = $this->prodi_model->where('id', user()->prodi_id)->findAll();
        }

        return view('FormManagement/kemampuan_bidang_khusus_management/index', $data);
    }

    public function get_all_kemampuan_bidang_khusus()
    {
        $builder = $this->db
            ->table('kemampuan_bidang_khusus')
            ->select('prodi_id, kemampuan_bidang_khusus.id, kemampuan_bidang_khusus.created_at, master_prodi.name')
            ->join('master_prodi', 'master_prodi.id = kemampuan_bidang_khusus.prodi_id');

        return DataTable::of($builder)
            ->addNumbering('number')
            ->add('action', function ($row) {
                return '<button type="button" class="btn btn-primary btn-sm" id="edit-data" data-id="' . $row->id . '" ><i class="fas fa-edit"></i></button><button type="button" class="btn btn-danger btn-sm ml-2" id="delete-data" data-id="' . $row->id . '" ><i class="fas fa-trash-alt"></i></button>';
            })
            ->postQuery(function ($builder) {

                $builder->orderBy('kemampuan_bidang_khusus.id', 'desc');
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

    public function add_kemampuan_bidang_khusus()
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
            'kemampuan_bidang_khusus.*' => [
                'rules' => 'required|min_length[1]',
                'errors' => [
                    'required' => 'Kemampuan bidang khusus harus diisi'
                ]
            ],
            'kemampuan_bidang_khusus_en.*' => [
                'rules' => 'required|min_length[1]',
                'errors' => [
                    'required' => 'Kemampuan bidang khusus harus diisi'
                ]
            ],
        ];

        if (!$this->validate($validation)) {
            return redirect()->to(base_url('form-management/kemampuan-bidang-khusus-management'))->withInput();
        }

        $this->kemampuan_bidang_khusus_model->save([
            'prodi_id' => $this->request->getPost('prodi_id'),
        ]);

        $kemampuanBidangKhususId = $this->kemampuan_bidang_khusus_model->insertID();

        // handling detail kemampuan bidang khusus
        $kemampuanBidangKhusus = $this->request->getPost('kemampuan_bidang_khusus');
        $kemampuanBidangKhususEn = $this->request->getPost('kemampuan_bidang_khusus_en');
        $detailKemampuanBidangKhusus = [];

        foreach ($kemampuanBidangKhusus as $key => $value) {
            $detailKemampuanBidangKhusus[] = [
                'kemampuan_bidang_khusus_id' => $kemampuanBidangKhususId,
                'isi_kemampuan_bidang_khusus' => $value,
                'isi_kemampuan_bidang_khusus_en' => $kemampuanBidangKhususEn[$key]
            ];
        }

        $this->detail_kemampuan_bidang_khusus_model->insertBatch($detailKemampuanBidangKhusus);

        // set flashdata
        session()->setFlashdata('message-success', 'Data berhasil ditambahkan');

        return redirect()->to(base_url('form-management/kemampuan-bidang-khusus-management'));
    }

    public function update_kemampuan_bidang_khusus()
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
            'kemampuan_bidang_khusus.*' => [
                'rules' => 'required|min_length[1]',
                'errors' => [
                    'required' => 'Kemampuan bidang khusus harus diisi'
                ]
            ],
            'kemampuan_bidang_khusus_en.*' => [
                'rules' => 'required|min_length[1]',
                'errors' => [
                    'required' => 'Kemampuan bidang khusus harus diisi'
                ]
            ],
        ];

        if (!$this->validate($validation)) {
            return redirect()->to(base_url('form-management/kemampuan-bidang-khusus-management'))->withInput();
        }

        $this->kemampuan_bidang_khusus_model->update($this->request->getPost('kemampuan_bidang_khusus_id'), [
            'prodi_id' => $this->request->getPost('prodi_id'),
        ]);

        // handling detail kemampuan bidang khusus
        $kemampuanBidangKhusus = $this->request->getPost('kemampuan_bidang_khusus');
        $kemampuanBidangKhususEn = $this->request->getPost('kemampuan_bidang_khusus_en');
        $detailKemampuanBidangKhusus = [];

        foreach ($kemampuanBidangKhusus as $key => $value) {
            $detailKemampuanBidangKhusus[] = [
                'kemampuan_bidang_khusus_id' => $this->request->getPost('kemampuan_bidang_khusus_id'),
                'isi_kemampuan_bidang_khusus' => $value,
                'isi_kemampuan_bidang_khusus_en' => $kemampuanBidangKhususEn[$key]
            ];
        }

        // deleting old data
        $this->detail_kemampuan_bidang_khusus_model->where('kemampuan_bidang_khusus_id', $this->request->getPost('kemampuan_bidang_khusus_id'))->delete();

        // insert new data
        $this->detail_kemampuan_bidang_khusus_model->insertBatch($detailKemampuanBidangKhusus);

        // set flashdata
        session()->setFlashdata('message-success', 'Data berhasil diubah');

        return redirect()->to(base_url('form-management/kemampuan-bidang-khusus-management'));
    }

    public function delete_kemampuan_bidang_khusus()
    {
        $id = $this->request->getPost('id');
        $this->kemampuan_bidang_khusus_model->delete($id);

        // delete detail kemampuan bidang khusus
        $this->detail_kemampuan_bidang_khusus_model->where('kemampuan_bidang_khusus_id', $id)->delete();

        return json_encode([
            'status' => true
        ]);
    }

    public function get_kemampuan_bidang_khusus()
    {
        $id = $this->request->getPost('id');
        $kemampuanBidangKhusus = $this->kemampuan_bidang_khusus_model->find($id);
        $detailKemampuanBidangKhusus = $this->detail_kemampuan_bidang_khusus_model->where('kemampuan_bidang_khusus_id', $id)->findAll();

        $data = [
            'kemampuan_bidang_khusus' => $kemampuanBidangKhusus,
            'detail_kemampuan_bidang_khusus' => $detailKemampuanBidangKhusus
        ];

        return json_encode($data);
    }
}
