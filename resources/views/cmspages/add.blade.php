@extends('layouts.main') 
@section('title', 'Add CMS Pages')
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
                            <h5>{{ __('CMS Page Add')}}</h5>
                            <span>{{ __('Add data of CMS Pages')}}</span>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-7">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <a href="{{ url('cms-pages/list') }}">
                    <button style="color: #fff;background-color: #202C50;border-radius: 10px;font-size: 12px; padding: 8px 16px;"data-toggle="tooltip" data-placement="top" title="View CMS Page">{{ __('View CMS Page')}}</button>    
                        </a>  
                    </nav>
                </div>
                <div class="col-lg-2">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ url('cms-pages/add') }}">{{ __('CMS Page')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Add')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
      <form class="forms-sample" enctype="multipart/form-data" method="POST" action="{{ url('cms-pages/store') }}" >
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
                <label for="exampleInputUsername1">{{ __('Page Title')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Title" required name="page_title">
                <div class="help-block with-errors"></div>

                @error('title')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror

            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Title For Menu')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Title For Menu" required name="title_menu">

                @error('Title For Menu')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror

            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('URL Title')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="URL Title" required name="slug">

                @error('URL Title')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror

            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Meta Title')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Meta Title" required name="meta_title">

                 @error('Meta Title')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror

            </div>
            <div class="form-group">
                <label for="exampleTextarea1">{{ __('Meta Keywords')}}</label>
                <textarea class="form-control" id="exampleTextarea1" rows="2" placeholder="Meta Keywords" name="meta_keyword" ></textarea>

                @error('Meta Keywords')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror

            </div>
            
            <div class="form-group" style="padding-top: 0.6rem;">
                <button type="submit" style="color: #fff;background-color: #202C50;border-radius: 10px;font-size: 12px; padding: 6px 14px;"data-toggle="tooltip" data-placement="top" title="Add CMS">{{ __('Add CMS')}}</button>
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
                <label for="exampleTextarea1">{{ __('Meta Keywords')}}</label>
                <textarea class="form-control" id="exampleTextarea1" rows="2" placeholder="Meta Keywords" name="meta_keyword" ></textarea>

                @error('Meta Keywords')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror

            </div>
            <div class="form-group">
                <label for="exampleTextarea1">{{ __('Meta Discription')}}</label>
                <textarea class="form-control" id="exampleTextarea1" rows="4" placeholder="Meta Discription" name="meta_description"></textarea>

                @error('Meta Discription')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror

            </div>
            <div class="form-group">
            <label>{{ __('Page Content')}}</label>
            <textarea class="form-control html-editor" rows="10" name="content"></textarea>
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