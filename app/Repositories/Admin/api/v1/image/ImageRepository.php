<?php

namespace App\Repositories\Admin\api\v1\image;

use App\Models\Image;
use App\Services\OSSImageService;
use App\Repositories\BaseRepository;
use App\Services\LocalImageService;
use Auth;

class ImageRepository extends BaseRepository
{
    protected $ossImageService, $localImageService;

    public function __construct(Image $image, OSSImageService $ossImageService, LocalImageService $localImageService)
    {
        parent::__construct($image);
        $this->ossImageService = $ossImageService;
        $this->localImageService = $localImageService;
    }

    /**
     * Upload OSS Image
     */
    public function uploadOssImage($data): Image
    {
        $imageData = $this->ossImageService->uploadImage($data['image']);
        $image = Image::create($imageData + ['user_id' => Auth::user()->id]);
        return $image;
    }

    /**
     *  Delete OSS Image
     */
    public function deleteOssImage(Image $image): void
    {
        $data = $this->ossImageService->deleteImage($image['full_url']);
        if ($data) {
            $image->delete();
        }
    }

    /**
     *  Upload Local Image
     */
    public function uploadLocalImage($data) : Image
    {
        $imageData = $this->localImageService->uploadImage($data['image']);
        $image = Image::create($imageData + ['user_id' => Auth::user()->id]);
        return $image;
    }

    /**
     *  Delete Local Image
     */
    public function deleteLocalImage(Image $image) : void
    {
        $data = $this->localImageService->deleteImage($image['full_url']);
        if ($data) {
            $image->delete();
        }
    }
}
