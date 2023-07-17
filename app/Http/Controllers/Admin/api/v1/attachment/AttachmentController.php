<?php

namespace App\Http\Controllers\Admin\api\v1\attachment;

use OSS\OssClient;
use OSS\Core\OssException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttachmentController extends Controller
{
    public function index()
    {
        $accessKeyId = env('OSS_ACCESS_ID');
        $accessKeySecret = env('OSS_ACCESS_KEY');
        $endpoint = env('OSS_ENDPOINT');
        $bucket = env('OSS_BUCKET');
        $cdnDomain = env('OSS_URL');

        try {
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);

            $objects = $ossClient->listObjects($bucket);

            $files = [];
            foreach ($objects->getObjectList() as $object) {
                $url = $cdnDomain . '/' . $object->getKey();
                $files[] = $url;
            }

            return response()->json([
                'message' => 'List of uploaded files',
                'files' => $files,
            ]);
        } catch (OssException $e) {
            throw new \Exception('Failed to retrieve files: ' . $e->getMessage());
        }
    }

        /**
     * Get the public URL of an uploaded file.
     */
    private function getPublicUrl($path)
    {
        $cdnDomain = env('OSS_URL');

        return $cdnDomain . '/' . $path;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $path = $this->uploadFile($request->file);

        return response()->json([
            'message' => 'File uploaded successfully',
            'path' => $path,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $path)
    {
        $this->deleteFile($path);

        return response()->json([
            'message' => 'File deleted successfully',
        ]);
    }

    /**
     * Upload a file to Aliyun OSS.
     */
    private function uploadFile($file)
    {
        $path = $this->generateFilePath($file);

        try {
            $this->ossClient()->uploadFile($this->bucket(), $path, $file->getPathname(), [
                OssClient::OSS_HEADERS => [
                    'x-oss-object-acl' => 'public-read',
                ],
            ]);
            // $this->ossClient()->uploadFile($this->bucket(), $path, $file->getPathname());
            $url = $this->getPublicUrl($path);
            return $url;
        } catch (\Exception $e) {
            throw new \Exception('Failed to upload file: ' . $e->getMessage());
        }
    }

    /**
     * Delete a file from Aliyun OSS.
     */
    private function deleteFile($path)
    {
        try {
            $this->ossClient()->deleteObject($this->bucket(), $path);
        } catch (\Exception $e) {
            throw new \Exception('Failed to delete file: ' . $e->getMessage());
        }
    }

    /**
     * Get the Aliyun OSS client instance.
     */
    private function ossClient()
    {
        $accessKeyId = env('OSS_ACCESS_ID');
        $accessKeySecret = env('OSS_ACCESS_KEY');
        $endpoint = env('OSS_ENDPOINT');

        return new OssClient($accessKeyId, $accessKeySecret, $endpoint);
    }

    /**
     * Get the OSS bucket name.
     */
    private function bucket()
    {
        return env('OSS_BUCKET');
    }

    /**
     * Generate a unique file path.
     */
    private function generateFilePath($file)
    {
        return 'uploads/' . time() . '_' . $file->getClientOriginalName();
    }
}
