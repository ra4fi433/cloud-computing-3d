<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\Document;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class TelegramController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // Tangani data webhook dari Telegram
        $update = Telegram::commandsHandler(true);

        // Contoh: Kirim balasan otomatis ke pengguna
        $chatId = $update->getMessage()->getChat()->getId();
        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => 'Pesan Anda diterima!',
        ]);

        return response()->json(['status' => 'ok']);
    }

    // Fungsi untuk mengirim pesan ke Telegram hari ini
    public function sendMessageToday()
    {
        return Cache::lock('telegram-send-today-lock', 30)->block(5, function () {
            $today = date('Y-m-d');
            $documents_today = Document::whereDate('tanggal_kegiatan', $today)->get();
            $this->sendTelegramMessage($documents_today, 'Hari Ini');

            return response()->json(['status' => 'sent']);
        });
    }

    // Fungsi untuk mengirim pesan ke Telegram hari ini sore
    public function sendMessageTodayAfternoon()
    {
        $lock = Cache::lock('telegram-send-today-afternoon-lock', 30);

        if (!$lock->get()) {
            return response()->json(['status' => 'locked']);
        }

        try {
            $today = date('Y-m-d');
            $current_time = date('H:i:s');
            $documents_today = Document::whereDate('tanggal_kegiatan', $today)
                ->where('waktu_kegiatan', '>=', $current_time)
                ->get();

            $this->sendTelegramMessage($documents_today, 'Hari Ini (Update)');

            return response()->json(['status' => 'sent']);
        } finally {
            $lock->release();
        }
    }
    // Fungsi untuk mengirim pesan ke Telegram besok
    public function sendMessageTomorrow()
    {
        $lock = Cache::lock('telegram-send-tomorrow-lock', 30);

        if (!$lock->get()) {
            return response()->json(['status' => 'locked']);
        }

        try {
            $tomorrow = date('Y-m-d', strtotime('+1 day'));
            $documents_tomorrow = Document::whereDate('tanggal_kegiatan', $tomorrow)->get();
            $this->sendTelegramMessage($documents_tomorrow, 'Besok');

            return response()->json(['status' => 'sent']);
        } finally {
            $lock->release();
        }
    }



    // Fungsi untuk mengirim pesan ke Telegram
    private function sendTelegramMessage($documents, $day) {
         if ($documents->isEmpty()) {
             return; // Jika tidak ada kegiatan, langsung keluar dari fungsi tanpa mengirim pesan
        }

        $days = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];

        $day = $days[date('l')];

    // kirim semua data
        foreach ($documents as $document) {
            $tanggal_kegiatan = $document->tanggal_kegiatan;
            $waktu_kegiatan = $document->waktu_kegiatan;
            $tempat_kegiatan = $document->tempat_kegiatan;
            // $disposisi = $document->disposisi;
            // $disposisi = is_array($document->disposisi) 
            //     ? implode(', ', $document->disposisi) 
            //     : $document->disposisi;
            $bidangTujuan = $document->bidangs->pluck('nama_bidang')->implode(', ');
            $perihal = $document->perihal;
            $instansi_pengirim = $document->instansi_pengirim;
            $keterangan = $document->keterangan;

            $day = $days[date('l', strtotime($tanggal_kegiatan))];
            $tanggal_kegiatan_formatted = $day . ', ' . date('d M Y', strtotime($tanggal_kegiatan));

            Telegram::sendMessage([
                'chat_id' => '-1002125500033', // Ganti dengan ID grup atau pengguna
                'text' => "📆 *Tanggal*: $tanggal_kegiatan_formatted\n⏰ *Jam*: $waktu_kegiatan\n🏛️ *Tempat Kegiatan*: $tempat_kegiatan\n📝 *Disposisi*: $disposisi\n📌 *Perihal*: $perihal\n🏢 *Instansi Pengirim*: $instansi_pengirim\n *Keterangan*: $keterangan",
                'parse_mode' => 'Markdown'
            ]);

            $document->update(['notifikasi_terkirim' => true]);
        }
    }
    
    // -1002599259414 // test-token
    // public function sendMessage(Request $request){  -1002279848372'
    //     // return Document::select("*")->get();

    //   $tomorrow = date('Y-m-d', strtotime('+1 day'));
    //     $documents = Document::whereDate('tanggal_kegiatan', $tomorrow)->get();

    //     foreach ($documents as $document) {
    //         $tanggal_kegiatan = $document->tanggal_kegiatan;
    //         $waktu_kegiatan = $document->waktu_kegiatan;
    //         $perihal = $document->perihal;
    //         $instansi_pengirim = $document->instansi_pengirim;
    //         $disposisi= $document->disposisi;
    //         $tempat_kegiatan= $document->tempat_kegiatan;

    //         Telegram::sendMessage([
    //             'chat_id' => '-1002125500033', // Ganti dengan ID pengguna atau grup
    //             'text' => "
    //                     Tanggal Acara : $tanggal_kegiatan\n Jam : $waktu_kegiatan \nPerihal : $perihal \nInstansi Pengirim : $instansi_pengirim \nDisposisi : $disposisi \nTempat Kegiatan : $tempat_kegiatan \n
    //                 "
    //         ]);
    //     }

        // return $documents[0]->tanggal_kegiatan;

        // $tanggal_kegiatan = $documents[0]->tanggal_kegiatan;
        // $waktu_kegiatan = $documents[0]->waktu_kegiatan;
        // $perihal = $documents[0]->perihal;
        // $instansi_pengirim = $documents[0]->instansi_pengirim;

        // Telegram::sendMessage([
        //     'chat_id' => '-4794420349', // Ganti dengan ID pengguna atau grup
        //     'text' => "
        //             tanggal : $tanggal_kegiatan\n jam : $waktu_kegiatan \nperihal : $perihal \ninstansi pengirim : $instansi_pengirim \n
        //         "
        // ]);
}
