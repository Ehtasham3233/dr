@extends('layouts.main') 
@section('title', 'Episode Fetch')
@section('content')

 @php
         $segment1 = request()->segment(1);
         $segment2 = request()->segment(2);
         $segment3 = request()->segment(3);

    @endphp

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="fas fa-tv bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Fatch Episode')}}</h5>
                            <span>{{ __('Fatch all episodes')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Fatch Episode')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>


        <div class="row">

                <!-- start message area-->
            @include('include.message')
            <!-- end message area-->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        
                        <h3>{{ __('Fetch Episode Status')}}</h3>
                    </div>
                    <div class="card-body">
                       <div class="row">
                    @if(isset($responsedata))     
                       @if(count($responsedata)>0) 
                        @foreach($responsedata as $episode)
                        <div class="col-md-6">
                        <div class="card-title"> <h3>{{$episode['episode_title']}}</h3></div>

                        @foreach($episode['episode_server'] as $server)
                        <p><b>{{$server}} Video Inserted Successfully</b></p>
                        @endforeach
    
                        </div> 
                        @endforeach
                        @endif

                        @else
                            <p><b>All Episodes Fatch No More Episodes Found To Update!</b></p>
                         @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    @endsection