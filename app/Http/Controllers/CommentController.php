<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Session;
use Redirect;
use App\Events\CommentWritten;

class CommentController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $comments = DB::table('comments')->where('user_id', '=', Session::get('user')['id'])->get()->toArray();
            
            if(empty($comments) != 1){
                $comments = $comments[0];
            }
            $data = [
                'comments' => $comments,
                'posted' => Session::get('user')['completedLessons']
            ];
            // print_r($data['comments']->id); exit;

            return view("comments")->with($data);
        }

        return redirect("login");
        
    }

    // public function postComment(Request $request)
    // {
    //     $request->validate([
    //         'comment' => 'required'
    //     ]);

    //     $user = Session::get('user');
    //     $data = $request->all();
    //     $data['id'] = $user['id'];
    //     $check = $this->create($data); 

    //     $postedComments = DB::table('comments')->where('user_id', '=', $user['id'])->get()->toArray();
    //     Session::put('user', ['useremail'=> $user['useremail'], 'username'=> $user['username'], 'id'=> $user['id'], 'completedLessons'=>$user['completedLessons'], 'postedComments' => $postedComments]);
            
    //     return redirect("comments");
    // }

    public function postComment(Request $request)
    {
        $request->validate([
            'comment' => 'required'
        ]);

        $user = Session::get('user');
        $data = $request->all();
        $data['id'] = $user['id'];
        $check = $this->create($data); 

        $postedComments = DB::table('comments')->where('user_id', '=', $user['id'])->get()->toArray();
        Session::put('user', ['useremail'=> $user['useremail'], 'username'=> $user['username'], 'id'=> $user['id'], 'completedLessons'=>$user['completedLessons'], 'postedComments' => $postedComments]);

        $event = [
            'body' => $request->input('comment'), 
            'user_id' => $user['id']
        ];
        
        event(new CommentWritten($event));

        return redirect("comments");
    }

    public function create(array $data)
    {
      return Comment::create([
        'body' => $data['comment'],
        'user_id' => $data['id'],
      ]);
    }
}
