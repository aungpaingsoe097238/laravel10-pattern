<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LocalVideoService
{
    /**
     * Public Disk Video Uploaded
     */
    public function uploadVideo($video, $path = 'uploads/videos', $fileName = null)
    {
        $fileName = $fileName ?: Str::random(20) . '.' . $video->getClientOriginalExtension();
        $video->storeAs('public/' . $path, $fileName);
        $fullUrl = $this->getFullUrl($path . '/' . $fileName);
        $mimeType = $video->getClientMimeType();
        $diskType = "local";
        $size = $video->getSize();

        return [
            'file_name' => $fileName,
            'full_url' => $fullUrl,
            'mime_type' => $mimeType,
            'disk_type' => $diskType,
            'size' => $size,
        ];
    }

    /**
     * Public Disk Video Deleted
     */
    public function deleteVideo($videoUrl)
    {
        $path = $this->getPathFromUrl($videoUrl);
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
