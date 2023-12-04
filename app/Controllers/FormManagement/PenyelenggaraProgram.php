<?php

namespace App\Controllers\FormManagement;

use App\Controllers\BaseController;
use Hermawan\DataTables\DataTable;

class PenyelenggaraProgram extends BaseController
{
    public function __construct()
    {
        $this->db = db_connect();
        $this->prodi_model = new \App\Models\ProdiModel();
        $this->fakultas_model = new \App\Models\FakultasModel();
        $this->penyelenggara_program_model = new \App\Models\FormManagement\PenyelenggaraProgramModel();
    }


    public function index()
    {
        $data = [
            'title' => 'Penyelenggara Program',
        ];

        if (in_groups('admin', 'bpm')) {
            $data['prodis'] = $this->prodi_model->findAll();
            $data['fakultases'] = $this->fakultas_model->findAll();
        } elseif (in_groups('fakultas')) {
            $data['prodis'] = $this->prodi_model->where('fakultas_id', user()->fakultas_id)->findAll();
            $data['fakultases'] = $this->fakultas_model->where('id', user()->fakultas_id)->findAll();
        } else {
            $data['prodis'] = $this->prodi_model->where('id', user()->prodi_id)->findAll();
            $data['fakultases'] = $this->fakultas_model->where('id', user()->fakultas_id)->findAll();
        }

        return view('FormManagement/penyelenggara_program_management/index', $data);
    }

    public function get_all_penyelenggara_program()
    {
        $builder = $this->db->table('penyelenggara_program')
            ->select('id,program_studi ,program_studi_en,status_akreditasi,jenis_pendidikan,jenis_pendidikan_en,jenjang_pendidikan,jenjang_pendidikan_en,jenjang_pendidikan_sesuai_kkni,persyaratan_penerimaan,persyaratan_penerimaan_en,bahasa_pengantar_kuliah,bahasa_pengantar_kuliah_en,sistem_penilaian,lama_studi,lama_studi_en,jenis_jenjang_pendidikan_lanjutan,prodi,fakultas');

        return DataTable::of($builder)
            ->addNumbering('number')
            ->add('action', function ($row) {
                return '<button type="button" class="btn btn-primary btn-sm" id="edit-data" data-id="' . $row->id . '" ><i class="fas fa-edit"></i></button><button type="button" class="btn btn-danger btn-sm ml-2" id="delete-data" data-id="' . $row->id . '" ><i class="fas fa-trash-alt"></i></button>';
            })
            ->postQuery(function ($builder) {

                $builder->orderBy('id', 'desc');
            })
            ->filter(function ($builder, $request) {

                if (in_groups('fakultas')) {
                    $builder->where('fakultas', $this->fakultas_model->where('id', user()->fakultas_id)->get()->getRow()->name);
                }

                if (in_groups('prodi')) {
                    $builder->where('prodi', $this->prodi_model->where('id', user()->prodi_id)->get()->getRow()->name);
                }
            })
            ->toJson(true);
    }

    public function add_penyelenggara_program()
    {
        // set validation
        $validation = [
            'program_studi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Program studi harus diisi',
                ]
            ],
            'program_studi_en' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Program studi (english) harus diisi',
                ]
            ],
            'status_akreditasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status akreditasi harus diisi',
                ]
            ],
            'jenis_pendidikan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status akreditasi harus diisi',
                ]
            ],
            'jenis_pendidikan_en' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status akreditasi (english) harus diisi',
                ]
            ],
            'jenjang_pendidikan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenjanng Pendidikan harus diisi',
                ]
            ],
            'jenjang_pendidikan_en' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenjanng Pendidikan (english) harus diisi',
                ]
            ],
            'jenjang_pendidikan_sesuai_kkni' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenjanng Pendidikan sesuai KKNI harus diisi',
                ]
            ],
            'persyaratan_penerimaan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Persyaratan penerimaan harus diisi',
                ]
            ],
            'persyaratan_penerimaan_en' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Persyaratan penerimaan (english) harus diisi',
                ]
            ],
            'bahasa_pengantar_kuliah' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Bahasa pengantar kuliah harus diisi',
                ]
            ],
            'bahasa_pengantar_kuliah_en' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Bahasa pengantar kuliah (english) harus diisi',
                ]
            ],
            'sistem_penilaian' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Sistem penilaian harus diisi',
                ]
            ],
            'lama_studi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Lama studi harus diisi',
                ]
            ],
            'lama_studi_en' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Lama studi (english) harus diisi',
                ]
            ],
            'jenis_jenjang_pendidikan_lanjutan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis jenjang pendidikan lanjutan harus diisi',
                ]
            ],
            'prodi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Prodi harus diisi',
                ]
            ],
            'fakultas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Fakultas harus diisi',
                ]
            ]
        ];

        // check validation
        if (!$this->validate($validation)) {
            return redirect()->to(base_url('form-management/penyelenggara-program-management'))->withInput();
        }

        // insert data
        $data = [
            'program_studi' => $this->request->getPost('program_studi'),
            'program_studi_en' => $this->request->getPost('program_studi_en'),
            'status_akreditasi' => $this->request->getPost('status_akreditasi'),
            'jenis_pendidikan' => $this->request->getPost('jenis_pendidikan'),
            'jenis_pendidikan_en' => $this->request->getPost('jenis_pendidikan_en'),
            'jenjang_pendidikan' => $this->request->getPost('jenjang_pendidikan'),
            'jenjang_pendidikan_en' => $this->request->getPost('jenjang_pendidikan_en'),
            'jenjang_pendidikan_sesuai_kkni' => $this->request->getPost('jenjang_pendidikan_sesuai_kkni'),
            'persyaratan_penerimaan' => $this->request->getPost('persyaratan_penerimaan'),
            'persyaratan_penerimaan_en' => $this->request->getPost('persyaratan_penerimaan_en'),
            'bahasa_pengantar_kuliah' => $this->request->getPost('bahasa_pengantar_kuliah'),
            'bahasa_pengantar_kuliah_en' => $this->request->getPost('bahasa_pengantar_kuliah_en'),
            'sistem_penilaian' => $this->request->getPost('sistem_penilaian'),
            'lama_studi' => $this->request->getPost('lama_studi'),
            'lama_studi_en' => $this->request->getPost('lama_studi_en'),
            'jenis_jenjang_pendidikan_lanjutan' => $this->request->getPost('jenis_jenjang_pendidikan_lanjutan'),
            'prodi' => $this->request->getPost('prodi'),
            'fakultas' => $this->request->getPost('fakultas')
        ];

        $this->penyelenggara_program_model->insert($data);

        // set flashdata
        session()->setFlashdata('message-success', 'Penyelenggara Program berhasil ditambahkan.');

        return redirect()->to(base_url('form-management/penyelenggara-program-management'));
    }

    public function get_penyelenggara_program()
    {
        $id = $this->request->getPost('id');
        $penyelenggara_program = $this->penyelenggara_program_model->find($id);

        return json_encode($penyelenggara_program);
    }

    public function update_penyelenggara_program()
    {
        // set validation
        $validation = [
            'program_studi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Program studi harus diisi',
                ]
            ],
            'program_studi_en' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Program studi (english) harus diisi',
                ]
            ],
            'status_akreditasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status akreditasi harus diisi',
                ]
            ],
            'jenis_pendidikan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status akreditasi harus diisi',
                ]
            ],
            'jenis_pendidikan_en' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status akreditasi (english) harus diisi',
                ]
            ],
            'jenjang_pendidikan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenjanng Pendidikan harus diisi',
                ]
            ],
            'jenjang_pendidikan_en' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenjanng Pendidikan (english) harus diisi',
                ]
            ],
            'jenjang_pendidikan_sesuai_kkni' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenjanng Pendidikan sesuai KKNI harus diisi',
                ]
            ],
            'persyaratan_penerimaan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Persyaratan penerimaan harus diisi',
                ]
            ],
            'persyaratan_penerimaan_en' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Persyaratan penerimaan (english) harus diisi',
                ]
            ],
            'bahasa_pengantar_kuliah' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Bahasa pengantar kuliah harus diisi',
                ]
            ],
            'bahasa_pengantar_kuliah_en' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Bahasa pengantar kuliah (english) harus diisi',
                ]
            ],
            'sistem_penilaian' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Sistem penilaian harus diisi',
                ]
            ],
            'lama_studi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Lama studi harus diisi',
                ]
            ],
            'lama_studi_en' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Lama studi (english) harus diisi',
                ]
            ],
            'jenis_jenjang_pendidikan_lanjutan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis jenjang pendidikan lanjutan harus diisi',
                ]
            ],
            'prodi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Prodi harus diisi',
                ]
            ],
            'fakultas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Fakultas harus diisi',
                ]
            ]
        ];

        // check validation
        if (!$this->validate($validation)) {
            return redirect()->to(base_url('form-management/penyelenggara-program-management'))->withInput();
        }

        // update data
        $data = [
            'program_studi' => $this->request->getPost('program_studi'),
            'program_studi_en' => $this->request->getPost('program_studi_en'),
            'status_akreditasi' => $this->request->getPost('status_akreditasi'),
            'jenis_pendidikan' => $this->request->getPost('jenis_pendidikan'),
            'jenis_pendidikan_en' => $this->request->getPost('jenis_pendidikan_en'),
            'jenjang_pendidikan' => $this->request->getPost('jenjang_pendidikan'),
            'jenjang_pendidikan_en' => $this->request->getPost('jenjang_pendidikan_en'),
            'jenjang_pendidikan_sesuai_kkni' => $this->request->getPost('jenjang_pendidikan_sesuai_kkni'),
            'persyaratan_penerimaan' => $this->request->getPost('persyaratan_penerimaan'),
            'persyaratan_penerimaan_en' => $this->request->getPost('persyaratan_penerimaan_en'),
            'bahasa_pengantar_kuliah' => $this->request->getPost('bahasa_pengantar_kuliah'),
            'bahasa_pengantar_kuliah_en' => $this->request->getPost('bahasa_pengantar_kuliah_en'),
            'sistem_penilaian' => $this->request->getPost('sistem_penilaian'),
            'lama_studi' => $this->request->getPost('lama_studi'),
            'lama_studi_en' => $this->request->getPost('lama_studi_en'),
            'jenis_jenjang_pendidikan_lanjutan' => $this->request->getPost('jenis_jenjang_pendidikan_lanjutan'),
            'prodi' => $this->request->getPost('prodi'),
            'fakultas' => $this->request->getPost('fakultas')
        ];

        $this->penyelenggara_program_model->update($this->request->getPost('penyelenggara_program_id'), $data);

        // set flashdata
        session()->setFlashdata('message-success', 'Penyelenggara Program berhasil diubah.');

        return redirect()->to(base_url('form-management/penyelenggara-program-management'));
    }

    public function delete_penyelenggara_program()
    {
        $id = $this->request->getPost('id');
        $this->penyelenggara_program_model->delete($id);

        return json_encode(['status' => true]);
    }
}
