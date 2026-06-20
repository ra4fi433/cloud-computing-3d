<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keluar</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9pt;
            margin: 40px;
            margin-top: -20px;
        }
        .kop {

            text-align: center;
            margin-left: 0px;
            margin-right: 0px;
            /* padding: 10px 0; */
            /* margin: 0px; */

        }
        .kop img {
            float: left;
            width: 80px;
        }
        .kop p {
            margin: 0px;
        }
        .kop h2 {
            margin: 0;
            font-size: 12pt;
            font-weight: normal;
        }
       .kop h1 {
            margin: 0;
            padding: 0;
            font-size: 12pt;
            line-height: 1.2;
        }
        .clear { clear: both; }

        .info-table td {
            /* padding: 1px 2x; */
border-collapse: separate;
    border-spacing: 0 1px;        }

        .clear { clear: both; }

        .info-table td {
            /* padding: 1px 2x; */
            border-collapse: separate;
            border-spacing: 0 1px;
        }

        .tanggal {
            margin-left: 500px; /* Sesuaikan posisi tanggal */
            margin-top: 10px;
            text-align: right;
        }

        .isi {
            margin-top: 20px;
            text-align: justify;
            line-height: 1.6;
        }

        .ttd-section {
            margin-top: 60px;
            text-align: right;
            width: 300px; /* Sesuaikan lebar area ttd */
            float: right;
        }

        .ttd-line {
            border-bottom: 1px solid black;
            width: 200px; /* Lebar garis untuk ttd manual */
            margin: 0 auto;
            margin-top: 50px; /* Jarak untuk tanda tangan fisik */
        }

        .footer {
            clear: both; /* Penting agar footer tidak terganggu float ttd */
            text-align: center;
            font-size: 9pt;
            margin-top: 60px;
        }

        .signature-box {
            border: 1px solid #ccc;
            padding: 5px;
            margin-top: 10px;
            text-align: center;
        }
        .signature-box img {
            width: 50px; /* Ukuran logo di dalam box tanda tangan elektronik */
            float: left;
            margin-right: 10px;
        }
    </style>
</head>
<body>

    
    <div class="kop">
        <img src="<?php echo e(public_path('Logo-kota.png')); ?>" alt="Logo Pemerintah Kota Semarang" style="width: 55px;">
        <h2>PEMERINTAH KOTA SEMARANG</h2>
        <h1>DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL</h1>
        <p>Jalan Kanguru Raya No.3 Semarang Telp (024) 6712563 Kode Pos 50248</p>
    </div>
    <div class="clear"></div>
    <hr>
    <span class="tanggal">
    <?php echo e(\Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y')); ?>

    </span>

    
    <table class="info-table">
        <tr>
            <td>Nomor</td>
            <td>: <?php echo e($surat->nomor_surat); ?></td>
        </tr>
        <tr>
            <td>Sifat</td><td>: <?php echo e($surat->sifat); ?></td>
        </tr>
        <tr>
            <td>Lampiran</td><td>: <?php echo e($surat->lampiran ?? '-'); ?></td>
        </tr>
        <tr>
            <td>Hal</td><td>: <?php echo e($surat->perihal); ?></td>
        </tr>
    </table>

    
    <p style="margin-top: 15px;"><strong>Yth. <?php echo e($surat->kepada); ?></strong></p>

    
    <div class="isi">
        <?php echo $surat->isi_surat; ?>

    </div>

    
    <div class="ttd-section">
        <p>Kepala Dinas,</p>

        <?php if($surat->kadis_ttd_status === 'elektronik'): ?>
            
            
            <?php if(isset($signatureContentHtml)): ?>
                <?php echo $signatureContentHtml; ?>

            <?php else: ?>
                
                <div class="signature-box">
                    <img src="<?php echo e(public_path('Logo-kota.png')); ?>" alt="Logo Pemerintah Kota Semarang" style="width: 30px; float: left; margin-right: 10px;">
                    <p style="margin: 0;">Dokumen ini telah ditandatangani</p>
                    <p style="margin: 0; font-weight: bold;">secara elektronik.</p>
                    <div style="clear: both;"></div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            
            <div style="height: 70px;"></div> 
        <?php endif; ?>

        
        <?php
            // Ambil data Kadis yang menandatangani (jika sudah)
            $kadisTtd = null;
            if ($surat->kadis_ttd_id) {
                $kadisTtd = \App\Models\User::find($surat->kadis_ttd_id);
            } else {
                // Atau tampilkan nama Kadis placeholder jika belum ditandatangani
                // Anda bisa mengambil Kadis default atau Kadis yang paling relevan
                $kadisTtd = \App\Models\User::role('Kadis')->first(); // Ambil Kadis pertama sebagai placeholder
            }
        ?>

        <?php if($kadisTtd): ?>
            <p style="margin-top: 10px;"><strong><?php echo e($kadisTtd->name ?? 'Nama Kadis'); ?></strong><br>
            <?php echo e($kadisTtd->jabatan ?? 'Pembina Utama Muda/IV-c'); ?><br>
            NIP <?php echo e($kadisTtd->nip ?? '196702261986031001'); ?></p>
        <?php else: ?>
            <p style="margin-top: 10px;"><strong>[Nama Kadis]</strong><br>
            [Pangkat/Jabatan]<br>
            NIP [NIP Kadis]</p>
        <?php endif; ?>
    </div>

    
    <div class="footer">
        <p>Dokumen ini telah ditandatangani secara elektronik menggunakan sertifikat dari BSrE</p>
        <img src="<?php echo e(public_path('qrcode.png')); ?>" width="80"> 
    </div>

</body>
</html><?php /**PATH /var/www/html/resources/views/filament/pdf/surat-keluar.blade.php ENDPATH**/ ?>