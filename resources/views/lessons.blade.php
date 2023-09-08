@extends('layout')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card m-2">
                <div class="card-header">
                    Lessons completed: {{count(Session::get('user')['completedLessons'])}}
                    <a href="{{ url('dashboard') }}" style="float: right">Go Back</a>
                </div>

                <div class="card-body text-center">
                    <table style="width:100%">
                    @foreach ($lessons as $lesson)
                        <tr>
                            <td>{{$lesson->title}}</td>
                            <td> 
                            @if(in_array($lesson->id, $completed))         
                            <a>Completed</a>        
                            @else
                                <a href="{{ url('complete-lesson/'.$lesson->id) }}" >Watch Video</a>      
                            @endif
                                
                            </td>
                        </tr>
                    @endforeach
                        
                    </table>
                    
                    
                </div>
            </div>

        </div>
    </div>
</div>

@endsection