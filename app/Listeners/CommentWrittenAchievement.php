<?php

namespace App\Listeners;

use App\Events\CommentWritten;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Session;

class CommentWrittenAchievement
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CommentWritten $event)
    {
        // $user = Session::get('user');
        // $noOfComments = count($user['postedComments']);

        // // $userAch = Session::get('user_cmnt_ach');

        // if($noOfComments >=1 && $noOfComments < 3){
        //     $old_ach = 0;
        //     $current_ach = 1;
        //     $upcoming_ach = 2;
        // }elseif($noOfComments >=3 && $noOfComments < 5){
        //     $old_ach = 1;
        //     $current_ach = 2;
        //     $upcoming_ach = 3;
        // }elseif($noOfComments >=5 && $noOfComments < 10){
        //     $old_ach = 2;
        //     $current_ach = 3;
        //     $upcoming_ach = 4;
        // }elseif($noOfComments >=10 && $noOfComments < 20){
        //     $old_ach = 3;
        //     $current_ach = 4;
        //     $upcoming_ach = 5;
        // }elseif($noOfComments >=20){
        //     $old_ach = 4;
        //     $current_ach = 5;
        //     $upcoming_ach = 5;
        // }else{
        //     $old_ach = 0;
        //     $current_ach = 0;
        //     $upcoming_ach = 0;
        // }

        // $ary = ['old_ach'=> $old_ach, 'current_ach'=> $current_ach, 'upcoming_ach'=> $upcoming_ach];
        // Session::put('user_cmnt_ach', $ary);

        // return $ary;
    }
}
