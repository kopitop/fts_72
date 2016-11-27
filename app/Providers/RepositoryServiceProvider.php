<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\SubjectRepository;
use App\Repositories\Contracts\SubjectRepositoryInterface;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\QuestionRepository;
use App\Repositories\Contracts\QuestionRepositoryInterface;
use App\Repositories\Eloquent\ExamRepository;
use App\Repositories\Contracts\ExamRepositoryInterface;
use App;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind(SubjectRepositoryInterface::class, SubjectRepository::class);
        App::bind(UserRepositoryInterface::class, UserRepository::class);
        App::bind(QuestionRepositoryInterface::class, QuestionRepository::class);
        App::bind(ExamRepositoryInterface::class, ExamRepository::class);
    }
}
