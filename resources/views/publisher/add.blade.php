@extends('layouts.main') 
@section('title', 'Add Publisher')
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
                <div class="col-lg-3">
                    <div class="page-header-title">
                        <i class="fas fa-tv bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Publisher Add')}}</h5>
                            <span>{{ __('Add Data of Publisher')}}</span>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-7">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <a href="{{ url('publisher/list') }}">
                    <button style="color: #fff;background-color: #202C50;border-radius: 10px;font-size: 12px; padding: 8px 16px;"data-toggle="tooltip" data-placement="top" title="View Publisher">{{ __('View Publisher')}}</button>    
                        </a>  
                    </nav>
                </div>
                <div class="col-lg-2">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ url('publisher/add') }}">{{ __('Publisher')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Add')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
     <form class="forms-sample" enctype="multipart/form-data" method="POST" action="{{ url('publisher/store') }}" >
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
                <label for="exampleInputUsername1">{{ __('Title For URL')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Title For URL" required name="slug">
            </div>
            <div class="form-group">
            <label>{{ __('Page Text Top')}}</label>
            <textarea class="form-control html-editor" rows="10" name="content"></textarea>
            </div>
            <div class="form-group">
            <label>{{ __('Page Text Bottom')}}</label>
            <textarea class="form-control html-editor" rows="10" name="content"></textarea>
            <div class="form-group">
                <button type="submit" style="color: #fff;background-color: #202C50;border-radius: 10px;font-size: 12px; padding: 6px 14px;"data-toggle="tooltip" data-placement="top" title="Add Publisher">{{ __('Add Publisher')}}</button>
            </div>
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
            <label for="exampleTextarea1">{{ __('Main Heading H1')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="2" name="main_heading"></textarea>
        </div>
        <div class="form-group">
            <label for="exampleTextarea1">{{ __('Meta Title')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="2" name="meta_title"></textarea>
        </div>
        <div class="form-group">
            <label for="exampleTextarea1">{{ __('Meta Keywords')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="2" name="meta_keywords"></textarea>
        </div>
        <div class="form-group">
            <label for="exampleTextarea1">{{ __('Meta Description')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="4" name="meta_description"></textarea>
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