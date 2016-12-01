<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer as Mail;
use wataridori\ChatworkSDK;
use App\Models\Exam;

class SendExamReport implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $exam;
    protected $mail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        Exam $exam
    )
    {
        $this->exam = $exam;    
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mail $mail)
    {
        $user = $this->exam->user;

        //Send notif through chatwork
        ChatworkSDK\ChatworkSDK::setApiKey(config('services.chatwork.client_id'));
        $chatwork = new ChatworkSDK\ChatworkApi();
        $chatwork->createRoomMessage(config('services.chatwork.group_id'), trans('messages.exam-checked', [
            'user' => $user->name,
            'score' => $this->exam->score,
        ]));

        //Send notif through email
        $mail->to($user)->send(new \App\Mail\ExamChecked($this->exam));
    }
}
