@extends('layouts.main') 
@section('title', 'Edit Movies')
@section('content')

<!-- push external head elements to head -->
    @push('head')
    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/summernote/dist/summernote-bs4.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/mohithg-switchery/dist/switchery.min.css') }}">
    @endpush
     <div class="container-fluid">
                <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-2">
                    <div class="page-header-title">
                        <i class="fas fa-tv bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Edit Movie')}}</h5>
                            <span>{{ __('Edit movie detail')}}</span>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-8">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <a href="{{ url('movies/list') }}">
                    <button style="color: #fff;background-color: #202C50;border-radius: 10px;font-size: 12px; padding: 8px 16px;"data-toggle="tooltip" data-placement="top" title="View Movie">{{ __('View Movie')}}</button>    
                        </a>  
                    </nav>
                </div>
                <div class="col-lg-2">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ url('movies/list') }}">{{ __('Moive List')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Edit')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <form class="forms-sample" enctype="multipart/form-data" method="POST" action="{{ url('movies/update') }}" >
        @csrf
        <input type="hidden" name="id" value="{{$movie['id']}}">
        <?php
        // echo "<pre>"; 
        // print_r($movie);
        // die();

         ?>
        <div class="row">
            <!-- start message area-->
            @include('include.message')
            <!-- end message area-->
        <div class="col-md-6">
        <div class="card">
        <div class="card-body">
        <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">{{ __('Status')}} </label>
                <select class="form-control select2" name="status">
                    <option {{$movie['status'] == 1?'selected':''}} value="1">{{ __('Active')}}</option>
                    <option value="0" {{$movie['status'] == 0?'selected':''}}>{{ __('Inactive')}}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">{{ __('Country')}} </label>
                <select class="form-control select2" name="country_id">


                    
                    @foreach(country_menu() as $country)
                    <option {{$movie['country_id'] == $country['id']?'selected':'' }} value="{{$movie['id']}}">{{$country['title']}}</option>
                    @endforeach
                 
                </select>
            </div>
            <div class="form-group">
                <label for="">{{ __('Genre')}} </label>
                <select class="form-control select2" multiple="multiple" name="genre[]">
                    @foreach($movie['genre'] as $gen)                   
                    <option selected value="{{$gen['name']}}">{{ $gen['name']}}</option>
                    @endforeach

                    @foreach($genre as $gen)                   
                    <option value="{{$gen['title']}}">{{ $gen['title']}}</option>
                    @endforeach
                   
                </select>
            </div>
            <!-- <div class="form-group">
        <label for="tagPlaces" class="control-label">Genre</label><br>
            <input style="width: 100%;" type="text" class="form-control" data-role="tagsinput" name="genre" id="tagPlaces"value="London,Canada,Australia,Mexico,India,china">
             </div> -->

            <!-- <div class="form-group">
        <label for="tagPlaces" class="control-label">Tags</label><br>
            <input style="width: 100%;" type="text" class="form-control" data-role="tagsinput" name="tags" id="tagPlaces"value="London,Canada,Australia,Mexico,India,china">
             </div> -->
             <div class="form-group">
                <label for="">{{ __('Tags')}} </label>
                <select class="form-control select2" multiple="multiple" name="tags[]">
                    @foreach($movie['tags'] as $row)
                    <option selected value="{{$row['name']}}">{{ $row['name']}}</option>
                    @endforeach

                    @foreach($tags as $row)
                    <option value="{{$row['title']}}">{{ $row['title']}}</option>
                    @endforeach
                </select>
            </div>
              <div class="form-group">
                <label for="">{{ __('Sort By')}} </label>
                <select class="form-control select2" name="first_char"> 
                    @foreach (range('A','Z') as $letter)    
                <option {{$letter == $movie['first_char']?'selected':''}} value="{{$letter}}">{{ __($letter)}}</option>
                    @endforeach
                    <option value="#">{{ __('#')}}</option> 
                </select>
            </div>

            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Title')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Title" name="title" value="{{$movie['title']}}">
                @error('Title')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Title For URL')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Title For URL" name="slug" value="{{$movie['slug']}}">
            </div>

            <div class="form-group">
                <label for="">{{ __('Subtitle')}} </label>
                <select class="form-control select2" name="movie_sub">
                    <option {{$movie['movie_sub'] == 0?'selected':''}} value="0">{{ __('Raw')}}</option>
                    <option {{$movie['movie_sub'] == 1?'selected':''}} value="1">{{ __('Sub')}}</option>
                 </select>
            </div>
            <div class="form-group">
            <label for="exampleTextarea1">{{ __('Download URL')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="4" name="movie_download_url" placeholder="Download URL">{{$movie['movie_download_url']}}</textarea>
        </div>
        <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Reff URl')}}</label>
                <input type="text" name="reff_url" class="form-control" id="exampleInputUsername1" value="{{$movie['reff_url']}}" placeholder="Reff URl">
            </div>
            <div class="form-group">
                <label>{{ __('Upload Image')}}</label>
                <input type="file" name="icon" class="file-upload-default">
                <div class="input-group col-xs-12">
                    <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                    <span class="input-group-append">
                        <button class="file-upload-browse btn btn-primary" type="button">{{ __('Upload')}}</button>
                    </span>
                </div>
                    <img  width="70px" height="50px" src="{{asset('public/storage/drama/'.$movie['icon'])}}">
            </div>
        <!-- <div class="form-group">
                <div class="file-upload-wrapper">
                    <p for="exampleInputUsername1"><b>{{ __('Upload Image')}}</b></p>
                    <input type="file" id="input-file-now" class="file-upload" name="icon" />
                  
                    <img style="margin-left: 15rem;" width="70px" height="50px" src="{{asset('public/storage/drama/'.$movie['icon'])}}">
                </div>
            </div> -->
        <div class="form-group">
                <label for="">{{ __('Movie Status')}} </label>
                <select class="form-control select2" name="movie_status">
                    <option value="1" {{$movie['movie_status'] == 2?'selected':''}}>{{ __('Upcoming')}}</option>
                    <option value="2" {{$movie['movie_status'] == 1?'selected':''}}>{{ __('Ongoing')}}</option>
                    <option value="3"{{$movie['movie_status'] == 3?'selected':''}}>{{ __('Completed')}}</option>
                </select>
            </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <div class="col-md-6">
    <div class="card">
    <div class="card-body">
    <div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputUsername1">{{ __('Episode Reff URL')}}</label>
            <input type="text" name="reff_url_detail" class="form-control" id="exampleInputUsername1" value="{{$movie['reff_url_detail']}}" placeholder="Episode Reff URL">
        </div> 
        <div class="form-group">
            <label for="">{{ __('Release Year')}} </label>
            <select class="form-control select2" name="release_year"> 
                    @foreach (range(1970,2022) as $letter)    
               <option {{$letter == $movie['release_year']?'selected':''}} value="{{$letter}}">{{ __($letter)}}</option>
                    @endforeach
                </select>
        </div>
        <div class="form-group">
            <label>{{ __('Release Date')}}</label>
            <input class="form-control" type="date" name="release_date" value="{{ $movie->date}}">
        </div>
        <div class="form-group">
            <label for="exampleTextarea1">{{ __('Movie Cast')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="4" name="cast" placeholder="Movie Cast">{{$movie['cast']}}</textarea>
        </div>
        <div class="form-group">
            <label for="exampleTextarea1">{{ __('Movie Trailer Youtube URL')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="4" name="trailer_yt_url" placeholder="Movie Trailer Youtube URL">{{$movie['trailer_yt_url']}}</textarea>
        </div>
        <div class="form-group">
            <label for="exampleTextarea1">{{ __('Meta Title')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="4" name="meta_title" placeholder="Meta Title">{{$movie['meta_title']}}</textarea>
        </div>
        <div class="form-group">
            <label for="exampleTextarea1">{{ __('Meta Keywords')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="4" name="meta_kwd" placeholder="Meta Keywords">{{$movie['meta_kwd']}}</textarea>
        </div>
        <div class="form-group">
            <label for="exampleTextarea1">{{ __('Meta Description')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="4" name="meta_desc" placeholder="Meta Description">{{$movie['meta_desc']}}</textarea>
        </div>
    </div>
</div>
</div>
</div>
</div>
<div class="row col-md-12 container-fluid" style="padding-left: 2rem;"><h1><b>Movie Videos</b></h1></div> 
<div class="container-fluid"><a class="btn btn-warning" style="padding-left: 1rem; margin-bottom:20px;" onclick="add_more_other_names();" href="javascript:void(0);">Add More Video</a></div>  
<div id="episode_videos_wrap" class="row  container-fluid">
    @foreach($movie['videos'] as $video)

         <?php

          $title = $video['server']['title']; 
         // echo "<pre>";
         // print_r($video);
         // die();
          ?>
    <div class="col-md-4">
    <div class="card">
    <div class="card-body">
    <div class="form-group">
        <select class="form-control select2" name="serv_id[]">
            {!! get_server_list($video['server_id']) !!}
            <!-- <option value="{{$title}}">{{ __('Selected Server')}}</option> -->
        </select>
    </div>
    <div class="form-group">
        <input type="text" value="{{$video['video_url']}}" name="epiv_url[]" class="form-control" id="exampleInputUsername1" placeholder="Video URL">
    </div>
    </div>
    </div>
    </div>
    @endforeach
</div>

<div class="col-md-12">
    <div class="card">
        <div class="card-header"><h3>{{ __('Main Description')}}</h3></div>
        <div class="card-body">
            <textarea class="form-control html-editor" rows="10" name="description">{{$movie['description']}}</textarea>
            <div class="form-group" >
                <button type="submit" style="color: #fff;background-color: #202C50;border-radius: 10px;font-size: 12px; padding: 6px 14px;"data-toggle="tooltip" data-placement="top" title="Update">{{ __('Update')}}</button>
            </div>
        </div>
    </div>
</div>
</form>
</div>
<!-- push external js -->
@push('script')
    
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('plugins/summernote/dist/summernote-bs4.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
        <script src="{{ asset('plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
        <script src="{{ asset('plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
       <script src="{{ asset('js/form-advanced.js') }}"></script>
       <script src="{{ asset('js/form-components.js') }}"></script>
       <script>
            function add_more_other_names()
            {
                $("#episode_videos_wrap").append('<div class="col-md-4"><div class="card"><div class="card-body"><div class="form-group"><select class="form-control select2" name="serv_id[]">{!! get_server_list() !!}</select></div><div class="form-group"><input type="text" value="" name="epiv_url[]"class="form-control" id="exampleInputUsername1" placeholder="Video URL"></div></div></div></div></div>');
            }
        </script>
@endpush
@endsection
