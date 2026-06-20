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

        .tanggal {
            margin-left: 500px;
            margin-top: 10px;
            text-align: right;
        }

        .isi {
            margin-top: 20px;
            text-align: justify;
            line-height: 1.6;
        }

        /* .ttd {
            margin-top: 60px;
            text-align: right;
        }

        .ttd img {
            width: 100px;
        } */

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

        {{-- Kop Surat --}}
    <div class="kop">
        <img src="{{ public_path('Logo-kota.png') }}" alt="Logo Pemerintah Kota Semarang" style="width: 55px;">
        <h2>PEMERINTAH KOTA SEMARANG</h5>
        <h1>DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL</h1>
        <p>Jalan Kanguru Raya No.3 Semarang Telp (024) 6712563 Kode Pos 50248</p>
    </div>

    <!-- {{-- Kop Surat --}}
    <div class="kop">
        <img src="{{ asset('http://localhost/Logo-kota.png') }}" alt="logo" style="width: 80px;">
        <h2>PEMERINTAH KOTA SEMARANG</h2>
        <h3>DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL</h3>
        <p>Jalan Kanguru Raya No.3 Semarang Telp (024) 6712563 Kode Pos 50248</p>
    </div> -->
    <div class="clear"></div>
    <hr>
    <span class="tanggal">
    {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}
</span>


    {{-- Info Surat --}}
    <table class="info-table">
        <tr>
            <td>Nomor</td>
            <td>: {{ $surat->nomor_surat }}</td>
            <!-- <td style="text-align: right;">{{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}</td> -->
        </tr>
        <tr>
            <td>Sifat</td><td>: {{ $surat->sifat }}</td>
        </tr>
        <tr>
            <td>Lampiran</td><td>: {{ $surat->lampiran ?? '-' }}</td>
        </tr>
        <tr>
            <td>Hal</td><td>: {{ $surat->perihal }}</td>
        </tr>
        <!-- <tr>
            <td align="right" style="width: 200px; text-align: right;">
                <div class="tanggal">
                    {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}
                </div>
            </td>

        </tr>
        
                <tr>
                    <td style="width: 70px;">Nomor</td>
                    <td style="width: 10px;">:</td>
                    <td>{{ $surat->nomor_surat }}</td>
                </tr>
                <tr>
                    <td>Sifat</td>
                    <td>:</td>
                    <td>{{ $surat->sifat }}</td>
                </tr>
                <tr>
                    <td>Lampiran</td>
                    <td>:</td>
                    <td>{{ $surat->lampiran ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Hal</td>
                    <td>:</td>
                    <td>{{ $surat->perihal }}</td>
                    </tr>
  
        </tr> -->
        
    </table>

    {{-- Kepada --}}
    <p style="margin-top: 15px;"><strong>Yth. {{ $surat->kepada }}</strong></p>

    {{-- Isi Surat --}}
    <div class="isi">
        {!! $surat->isi_surat !!}
    </div>

    <!-- {{-- Penutup --}}
   

    {{-- Tanda Tangan --}}
    <!-- <div class="ttd-section">
        <p>Kepala Dinas,</p>

        @if ($surat->kadis_ttd_status === 'elektronik')
            {{-- Konten Tanda Tangan Elektronik --}}
            {{-- Ini akan di-inject dari controller, jadi pastikan signatureContentHtml dikirim --}}
            @if (isset($signatureContentHtml))
                {!! $signatureContentHtml !!}
            @else
{{-- Fallback jika signatureContentHtml tidak tersedia (misal preview tanpa proses sign elektronik) --}}
                <div class="signature-box">
                    <img src="{{ public_path('Logo-kota.png') }}" alt="Logo Pemerintah Kota Semarang" style="width: 50px; float: left; margin-right: 10px;">
                    <p style="margin: 0;">Dokumen ini telah ditandatangani</p>
                    <p style="margin: 0; font-weight: bold;">secara elektronik.</p>
                    <div style="clear: both;"></div>
                </div>
            @endif
        @else
{{-- Area Kosong untuk Tanda Tangan Manual --}}
            <div style="height: 70px;"></div> {{-- Memberi ruang untuk tanda tangan fisik --}}
        @endif

{{-- Nama dan NIP Kadis (akan selalu tampil, baik elektronik maupun manual) --}}
        @php
            // Ambil data Kadis yang menandatangani (jika sudah)
            $kadisTtd = null;
            if ($surat->kadis_ttd_id) {
                $kadisTtd = \App\Models\User::find($surat->kadis_ttd_id);
            } else {
                // Atau tampilkan nama Kadis placeholder jika belum ditandatangani
                // Anda bisa mengambil Kadis default atau Kadis yang paling relevan
                $kadisTtd = \App\Models\User::role('Kadis')->first(); // Ambil Kadis pertama sebagai placeholder
            }
        @endphp

        @if ($kadisTtd)
            <p style="margin-top: 10px;"><strong>{{ $kadisTtd->name ?? 'Nama Kadis' }}</strong><br>
            {{ $kadisTtd->jabatan ?? 'Pembina Utama Muda/IV-c' }}<br>
            NIP {{ $kadisTtd->nip ?? '19XXXXXXXXXXXXXX' }}</p>
        @else
            <p style="margin-top: 10px;"><strong>[Nama Kadis]</strong><br>
            [Pangkat/Jabatan]<br>
            NIP [NIP Kadis]</p>
        @endif
    </div> -->

    <!-- <div class="ttd">
        <p>Kepala,</p>
        <img src="{{ asset('ttd.png') }}" alt="ttd">
        <p><strong>Drs. Yudi Hardianto Wibowo</strong><br>
        Pembina Utama Muda/IV-c<br>
        NIP 196702261986031001</p>
    </div> -->

    {{-- Footer --}}
    <div class="footer">
        <p>Dokumen ini telah ditandatangani secara elektronik menggunakan sertifikat dari BSrE</p>
        <img src="{{ asset('qrcode.png') }}" width="80">
    </div> 

</body>
</html>