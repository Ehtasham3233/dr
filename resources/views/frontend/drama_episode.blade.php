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
			<?php
			$type;
			if(isset($datatype)) {
				if($datatype == 'drama'){
				$url = url('drama-detail/');
				$type = 'type'; 
				}
				else{
				$url = url('movie-detail/');
				$type = 'movie_sub';
				}
			}
			else
			{
				$url = url('drama-detail/');
				$type = 'type';
			}
			
			
			?>
			
			@foreach($dramas as $row)

				<?php

				if($type = 'type')
				$class = 'SUB';
				else
				$class = $row[$type]==1?'SUB':'RAW'; 
				// echo "<pre>";
				// print_r($row);
				// die();
				?>
			<li>
			  <a href="{{$url.'/'.$row['slug']}}" class="img" title="{{$row['title']}}">
				<img src="{{asset('public/storage/drama/'.$row['icon'])}}" class="lazy" alt="{{$row['title']}}" data-original="{{asset('public/storage/drama/'.$row['icon'])}}" style="display: block;">				<span class="type {{$class}}">{{$class}}</span>
				<h3 class="title">{{$row['title']}}</h3>
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