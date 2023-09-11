@extends('layout')

@section('content')

@php
    use App\Http\Controllers\AchievementsController;
    $achievementsController = new AchievementsController;
    $user = App\Models\User::find(Session::get('user')['id']);
    $jsonData = $achievementsController->index($user);
    $data = $jsonData->getData();

    $unlockedLessonWatchedAchs = $data->unlocked_achievements_all_earned->lessonWatcedAchievements;	
    $unlockedCommentsWrittenAchs = $data->unlocked_achievements_all_earned->commentWrittenAchievements;	
    $upcomingAchievements = $data->next_available_achievements;	

    $unlockedBadgesAllEarned = $data->unlockedBadgesAllEarned;
@endphp
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

            <div class="card m-2">
                <div class="card-header"><h5 class="mb-1 text-center" style="font-family: Raleway, sans-serif;">A  C  H  I  E  V  E  M  E  N  T  S</h5></div>
                <div class="card-body">
                    Lessons Watched Achievements:
                    <div class="row mt-3" style="justify-content: center;">
                        @if(count($unlockedLessonWatchedAchs)!=0)
                            @foreach($unlockedLessonWatchedAchs as $lessonWatched)
                            <div class="col-4 col-lg-3">
                                <div class="text-center">
                                    <div class="d-flex align-items-center justify-content-center mb-3 mx-auto bsb-circle">
                                        <i class="fa fa-star badge-custom" aria-hidden="true"></i>
                                    </div>
                                    <p class="display-6 fw-bold m-1">{{$lessonWatched}}</p>
                                    <p class="text-secondary m-0">Achieved</p>
                                </div>
                            </div>
                            @endforeach
                        @endif
                        <div class="col-4 col-lg-3">
                            <div class="text-center">
                                <div class="d-flex align-items-center justify-content-center mb-3 mx-auto bsb-circle">
                                    <i class="fa fa-star-half-o badge-custom" aria-hidden="true"></i>
                                </div>
                                <p class="display-6 fw-bold m-1">{{$upcomingAchievements[0]}}</p>
                                <p class="text-secondary">In Progress</p>
                            </div>
                        </div>
                    </div>

                    <hr class="w-50 mx-auto mb-3 mb-xl-9 border-dark-subtle">
                    Comments Written Achievements:
                    <div class="row mt-3" style="justify-content: center;">
                        @if(count($unlockedCommentsWrittenAchs)!=0)
                            @foreach($unlockedCommentsWrittenAchs as $commentsWritten)
                            <div class="col-4 col-lg-3">
                                <div class="text-center">
                                    <div class="d-flex align-items-center justify-content-center mb-3 mx-auto bsb-circle">
                                        <i class="fa fa-star badge-custom" aria-hidden="true"></i>
                                    </div>
                                    <p class="display-6 fw-bold m-1">{{$commentsWritten}}</p>
                                    <p class="text-secondary m-0">Achieved</p>
                                </div>
                            </div>
                            @endforeach
                        @endif
                        <div class="col-4 col-lg-3">
                            <div class="text-center">
                                <div class="d-flex align-items-center justify-content-center mb-3 mx-auto bsb-circle">
                                    <i class="fa fa-star-half-o badge-custom" aria-hidden="true"></i>
                                </div>
                                <p class="display-6 fw-bold m-1">{{$upcomingAchievements[1]}}</p>
                                <p class="text-secondary">In Progress</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card m-2">
                <div class="card-header"><h5 class="mb-1 text-center" style="font-family: Raleway, sans-serif;">B  A  D  G  E  S</h5></div>
                <div class="card-body">
                    <?php
                    // print_r($data);
                    ?>

                    <div class="row" style="justify-content: center;">
                        @if(count($unlockedBadgesAllEarned)!=0)
                            @foreach($unlockedBadgesAllEarned as $badge)
                            <div class="col-4 col-lg-3">
                                <div class="text-center">
                                    <div class="d-flex align-items-center justify-content-center mb-3 mx-auto bsb-circle">
                                        <i class="fa fa-star badge-custom" aria-hidden="true"></i>
                                    </div>
                                    <p class="display-6 fw-bold m-1">{{$badge}}</p>
                                    <p class="text-secondary m-0">Achieved</p>
                                </div>
                            </div>
                            @endforeach
                        @endif
                        <div class="col-4 col-lg-3">
                            <div class="text-center">
                                <div class="d-flex align-items-center justify-content-center mb-3 mx-auto bsb-circle">
                                    <i class="fa fa-star-half-o badge-custom" aria-hidden="true"></i>
                                </div>
                                <p class="display-6 fw-bold m-1">{{$data->next_badge}}</p>
                                <p class="text-secondary">In Progress</p>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

@endsection



