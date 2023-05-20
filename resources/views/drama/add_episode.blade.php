 @extends('layouts.main') 
@section('title', 'Add Episode')
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
                            <h5>{{ __('Add Episode')}}</h5>
                            <span>{{ __('Add Drama Episode')}}</span>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-7">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <a href="{{ url('drama/list') }}">
                    <button style="color: #fff;background-color: #202C50;border-radius: 10px;font-size: 12px; padding: 8px 16px;"data-toggle="tooltip" data-placement="top" title="View Drama">{{ __('View Drama')}}</button>    
                        </a>  
                    </nav>
                </div>
                <div class="col-lg-2">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ url('Drama/list') }}">{{ __('Drama')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Add Episode')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <form class="forms-sample" enctype="multipart/form-data" method="POST" action="{{ url('episode/store ') }}" >
        @csrf
        <input type="hidden" name="drama_id" value="{{$drama_id}}">
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
                <label for="">{{ __('Home Page Recent[Display]')}} </label>
                <select class="form-control select2" name="home_recent">
                    <option value="0">{{ __('No')}}</option>
                    <option value="1">{{ __('Yes')}}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">{{ __('Home Page Kshow[Display]')}} </label>
                <select class="form-control select2" name="home_kshow">
                    <option value="0">{{ __('No')}}</option>
                    <option value="1">{{ __('Yes')}}</option>
                </select>
            </div>
              <div class="form-group">
                <label for="">{{ __('Episode No.')}} </label>
                <select class="form-control select2" name="episodes_no"> 
                    @foreach (range(1,1000) as $letter)    
                        <option value="{{$letter}}">{{ __($letter)}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="">{{ __('Subtitle')}} </label>
                <select class="form-control select2" name="type">
                    <option value="0">{{ __('RAW')}}</option>
                    <option value="1">{{ __('SUB')}}</option>
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
                @error('Title')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Reff URl')}}</label>
                <input type="text" name="reff_url" class="form-control" id="exampleInputUsername1" placeholder="Reff URl">
            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Episode Date')}}</label>
                <input type="date" class="form-control" id="exampleInputUsername1" name="date">
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
            <textarea class="form-control" id="exampleTextarea1" rows="4" name="download_url" placeholder="Download URL"></textarea>
        </div> 
        <div class="form-group">
            <label for="exampleTextarea1">{{ __('Meta Title')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="4" name="meta_title" placeholder="Meta Title"></textarea>
        </div>
        <div class="form-group">
            <label for="exampleTextarea1">{{ __('Meta Keywords')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="4" name="meta_kwd" placeholder="Meta Keywords"></textarea>
        </div>
        <div class="form-group">
            <label for="exampleTextarea1">{{ __('Meta Description')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="6" name="meta_desc" placeholder="Meta Description"></textarea>
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

        <div class="input-group input-group-button">
            <input type="text" name="list_get" id="list_get" class="form-control" placeholder="Get Server">
            <div class="input-group-append">
                <button class="btn btn-primary" onclick="getlist();" type="button">{{ __('Get All Server')}}</button>
            </div>
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
        </div>
        <div class="form-group" style="margin-left: 1.5rem; margin-bottom: 2rem;">
            <button type="submit" style="color: #fff;background-color: #202C50;border-radius: 10px;font-size: 12px; padding: 6px 14px;"data-toggle="tooltip" data-placement="top" title="Add Episode">{{ __('Add Episode')}}</button>
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

            function getlist()
            {   
                var url = $("#list_get").val();
                if(url  != '')
                {   
                    var html = "{{get_list_server("+url+")}}";
                    alert(html); 
                }
                //alert($("#list_get").val());
            }
        </script> 

@endpush
@endsection
