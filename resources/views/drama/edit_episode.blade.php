 @extends('layouts.main') 
@section('title', 'Edit Episode')
@section('content')
<?php
    
    $drama_id = request()->segment(3);
   

?>

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
                <div class="col-lg-3">
                    <div class="page-header-title">
                        <i class="fas fa-tv bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Edit Episode')}}</h5>
                            <span>{{ __('Edit drama episode')}}</span>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-7">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <a href="{{url('episode/list/'.$record['drama_id'])}}">
                    <button style="color: #fff;background-color: #202C50;border-radius: 10px;font-size: 12px; padding: 8px 16px;"data-toggle="tooltip" data-placement="top" title="View Episodes">{{ __('View Episodes')}}</button>    
                        </a>  
                    </nav>
                </div>
                <div class="col-lg-2">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{url('episode/list/'.$record['drama_id'])}}">{{ __('Episode List')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Edit')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <form class="forms-sample" enctype="multipart/form-data" method="POST" action="{{ url('episode/update') }}" >
        @csrf
        <input type="hidden" name="id" value="{{$record['id']}}">
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
                    <option {{$record['status'] == 1?'selected':''}} value="1">{{ __('Active')}}</option>
                    <option value="0" {{$record['status'] == 0?'selected':''}}>{{ __('Inactive')}}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">{{ __('Home Page Recent[Display]')}} </label>
                <select class="form-control select2" name="home_recent">
                    <option {{$record['home_recent'] == 0?'selected':''}} value="0">{{ __('No')}}</option>
                    <option {{$record['home_recent'] == 1?'selected':''}} value="1">{{ __('Yes')}}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">{{ __('Home Page Kshow[Display]')}} </label>
                <select class="form-control select2" name="home_kshow">
                    <option {{$record['home_kshow'] == 0?'selected':''}} value="0">{{ __('No')}}</option>
                    <option {{$record['home_kshow'] == 1?'selected':''}} value="1">{{ __('Yes')}}</option>
                </select>
            </div>
              <div class="form-group">
                <label for="">{{ __('Episode No.')}} </label>
                <?php
                // echo "<pre>";
                // print_r($record);
                // die();
                ?>
                <select class="form-control select2" name="episodes_no"> 
                    @foreach (range(1,1000) as $letter)    
                        <option {{$letter == $record['episodes_no']?'selected':''}} value="{{$letter}}">{{ __($letter)}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="">{{ __('Subtitle')}} </label>
                <select class="form-control select2" name="type">
                    <option {{$record['type'] == 0?'selected':''}} value="0">{{ __('RAW')}}</option>
                    <option {{$record['type'] == 1?'selected':''}} value="1">{{ __('SUB')}}</option>
                </select>
            </div>

            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Title')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Title" value="{{$record['title']}}" name="title" required>
                @error('Title')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Title For URL')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Title For URL" value="{{$record['slug']}}" name="slug">
                @error('Title')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Reff URl')}}</label>
                <input type="text" name="reff_url" class="form-control" id="exampleInputUsername1" value="{{$record['reff_url']}}" placeholder="Reff URl">
            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Episode Date')}}</label>
                <input type="date" class="form-control" name="date" value="{{$record->date}}">
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
            <label for="exampleTextarea1">{{ __('Download URL')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="4" name="download_url"placeholder="Download URL">{{$record['download_url']}}</textarea>
        </div> 
        <div class="form-group">
            <label for="exampleTextarea1">{{ __('Meta Title')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="4" name="meta_title" placeholder="Meta Title">{{$record['meta_title']}}</textarea>
        </div>
        <div class="form-group">
            <label for="exampleTextarea1">{{ __('Meta Keywords')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="4" name="meta_kwd" placeholder="Meta Keywords">{{$record['meta_kwd']}}</textarea>
        </div>
        <div class="form-group">
            <label for="exampleTextarea1">{{ __('Meta Description')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="6" name="meta_desc" placeholder="Meta Description">{{$record['meta_desc']}}</textarea>
        </div>
    </div>
</div>
</div>
</div>
</div>
<div class="row col-md-12 container-fluid" style="padding-left: 2rem;"><h1><b>Movie Videos</b></h1></div> 
<div class="container-fluid"><a class="btn btn-warning" style="padding-left: 1rem; margin-bottom:20px;" onclick="add_more_other_names();" href="javascript:void(0);">Add More Video</a></div>  
<div id="episode_videos_wrap" class="row  container-fluid">
    @foreach($record['videos'] as $video)

    <div class="col-md-4">
    <div class="card">
    <div class="card-body">
    <div class="form-group">
        <select class="form-control select2" name="serv_id[]">
           {!! get_server_list($video['server_id']) !!}
        </select>
    </div>
    <div class="form-group">
        <input type="text" value="{{$video['video_url'] ?? ''}}" name="epiv_url[]" class="form-control" id="exampleInputUsername1" placeholder="Video URL">
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
            <textarea class="form-control html-editor" rows="10" name="description">{{$record['description']}}</textarea>
        </div>
        <div class="form-group" style="margin-left: 1.5rem; margin-bottom: 2rem;">
            <button type="submit" style="color: #fff;background-color: #202C50;border-radius: 10px;font-size: 12px; padding: 6px 14px;"data-toggle="tooltip" data-placement="top" title="Update">{{ __('Update')}}</button>
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
