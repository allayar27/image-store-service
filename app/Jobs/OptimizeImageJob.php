<?php

namespace App\Jobs;

use App\Models\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Log;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class OptimizeImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Image $image) {}

    public function handle(): void
    {
        try {
            $realPath = storage_path('app/' . $this->image->path);

            $optimizedPath = 'images/optimized' . $this->image->hash . '.webp';

            $optimizedfullPath = storage_path('app/' . $optimizedPath);

            $manager = new ImageManager(new Driver());

            $img = $manager->read($realPath);
            $img->encodeByExtension('webp', quality: 85)->save($optimizedfullPath);

            $this->image->update([
                'path'      => $optimizedPath,
                'mime_type' => 'image/webp',
                'size'      => filesize($optimizedfullPath),
            ]);

            $this->deleteOriginalFile($realPath);

        } catch (\Throwable $e) {
            Log::error('failed optimize image job: ' . $e->getMessage());
            throw $e;
        }
    }

    private function deleteOriginalFile(string $sourcePath): void
    {
        if (file_exists($sourcePath)) {
            unlink($sourcePath);
        }
    }
}
