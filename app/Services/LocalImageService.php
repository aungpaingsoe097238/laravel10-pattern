<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LocalImageService
{
    /**
     * Public Disk Image Uploaded
     */
    public function uploadImage($image, $path = 'uploads', $fileName = null)
    {
        $fileName = $fileName ?: Str::random(20) . '.' . $image->getClientOriginalExtension();
        Storage::disk('public')->putFileAs($path, $image, $fileName);
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
        $fileExists = Storage::disk('public')->exists($path);

        if ($fileExists) {
            Storage::disk('public')->delete($path);
            return true;
        }

        return false;
    }

    private function getFullUrl($path)
    {
        return asset(Storage::disk('public')->url($path));
    }

    private function getPathFromUrl($url)
    {
        $baseUrl = asset('/');
        return str_replace($baseUrl, '', $url);
    }
}
