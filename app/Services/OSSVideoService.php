<?php

namespace App\Services;

use OSS\OssClient;

class OSSVideoService
{
    public function uploadVideo($video)
    {
        $accessKeyId = 'LTAI5tSZWuqQrCkACVCkdhug';
        $accessKeySecret = '5IIQ44umnRIq2aK4MDsvkRemDKRbmf';
        $bucket = 'coursia-demo-video';
        $endpoint = 'oss-ap-southeast-1.aliyuncs.com';

        $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);

        $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);

        $currentDate = now()->toDateString();
        $unique_file_name = date("Y") . date("m") . date("d") . "-" . substr(number_format(time() * mt_rand(), 0, '', ''), 0, 10) . "-" . $video->getClientOriginalName();

        $object = 'public/videos/' . $currentDate . '/' . $unique_file_name;

        $ali_response = $ossClient->uploadFile($bucket, $object, $video->getPathname());

        $result = [];
        $result['video_url'] = $ali_response['info']['url'];
        $result['file_size'] = $ali_response['info']['size_upload'];
        $result['original_filename'] = $video->getClientOriginalName();

        return response()->json([
            'message' => 'success',
            'status'  => true,
            'result'  => $result
        ]);
    }
}
