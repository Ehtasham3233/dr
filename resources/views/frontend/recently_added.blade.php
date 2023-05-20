@extends('frontend.layouts.main') 
@section('content')
<div class="content">
        <div class="content-left">
            
  <div class="ads_place"></div>
  <div class="block-tab">
  <h1>Popular Drama</h1>

  <ul class="switch-view">
    <li class="selected" data-view="list-episode-item"></li>
    <li data-view="list-episode-item-2"></li>
  </ul>

  <div class="block tab-container">
    <div class="tab-content left-tab-1 selected">
    <ul class="switch-block list-episode-item">

      @if(count($dramas)>0)
      @foreach($dramas as $row)

        <?php
        if($datatype == 'drama')
        { 
          $url = url('video-watch/'.$row['slug']);
          $class = $row['type']==1?'SUB':'RAW';
          $title = $row['drama']['title'];
          $icon = $row['drama']['icon'];
          $episode_no = $row['episodes_no'];
          $time_ago = $row['updated_at']?$row['updated_at']->diffForHumans():'-';
        }
        else
        { 
          $url = url('video-watch/'.$row['slug']);
          $class = $row['movie_sub']==1?'SUB':'RAW';
          $title = $row['title'];
          $icon = $row['icon'];
          $episode_no = 1;
          $time_ago = $row['updated_at']?$row['updated_at']->diffForHumans():'-';
        }
        
        ?>
          <li>
              <a href="{{$url}}" class="img" title="{{$title}}">
                <img src="{{ asset('frontend/images/background.jpg') }}" class="lazy" alt="{{$title}}" data-original="{{asset('public/storage/drama/'.$icon)}}" /><span class="type {{$class}}">{{$class}}</span>
                <h3 class="title" onclick="window.location = {{$url}}">{{$title}}</h3>
                <span class="time"> {{ $time_ago }}  </span>
                <span class="ep {{$class}}">EP {{$episode_no}}</span>
              </a>
            </li>
      @endforeach
      @endif    
      </ul>
      @include('frontend.include.pagination',['pagination' => $dramas])
    </div>
  </div>
  </div>

    </div>
        @include('frontend.include.rightbar',['sidebar' => $sidebar])
    </div>

    @endsection

