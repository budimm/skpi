<?php

namespace App\Controllers\FormManagement;

use App\Controllers\BaseController;
use CodeIgniter\Database\BaseBuilder;
use Hermawan\DataTables\DataTable;

class PenguasaanSikap extends BaseController
{
    public function __construct()
    {
        $this->db = db_connect();
        $this->prodi_model = new \App\Models\ProdiModel();
        $this->fakultas_model = new \App\Models\FakultasModel();
        $this->penguasaan_sikap_model = new \App\Models\FormManagement\PenguasaanSikapModel();
        $this->detail_penguasaan_sikap_model  = new \App\Models\FormManagement\DetailPenguasaanSikapModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Penguasaan Sikap Management',
        ];

        if (in_groups('admin', 'bpm')) {
            $data['prodis'] = $this->prodi_model->findAll();
        } elseif (in_groups('fakultas')) {
            $data['prodis'] = $this->prodi_model->where('fakultas_id', user()->fakultas_id)->findAll();
        } else {
            $data['prodis'] = $this->prodi_model->where('id', user()->prodi_id)->findAll();
        }

        return view('FormManagement/penguasaan_sikap_management/index', $data);
    }

    public function get_all_penguasaan_sikap()
    {
        $builder = $this->db
            ->table('penguasaan_sikap')
            ->select('prodi_id, penguasaan_sikap.id, penguasaan_sikap.created_at, master_prodi.name')
            ->join('master_prodi', 'master_prodi.id = penguasaan_sikap.prodi_id');

        return DataTable::of($builder)
            ->addNumbering('number')
            ->add('action', function ($row) {
                return '<button type="button" class="btn btn-primary btn-sm" id="edit-data" data-id="' . $row->id . '" ><i class="fas fa-edit"></i></button><button type="button" class="btn btn-danger btn-sm ml-2" id="delete-data" data-id="' . $row->id . '" ><i class="fas fa-trash-alt"></i></button>';
            })
            ->postQuery(function ($builder) {

                $builder->orderBy('penguasaan_sikap.id', 'desc');
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

    public function add_penguasaan_sikap()
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
            'penguasaan_sikap.*' => [
                'rules' => 'required|min_length[1]',
                'errors' => [
                    'required' => 'Penguasaan Sikap harus diisi'
                ]
            ],
            'penguasaan_sikap_en.*' => [
                'rules' => 'required|min_length[1]',
                'errors' => [
                    'required' => 'Penguasaan Sikap harus diisi'
                ]
            ],
        ];

        if (!$this->validate($validation)) {
            return redirect()->to(base_url('form-management/penguasaan-sikap-management'))->withInput();
        }

        $this->penguasaan_sikap_model->save([
            'prodi_id' => $this->request->getPost('prodi_id'),
        ]);

        $penguasaanSikapId = $this->penguasaan_sikap_model->insertID();

        // handling detail Sikap bidang umum
        $penguasaanSikap = $this->request->getPost('penguasaan_sikap');
        $penguasaanSikapEn = $this->request->getPost('penguasaan_sikap_en');
        $detailPenguasaanSikap = [];

        foreach ($penguasaanSikap as $key => $value) {
            $detailPenguasaanSikap[] = [
                'penguasaan_sikap_id' => $penguasaanSikapId,
                'isi_penguasaan_sikap' => $value,
                'isi_penguasaan_sikap_en' => $penguasaanSikapEn[$key]
            ];
        }

        $this->detail_penguasaan_sikap_model->insertBatch($detailPenguasaanSikap);

        // set flashdata
        session()->setFlashdata('message-success', 'Data berhasil ditambahkan');

        return redirect()->to(base_url('form-management/penguasaan-sikap-management'));
    }

    public function update_penguasaan_sikap()
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
            'penguasaan_sikap.*' => [
                'rules' => 'required|min_length[1]',
                'errors' => [
                    'required' => 'Sikap bidang umum harus diisi'
                ]
            ],
            'penguasaan_sikap_en.*' => [
                'rules' => 'required|min_length[1]',
                'errors' => [
                    'required' => 'Sikap bidang umum harus diisi'
                ]
            ],
        ];

        if (!$this->validate($validation)) {
            return redirect()->to(base_url('form-management/penguasaan-sikap-management'))->withInput();
        }

        $this->penguasaan_sikap_model->update($this->request->getPost('penguasaan_sikap_id'), [
            'prodi_id' => $this->request->getPost('prodi_id'),
        ]);

        // handling detail Sikap bidang umum
        $penguasaanSikap = $this->request->getPost('penguasaan_sikap');
        $penguasaanSikapEn = $this->request->getPost('penguasaan_sikap_en');
        $detailPenguasaanSikap = [];

        foreach ($penguasaanSikap as $key => $value) {
            $detailPenguasaanSikap[] = [
                'penguasaan_sikap_id' => $this->request->getPost('penguasaan_sikap_id'),
                'isi_penguasaan_sikap' => $value,
                'isi_penguasaan_sikap_en' => $penguasaanSikapEn[$key]
            ];
        }

        // deleting old data
        $this->detail_penguasaan_sikap_model->where('penguasaan_sikap_id', $this->request->getPost('penguasaan_sikap_id'))->delete();

        // insert new data
        $this->detail_penguasaan_sikap_model->insertBatch($detailPenguasaanSikap);

        // set flashdata
        session()->setFlashdata('message-success', 'Data berhasil diubah');

        return redirect()->to(base_url('form-management/penguasaan-sikap-management'));
    }

    public function delete_penguasaan_sikap()
    {
        $id = $this->request->getPost('id');
        $this->penguasaan_sikap_model->delete($id);

        // delete detail Sikap bidang umum
        $this->detail_penguasaan_sikap_model->where('penguasaan_sikap_id', $id)->delete();

        return json_encode([
            'status' => true
        ]);
    }

    public function get_penguasaan_sikap()
    {
        $id = $this->request->getPost('id');
        $penguasaanSikap = $this->penguasaan_sikap_model->find($id);
        $detailPenguasaanSikap = $this->detail_penguasaan_sikap_model->where('penguasaan_sikap_id', $id)->findAll();

        $data = [
            'penguasaan_sikap' => $penguasaanSikap,
            'detail_penguasaan_sikap' => $detailPenguasaanSikap
        ];

        return json_encode($data);
    }
}
