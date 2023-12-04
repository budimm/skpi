<html>

<head>
    <style>
        @page {
            margin-top: 1.25cm;
            margin-bottom: 2cm;
            margin-right: 1.25cm;
            margin-left: 1.25cm;
        }

        .fonten {
            color: #00038e;
            /* make italic */
            font-style: italic;
        }

        body {
            font-family: sans-serif;
            font-size: 10pt;
            line-height: 1.3;
            page-break-after: avoid;
        }

        .judul {
            /* setup like h2 */
            font-size: 2em;
            /* Change the value as per your requirement */
        }

        .sub-judul {
            /* setup like h2 */
            font-size: 1.5em;
            /* Change the value as per your requirement */
        }

        .fontkecil {
            font-size: 10pt;
        }

        .fontsubkecil {
            font-size: 8pt;
        }

        .first-row {
            border-top: 2px solid black;
            border-bottom: 2px solid black;
        }

        table {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>
    <table width="100%" border="1" style="border-collapse:collapse;">
        <tr>
            <td style="border-top-style: solid;
		border-top-width: 3px;
        border-bottom-width: 0px;
		border-left-width: 0px;
        border-right-width: 0px;">
            </td>
        </tr>
    </table>
    <p align="center"><b>
            <font class="judul">Surat Keterangan Pendamping Ijazah</font><br><i>
                <font class="subjudul">
                    <font class="fonten">Diploma Supplement</font>
                </font>
            </i>
        </b>
        <br>
        <font class="fontkecil">Nomor / </font>
        <font class="fontkecil" color="blue"><i>Number</i></font>
        <font class="fontkecil"> : <?= $form['no_skpi'] ?></font>
    </p>

    <font class="fontkecil"><i>Surat keterangan pendamping ijazah (SKPI) ini dikeluarkan oleh Fakultas Teknik Universitas Bhayangkara Surabaya, sebagai pelengkap ijazah untuk menerangkan capaian pembelajaran pemegang ijazah. / <font class="fonten">The Diploma Supplement is issued by the Faculty of Engineering, Bhayangkara University of Surabaya, as a complement to explain learning outcome of the diploma holders.</font></i></font><br>

    <table border="0" cellpadding="1" cellspacing="0" width="100%" class="tabelcetak">
        <tr>
            <td class="first-row">
                <b>1. INFORMASI PEMEGANG SKPI</b> /
                <font class="fonten">INFORMATION OF THE HOLDER OF THE QUALIFICATION </font>
            </td>
        </tr>
        <tr>
            <td class="tdjudul">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td class="tdcetak" height="8">1.1</td>
                        <td class="tdcetak" width="300">Nama / <font class="fonten">Name</font>
                        </td>
                        <td class="tdcetak">:</td>
                        <td class="tdcetak"><?= strtoupper($form['nama']) ?></td>
                    </tr>
                    <tr>
                        <td class="tdcetak">1.2</td>
                        <td class="tdcetak">Tempat, Tanggal Lahir / <font class="fonten">Place, Date of Birth</font>
                        </td>
                        <td class="tdcetak">:</td>
                        <td class="tdcetak"><?= $form['ttl'] ?></td>
                    </tr>
                    <tr>
                        <td class="tdcetak">1.3</td>
                        <td class="tdcetak">NIM / <font class="fonten">Student ID</font>
                        </td>
                        <td class="tdcetak">:</td>
                        <td class="tdcetak"><?= $form['nim'] ?></td>
                    </tr>
                    <tr>
                        <td class="tdcetak">1.4</td>
                        <td class="tdcetak">Tanggal Masuk / <font class="fonten">Enrollment Date</font>
                        </td>
                        <td class="tdcetak">:</td>
                        <td class="tdcetak"><?= date('j F Y', strtotime($form['tanggal_masuk'])) ?></td>
                    </tr>
                    <tr>
                        <td class="tdcetak">1.5</td>
                        <td class="tdcetak">Tanggal Kelulusan / <font class="fonten">Graduation Date</font>
                        </td>
                        <td class="tdcetak">:</td>
                        <td class="tdcetak"><?= date('j F Y', strtotime($form['tanggal_lulus'])) ?></td>
                    </tr>
                    <tr>
                        <td class="tdcetak">1.6</td>
                        <td class="tdcetak">Nomor Seri Ijazah / <font class="fonten">Certificate Serial Number</font>
                        </td>
                        <td class="tdcetak">:</td>
                        <td class="tdcetak"><?= $form['nomor_seri_ijazah'] ?></td>
                    </tr>
                    <tr>
                        <td class="tdcetak">1.7</td>
                        <td class="tdcetak">Gelar yang diberikan / <font class="fonten">Title of Qualification</font>
                        </td>
                        <td class="tdcetak">:</td>
                        <td class="tdcetak"><?= $gelar['name'] ?> / <font class="fonten"><?= $gelar['name_en'] ?></font>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="first-row"><b>2. INFORMASI PENYELENGGARA PROGRAM</b> / <font class="fonten">INFORMATION OF PROGRAM ORGANIZER</font>
            </td>
        </tr>
        <tr>
            <td class="tdjudul">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td class="tdcetak" height="8">2.1</td>
                        <td class="tdcetak" width="300">Nama Program Studi / <font class="fonten">Department Name</font>
                        </td>
                        <td class="tdcetak">:</td>
                        <td class="tdcetak"><?= $penyelenggara_program['program_studi'] ?> / <font class="fonten"><?= $penyelenggara_program['program_studi_en'] ?></font>
                        </td>
                    </tr>
                    <tr>
                        <td class="tdcetak" height="8">2.2</td>
                        <td class="tdcetak">Status Akreditasi / <font class="fonten">Accreditation</font>
                        </td>
                        <td class="tdcetak">:</td>
                        <td class="tdcetak"><?= $penyelenggara_program['status_akreditasi'] ?></td>
                    </tr>
                    <tr>
                        <td class="tdcetak">2.3</td>
                        <td class="tdcetak">Jenis Pendidikan / <font class="fonten">Type of Education</font>
                        </td>
                        <td class="tdcetak">:</td>
                        <td class="tdcetak"><?= $penyelenggara_program['jenis_pendidikan'] ?> / <font class="fonten"><?= $penyelenggara_program['jenis_pendidikan_en'] ?></font>
                        </td>
                    </tr>
                    <tr>
                        <td class="tdcetak">2.4</td>
                        <td class="tdcetak">Jenjang Pendidikan / <font class="fonten">Level of Education</font>
                        </td>
                        <td class="tdcetak">:</td>
                        <td class="tdcetak"><?= $penyelenggara_program['jenjang_pendidikan'] ?> / <font class="fonten"><?= $penyelenggara_program['jenjang_pendidikan_en'] ?></font>
                        </td>
                    </tr>
                    <tr>
                        <td class="tdcetak" valign="top">2.5</td>
                        <td class="tdcetak" valign="top">Jenjang Pendidikan Sesuai KKNI / <font class="fonten">Level of Qualification in the National Qualification Framework</font>
                        </td>
                        <td class="tdcetak" valign="top">:</td>
                        <td class="tdcetak" valign="top"><?= $penyelenggara_program['jenjang_pendidikan_sesuai_kkni'] ?></td>
                    </tr>
                    <tr>
                        <td class="tdcetak">2.6</td>
                        <td class="tdcetak">Persyaratan Penerimaan / <font class="fonten">Entry Requirements</font>
                        </td>
                        <td class="tdcetak">:</td>
                        <td class="tdcetak"><?= $penyelenggara_program['persyaratan_penerimaan'] ?> / <font class="fonten"><?= $penyelenggara_program['persyaratan_penerimaan_en'] ?></font>
                        </td>
                    </tr>
                    <tr>
                        <td class="tdcetak">2.7</td>
                        <td class="tdcetak">Bahasa Pengantar Kuliah / <font class="fonten">Language of Instruction</font>
                        </td>
                        <td class="tdcetak">:</td>
                        <td class="tdcetak"><?= $penyelenggara_program['bahasa_pengantar_kuliah'] ?> / <font class="fonten"><?= $penyelenggara_program['bahasa_pengantar_kuliah_en'] ?></font>
                        </td>
                    </tr>
                    <tr>
                        <td class="tdcetak">2.8</td>
                        <td class="tdcetak">Sistem Penilaian / <font class="fonten">Grading System</font>
                        </td>
                        <td class="tdcetak">:</td>
                        <td class="tdcetak"><?= $penyelenggara_program['sistem_penilaian'] ?></td>
                    </tr>
                    <tr>
                        <td class="tdcetak" valign="top">2.9</td>
                        <td class="tdcetak" valign="top">Lama Studi / <font class="fonten">Length of Study</font>
                        </td>
                        <td class="tdcetak">:</td>
                        <td class="tdcetak" valign="top"><?= $penyelenggara_program['lama_studi'] ?> / <font class="fonten"><?= $penyelenggara_program['lama_studi_en'] ?></font>
                        </td>
                    </tr>
                    <tr>
                        <td class="tdcetak">2.10</td>
                        <td class="tdcetak"> Jenis dan Jenjang Pendidikan Lanjutan / <font class="fonten">Type and Level of Advanced Study </font>
                        </td>
                        <td class="tdcetak">:</td>
                        <td class="tdcetak"><?= $penyelenggara_program['jenis_jenjang_pendidikan_lanjutan'] ?></td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>
    <pagebreak />
    <table border="0" cellpadding="1" cellspacing="0" width="100%" class="1tabelcetak">

        <tr>
            <td class="first-row"><b>3. INFORMASI KUALIFIKASI DAN HASIL YANG DICAPAI</b> / <font class="fonten">INFORMATION OF THE QUALIFICATION AND OUTCOMES ACHIEVED</font>
            </td>
        </tr>
        <tr>
            <td>
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="tabelcetak">
                    <tr border='1'>
                        <td class="tdcetak" colspan="6"><b>3.1 Capaian Pembelajaran</b> / <font class="fonten">Learning Outcomes</font>
                        </td>
                    </tr>
                    <tr>
                        <td class="tdcetak">&nbsp;&nbsp;&nbsp;</td>
                        <td class="tdcetak"><b>A.</b></td>
                        <td class="tdcetak" width="50%"><b>Kemampuan Bidang Umum</b></td>
                        <td class="tdcetak" valign="top">&nbsp;&nbsp;</td>
                        <td class="tdcetak">
                            <font class="fonten"><b>A.</b></font>
                        </td>
                        <td class="tdcetak" width="50%">
                            <font class="fonten"><b>General Working Ability</b></font>
                        </td>
                    </tr>

                    <?php foreach ($kemampuan_bidang_umum as $key => $value) : ?>
                        <tr>
                            <td class="tdcetak" valign="top">&nbsp;&nbsp;&nbsp;</td>
                            <td class="tdcetak" valign="top"><?= $key + 1 ?>.</td>
                            <td class="tdcetak" valign="top">
                                <?= $value['isi_kemampuan_bidang_umum'] ?>
                            </td>
                            <td class="tdcetak" valign="top">&nbsp;&nbsp;</td>
                            <td class="tdcetak" valign="top">
                                <font class="fonten"><?= $key + 1 ?>.</font>
                            </td>
                            <td class="tdcetaken" valign="top">
                                <font class="fonten">
                                    <?= $value['isi_kemampuan_bidang_umum_en'] ?>
                                </font>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>

        <tr>
            <td>
                <table border="0" cellpadding="1" cellspacing="0" width="100%" class="tabelcetak">
                    <tr>
                        <td class="tdcetak">&nbsp;&nbsp;&nbsp;</td>
                        <td class="tdcetak"><b>B.</b></td>
                        <td class="tdcetak" width="50%"><b>Kemampuan Bidang Khusus</b></td>
                        <td class="tdcetak" valign="top">&nbsp;&nbsp;</td>
                        <td class="tdcetak">
                            <font class="fonten"><b>B.</b></font>
                        </td>
                        <td class="tdcetak" width="50%">
                            <font class="fonten"><b>Specific Working Ability</b></font>
                        </td>
                    </tr>
                    <?php foreach ($kemampuan_bidang_khusus as $key => $value) : ?>
                        <tr>
                            <td class="tdcetak" valign="top">&nbsp;&nbsp;&nbsp;</td>
                            <td class="tdcetak" valign="top"><?= $key + 1 ?>.</td>
                            <td class="tdcetak" valign="top">
                                <?= $value['isi_kemampuan_bidang_khusus'] ?>
                            </td>
                            <td class="tdcetak" valign="top">&nbsp;&nbsp;</td>
                            <td class="tdcetak" valign="top">
                                <font class="fonten"><?= $key + 1 ?>.</font>
                            </td>
                            <td class="tdcetaken" valign="top">
                                <font class="fonten">
                                    <?= $value['isi_kemampuan_bidang_khusus_en'] ?>
                                </font>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>





        <tr style="width :'100%'">
            <td>
                <table border="0" cellpadding="1" cellspacing="0" width="100%" class="tabelcetak">
                    <tr>
                        <td class="tdcetak">&nbsp;&nbsp;&nbsp;</td>
                        <td class="tdcetak"><b>C.</b></td>
                        <td class="tdcetak" width="50%"><b>Penguasaan Pengetahuan</b></td>
                        <td class="tdcetak" valign="top">&nbsp;&nbsp;</td>
                        <td class="tdcetak">
                            <font class="fonten"><b>C.</b></font>
                        </td>
                        <td class="tdcetak" width="50%">
                            <font class="fonten"><b>Knowledge Competencies</b></font>
                        </td>
                    </tr>
                    <?php foreach ($penguasaan_pengetahuan as $key => $value) : ?>
                        <tr>
                            <td class="tdcetak" valign="top">&nbsp;&nbsp;&nbsp;</td>
                            <td class="tdcetak" valign="top"><?= $key + 1 ?>.</td>
                            <td class="tdcetak" valign="top">
                                <?= $value['isi_penguasaan_pengetahuan'] ?>

                            </td>
                            <td class="tdcetak" valign="top">&nbsp;&nbsp;</td>
                            <td class="tdcetak" valign="top">
                                <font class="fonten"><?= $key + 1 ?>.</font>
                            </td>
                            <td class="tdcetaken" valign="top">
                                <font class="fonten">
                                    <?= $value['isi_penguasaan_pengetahuan_en'] ?>
                                </font>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table border="0" cellpadding="1" cellspacing="0" width="100%" class="tabelcetak">
                    <tr>
                        <td class="tdcetak">&nbsp;&nbsp;&nbsp;</td>
                        <td class="tdcetak"><b>D.</b></td>
                        <td class="tdcetak" width="50%"><b>Penguasaan Sikap</b></td>
                        <td class="tdcetak" valign="top">&nbsp;&nbsp;</td>
                        <td class="tdcetak">
                            <font class="fonten"><b>D.</b>
                                <font>
                        </td>
                        <td class="tdcetak" width="50%">
                            <font class="fonten"><b>Attitude Competencies</b></font>
                        </td>
                    </tr>
                    <?php foreach ($penguasaan_sikap as $key => $value) : ?>
                        <tr>
                            <td class="tdcetak" valign="top">&nbsp;&nbsp;&nbsp;</td>
                            <td class="tdcetak" valign="top"><?= $key + 1 ?>.</td>
                            <td class="tdcetak" valign="top">
                                <?= $value['isi_penguasaan_sikap'] ?>

                            </td>
                            <td class="tdcetak" valign="top">&nbsp;&nbsp;</td>
                            <td class="tdcetak" valign="top">
                                <font class="fonten"><?= $key + 1 ?>.</font>
                            </td>
                            <td class="tdcetaken" valign="top">
                                <font class="fonten">
                                    <?= $value['isi_penguasaan_sikap_en'] ?>
                                </font>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>

        <tr>
            <td>
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="tabelcetak">
                    <tr>
                        <td class="tdcetak" colspan="4"><b>3.2 Informasi Tambahan</b> / <font class="fonten">Adding Information</font>
                        </td>
                    </tr>
                    <tr>
                        <td class="tdcetak">&nbsp;&nbsp;&nbsp;</td>
                        <td class="tdcetak" width="50%">
                            <b> Tugas Khusus Pengganti Kerja Praktek :</b><br>
                            <?= $form['tugas_khusus_pengganti_kerja_praktek'] ?>
                        </td>
                        <td class="tdcetak" valign="top">&nbsp;&nbsp;</td>
                        <td class="tdcetaken" width="50%">
                            <font class="fonten"><b>Special Task :</b><br>
                                <?= $form['tugas_khusus_pengganti_kerja_praktek_en'] ?>
                            </font>
                        </td>
                    </tr>

                    <!-- //Sertifikasi
                    <tr>
                        <td class="tdcetak">&nbsp;&nbsp;&nbsp;</td>
                        <td class="tdcetak" width="420"><b>Sertifikasi dan Keahlian :</b><br>
                        </td>
                        <td class="tdcetak" valign="top">&nbsp;&nbsp;</td>
                        <td class="tdcetaken">
                            <font class="fonten"><b>Certification and Expertise :</b><br>
                            </font>
                        </td>
                    </tr> -->

                    <tr>
                        <td class="tdcetak">&nbsp;&nbsp;&nbsp;</td>
                        <td class="tdcetak" width="50%"><b>Pengalaman Organisasi :</b><br>
                            <?= $form['pengalaman_organisasi'] ?>
                        </td>
                        <td class="tdcetak" valign="top">&nbsp;&nbsp;</td>
                        <td class="tdcetaken" width="50%">
                            <font class="fonten"><b>Organizational Experience :</b><br>
                                <?= $form['pengalaman_organisasi_en'] ?>
                            </font>
                        </td>
                    </tr>

                    <!-- <tr>
                        <td class="tdcetak">&nbsp;&nbsp;&nbsp;</td>
                        <td class="tdcetak" width="420"><b>Prestasi :</b><br>

                        </td>
                        <td class="tdcetak" valign="top">&nbsp;&nbsp;</td>
                        <td class="tdcetaken">
                            <font class="fonten"><b>Achievement :</b><br>

                            </font>
                        </td>
                    </tr> -->


                    <tr>
                        <td class="tdcetak">&nbsp;&nbsp;&nbsp;</td>
                        <td class="tdcetak" width="50%"><b>Tugas Akhir :</b><br>
                            <?= $form['tugas_akhir'] ?>
                        </td>
                        <td class="tdcetak" valign="top">&nbsp;&nbsp;</td>
                        <td class="tdcetaken" width="50%">
                            <font class="fonten"><b>Final Project :</b><br>
                                <?= $form['tugas_akhir_en'] ?>
                            </font>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>

    </table>


    <table border="0" cellpadding="1" cellspacing="0" width="100%" class="1tabelcetak">


        <tr>
            <td class="first-row"><b>4. INFORMASI SISTEM PENDIDIKAN TINGGI DI INDONESIA DAN KERANGKA KUALIFIKASI NASIONAL INDONESIA</b> / <font class="fonten">INFORMATION OF HIGHER EDUCATION SYSTEM IN INDONESIA AND INDONESIAN NATIONAL QUALIFICATIONS FRAMEWORK</font>
            </td>
        </tr>
        <tr>
            <td>
                <table border="0" cellpadding="1" cellspacing="0" width="100%" class="tabelcetak">
                    <tr>
                        <td class="tdcetak" width="50%" valign="top"><b>Bagian ini disiapkan oleh Ditjen Dikti</b><br>
                            <?= $bagian_ditjen_dikti['text_bagian'] ?>
                        </td>
                        <td class="tdcetak" valign="top">&nbsp;&nbsp;</td>
                        <td class="tdcetaken" valign="top" width="50%">
                            <font class="fonten"><b>This section was prepared by the Ditjen Dikti</b><br>
                                <?= $bagian_ditjen_dikti['text_bagian_en'] ?>
                            </font>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>

    <pagebreak />
    <table width="100%">
        <tr>
            <td class="first-row" colspan="2"><b>5. PENGESAHAN</b> / <font class="fonten">LEGALIZATION</font>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <table border="0">
                    <tr>
                        <td width="10%">&nbsp;</td>
                        <td class="fontkecil">
                            <font class="fontkecil">Surabaya, <?= date('j F Y', strtotime($form['tgl_pengesahan'])) ?> /
                                <font class="fonten"><?= date('M j, Y', strtotime($form['tgl_pengesahan'])) ?>
                                </font>
                                <br><br><br><br><br><br>
                                <b><?= $fakultas['dekan'] ?></b><br>
                                Dekan Fakultas <?= ucfirst($fakultas['name']) ?> / <font class="fonten">Dean of <?= ucfirst($fakultas['name_en']) ?> Faculty</font><br>
                                NIP / <font class="fonten">Employee ID Number</font> : <?= $fakultas['dekan_nidn'] ?>
                            </font>
                        </td>
                    </tr>
                </table>
            </td>
            <?php
            $data = file_get_contents(base_url('img/web/for-pdf.jpg'));
            $base64 = 'data:image/jpg;base64,' . base64_encode($data);
            ?>

            <td align="center"><img src="<?= $base64 ?>" width="225" height="156"><br>
                <p align="center" class="fontsubkecil">Gambar 1. / <font class="fonten">Figure 1. A Mutual Agreement on IQF Level Descriptions</font>
                </p>
            </td>
        </tr>
    </table>


</body>

</html>