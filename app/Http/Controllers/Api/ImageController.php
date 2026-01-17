<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ImageUploadRequest;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index(Request $request)
    {
        $images = $request->user()->images()->latest()->paginate(20);

        return $this->succes($images);
    }

    public function show(Request $request, Image $image)
    {
        $this->authorize('view', $image);

        if (!Storage::exists($image->path)) {
            abort(404, 'file not found');
        }

        return Storage::response($image->path);
    }

    public function upload(ImageUploadRequest $request)
    {
        return DB::transaction(function () use ($request) {

            $file = $request->file('image');

            $hash = hash_file('sha256', $file->getRealPath());

            $image = Image::where('hash', $hash)->first();

            if (!$image) {
                $path = $file->store('images/original');

                $image = Image::create([
                    'path'      => $path,
                    'hash'      => $hash,
                    'size'      => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                ]);
            }

            $request->user()->images()->syncWithoutDetaching($image->id);

            return $this->succes([
                    'id' => $image->id,
                    'mime_type' => $image->mime_type,
                    'size' => $image->size,
                ],
                'Image uploaded successfully',
                201
            );

        });
    }

    public function destroy(Request $request, Image $image)
    {
        $this->authorize('delete', $image);

        $request->user()->images()->detach($image->id);

        if ($image->users()->count() === 0) {

            if (Storage::exists($image->path)) {
                Storage::delete($image->path);
            }

            $image->delete();
        }

        return $this->succes('Image deleted successfully');
    }
}
