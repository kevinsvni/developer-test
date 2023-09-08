@extends('layout')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card m-2">
                <div class="card-header"><h5 class="mb-1 text-center" style="font-family: Raleway, sans-serif;">D  A  S  H  B  O  A  R  D</h5></div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table style="width:100%">
                        <tr>
                            <td>You have learned {{count(Session::get('user')['completedLessons'])}} lessons.</td>
                            <td>
                                <a href="{{ url('lessons') }}">All Lessons</a>
                            </td>
                        </tr>
                        <tr>
                            <td>You have written {{count(Session::get('user')['postedComments'])}} comments.</td>
                            <td> 
                                <a href="{{ url('comments') }}">Comments</a>
                            </td>
                        </tr>
                    </table>
                    
                    
                </div>

            </div>

            

        </div>
    </div>
</div>

@endsection


<hr class="w-50 mx-auto mb-3 mb-xl-9 border-dark-subtle">
