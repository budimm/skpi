<?php

namespace App\Models;

use CodeIgniter\Model;

class FormSkpiModel extends Model
{
    protected $table            = 'form_skpi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'prodi_id ',
        'penyelenggara_program_id ',
        'kemampuan_bidang_umum_id ',
        'kemampuan_bidang_khusus_id',
        'penguasaan_pengetahuan_id',
        'penguasaan_sikap_id',
        'bagian_ditjen_dikti_id',
        'nama',
        'nim',
        'ttl',
        'tanggal_masuk',
        'tanggal_lulus',
        'nomor_seri_ijazah',
        'gelar',
        'tugas_khusus_pengganti_kerja_praktek',
        'tugas_khusus_pengganti_kerja_praktek_en',
        'pengalaman_organisasi',
        'pengalaman_organisasi_en',
        'tugas_akhir',
        'tugas_akhir_en',
        'tgl_pengesahan',
        'no_skpi',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
