<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\BaseBuilder;
use Dompdf\Dompdf;
use Hermawan\DataTables\DataTable;

class FormSkpi extends BaseController
{
    public function __construct()
    {
        $this->form_skpi_model = new \App\Models\FormSkpiModel();
        $this->prodi_model = new \App\Models\ProdiModel();
        $this->db = \Config\Database::connect();
        $this->fakultas_model = new \App\Models\FakultasModel();
        $this->penyeleggara_program_model = new \App\Models\FormManagement\PenyelenggaraProgramModel();
        $this->kemampuan_bidang_umum_model = new \App\Models\FormManagement\KemampuanBidangUmumModel();
        $this->kemampuan_bidang_khusus_model = new \App\Models\FormManagement\KemampuanBidangKhususModel();
        $this->penguasaan_pengetahuan_model = new \App\Models\FormManagement\PenguasaanPengetahuanModel();
        $this->penguasaan_sikap_model = new \App\Models\FormManagement\PenguasaanSikapModel();
        $this->bagian_ditjen_dikti_model = new \App\Models\FormManagement\DitjenDiktiModel();
        $this->gelar_model = new \App\Models\GelarModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Form SKPI',
            'years' => $this->form_skpi_model->select('YEAR(tanggal_masuk) as year')->distinct()->findAll(),
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

        $data['penyeleggara_programs'] = $this->penyeleggara_program_model
            ->select('penyelenggara_program.id, penyelenggara_program.created_at,master_prodi.name as prodi_name')
            ->join('master_prodi', 'master_prodi.name = penyelenggara_program.prodi', 'left')
            ->when(in_groups('fakultas'), 'master_prodi.fakultas_id', user()->fakultas_id)
            ->when(in_groups('prodi'), 'master_prodi.id', user()->prodi_id)
            ->findAll();

        $data['kemampuan_bidang_umums'] = $this->kemampuan_bidang_umum_model
            ->select('kemampuan_bidang_umum.id, kemampuan_bidang_umum.created_at,master_prodi.name as prodi_name')
            ->join('master_prodi', 'master_prodi.id = kemampuan_bidang_umum.prodi_id', 'left')
            ->when(in_groups('fakultas'), 'master_prodi.fakultas_id', user()->fakultas_id)
            ->when(in_groups('prodi'), 'master_prodi.id', user()->prodi_id)
            ->findAll();

        $data['kemampuan_bidang_khususes'] = $this->kemampuan_bidang_khusus_model
            ->select('kemampuan_bidang_khusus.id, kemampuan_bidang_khusus.created_at,master_prodi.name as prodi_name')
            ->join('master_prodi', 'master_prodi.id = kemampuan_bidang_khusus.prodi_id', 'left')
            ->when(in_groups('fakultas'), 'master_prodi.fakultas_id', user()->fakultas_id)
            ->when(in_groups('prodi'), 'master_prodi.id', user()->prodi_id)
            ->findAll();

        $data['penguasaan_pengetahuans'] = $this->penguasaan_pengetahuan_model
            ->select('penguasaan_pengetahuan.id, penguasaan_pengetahuan.created_at,master_prodi.name as prodi_name')
            ->join('master_prodi', 'master_prodi.id = penguasaan_pengetahuan.prodi_id', 'left')
            ->when(in_groups('fakultas'), 'master_prodi.fakultas_id', user()->fakultas_id)
            ->when(in_groups('prodi'), 'master_prodi.id', user()->prodi_id)
            ->findAll();

        $data['penguasaan_sikaps'] = $this->penguasaan_sikap_model
            ->select('penguasaan_sikap.id, penguasaan_sikap.created_at,master_prodi.name as prodi_name')
            ->join('master_prodi', 'master_prodi.id = penguasaan_sikap.prodi_id', 'left')
            ->when(in_groups('fakultas'), 'master_prodi.fakultas_id', user()->fakultas_id)
            ->when(in_groups('prodi'), 'master_prodi.id', user()->prodi_id)
            ->findAll();

        $data['bagian_ditjen_diktis'] = $this->bagian_ditjen_dikti_model
            ->select('bagian_ditjen_dikti.id, bagian_ditjen_dikti.created_at,master_prodi.name as prodi_name')
            ->join('master_prodi', 'master_prodi.id = bagian_ditjen_dikti.prodi_id', 'left')
            ->when(in_groups('fakultas'), 'master_prodi.fakultas_id', user()->fakultas_id)
            ->when(in_groups('prodi'), 'master_prodi.id', user()->prodi_id)
            ->findAll();

        $data['gelars'] = $this->gelar_model
            ->select('master_gelar.id, master_gelar.name,master_prodi.name as prodi_name')
            ->join('master_prodi', 'master_prodi.name = master_gelar.prodi', 'left')
            ->when(in_groups('fakultas'), 'master_prodi.fakultas_id', user()->fakultas_id)
            ->when(in_groups('prodi'), 'master_prodi.id', user()->prodi_id)
            ->findAll();



        return view('form_skpi/index', $data);
    }

    public function get_all_form_skpi()
    {
        $builder = $this->db
            ->table('form_skpi')
            ->select(
                'master_prodi.name as prodi_name ,
                master_fakultas.name as fakultas_name,
                form_skpi.id,
                penyelenggara_program_id ,
                kemampuan_bidang_umum_id ,
                kemampuan_bidang_khusus_id,
                penguasaan_pengetahuan_id,
                penguasaan_sikap_id,
                bagian_ditjen_dikti_id,
                nama,
                nim,
                ttl,
                tanggal_masuk,
                tanggal_lulus,
                nomor_seri_ijazah,
                gelar,
                tugas_khusus_pengganti_kerja_praktek,
                tugas_khusus_pengganti_kerja_praktek_en,
                pengalaman_organisasi,
                pengalaman_organisasi_en,
                tugas_akhir,
                tugas_akhir_en,
                tgl_pengesahan,
                no_skpi'
            )
            ->join('master_prodi', 'master_prodi.id = form_skpi.prodi_id', 'left')
            ->join('master_fakultas', 'master_fakultas.id = master_prodi.fakultas_id', 'left');

        return DataTable::of($builder)
            ->addNumbering('number')
            ->add('action', function ($row) {
                return '<button type="button" class="btn btn-primary btn-sm" id="edit-data" data-id="' . $row->id . '" ><i class="fas fa-edit"></i></button><button type="button" class="btn btn-danger btn-sm ml-2" id="delete-data" data-id="' . $row->id . '" ><i class="fas fa-trash-alt"></i></button></button><button type="button" class="btn btn-success btn-sm ml-2" id="export-data" data-id="' . $row->id . '" ><i class="fas fa-file-download"></i></button>';
            })
            ->postQuery(function ($builder) {

                $builder->orderBy('form_skpi.id', 'desc');
            })
            ->filter(function ($builder, $request) {

                if (in_groups('fakultas')) {
                    $builder->where(
                        'master_fakultas.id',
                        user()->fakultas_id
                    );
                }

                if (in_groups('prodi_id')) {
                    $builder->where('prodi', user()->prodi_id);
                }

                if (isset($request->tahun)) {
                    $builder->where('YEAR(tanggal_masuk)', $request->tahun);
                }
            })
            ->toJson(true);
    }

    public function get_form_skpi()
    {
        $id = $this->request->getPost('id');

        $data = $this->form_skpi_model->find($id);

        return json_encode($data);
    }

    public function add_form_skpi()
    {
        // set validation
        $validation = [
            'prodi_id ' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Prodi harus diisi',
                ]
            ],
            'no_skpi ' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomor SKPI harus diisi',
                ]
            ],
            'penyelenggara_program_id ' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Penyelenggara program harus diisi',
                ]
            ],
            'kemampuan_bidang_umum_id '  => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kemampuan bidang umum harus diisi',
                ]
            ],
            'kemampuan_bidang_khusus_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kemampuan bidang khusus harus diisi',
                ]
            ],
            'penguasaan_pengetahuan_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Penguasaan pengetahuan harus diisi',
                ]
            ],
            'penguasaan_sikap_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Penguasaan sikap harus diisi',
                ]
            ],
            'bagian_ditjen_dikti_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Bagian ditjen dikti harus diisi',
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi',
                ]
            ],
            'nim' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'NIM harus diisi',
                ]
            ],
            'ttl' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'TTL harus diisi',
                ]
            ],
            'tanggal_masuk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Masuk harus diisi',
                ]
            ],
            'tanggal_lulus' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Lulus harus diisi',
                ]
            ],
            'nomor_seri_ijazah' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomor Seri Ijazah harus diisi',
                ]
            ],
            'gelar' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Gelar harus diisi',
                ]
            ],
            'tugas_khusus_pengganti_kerja_praktek' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tugas khusus pengganti kerja praktek harus diisi',
                ]
            ],
            'tugas_khusus_pengganti_kerja_praktek_en' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tugas khusus pengganti kerja praktek harus diisi',
                ]
            ],
            'pengalaman_organisasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pengalaman organisasi harus diisi',
                ]
            ],
            'pengalaman_organisasi_en' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pengalaman organisasi harus diisi',
                ]
            ],
            'tugas_akhir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tugas akhir harus diisi',
                ]
            ],
            'tugas_akhir_en' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tugas akhir harus diisi',
                ]
            ],
            'tgl_pengesahan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Pengesahan harus diisi',
                ]
            ]
        ];

        // check validation
        if (!$this->validate($validation)) {
            return redirect()->to(base_url('form-skpi'))->withInput();
        }

        // setup data
        $data = [
            'prodi_id ' => $this->request->getPost('prodi_id'),
            'penyelenggara_program_id ' => $this->request->getPost('penyelenggara_program_id'),
            'kemampuan_bidang_umum_id '  => $this->request->getPost('kemampuan_bidang_umum_id'),
            'kemampuan_bidang_khusus_id' => $this->request->getPost('kemampuan_bidang_khusus_id'),
            'penguasaan_pengetahuan_id' => $this->request->getPost('penguasaan_pengetahuan_id'),
            'penguasaan_sikap_id' => $this->request->getPost('penguasaan_sikap_id'),
            'bagian_ditjen_dikti_id' => $this->request->getPost('bagian_ditjen_dikti_id'),
            'nama' => $this->request->getPost('nama'),
            'nim' => $this->request->getPost('nim'),
            'ttl' => $this->request->getPost('ttl'),
            'tanggal_masuk' => $this->request->getPost('tanggal_masuk'),
            'tanggal_lulus' => $this->request->getPost('tanggal_lulus'),
            'nomor_seri_ijazah' => $this->request->getPost('nomor_seri_ijazah'),
            'gelar' => $this->request->getPost('gelar'),
            'tugas_khusus_pengganti_kerja_praktek' => $this->request->getPost('tugas_khusus_pengganti_kerja_praktek'),
            'tugas_khusus_pengganti_kerja_praktek_en' => $this->request->getPost('tugas_khusus_pengganti_kerja_praktek_en'),
            'pengalaman_organisasi' => $this->request->getPost('pengalaman_organisasi'),
            'pengalaman_organisasi_en' => $this->request->getPost('pengalaman_organisasi_en'),
            'tugas_akhir' => $this->request->getPost('tugas_akhir'),
            'tugas_akhir_en' => $this->request->getPost('tugas_akhir_en'),
            'tgl_pengesahan' => $this->request->getPost('tgl_pengesahan'),
            'no_skpi' => $this->request->getPost('no_skpi'),
        ];

        // insert data
        $this->form_skpi_model->insert($data);

        // set session
        session()->setFlashdata('message-success', 'Data berhasil ditambahkan.');

        return redirect()->to(base_url('form-skpi'));
    }

    public function update_form_skpi()
    {
        // set validation
        $validation = [
            'prodi_id ' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Prodi harus diisi',
                ]
            ],
            'no_skpi ' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomor SKPI harus diisi',
                ]
            ],
            'penyelenggara_program_id ' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Penyelenggara program harus diisi',
                ]
            ],
            'kemampuan_bidang_umum_id '  => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kemampuan bidang umum harus diisi',
                ]
            ],
            'kemampuan_bidang_khusus_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kemampuan bidang khusus harus diisi',
                ]
            ],
            'penguasaan_pengetahuan_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Penguasaan pengetahuan harus diisi',
                ]
            ],
            'penguasaan_sikap_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Penguasaan sikap harus diisi',
                ]
            ],
            'bagian_ditjen_dikti_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Bagian ditjen dikti harus diisi',
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi',
                ]
            ],
            'nim' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'NIM harus diisi',
                ]
            ],
            'ttl' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'TTL harus diisi',
                ]
            ],
            'tanggal_masuk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Masuk harus diisi',
                ]
            ],
            'tanggal_lulus' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Lulus harus diisi',
                ]
            ],
            'nomor_seri_ijazah' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomor Seri Ijazah harus diisi',
                ]
            ],
            'gelar' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Gelar harus diisi',
                ]
            ],
            'tugas_khusus_pengganti_kerja_praktek' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tugas khusus pengganti kerja praktek harus diisi',
                ]
            ],
            'tugas_khusus_pengganti_kerja_praktek_en' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tugas khusus pengganti kerja praktek harus diisi',
                ]
            ],
            'pengalaman_organisasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pengalaman organisasi harus diisi',
                ]
            ],
            'pengalaman_organisasi_en' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pengalaman organisasi harus diisi',
                ]
            ],
            'tugas_akhir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tugas akhir harus diisi',
                ]
            ],
            'tugas_akhir_en' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tugas akhir harus diisi',
                ]
            ],
            'tgl_pengesahan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Pengesahan harus diisi',
                ]
            ]
        ];

        // check validation
        if (!$this->validate($validation)) {
            return redirect()->to(base_url('form-skpi'))->withInput();
        }

        // setup data
        $data = [
            'prodi_id ' => $this->request->getPost('prodi_id'),
            'penyelenggara_program_id ' => $this->request->getPost('penyelenggara_program_id'),
            'kemampuan_bidang_umum_id '  => $this->request->getPost('kemampuan_bidang_umum_id'),
            'kemampuan_bidang_khusus_id' => $this->request->getPost('kemampuan_bidang_khusus_id'),
            'penguasaan_pengetahuan_id' => $this->request->getPost('penguasaan_pengetahuan_id'),
            'penguasaan_sikap_id' => $this->request->getPost('penguasaan_sikap_id'),
            'bagian_ditjen_dikti_id' => $this->request->getPost('bagian_ditjen_dikti_id'),
            'nama' => $this->request->getPost('nama'),
            'nim' => $this->request->getPost('nim'),
            'ttl' => $this->request->getPost('ttl'),
            'tanggal_masuk' => $this->request->getPost('tanggal_masuk'),
            'tanggal_lulus' => $this->request->getPost('tanggal_lulus'),
            'nomor_seri_ijazah' => $this->request->getPost('nomor_seri_ijazah'),
            'gelar' => $this->request->getPost('gelar'),
            'tugas_khusus_pengganti_kerja_praktek' => $this->request->getPost('tugas_khusus_pengganti_kerja_praktek'),
            'tugas_khusus_pengganti_kerja_praktek_en' => $this->request->getPost('tugas_khusus_pengganti_kerja_praktek_en'),
            'pengalaman_organisasi' => $this->request->getPost('pengalaman_organisasi'),
            'pengalaman_organisasi_en' => $this->request->getPost('pengalaman_organisasi_en'),
            'tugas_akhir' => $this->request->getPost('tugas_akhir'),
            'tugas_akhir_en' => $this->request->getPost('tugas_akhir_en'),
            'tgl_pengesahan' => $this->request->getPost('tgl_pengesahan'),
            'no_skpi' => $this->request->getPost('no_skpi'),
        ];

        // update data
        $this->form_skpi_model->update($this->request->getPost('form_skpi_id'), $data);

        // set session
        session()->setFlashdata('message-success', 'Data berhasil diubah.');

        return redirect()->to(base_url('form-skpi'));
    }

    public function delete_form_skpi()
    {
        // delete data
        $this->form_skpi_model->delete($this->request->getPost('id'));

        return json_encode([
            'status' => true
        ]);
    }

    public function export_pdf()
    {
        $filename = date('y-m-d-H-i-s') . '-skpi-report';

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        // setup data 
        $form_id = $this->request->getGet('form_id');

        $data['form'] = $this->form_skpi_model->find($form_id);
        $data['penyelenggara_program'] = $this->penyeleggara_program_model->find($data['form']['penyelenggara_program_id']);
        $data['kemampuan_bidang_umum'] = $this->kemampuan_bidang_umum_model
            ->where('kemampuan_bidang_umum.id', $data['form']['kemampuan_bidang_umum_id'])
            ->join('detail_kemampuan_bidang_umum', 'detail_kemampuan_bidang_umum.kemampuan_bidang_umum_id = kemampuan_bidang_umum.id', 'left')
            ->findAll();
        $data['kemampuan_bidang_khusus'] = $this->kemampuan_bidang_khusus_model
            ->where('kemampuan_bidang_khusus.id', $data['form']['kemampuan_bidang_khusus_id'])
            ->join('detail_kemampuan_bidang_khusus', 'detail_kemampuan_bidang_khusus.kemampuan_bidang_khusus_id = kemampuan_bidang_khusus.id', 'left')
            ->findAll();
        $data['penguasaan_pengetahuan'] = $this->penguasaan_pengetahuan_model
            ->where('penguasaan_pengetahuan.id', $data['form']['penguasaan_pengetahuan_id'])
            ->join('detail_penguasaan_pengetahuan', 'detail_penguasaan_pengetahuan.penguasaan_pengetahuan_id = penguasaan_pengetahuan.id', 'left')
            ->findAll();
        $data['penguasaan_sikap'] = $this->penguasaan_sikap_model
            ->where('penguasaan_sikap.id', $data['form']['penguasaan_sikap_id'])
            ->join('detail_penguasaan_sikap', 'detail_penguasaan_sikap.penguasaan_sikap_id = penguasaan_sikap.id', 'left')
            ->findAll();
        $data['bagian_ditjen_dikti'] = $this->bagian_ditjen_dikti_model->find($data['form']['bagian_ditjen_dikti_id']);
        $data['gelar'] = $this->gelar_model->where('name', $data['form']['gelar'])->first();
        $data['fakultas'] = $this->prodi_model
            ->where('master_prodi.id', $data['form']['prodi_id'])
            ->join('master_fakultas', 'master_fakultas.id = master_prodi.fakultas_id', 'left')
            ->first();

        // load HTML content
        $dompdf->loadHtml(view('templates/export_pdf', $data));

        // (optional) setup the paper size and orientation
        // $dompdf->setPaper('A4');

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        return $dompdf->stream($filename);
    }
}
