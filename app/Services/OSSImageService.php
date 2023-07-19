<?php

namespace App\Services;

use OSS\OssClient;
use OSS\Core\OssException;

class OSSImageService
{
    private $ossClient;
    private $bucket;
    private $endpoint;

    public function __construct()
    {
        $this->bucket = env('OSS_BUCKET');
        $this->endpoint = env('OSS_ENDPOINT');
        $accessKeyId = env('OSS_ACCESS_ID');
        $accessKeySecret = env('OSS_ACCESS_KEY');
        $this->ossClient = new OssClient($accessKeyId, $accessKeySecret, $this->endpoint);
    }

    /**
     *  Base64 File
     */
    public function uploadImageBase64($imageData, $path = 'uploads', $fileName = null, $acl = null)
    {
        $decodedImage = base64_decode($imageData);
        return $this->uploadImage($decodedImage, $path, $fileName, $acl);
    }

    /**
     *  Normal File
     */
    public function uploadImageFile($image, $path = 'uploads', $fileName = null, $acl = null)
    {
        $fileContents = base64_decode($image->getPathname());
        return $this->uploadImage($fileContents, $path, $fileName, $acl);
    }

    /**
     *  Delete File From OSS Cloud
     */
    public function deleteImage($imageUrl)
    {
        $path = $this->getPathFromUrl($imageUrl);
        $this->ossClient->deleteObject($this->bucket, $path);
        return true;
    }

    /**
     *  Upload File To OSS
     */
    private function uploadImage($imageContents, $path, $fileName, $acl)
    {
        if (!$fileName) {
            $fileName = time() . '.jpg';
        }

        $fullPath = $path . '/' . $fileName;

        $this->ossClient->putObject($this->bucket, $fullPath, $imageContents, [
            OssClient::OSS_HEADERS => [
                'x-oss-object-acl' => $acl ?: OssClient::OSS_ACL_TYPE_PUBLIC_READ,
            ],
        ]);

        $fullUrl = $this->getFullUrl($fullPath);
        $mimeType = finfo_buffer(finfo_open(), $imageContents, FILEINFO_MIME_TYPE);
        $size = strlen($imageContents);

        return [
            'file_name' => $fileName,
            'full_url' => $fullUrl,
            'mime_type' => $mimeType,
            'size' => $size,
        ];
    }

    private function getFullUrl($path)
    {
        return env('OSS_URL') . '/' . $path;
    }

    private function getPathFromUrl($url)
    {
        return str_replace(env('OSS_URL') . '/', '', $url);
    }
}
