<?php

namespace App\Http\Controllers\Admin\api\v1\video;

use OSS\OssClient;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\api\v1\video\VideoResource;
use App\Repositories\Admin\api\v1\video\VideoRepository;
use App\Http\Resources\Admin\api\v1\video\VideoCollection;

class VideoController extends Controller
{

    protected $videoRepository;
    protected $with = [];

    public function __construct(VideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
        $this->with = ['user'];
        $this->middleware('permission:video-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:video-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:video-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:video-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = $this->videoRepository->getAll();
        return new VideoCollection($videos->load($this->with));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $video = $this->videoRepository->uploadLocalVideo($request);
        return new VideoResource($video->load($this->with));
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        $video = $this->videoRepository->get($video);
        return new VideoResource($video->load($this->with));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        $video = $this->videoRepository->deleteLocalVideo($video);
        return new VideoResource($video);
    }
}
