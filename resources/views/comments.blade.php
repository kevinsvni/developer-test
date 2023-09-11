@extends('layout')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card m-2">
                <div class="card-header">
                    Comments Posted: 
                    <a href="{{ url('dashboard') }}" class="float-right">Go Back</a>
                </div>

                <div class="card-body">
                    <div>
                        <form action="{{ route('comment.post') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <textarea class="form-control" id="comment" rows="1" name="comment" required autofocus></textarea>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    Post
                                </button>
                            </div>
                        </form>
                    </div>
                    <hr class='mt-4'>
                    <div class='mt-3'>
                        <div class="mb-3">Your Comments ({{count(Session::get('user')['postedComments'])}}):</div>

                        <?php 
                        $comments = Session::get('user')['postedComments']; 
                        $user = Session::get('user');
                        $isComment = count($comments);
                        ?>
                        @if($isComment != 0)   
                            @foreach ($comments as $comment)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        {{ $comment->body }}
                                        <a class="small float-right">~ {{ $user['username'] }}</a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            You have not commented yet
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection