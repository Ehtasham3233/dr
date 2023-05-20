@extends('layouts.main') 
@section('title', 'Add Movies')
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
                            <h5>{{ __('Movie Add')}}</h5>
                            <span>{{ __('Add a new movie')}}</span>
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
                            <li class="breadcrumb-item"><a href="{{ url('movies/add') }}">{{ __('Moive')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Add')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <form class="forms-sample" enctype="multipart/form-data" method="POST" action="{{ url('movies/store') }}" >
        @csrf
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
                    <option value="1">{{ __('Active')}}</option>
                    <option value="0">{{ __('Inactive')}}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">{{ __('Country')}} </label>
                <select class="form-control select2" name="country_id">
                    @foreach(country_menu() as $country)
                    <option value="{{$country['id']}}">{{$country['title']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="">{{ __('Genre')}} </label>
                <select class="form-control select2" multiple="multiple" name="genre[]">
                    @foreach($genre as $row)
                    <option value="{{$row['title']}}">{{$row['title']}}</option>
                    @endforeach
                </select>
            </div>
            <!-- <div class="form-group">
        <label for="tagPlaces" class="control-label">Genre</label><br>
            <input style="width: 100%;" type="text" class="form-control" data-role="tagsinput" name="genre" id="tagPlaces"value="London,Canada,Australia,Mexico,India,china">
             </div> -->
             <div class="form-group">
                <label for="">{{ __('Tags')}} </label>
                <select class="form-control select2" multiple="multiple" name="tags[]">
                    
                    @foreach($tags as $row)
                    <option value="{{$row['title']}}">{{$row['title']}}</option>
                    @endforeach
                </select>
            </div>

            <!-- <div class="form-group">
        <label for="tagPlaces" class="control-label">Tags</label><br>
            <input style="width: 100%;" type="text" class="form-control" data-role="tagsinput" name="tags" id="tagPlaces"value="London,Canada,Australia,Mexico,India,china">
             </div> -->
              <div class="form-group">
                <label for="">{{ __('Sort By')}} </label>
                <select class="form-control select2" name="first_char">
                    <option value="#">{{ __('#')}}</option> 
                    @foreach (range('A','Z') as $letter)    
                        <option value="{{$letter}}">{{ __($letter)}}</option>
                    @endforeach
                    
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Title')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Title" name="title">
                @error('Title')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Title For URL')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Title For URL" name="slug">
            </div>

            <div class="form-group">
                <label for="">{{ __('Subtitle')}} </label>
                <select class="form-control select2" name="movie_sub">
                    <option 1="1">{{ __('SUB')}}</option>
                    <option 0="0">{{ __('RAW')}}</option>
                 </select>
            </div>
            <div class="form-group">
            <label for="exampleTextarea1">{{ __('Download URL')}}</label>
            <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Download URL" name="movie_download_url">
        </div>
        <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Reff URl')}}</label>
                <input type="text" name="reff_url" class="form-control" id="exampleInputUsername1" placeholder="Reff URl">
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
            </div>
            <!-- <div class="form-group">
                <div class="file-upload-wrapper">
                    <p for="exampleInputUsername1"><b>{{ __('Upload Image')}}</b></p>
                    <input type="file" id="input-file-now" class="file-upload" name="icon" />
                </div>
            </div> -->
        <div class="form-group">
                <label for="">{{ __('Movie Status')}} </label>
                <select class="form-control select2" name="movie_status">
                    <option value="1">{{ __('Upcoming')}}</option>
                    <option value="2">{{ __('Ongoing')}}</option>
                    <option value="3">{{ __('Completed')}}</option>
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
            <input type="text" name="reff_url_detail" class="form-control" id="exampleInputUsername1" placeholder="Episode Reff URL">
        </div>  
        <div class="form-group">
            <label for="">{{ __('Release Year')}} </label>
            <select class="form-control select2" name="release_year"> 
                    @foreach (range(1970,date('Y')) as $letter)    
                        <option value="{{$letter}}">{{ __($letter)}}</option>
                    @endforeach
                </select>
        </div>
        <div class="form-group">
            <label>{{ __('Release Date')}}</label>
            <input class="form-control" type="date" / name="release_date">
        </div>
        <div class="form-group">
            <label for="exampleTextarea1">{{ __('Movie Trailer Youtube URL')}}</label>
            <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Movie Trailer Youtube URL" name="trailer_yt_url">
        </div>
        <div class="form-group">
            <label for="exampleTextarea1">{{ __('Meta Title')}}</label>
            <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Meta Title" name="meta_title">
        </div>
        <div class="form-group">
            <label for="exampleTextarea1">{{ __('Movie Cast')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="4" name="cast" placeholder="Movie Cast"></textarea>
        </div>
        <div class="form-group">
            <label for="exampleTextarea1">{{ __('Meta Keywords')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="4" name="meta_kwd" placeholder="Meta Keywords"></textarea>
        </div>
        <div class="form-group">
            <label for="exampleTextarea1">{{ __('Meta Description')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="4" name="meta_desc" placeholder="Meta Description"></textarea>
        </div>
    </div>
</div>
</div>
</div>
</div>
<div class="row col-md-12 container-fluid" style="padding-left: 2rem;"><h1><b>Movie Videos</b></h1></div>
<div class="container-fluid"><a class="btn btn-warning" style="padding-left: 1rem; margin-bottom:20px;" onclick="add_more_other_names();" href="javascript:void(0);">Add More Video</a></div>  

<div id="episode_videos_wrap" class="row  container-fluid">
    <div class="col-md-4">
    <div class="card">
    <div class="card-body">
    <div class="form-group">
        <select class="form-control select2" name="serv_id[]">
            <option value="{!! get_server_list() !!}">{{ __('Selected Server')}}</option>
        </select>
    </div>
    <div class="form-group">
        <input type="text" value="" name="epiv_url[]" class="form-control" id="exampleInputUsername1" placeholder="Video URL">
    </div>
    </div>
    </div>
    </div>
</div>
<div class="col-md-12">
    <div class="card">
        <div class="card-header"><h3>{{ __('Main Description')}}</h3></div>
        <div class="card-body">
            <textarea class="form-control html-editor" rows="10" name="description"></textarea>
            <div class="form-group" >
                <button type="submit" style="color: #fff;background-color: #202C50;border-radius: 10px;font-size: 12px; padding: 6px 14px;"data-toggle="tooltip" data-placement="top" title="Add Movie">{{ __('Add Movie')}}</button>
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
