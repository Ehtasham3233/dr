@extends('layouts.main') 
@section('title', 'Add Servers')
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
                            <h5>{{ __('Server Add')}}</h5>
                            <span>{{ __('Add Data of Server')}}</span>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-8">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <a href="{{ url('servers/list') }}">
                    <button style="color: #fff;background-color: #202C50;border-radius: 10px;font-size: 12px; padding: 8px 16px;"data-toggle="tooltip" data-placement="top" title="View Server">{{ __('View Server')}}</button>    
                        </a>  
                    </nav>
                </div>
                <div class="col-lg-2">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ url('servers/add') }}">{{ __('Server')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Add')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <form class="forms-sample" enctype="multipart/form-data" method="POST" action="{{ url('servers/store') }}" >
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
                <label for="exampleInputUsername1">{{ __('Title')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Title" required name="title">
                <div class="help-block with-errors"></div>

                @error('title')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror

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
            </div>
            <div class="form-group" style="padding-top: 0.6rem;">
                <button type="submit" style="color: #fff;background-color: #202C50;border-radius: 10px;font-size: 12px; padding: 6px 14px;"data-toggle="tooltip" data-placement="top" title="Add Server">{{ __('Add Server')}}</button>
               <!--  <button type="submit" data-toggle="tooltip" data-placement="top" title="Add" class="btn btn-primary mr-2">{{ __('Add')}}</button> -->
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