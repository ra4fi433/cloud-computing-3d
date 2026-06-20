<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class TestJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Telegram::sendMessage([
            'chat_id' => '-4794420349', // Ganti dengan ID pengguna atau grup
            'text' => "
                    tanggal : senin, 21 september 2021 \njam : 08.00 - 09.40 \nperihal : rapat koordinasi \ninstansi pengirim : dinas pendidikan \nketerangan : rapat koordinasi \n
                "
        ]);
    }
}
