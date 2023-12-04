<?php

namespace App\Controllers\FormManagement;

use App\Controllers\BaseController;
use CodeIgniter\Database\BaseBuilder;
use Hermawan\DataTables\DataTable;

class PenguasaanPengetahuan extends BaseController
{
    public function __construct()
    {
        $this->db = db_connect();
        $this->prodi_model = new \App\Models\ProdiModel();
        $this->fakultas_model = new \App\Models\FakultasModel();
        $this->penguasaan_pengetahuan_model = new \App\Models\FormManagement\PenguasaanPengetahuanModel();
        $this->detail_penguasaan_pengetahuan_model  = new \App\Models\FormManagement\DetailPenguasaanPengetahuanModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Penguasaan Pengetahuan Management',
        ];

        if (in_groups('admin', 'bpm')) {
            $data['prodis'] = $this->prodi_model->findAll();
        } elseif (in_groups('fakultas')) {
            $data['prodis'] = $this->prodi_model->where('fakultas_id', user()->fakultas_id)->findAll();
        } else {
            $data['prodis'] = $this->prodi_model->where('id', user()->prodi_id)->findAll();
        }

        return view('FormManagement/penguasaan_pengetahuan_management/index', $data);
    }

    public function get_all_penguasaan_pengetahuan()
    {
        $builder = $this->db
            ->table('penguasaan_pengetahuan')
            ->select('prodi_id, penguasaan_pengetahuan.id, penguasaan_pengetahuan.created_at, master_prodi.name')
            ->join('master_prodi', 'master_prodi.id = penguasaan_pengetahuan.prodi_id');

        return DataTable::of($builder)
            ->addNumbering('number')
            ->add('action', function ($row) {
                return '<button type="button" class="btn btn-primary btn-sm" id="edit-data" data-id="' . $row->id . '" ><i class="fas fa-edit"></i></button><button type="button" class="btn btn-danger btn-sm ml-2" id="delete-data" data-id="' . $row->id . '" ><i class="fas fa-trash-alt"></i></button>';
            })
            ->postQuery(function ($builder) {

                $builder->orderBy('penguasaan_pengetahuan.id', 'desc');
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

    public function add_penguasaan_pengetahuan()
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
            'penguasaan_pengetahuan.*' => [
                'rules' => 'required|min_length[1]',
                'errors' => [
                    'required' => 'Penguasaan Pengetahuan harus diisi'
                ]
            ],
            'penguasaan_pengetahuan_en.*' => [
                'rules' => 'required|min_length[1]',
                'errors' => [
                    'required' => 'Penguasaan Pengetahuan harus diisi'
                ]
            ],
        ];

        if (!$this->validate($validation)) {
            return redirect()->to(base_url('form-management/penguasaan-pengetahuan-management'))->withInput();
        }

        $this->penguasaan_pengetahuan_model->save([
            'prodi_id' => $this->request->getPost('prodi_id'),
        ]);

        $penguasaanPengetahuanId = $this->penguasaan_pengetahuan_model->insertID();

        // handling detail Pengetahuan bidang umum
        $penguasaanPengetahuan = $this->request->getPost('penguasaan_pengetahuan');
        $penguasaanPengetahuanEn = $this->request->getPost('penguasaan_pengetahuan_en');
        $detailPenguasaanPengetahuan = [];

        foreach ($penguasaanPengetahuan as $key => $value) {
            $detailPenguasaanPengetahuan[] = [
                'penguasaan_pengetahuan_id' => $penguasaanPengetahuanId,
                'isi_penguasaan_pengetahuan' => $value,
                'isi_penguasaan_pengetahuan_en' => $penguasaanPengetahuanEn[$key]
            ];
        }

        $this->detail_penguasaan_pengetahuan_model->insertBatch($detailPenguasaanPengetahuan);

        // set flashdata
        session()->setFlashdata('message-success', 'Data berhasil ditambahkan');

        return redirect()->to(base_url('form-management/penguasaan-pengetahuan-management'));
    }

    public function update_penguasaan_pengetahuan()
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
            'penguasaan_pengetahuan.*' => [
                'rules' => 'required|min_length[1]',
                'errors' => [
                    'required' => 'Pengetahuan bidang umum harus diisi'
                ]
            ],
            'penguasaan_pengetahuan_en.*' => [
                'rules' => 'required|min_length[1]',
                'errors' => [
                    'required' => 'Pengetahuan bidang umum harus diisi'
                ]
            ],
        ];

        if (!$this->validate($validation)) {
            return redirect()->to(base_url('form-management/penguasaan-pengetahuan-management'))->withInput();
        }

        $this->penguasaan_pengetahuan_model->update($this->request->getPost('penguasaan_pengetahuan_id'), [
            'prodi_id' => $this->request->getPost('prodi_id'),
        ]);

        // handling detail Pengetahuan bidang umum
        $penguasaanPengetahuan = $this->request->getPost('penguasaan_pengetahuan');
        $penguasaanPengetahuanEn = $this->request->getPost('penguasaan_pengetahuan_en');
        $detailPenguasaanPengetahuan = [];

        foreach ($penguasaanPengetahuan as $key => $value) {
            $detailPenguasaanPengetahuan[] = [
                'penguasaan_pengetahuan_id' => $this->request->getPost('penguasaan_pengetahuan_id'),
                'isi_penguasaan_pengetahuan' => $value,
                'isi_penguasaan_pengetahuan_en' => $penguasaanPengetahuanEn[$key]
            ];
        }

        // deleting old data
        $this->detail_penguasaan_pengetahuan_model->where('penguasaan_pengetahuan_id', $this->request->getPost('penguasaan_pengetahuan_id'))->delete();

        // insert new data
        $this->detail_penguasaan_pengetahuan_model->insertBatch($detailPenguasaanPengetahuan);

        // set flashdata
        session()->setFlashdata('message-success', 'Data berhasil diubah');

        return redirect()->to(base_url('form-management/penguasaan-pengetahuan-management'));
    }

    public function delete_penguasaan_pengetahuan()
    {
        $id = $this->request->getPost('id');
        $this->penguasaan_pengetahuan_model->delete($id);

        // delete detail Pengetahuan bidang umum
        $this->detail_penguasaan_pengetahuan_model->where('penguasaan_pengetahuan_id', $id)->delete();

        return json_encode([
            'status' => true
        ]);
    }

    public function get_penguasaan_pengetahuan()
    {
        $id = $this->request->getPost('id');
        $penguasaanPengetahuan = $this->penguasaan_pengetahuan_model->find($id);
        $detailPenguasaanPengetahuan = $this->detail_penguasaan_pengetahuan_model->where('penguasaan_pengetahuan_id', $id)->findAll();

        $data = [
            'penguasaan_pengetahuan' => $penguasaanPengetahuan,
            'detail_penguasaan_pengetahuan' => $detailPenguasaanPengetahuan
        ];

        return json_encode($data);
    }
}
