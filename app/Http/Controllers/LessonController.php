<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Session;
use Redirect;

class LessonController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $data = [
                'lessons' => DB::select('select * from lessons'),
                'completed' => Session::get('user')['completedLessons']
            ];
            return view("lessons")->with($data);
        }

        return redirect("login");
        
    }

    public function completeLesson($lessonId)
    {
        $user = Session::get('user');
        $data = ['user_id'=>$user['id'], 'lesson_id'=>$lessonId, 'watched'=>'1'];
        $check = DB::table('lesson_user')->insert($data);
        $completed = DB::table('lesson_user')
                    ->select('lesson_id')
                    ->where('user_id', '=', Session::get('user')['id'])
                    ->get();
        Session::put('user', ['useremail'=> $user['useremail'], 'username'=> $user['username'], 'id'=> $user['id'], 'completedLessons'=>$completed->pluck('lesson_id')->toArray()]);
        return Redirect::back();           
    }
}
