@extends('layouts.main') 
@section('title', 'Edit Menu')
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
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Edit Menu')}}</h5>
                            <!--<span>{{ __('lorem ipsum dolor sit amet, consectetur adipisicing elit')}}</span>-->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">{{ __('Forms')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Components')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <form class="forms-sample" method="POST" action="{{ url('menus/update') }}" >
        <input type="hidden" name="id" value="{{$record['id']}}">
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
                <label for="">{{ __('Menu')}} </label>
                <select class="form-control select2" name="menu">
                    <option {{$record['menu'] == 1?'selected':''}} value="1">{{ __('Parent')}}</option>
                    <option {{$record['menu'] == 0?'selected':''}} value="0">{{ __('Child')}}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">{{ __('Status')}} </label>
                <select class="form-control select2" name="status">
                    <option {{$record['status'] == 1?'selected':''}} value="1">{{ __('Active')}}</option>
                    <option value="0" {{$record['status'] == 0?'selected':''}}>{{ __('Inactive')}}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">{{ __('Type')}} </label>
                <select class="form-control select2" name="type" required>
                    <option {{$record['status'] == 1?'selected':''}} value="1">{{ __('Internal')}}</option>
                    <option value="0" {{$record['status'] == 0?'selected':''}}>{{ __('External')}}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Title')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" value="{{$record['title']}}" placeholder="Title" required name="title">
                <div class="help-block with-errors"></div>

                @error('title')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror

            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('URL')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="URL" value="{{$record['slug']}}" name="slug">
            </div>
            <div class="form-group" style="padding-top: 0.5rem;">
                <button type="submit" class="btn btn-primary mr-2">{{ __('Submit')}}</button>
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