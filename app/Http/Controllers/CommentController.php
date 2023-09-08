<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Session;
use Redirect;

class CommentController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $data = [
                'comments' => DB::table('comments')->where('user_id', '=', Session::get('user')['id'])->get()->toArray()[0],
                'posted' => Session::get('user')['completedLessons']
            ];
            // print_r($data['comments']->id); exit;
            return view("comments")->with($data);
        }

        return redirect("login");
        
    }

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
