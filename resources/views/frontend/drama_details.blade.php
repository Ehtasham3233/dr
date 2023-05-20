@extends('frontend.layouts.main')
@section('title', $drama['title'].' Online at Dramacool')
@section('description', 'Dramacool users '.$drama['title'].' watch Online. DramaCool will always be the first to have the episodes.')
@push('head')
<style>
    .button {
  background-color: #3EC2CF; /* Green */
  border: none;
  color: white;
  padding: 10px 25px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
}
</style>
@endpush

@section('content')
@auth
  <div>
    <a href="{{url('drama/edit/'.$drama['id'])}}">
    <button data-toggle="tooltip" data-placement="top" title="Edit Drama" type="button" class="button">{{ __('Edit Drama')}}</button></a>
    </div>
@endauth 
    
<div class="content">
        <div class="content-left">
            
  <div class="ads_place">
      </div>

  <div class="block">
    <div class="details">
      <div class="img"><img src="{{asset('public/storage/drama/'.$drama['icon'])}}" alt="1:11 Time To Go See You (2021)"></div>
      <div class="info">

        <?php
        // echo "<pre>";
        // print_r($drama);
        // die('here');
        ?>
        <h1>{{$drama['title']}}</h1>

        @if(count($drama->othername)>0)

        <p class="other_name"><span>Other name: </span>

            @foreach($drama->othername as $name)

                <a href="{{url('drama-detail/'.$drama['slug'])}}" title="{{$name['name']}}">{{$name['name']}}</a>

            @endforeach
            
        </p>
        @endif



        
            
        
        <p><span>Description</span></p>
        <p>{!!$drama['description']!!}</p>

                           

          
        @if($drama->country)

        <p><span>Country:</span> <a href="{{url('country/'.$drama->country['slug'])}}-drama" title="Dramas in {{$drama->country['title']}}">

        {{$drama->country['title']}}</a></p>

        @endif

        @if($drama['drama_status'])

        <?php
        if($drama['drama_status']==1)
            $status = 'upcoming';
        else if($drama['drama_status']==2)
            $status = 'ongoing';
        else
            $status = 'completed';
        ?>

         <p><span>Status:</span>
         <a href="{{url('popular/' .$status)}}-series" title="{{$status}} Dramas">{{$status}}</a>
            </p>
        @endif
        


         @if($drama['release_year'])
        <p><span>Released:</span>
          <a href="/released-in-{{$drama['release_year']}}" title="Dramas in {{$drama['release_year']}}">{{$drama['release_year']}}</a>
        </p>
        @endif

        @if(count($drama->genre)>0)
        <p><span>Genre:</span>

            @foreach($drama->genre as $genre)
                <a href="{{url('genre/'.strtolower($genre['name']))}}" title="{{$genre['name']}} Dramas">{{$genre['name']}}</a>
            @endforeach
        </p>
        @endif
		
		      </div>
    </div>
       

         @if(count($drama->tags)>0)

        <div class="tags">
        <strong>Tags:</strong>

                 <?php
                // echo "<pre>";
                // print_r($drama->tags);
                // die();
                ?>


         @foreach($drama->tags as $tags)
                <a href="{{url('tags/'.strtolower($tags['name']))}}" rel="tag">{{$tags['name']}}</a>
            @endforeach
        </div>
        @endif

      
    @if($drama['trailer_yt_url'])
    <?php
        $youtube = explode('=', $drama['trailer_yt_url'])
    ?>
    <div class="trailer">
      <div>{{$drama['title']}} trailer:</div>
      <iframe src="https://www.youtube.com/embed/{{$youtube[1]}}" frameborder="0" allowfullscreen="">
      </iframe>
    </div>
    @endif
    <div class="btn-comment">
      <i class="fa fa-comment"></i>
      <span class="disqus-comment-count" data-disqus-url="{{url('/drama-detail/'.$drama['slug'])}}">Comments (0)</span>
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
    @if(count($drama->episodes)>0)
    <div class="block tab-container">
      <div class="tab-content left-tab-1 selected">
        <ul class="list-episode-item-2 all-episode">
            @foreach($drama->episodes as $episode)
              <li>
              <a href="{{url('video-watch/'.$episode['slug'])}}" class="img">
                @if($episode['type']==1)
                <span class="type SUB">SUB</span>
                @else
                <span class="type RAW">RAW</span>
                @endif
                <h3 class="title">
                    {{$episode['title']}}</h3>
                <span class="time">{{$episode['updated_at']}}</span>
              </a>
            </li>
            @endforeach   
        </ul>
      </div>
    </div>
    @endif

  </div>
        </div>
        @include('frontend.include.rightbar',['sidebar' => $sidebar])
    </div>

 @push('script') 

<script type="text/javascript">
    var disqus_url = "{{url('/drama-detail/'.$drama['slug'])}}";
</script>
@endpush
    @endsection