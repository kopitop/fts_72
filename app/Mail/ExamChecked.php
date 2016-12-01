<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Exam;

class ExamChecked extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The exam instance.
     *
     * @var Order
     */
    public $exam;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Exam $exam)
    {
        $this->exam = $exam;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('admin@fts.app')
            ->view('emails.exam.checked');
    }
}
