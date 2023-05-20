@extends('layouts.main') 
@section('title', 'Edit Slider')
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
                            <h5>{{ __('Edit Slider')}}</h5>
                            <span>{{ __('Edit data of Slider')}}</span>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-8">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <a href="{{ url('slider/list') }}">
                    <button style="color: #fff;background-color: #202C50;border-radius: 10px;font-size: 12px; padding: 8px 16px;"data-toggle="tooltip" data-placement="top" title="View Slider">{{ __('View Slider')}}</button>    
                        </a>  
                    </nav>
                </div>
                <div class="col-lg-2">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ url('slider/list') }}">{{ __('Slider List')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Edit')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <form class="forms-sample" enctype="multipart/form-data" method="POST" action="{{ url('slider/update') }}" >
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
                <label for="exampleInputUsername1">{{ __('Heading')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Heading" required name="heading" value="{{$record['heading']}}">
            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('URL')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="URL" required name="slug" value="{{$record['slug']}}">
            </div>
            <div class="form-group">
                <label for="">{{ __('Target')}} </label>
                <select class="form-control select2" name="target">
                    <option {{$record['target'] == 1?'selected':''}} value="1">{{ __('Same Tab')}}</option>
                    <option value="0" {{$record['target'] == 0?'selected':''}}>{{ __('New Tab')}}</option>
                </select>
            </div>
            <div class="form-group">
                <label>{{ __('Upload Image')}}</label>
                <input type="file" name="img" class="file-upload-default">
                <div class="input-group col-xs-12">
                    <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                    <span class="input-group-append">
                        <button class="file-upload-browse btn btn-primary" type="button">{{ __('Upload')}}</button>
                    </span>
                </div>
                <img  width="130px" height="auto" src="{{url('storage/slider/',$record['img'])}}">
            </div>
            <div class="form-group" style="padding-top: 0.6rem;">
                <button type="submit" style="color: #fff;background-color: #202C50;border-radius: 10px;font-size: 12px; padding: 6px 14px;"data-toggle="tooltip" data-placement="top" title="Update">{{ __('Update')}}</button>
            </div>
        </div>
    </div>
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
    
@endpush
@endsection