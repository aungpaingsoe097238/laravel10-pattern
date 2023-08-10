<?php

namespace App\Services\VideoService;

use OSS\OssClient;

class OSSVideoService
{
    /**
     * Public Disk Video Uploaded
     */
    public function uploadVideo($video, $path = 'uploads/videos', $fileName = null)
    {
        $accessKeyId = 'LTAI5tSZWuqQrCkACVCkdhug';
        $accessKeySecret = '5IIQ44umnRIq2aK4MDsvkRemDKRbmf';
        $bucket = 'coursia-demo-video';
        $endpoint = 'oss-ap-southeast-1.aliyuncs.com';

        $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
        $currentDate = now()->toDateString();
        $unique_file_name = date("Y") . date("m") . date("d") . "-" . substr(number_format(time() * mt_rand(), 0, '', ''), 0, 10) . "-" . $video->getClientOriginalName();

        $object = 'public/videos/' . $currentDate . '/' . $unique_file_name;

        $ali_response = $ossClient->uploadFile($bucket, $object, $video->getPathname());

        return $ali_response;
    }
}
