<?php

namespace App\Providers;

use App\Models\Post;
use App\Observers\PostObserver;
use App\Repositories\BaseRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Repositories\BaseRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BaseRepositoryInterface::class,BaseRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {   
        Post::observe(PostObserver::class);
        
        Validator::extend('image64', function ($attribute, $value, $parameters, $validator) {
            $decodedImage = base64_decode($value);
            $f = finfo_open();
            $mime_type = finfo_buffer($f, $decodedImage, FILEINFO_MIME_TYPE);

            return str_starts_with($mime_type, 'image/');
        });
    }
}
