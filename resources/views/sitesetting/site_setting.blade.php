@extends('layouts.main') 
@section('title', 'Manage Site Information')
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
                        <i class="fas fa-tv bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Manage Site Information')}}</h5>
                            <span>{{ __('Information of site')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Site Setting')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <form class="forms-sample" enctype="multipart/form-data" method="POST" action="{{ url('site-setting/store') }}" >
        @csrf
        <div class="row">

            <!-- start message area-->
            @include('include.message')
            <!-- end message area-->

        <div class="col-md-6">
        <div class="card">
            <div class="card-header">     
            <h4><b>{{ __('Genrel Detail')}}</b></h4>
            </div>
        <div class="card-body">
        <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Site Title')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Site Title" required value="{{$SiteSettings->title}}" name="title">
                <div class="help-block with-errors"></div>

                @error('title')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror

            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Site Title Short')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Site Title" required value="{{$SiteSettings->site_title_sort}}" name="site_title_sort">
                <div class="help-block with-errors"></div>

                @error('title')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror

            </div>
            <div class="form-group">
                <label>{{ __('Site Logo')}}</label>
                <input type="file" name="site_logo" class="file-upload-default">
                <div class="input-group col-xs-12">
                    <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Site Logo">
                    <span class="input-group-append">
                        <button class="file-upload-browse btn btn-primary" type="button">{{ __('Upload')}}</button>
                    </span>
                </div>
                <img style="margin-left: 14rem;" width="150px" height="30" src="{{url('storage/site/',$SiteSettings['site_logo'])}}">
            </div>
            <div class="form-group">
                <label>{{ __('Site FAV Icon')}}</label>
                <input type="file" name="site_icon" class="file-upload-default">
                <div class="input-group col-xs-12">
                    <input type="text" class="form-control file-upload-info" disabled placeholder="Upload FAV Icon">
                    <span class="input-group-append">
                        <button class="file-upload-browse btn btn-primary" type="button">{{ __('Upload')}}</button>
                    </span>
                </div>
               <img style="margin-left: 17rem;" width="auto" height="auto" src="{{url('storage/site/',$SiteSettings['site_icon'])}}">
            </div>
            <div class="form-group">
                <label>{{ __('Logo For Mobile')}}</label>
                <input type="file" name="logo_mobile" class="file-upload-default">
                <div class="input-group col-xs-12">
                    <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Mobile Logo">
                    <span class="input-group-append">
                        <button class="file-upload-browse btn btn-primary" type="button">{{ __('Upload')}}</button>
                    </span>
                </div>
              <img style="margin-left: 14rem;" width="150px" height="30" src="{{url('storage/site/',$SiteSettings['logo_mobile'])}}">
            </div>
            <div class="form-group">
                <label>{{ __('Site OG Image For Sharing')}}</label>
                <input type="file" name="site_img" class="file-upload-default">
                <div class="input-group col-xs-12">
                    <input type="text" class="form-control file-upload-info" disabled placeholder="Upload OG Image">
                    <span class="input-group-append">
                        <button class="file-upload-browse btn btn-primary" type="button">{{ __('Upload')}}</button>
                    </span>
                </div>
              <img style="margin-left: 14rem;" width="150px" height="30" src="{{url('storage/site/',$SiteSettings['site_img'])}}">
            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Contact Email')}}</label>
                <input type="email" class="form-control" id="exampleInputUsername1" placeholder="Contact Email" required value="{{$SiteSettings->email}}" name="email">
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Contact Phone')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Contact Phone" required value="{{$SiteSettings->phone}}" name="phone">
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
            <label for="exampleTextarea1">{{ __('Contact Address')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="3"  name="address">{{$SiteSettings->address}}</textarea>
        </div>
        <div class="form-group">
                <label for="">{{ __('Comment Type')}} </label>
                <select class="form-control select2" name="com_type">
                    <option value="1">{{ __('Manual Commet Post')}}</option>
                    <option value="0">{{ __('Auto Commet Post')}}</option>
                </select>
            </div>
            </div>
        </div>
    </div>
</div>
  <div class="card">
        <div class="card-header">     
            <h4><b>{{ __('Admin Side')}}</b></h4>
            </div>
    <div class="card-body">
    <div class="row">
    <div class="col-md-12">
        <div class="form-group">
                <label>{{ __('Admin Dark Logo')}}</label>
                <input type="file" name="admin_dark_logo" class="file-upload-default">
                <div class="input-group col-xs-12">
                    <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Dark Logo">
                    <span class="input-group-append">
                        <button class="file-upload-browse btn btn-primary" type="button">{{ __('Upload')}}</button>
                    </span>
                </div>
                <img style="margin-left: 14rem;" width="150px" height="30" src="{{url('storage/site/',$SiteSettings['admin_dark_logo'])}}">
            </div>
            <div class="form-group">
                <label>{{ __('Admin Light Logo')}}</label>
                <input type="file" name="admin_light_logo" class="file-upload-default">
                <div class="input-group col-xs-12">
                    <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Light Logo">
                    <span class="input-group-append">
                        <button class="file-upload-browse btn btn-primary" type="button">{{ __('Upload')}}</button>
                    </span>
                </div>
                <img style="margin-left: 14rem;" width="150px" height="30" src="{{url('storage/site/',$SiteSettings['admin_light_logo'])}}">
            </div>
             <div class="form-group" style="padding-top: 0.6rem;">
                <button type="submit" style="color: #fff;background-color: #202C50;border-radius: 10px;font-size: 12px; padding: 6px 14px;"data-toggle="tooltip" data-placement="top" title="Update">{{ __('Update')}}</button>
            </div>
    </div>
</div>
</div>
</div>
</div>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">     
            <h4><b>{{ __('Social Links')}}</b></h4>
            </div>
    <div class="card-body">
    <div class="row">
    <div class="col-md-12">
        <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Facebook URL')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Facebook URL"  value="{{$SiteSettings->fb_url}}" name="fb_url">
            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Twiter URL')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Twiter URL"  value="{{$SiteSettings->twtr_url}}" name="twtr_url">
            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Youtube URL')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Youtube URL"  value="{{$SiteSettings->yt_url}}" name="yt_url">
            </div>
        <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Google+ URL')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Google+ URL"  value="{{$SiteSettings->google_url}}" name="google_url">
            </div>
        <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Pinterest URL')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Pinterest URL"  value="{{$SiteSettings->pin_url}}" name="pin_url">
            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Reddit URL')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Reddit URL"  value="{{$SiteSettings->reddit_url}}" name="reddit_url">
            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Vimeo URL')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Vimeo UR"  value="{{$SiteSettings->vimeo_url}}" name="vimeo_url">
            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Linkedin URL')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Linkedin URL"  value="{{$SiteSettings->linkedin_url}}" name="linkedin_url">
            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Instagram URL')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Instagram URL"  value="{{$SiteSettings->ins_url}}" name="ins_url">
            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Telegram URL')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Telegram UR"  value="{{$SiteSettings->tele_url}}" name="tele_url">
            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Footer Text')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Footer Text"  value="{{$SiteSettings->footer_text}}" name="footer_text">
            </div>
            <div class="form-group">
            <label for="exampleTextarea1">{{ __('Befor Head Close')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="12" name="befor_head">{{$SiteSettings->befor_head}}</textarea>
        </div>
        <!-- <div class="form-group">
            <label for="exampleTextarea1">{{ __('After Body Start')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="7" name="after_body">{{$SiteSettings->after_body}}</textarea>
        </div> -->
        <div class="form-group">
            <label for="exampleTextarea1">{{ __('Before Body Close')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="12" name="before_body">{{$SiteSettings->before_body}}</textarea>
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