<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Result extends Model
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
     * Get the exam answers for the result.
     */
    public function examAnswers()
    {
        return $this->hasMany(ExamAnswer::class);
    }

    /**
     * Get the exam that owns the result.
     */
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    /**
     * Get the question that owns the result.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
