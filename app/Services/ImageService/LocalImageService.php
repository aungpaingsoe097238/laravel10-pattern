<?php

namespace App\Services\ImageService;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LocalImageService
{
    /**
     * Public Disk Image Uploaded
     */
    public function uploadImage($image, $path = 'uploads/images', $fileName = null)
    {
        $fileName = $fileName ?: Str::random(20) . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/' . $path, $fileName);
        $fullUrl = $this->getFullUrl($path . '/' . $fileName);
        $mimeType = $image->getClientMimeType();
        $diskType = "local";
        $size = $image->getSize();

        return [
            'file_name' => $fileName,
            'full_url' => $fullUrl,
            'mime_type' => $mimeType,
            'disk_type' => $diskType,
            'size' => $size,
        ];
    }

    /**
     * Public Disk Image Deleted
     */
    public function deleteImage($imageUrl)
    {
        $path = $this->getPathFromUrl($imageUrl);
        if ($path) {
            $fileExists = Storage::disk('public')->exists($path);

            if ($fileExists) {
                Storage::disk('public')->delete($path);
                return true;
            }
        }

        return false;
    }

    private function getFullUrl($path)
    {
        return asset('storage/' . $path);
    }

    private function getPathFromUrl($url)
    {
        $baseUrl = asset('storage/');
        if (Str::startsWith($url, $baseUrl)) {
            return Str::replaceFirst($baseUrl, '', $url);
        }

        return null;
    }
}
