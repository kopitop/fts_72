<?php

namespace App\Listeners;

use App\Events\ExamChecked;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use wataridori\ChatworkSDK;
use Illuminate\Support\Facades\Mail;

class SendExamCheckedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ExamChecked  $event
     * @return void
     */
    public function handle(ExamChecked $event)
    {
        $user = $event->exam->user;

        //Send notif through chatwork
        ChatworkSDK\ChatworkSDK::setApiKey(config('services.chatwork.client_id'));
        $chatwork = new ChatworkSDK\ChatworkApi();
        $chatwork->createRoomMessage(config('services.chatwork.group_id'), trans('messages.exam-checked', [
            'user' => $user->name,
            'score' => $event->exam->score,
        ]));

        //Send notif through email
        Mail::to($user)->send(new \App\Mail\ExamChecked($event->exam));
    }
}
