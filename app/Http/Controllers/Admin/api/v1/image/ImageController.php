<?php

namespace App\Http\Controllers\Admin\api\v1\image;

use App\Models\Image;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\api\v1\image\StoreImageRequest;
use App\Http\Resources\Admin\api\v1\image\ImageCollection;
use App\Http\Resources\Admin\api\v1\image\ImageResource;
use App\Repositories\Admin\api\v1\image\ImageRepository;

class ImageController extends Controller
{
    protected $imageRepository;
    protected $with = [];

    public function __construct(ImageRepository $imageRepository)
    {
        $this->with = ['user'];
        $this->imageRepository = $imageRepository;
        $this->middleware('permission:image-list', ['only' => ['index','show']]);
        $this->middleware('permission:image-create', ['only' => ['create','store']]);
        $this->middleware('permission:image-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:image-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $images = $this->imageRepository->getAll();
        return new ImageCollection($images->load($this->with));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImageRequest $request)
    {
        $image = $this->imageRepository->uploadImage($request->validated());
        return new ImageResource($image->load($this->with));
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        $image = $this->imageRepository->get($image);
        return new ImageResource($image->load($this->with));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        $image = $this->imageRepository->deleteImage($image);
        return new ImageResource($image);
    }
}
