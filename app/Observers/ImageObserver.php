<?php

namespace App\Observers;

use App\Jobs\OptimizeImageJob;
use App\Models\Image;

class ImageObserver
{
    /**
     * Handle the Image "created" event.
     */
    public function created(Image $image): void
    {
        if ($image->mime_type !== 'image/webp') {
            OptimizeImageJob::dispatch($image)->onQueue('images');
        }
    }

    /**
     * Handle the Image "updated" event.
     */
    public function updated(Image $image): void
    {
        //
    }

    /**
     * Handle the Image "deleted" event.
     */
    public function deleted(Image $image): void
    {
        //
    }

    /**
     * Handle the Image "restored" event.
     */
    public function restored(Image $image): void
    {
        //
    }

    /**
     * Handle the Image "force deleted" event.
     */
    public function forceDeleted(Image $image): void
    {
        //
    }
}
