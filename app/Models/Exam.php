<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the results for the exam.
     */
    public function results()
    {
        return $this->hasMany(Result::class);
    }

    /**
     * Get the user that owns the exams.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subject that owns the exams.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Check if a user own exam
     * @return boolean
     */
    public function isOwnExam()
    {
        return auth()->check() && auth()->id() == $this->user_id;
    }
}
