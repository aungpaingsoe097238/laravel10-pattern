<?php

namespace App\Services\ImageService;

use OSS\OssClient;

class OSSImageService
{
    private $ossClient;
    private $bucket;
    private $endpoint;
    private $defaultACL = 'public-read';

    public function __construct()
    {
        $this->bucket = env('OSS_BUCKET');
        $this->endpoint = env('OSS_ENDPOINT');
        $accessKeyId = env('OSS_ACCESS_ID');
        $accessKeySecret = env('OSS_ACCESS_KEY');
        $this->ossClient = new OssClient($accessKeyId, $accessKeySecret, $this->endpoint);
    }

    /**
     * OSS Image Uploaded
     */
    public function uploadImage($image, $path = 'uploads/images', $fileName = null, $acl = null)
    {
        if (!$fileName) {
            $fileName = time() . '_' . $image->getClientOriginalName();
        }

        $fullPath = $path . '/' . $fileName;

        $this->ossClient->uploadFile($this->bucket, $fullPath, $image->getPathname(), [
            OssClient::OSS_HEADERS => [
                'x-oss-object-acl' => $acl ?: $this->defaultACL,
            ],
        ]);

        $fullUrl = $this->getFullUrl($fullPath);
        $mimeType = $image->getMimeType();
        $diskType = "oss";
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
     * OSS Image Deleted
     */
    public function deleteImage($imageUrl)
    {
        $path = $this->getPathFromUrl($imageUrl);
        $this->ossClient->deleteObject($this->bucket, $path);
        return true;
    }

    private function getFullUrl($path)
    {
        // Construct the full URL using the endpoint and bucket
        return "https://{$this->bucket}.{$this->endpoint}/$path";
    }

    private function getPathFromUrl($url)
    {
        return str_replace("https://{$this->bucket}.{$this->endpoint}/", '', $url);
    }
}
