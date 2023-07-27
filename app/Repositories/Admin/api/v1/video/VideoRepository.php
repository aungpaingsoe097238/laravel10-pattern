<?php

namespace App\Repositories\Admin\api\v1\video;

use App\Models\Video;
use App\Services\LocalVideoService;
use App\Repositories\BaseRepository;
use App\Services\OSSVideoService;
use Illuminate\Support\Facades\Auth;

class VideoRepository extends BaseRepository
{
    protected $localVideoSerrvice, $ossVideoService;

    public function __construct(Video $video, LocalVideoService $localVideoService, OSSVideoService $ossVideoService )
    {
        parent::__construct($video);
        $this->localVideoSerrvice = $localVideoService;
        $this->ossVideoService = $ossVideoService;
    }

    /**
     *  Upload OSS Video
     */
    public function uploadOssVideo($video)
    {
        $videoData = $this->ossVideoService->uploadVideo($video['video']);
        return $videoData;
        $video = Video::create($videoData + ['user_id' => Auth::user()->id]);
        return $video;
    }

    /**
     *  Delete OSS Video
     */
    public function deleteOssVideo(Video $video)
    {
        // $videoData = $this->ossVideoService->deleteVideo($video['full_url']);
        // if($videoData){
        //     $video->delete();
        // }
    }

    /**
     *  Upload Local Video
     */
    public function uploadLocalVideo($video)
    {
        $videoData = $this->localVideoSerrvice->uploadVideo($video['video']);
        $video = Video::create($videoData + ['user_id' => Auth::user()->id]);
        return $video;
    }

    /**
     *  Delete Local Video
     */
    public function deleteLocalVideo(Video $video)
    {
        $videoData = $this->localVideoSerrvice->deleteVideo($video['full_url']);
        if($videoData){
            $video->delete();
        }
    }
}
