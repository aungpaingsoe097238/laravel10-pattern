<?php

namespace App\Repositories\Admin\api\v1\image;

use App\Models\Image;
use App\Services\OSSImageService;
use App\Repositories\BaseRepository;
use Auth;

class ImageRepository extends BaseRepository
{
    protected $ossImageService;

    public function __construct(Image $image, OSSImageService $ossImageService)
    {
        parent::__construct($image);
        $this->ossImageService = $ossImageService;
    }

    public function uploadImage($data)
    {
        $response = $this->ossImageService->uploadImageFile($data['image']);
        $image = Image::create($response + ['user_id' => Auth::user()->id]);
        return $image;
    }

    public function deleteImage(Image $image)
    {
        $data = $this->ossImageService->deleteImage($image['full_url']);
        if ($data) {
            $image->delete();
        }
    }
}
