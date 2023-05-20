@extends('frontend.layouts.main') 
@section('content')


@push('head')

        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/fullwidth/skin.css') }}" />

    @endpush



@include('frontend.include.slider')
<div class="content-left">
  <div class="block-tab">
    <ul class="tab">
      <li data-tab="left-tab-1" class="Recently selected">Recently Drama</li>
      <li class="Added" data-tab="left-tab-2">Recently Movie</li>
      <li class="Kshow" data-tab="left-tab-3">Recently Kshow</li>
    </ul>
    <ul class="switch-view">
      <li class="selected" data-view="list-episode-item"></li>
      <li data-view="list-episode-item-2"></li>
    </ul>
    <div class="block tab-container">
      <div class="tab-content left-tab-1 selected">
        <ul class="switch-block list-episode-item">

        		@foreach($episode as $row)
        		<li>
              <a href="{{url('video-watch/'.$row['slug'])}}" class="img" title="{{$row['drama']['title']}}">
                <img src="{{ asset('frontend/images/background.jpg') }}" class="lazy" alt="{{$row['title']}}" data-original="{{asset('public/storage/drama/'.$row['drama']['icon'])}}" />                <span class="type {{$row['type']==1?'SUB':'RAW'}}">{{$row['type']==1?'SUB':'RAW'}}</span>
                <h3 class="title" onclick="window.location = {{$row['slug']}}">{{$row['drama']['title']}}</h3>
                <span class="time"> {{ $row['updated_at']?$row['updated_at']->diffForHumans():'-' }}  </span>
                <span class="ep {{$row['type']==1?'SUB':'RAW'}}">EP {{$row['episodes_no']}}</span>
              </a>
            </li>

            

        		@endforeach
                    
       </ul>
        <div class="view-more"><a href="{{url('recently-added/drama')}}" title="Recently Added Drama">View more</a></div>
      </div>
      <div class="tab-content left-tab-2">
        <ul class="switch-block list-episode-item">

        	@foreach($videos as $row)

          <?php
          // echo "<pre>";
          // print_r($row);
          // die();
          ?>
        		<li>
              <a href="{{url('movie-watch/'.$row['slug'])}}" class="img" title="{{$row['title']}}">
                <img src="{{ asset('frontend/images/background.jpg') }}" class="lazy" alt="{{$row['title']}}" data-original="{{asset('public/storage/drama/'.$row['icon'])}}" />                <span class="type {{$row['movie_sub']==1?'SUB':'RAW'}}">{{$row['movie_sub']==1?'SUB':'RAW'}}</span>
                <h3 class="title" onclick="window.location = {{$row['slug']}}">{{$row['title']}}</h3>
                <span class="time"> {{ $row['updated_at']?$row['updated_at']->diffForHumans():'-'}}  </span>
                <span class="ep {{$row['movie_sub']==1?'SUB':'RAW'}}">EP 1</span>
              </a>
            </li>

        		@endforeach
        </ul>
        <div class="view-more"><a href="{{url('recently-added/movie')}}" title="Recently Added Movie">View more</a></div>
      </div>
	  <div class="tab-content left-tab-3">
		<ul class="switch-block list-episode-item">


			@foreach($kshow_drama as $key=> $row)
        		<li>
              <a href="{{url('video-watch/'.$row['slug'])}}" class="img" title="{{$row['title']}}">
                <img src="{{ asset('frontend/images/background.jpg') }}" class="lazy" alt="{{$row['title']}}" data-original="{{asset('public/storage/drama/'.$row['drama']['icon'])}}" />                <span class="type {{$row['type']==1?'SUB':'RAW'}}">{{$row['type']==1?'SUB':'RAW'}}</span>
                <h3 class="title" onclick="window.location = {{$row['slug']}}">{{$row['drama']['title']}}</h3>
                <span class="time"> {{ $row['updated_at']?$row['updated_at']->diffForHumans():'-'}}  </span>
                <span class="ep {{$row['type']==1?'SUB':'RAW'}}">EP {{$row['episodes_no']}}</span>
              </a>
            </li>

        		@endforeach

		
		  			
		 </ul>
		<div class="view-more">
		  <a href="{{url('recently-added/kshow')}}" title="Recently Added Kshow">View more</a>
		</div>
		
	  </div>
    </div>
  </div>

  <div class="block-tab">
	<ul class="tab">
	  <li data-tab="left-tab-4" class="selected">Most Popular Series</li>
	</ul>
	<div class="block tab-container list-popular">
	  <div class="tab-content left-tab-4 selected">
		<ul>  
          @if(count($popular)>0)
          @foreach($popular as $row)
          <li><a href="{{url('drama-detail/'.$row['slug'])}}" title="{{$row['title']}}">{{$row['title']}}</a></li>
          @endforeach
          @endif
		  		</ul>
		<div class="view-more">
		  <a href="{{url('most-popular-drama')}}" title="Popular Drama">View more</a>
		</div>
	  </div>
	</div>
  </div>

        </div>

    @include('frontend.include.rightbar')



 <!-- push external js -->
    @push('script')  


  <script type="text/javascript" src="{{ asset('frontend/plugins/slideshow/js/greensock096a.js?v=4.7') }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/plugins/slideshow/js/layerslider.transitions096a.js?v=4.7') }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/plugins/slideshow/js/layerslider.kreaturamedia.jquery096a.js?v=4.7') }}"></script>

  <script>
    $(window).on('load', function () {
      $("#layerslider").layerSlider({
        skin: '/fullwidth',
        autoPlayVideos: false,
        firstLayer: 'random',
        skinsPath: '{{ asset("frontend/css/") }}'
      });
    });
  </script>
     @endpush
@endsection