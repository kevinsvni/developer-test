<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Session;
use DB;

use App\Events\CommentWritten;

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        // $userCommentAch = Session::all();
        // $userLessonAch = Session::get('user_lesson_ach');
        // print_r($userCommentAch);

        $commentWrittenAchievements = $this->getCommentWrittenAchievements($user);
        $lessonsWatchedAchievements = $this->getLessonsWatchedAchievements($user);

        $totalAchievements = $commentWrittenAchievements['count'] + $lessonsWatchedAchievements['count'];
        
        $badges = $this->getBadges($totalAchievements);

        return response()->json([
            'unlocked_achievements' => [
                'lessonWatcedAchievements'=>$lessonsWatchedAchievements['current_ach'], 
                'commentWrittenAchievements'=>$commentWrittenAchievements['current_ach']
            ],
            'next_available_achievements' => [$lessonsWatchedAchievements['upcoming_ach'], $commentWrittenAchievements['upcoming_ach']],
            'current_badge' => $badges['current_badge'],
            'next_badge' => $badges['upcoming_badge'],
            'remaing_to_unlock_next_badge' => $badges['remaining'],
            'unlocked_achievements_all_earned'=>[
                'lessonWatcedAchievements'=>$lessonsWatchedAchievements['unlockedAchievements'], 
                'commentWrittenAchievements'=>$commentWrittenAchievements['unlockedAchievements']
            ],
            'unlockedBadgesAllEarned' => $badges['unlockedBadgesAll']
        ]);
    }

    function getCommentWrittenAchievements($user){
        $postedComments = DB::table('comments')->where('user_id', '=', $user->id)->get()->toArray();
        $noOfComments = count($postedComments);
        $count = 0;

        if($noOfComments >=1 && $noOfComments < 3){
            $current_ach = 'First Comment Written';
            $upcoming_ach = '3 Comments Written';
            $count=1;
            $unlockedAchievements = ['First Comment Written'];
        }elseif($noOfComments >=3 && $noOfComments < 5){
            $current_ach = '3 Comments Written';
            $upcoming_ach = '5 Comments Written';
            $count=2;
            $unlockedAchievements = ['First Comment Written','3 Comments Written'];
        }elseif($noOfComments >=5 && $noOfComments < 10){
            $current_ach = '5 Comments Written';
            $upcoming_ach = '10 Comment Written';
            $count=3;
            $unlockedAchievements = ['First Comment Written','3 Comments Written','5 Comments Written'];
        }elseif($noOfComments >=10 && $noOfComments < 20){
            $current_ach = '10 Comment Written';
            $upcoming_ach = '20 Comment Written';
            $count=4;
            $unlockedAchievements = ['First Comment Written','3 Comments Written','5 Comments Written','10 Comment Written'];
        }elseif($noOfComments >=20){
            $current_ach = '20 Comment Written';
            $upcoming_ach = '';
            $count=5;
            $unlockedAchievements = ['First Comment Written','3 Comments Written','5 Comments Written','10 Comment Written','20 Comment Written'];
        }else{
            $current_ach = '';
            $upcoming_ach = 'First Comment Written';
            $count=0;
            $unlockedAchievements = [];
        }
        return [
            'current_ach'=>$current_ach, 
            'upcoming_ach'=>$upcoming_ach,
            'unlockedAchievements'=>$unlockedAchievements,
            'count'=>$count
        ];
    }

    function getLessonsWatchedAchievements($user){
        $watchedLessons = DB::table('lesson_user')->select('lesson_id')->where('user_id', '=', Session::get('user')['id'])->get();
        $noOfLessons = count($watchedLessons);

        if($noOfLessons >=1 && $noOfLessons < 5){
            $current_ach = 'First Lesson Watched';
            $upcoming_ach = '5 Lessons Watched';
            $count=1;
            $unlockedAchievements = ['First Lesson Watched'];
        }elseif($noOfLessons >=5 && $noOfLessons < 10){
            $current_ach = '5 Lessons Watched';
            $upcoming_ach = '10 Lessons Watched';
            $count=2;
            $unlockedAchievements = ['First Lesson Watched','5 Lessons Watched'];
        }elseif($noOfLessons >=10 && $noOfLessons < 25){
            $current_ach = '10 Lessons Watched';
            $upcoming_ach = '25 Lessons Watched';
            $count=3;
            $unlockedAchievements = ['First Lesson Watched','5 Lessons Watched','10 Lessons Watched'];
        }elseif($noOfLessons >=25 && $noOfLessons < 50){
            $current_ach = '25 Lessons Watched';
            $upcoming_ach = '50 Lessons Watched';
            $count=4;
            $unlockedAchievements = ['First Lesson Watched','5 Lessons Watched','10 Lessons Watched','25 Lessons Watched'];
        }elseif($noOfLessons >50){
            $current_ach = '50 Lessons Watched';
            $upcoming_ach = '';
            $count=5;
            $unlockedAchievements = ['First Lesson Watched','5 Lessons Watched','10 Lessons Watched','25 Lessons Watched','50 Lessons Watched'];
        }else{
            $current_ach = '';
            $upcoming_ach = 'First Lesson Watched';
            $count=0;
            $unlockedAchievements = [];
        }
        return [
            'current_ach'=>$current_ach, 
            'upcoming_ach'=>$upcoming_ach, 
            'unlockedAchievements'=>$unlockedAchievements,
            'count'=>$count
        ];
    }

    function getBadges($total){
        
        if($total>=1 && $total<3){
            $current_badge = 'Beginner';
            $upcoming_badge = 'Intermediate';
            $remaining=3-$total;
            $unlockedBadges = ['Beginner'];
        }elseif($total>=4 && $total<8){
            $current_badge = 'Intermediate';
            $upcoming_badge = 'Advanced';
            $remaining=8-$total;
            $unlockedBadges = ['Beginner','Intermediate'];
        }elseif($total>=8 && $total<10){
            $current_badge = 'Advanced';
            $upcoming_badge = 'Master';
            $remaining=10-$total;
            $unlockedBadges = ['Beginner','Intermediate','Advanced'];
        }elseif($total>=10){
            $current_badge = 'Master';
            $upcoming_badge = '';
            $unlockedBadges = ['Beginner','Intermediate','Advanced','Master'];
        }else{
            $current_badge = '';
            $upcoming_badge = 'Beginner';
            $remaining=1;
            $unlockedBadges = [];
        }

        return ['current_badge'=>$current_badge, 'upcoming_badge'=>$upcoming_badge, 'remaining'=>$remaining, 'unlockedBadgesAll'=>$unlockedBadges];
    }

}
