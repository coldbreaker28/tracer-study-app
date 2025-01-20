<?php

namespace App\Console\Commands;

use App\Models\Acara;
use App\Models\Karir;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DeleteUnusedFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'files:delete-unused';
    protected $description = 'Hapus file yang tidak terpakai';

    public function handle()
    {
        //
        $unusedImages = Acara::where('poster', false)->get();

        foreach ($unusedImages as $image) {
            $folderPath = 'app/public/';
            $filePath = storage_path($folderPath . $image->file_path);

            if (File::exists($filePath)) {
                File::delete($filePath);
                $this->info("File {$image->file_path} telah dihapus");
            }
        }

        $this->info('Proses penghapusan selesai.');
    }
}
