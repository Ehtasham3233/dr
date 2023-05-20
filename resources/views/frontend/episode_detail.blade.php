
@extends('frontend.layouts.main') 
@section('title', $episode['title'].' English SUB Online at Dramacool')
@section('description', 'Dramacool users '.$episode['title'].' English SUB watch Online. DramaCool will always be the first to have the episodes.')


@section('content')

<!-- push external head elements to head -->
    @push('head')

        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/watch.css') }}" />

        <style type="text/css">
          
          #off_light{position:fixed;z-index:10;opacity:.98;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.9);}
          .mask{width:100%;height:100%;background:rgba(0,0,0,.7);z-index:15;position:fixed;top:0;display:none}
          .button {
          background-color: #3EC2CF;border: none;color: white;padding: 10px 25px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;
        </style>

    @endpush

<?php
// echo "<pre>";
// print_r($episode);
// die();
$main_vid_link='';

$url = url('drama-detail/'.$episode['drama']['slug']);
$epiurl = url('video-watch/'.$episode['slug']);
$epititle = $episode['title'];

?>

@auth
    <div>
    <a href="{{url('episode/edit/'.$episode['id'])}}">
    <button type="button" class="button">{{ __('Edit Episode')}}</button></a>
    </div>
@endauth 

<div class="content">
        
    <div class="content-left">
            
  <div class="ads_place">
      </div>

  <div class="block watch-drama">
        
    <h1>{{$episode['title']}} </h1>
        <div class="kname" style="padding-bottom:0;"></div>
    <style>.watch-drama .category {top:10px;}</style>
    
    <div class="category">
      <span>Category: </span><a href="{{url('drama-detail/'.$episode['drama']['slug'])}}">{{$episode['drama']['title']}}</a>
    </div>

 <div class="block-watch">
Watch <strong>{{$episode['title']}}</strong> {{$episode['type']==1?'English SUB':'RAW'}} on <a href="<?php echo url('/'); ?>">DramaCool</a>. We updates hourly and will always be the first drama site to release the latest episodes of {{$episode['drama']['title']}}. Please reload the page if any error appears.
          <!-- <p>Here is the RAW.</p> -->
      </div>

   
      <div class="block-tab" id="vframe_block">
        <!-- <span class="report2">! Report This Episode</span> -->
        <div class="clearfix"></div>
        <div class="block tab-container" id="block-tab-video">
          <div class="tab-content tab-content-video tab-video-1 selected">
            <div class="watch_video watch-iframe">
              <div id="frame_wrap"></div>
            </div>
          </div>
        </div>
        </div>


      <div class="plugins2">
        <ul>
          <li class="facebook" onclick="window.open('https://www.facebook.com/share.php?u={{$epiurl}}', 'sharer', 'width=548,height=325');">
            <i class="fa fa-facebook"></i>
            <span>Facebook</span>
          </li>
          <li class="twitter" onclick="window.open('https://twitter.com/intent/tweet?text={{$epititle}}&url={{$epiurl}}', 'TwitterWindow', 'width=548,height=325');">
            <i class="fa fa-twitter"></i>
            <span>Twitter</span>
          </li>
          <li class="offlight" id="offlight">
            <i class="fa fa-lightbulb-o"></i>
            <span>Switch Off Light</span>
      </li>
          <li class="download">
            <a href="{{$episode['download_url']}}" target="_blank">
              <i class="fa fa-download"></i>
              <span>Download</span>
            </a>
          </li>
          <!-- <li class="favorites">
            <i class="fa fa-heart"></i>
            <span>Favorites</span>
          </li> -->
          <li class="btn-comment">
            <i class="fa fa-comment"></i>
            <span class="disqus-comment-count" data-disqus-url="{{url('/video-watch/'.$episode['slug'])}}">Comments (0)</span>
          </li>
          <li class="reports report2">
            <i class="fa fa-warning"></i>
          </li>
          <li class="direction">

          @if($prev = getprev($episode))
          <a href="{{url('video-watch/'.$prev['slug'])}}"><i class="fa fa-angle-left"></i> <span>Prev</span></a>
          @endif
            
          <select onchange="location = this.options[this.selectedIndex].value;">
          <option selected="" value="{{url('video-watch/'.$episode['slug'])}}">Episode {{$episode['episodes_no']}}</option>

          @if(count($all_episode)>0)                
          @foreach($all_episode as $row)
          <option value="{{url('video-watch/'.$row['slug'])}}">Episode {{$row['episodes_no']}}</option>
          @endforeach
          @endif

               
                          
                         
          </select>
          @if($next = getnext($episode))
          <a href="{{url('video-watch/'.$next['slug'])}}"><span>Next</span> <i class="fa fa-angle-right"></i></a>
          @endif

       </li>
        </ul>
      </div>
      <div style="color:#FDB813;border-bottom:1px solid #cfcfcf;padding-bottom:10px;margin-bottom:10px;font-size:15px;margin-top:20px;font-weight:bold;">Please scroll down to choose servers and episodes</div>
      <div class="clearfix"></div>
      <div class="anime_muti_link">
        <ul>

          @if(count($episode['videos'])>0)
          @foreach($episode['videos'] as $video)

          <?php
          if($loop->index == 0)
          $main_vid_link = $video['video_url'];
          $url = $video['video_url'];
          if(isset($video['server']))
          $title = $video['server']['title'];
          else
          $title = 'Name Not Found';
          ?>
          <li onClick="manage_server({{strtolower($title)}})" class="{{strtolower($title)}}" id="{{strtolower($title)}}"  data-video="{{$url}}"

          rel="{{$loop->index}}">{{$title}}<span>Choose this server</span>
          </li>
          @endforeach
          @endif
        </ul>
      </div>
    
    <p class="note">Dear valued customer,<br>
      1. Dramacool regularly updates new technology. If there any errors appear, please reload the page first. If errors re-appear then <a href="/contact-us" target="_blank">report to us</a>.
      <br>
      2. Pop ads on Standard Server only have frequency of 1 pop per 1 hour. if you saw it otherwise, please <a href="/contact-us" target="_blank">contact us</a>.
      <br>
      3. Ads sometimes is bothering but it is a necessary to maintain our fully services. Hope you understand and support us.
      <br>
      Thank you!
      <br>
      <br>
    </p>

   <div class="btn-comment">
      <i class="fa fa-comment"></i>
      <span class="disqus-comment-count" data-disqus-url="{{url('video-watch/'.$episode['slug'])}}">Comments (0)</span>
    </div>

    <div class="comment">
        <div id="disqus_thread"></div>
    </div>
  
    
  </div>
  
  <div class="block-tab">
    <ul class="tab">
      <li data-tab="left-tab-1" class="selected">View more video</li>
    </ul>
    <span class="show-all">Show all episodes</span>
    <div class="block tab-container">
      <div class="tab-content left-tab-1 selected">
        <ul class="list-episode-item-2 all-episode">
          
          @foreach($all_episode as $row)
          <li>
              <a href="{{url('video-watch/'.$row['slug'])}}" class="img">
                @if($row['type']==1)
                <span class="type SUB">SUB</span>
                @else
                <span class="type RAW">RAW</span>
                @endif
                <h3 class="title" onclick="window.location = '/win-the-future-2021-episode-27.html'">{{$row['title']}}</h3>
                <span class="time">{{$row['updated_at']}}</span>
              </a>
            </li>

          @endforeach
            
    
        </ul>
      </div>
    </div>
  </div>

    

  <div class="mask"></div>
  <div id="off_light" class="hide"></div>  

      </div>



 @include('frontend.include.rightbar')
    </div>


     <!-- push external js -->
    @push('script')  
    
  <script type="text/javascript" src="{{ asset('frontend/js/watch2.js') }}"></script>
    
<script type="text/javascript">
  function manage_server(id)
  { 
     var video_link = $("#"+id).data("video");
     manage_vframe(video_link);
     scrollToi('vframe_block');
  }

  function manage_vframe(url)
  { 
      $("#frame_wrap").html ('<iframe allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" marginheight="0" marginwidth="0" scrolling="no" frameborder="0" style="width: 100%" src="'+url+'" target="_blank" sandbox="allow-top-navigation allow-scripts block-popups allow-same-origin"></iframe>');
  }
  $(document).ready(function() 
  {
      <?php if(isset($main_vid_link) and $main_vid_link != ''){?>
      manage_vframe("{{$main_vid_link}}");
      <?php } ?>
  });
</script>

<script type="text/javascript">
    var disqus_url = "{{url('video-watch/'.$episode['slug'])}}";
</script>

    

    @endpush
@endsection