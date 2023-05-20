@extends('layouts.main') 
@section('title', 'Edit Drama')
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
                            <h5>{{ __('Edit Drama')}}</h5>
                            <span>{{ __('Edit drama detail')}}</span>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-8">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <a href="{{ url('drama/list') }}">
                    <button style="color: #fff;background-color: #202C50;border-radius: 10px;font-size: 12px; padding: 8px 16px;"data-toggle="tooltip" data-placement="top" title="Add Drama">{{ __('View Drama')}}</button>    
                        </a>  
                    </nav>
                </div>
                <div class="col-lg-2">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ url('drama/list') }}">{{ __('Drama List')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Edit')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <form class="forms-sample" method="POST" enctype="multipart/form-data" action="{{ url('drama/update') }}" >
        @csrf
        <input type="hidden" name="id" value="{{$record['id']}}">
        <?php
        // echo "<pre>"; 
        // print_r($record);
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
                    <option {{$record['status'] == 1?'selected':''}} value="1">{{ __('Active')}}</option>
                    <option value="0" {{$record['status'] == 0?'selected':''}}>{{ __('Inactive')}}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">{{ __('Kshow')}} </label>
                <select class="form-control select2" name="is_kshow">
                    <option {{$record['is_kshow'] == 1?'selected':''}} value="1">{{ __('Yes')}}</option>
                    <option value="0" {{$record['is_kshow'] == 0?'selected':''}}>{{ __('No')}}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">{{ __('Country')}} </label>
                <select class="form-control select2" name="country_id">


                    
                    @foreach(country_menu() as $country)
                    <option {{$record['country_id'] == $country['id']?'selected':'' }} value="{{$country['id']}}">{{$country['title']}}</option>
                    @endforeach
                 
                </select>
            </div>
            <div class="form-group">
                <label for="">{{ __('Genre')}} </label>
                <select class="form-control select2" multiple="multiple" name="genre[]">
                    @foreach($record['genre'] as $row)
                    <option selected value="{{$row['name']}}">{{ $row['name']}}</option>
                    @endforeach
                     @foreach($genre as $row)
                    <option value="{{$row['title']}}">{{ $row['title']}}</option>
                     @endforeach
                   
                </select>
            </div>
           <div class="form-group">
                <label for="">{{ __('Tags')}} </label>
                <select class="form-control select2" multiple="multiple" name="tags[]">
                    @foreach($record['tags'] as $row)
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
                <option {{$letter == $record['first_char']?'selected':''}} value="{{$letter}}">{{ __($letter)}}</option>
                    @endforeach
                    <option value="#">{{ __('#')}}</option> 
                </select>
            </div>
             <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Title')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Title" name="title" value="{{$record['title']}}">
            </div>
             <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Title For URL')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Title For URL" name="slug" value="{{$record['slug']}}">
            </div>

            <?php
            // echo "<pre>";
            // print_r($record['othername']);
            // die();
            ?>
              <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Other Names')}}</label><br>
                <input type="text" class="form-control" id="tags" placeholder="Other Names"  value="{{get_othername($record['othername'])}}" name="other_names">
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
                    <img  width="70px" height="50px" src="{{asset('public/storage/drama/'.$record['icon'])}}">
            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Reff URl')}}</label>
                <input type="text" name="reff_url" class="form-control" id="exampleInputUsername1" placeholder="Reff URl" value="{{$record['reff_url']}}" >
            </div>
            <div class="form-group">
                <label for="">{{ __('Drama Status')}} </label>
                <select class="form-control select2" name="drama_status">
                    <option {{$record['drama_status'] == 1?'selected':''}} value="1">{{ __('Upcoming')}}</option>
                    <option value="2" {{$record['drama_status'] == 2?'selected':''}}>{{ __('Ongoing')}}</option>
                    <option value="3" {{$record['drama_status'] == 3?'selected':''}}>{{ __('Completed')}}</option>

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
            <label for="">{{ __('Release Year')}} </label>
            <select class="form-control select2" name="release_year"> 
                    @foreach (range(1970,2022) as $letter)    
               <option {{$letter == $record['release_year']?'selected':''}} value="{{$letter}}">{{ __($letter)}}</option>
                    @endforeach
                </select>
        </div>
        <div class="form-group">
        <label>{{ __('Release Date')}}</label>
            <input class="form-control" type="date" name="release_date" value="{{ $record->release_date}}">
        </div>
        <div class="form-group">
            <label for="exampleTextarea1">{{ __('Drama Cast')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="4" name="cast">{{$record['cast']}}</textarea>
        </div>
        <div class="form-group">
            <label for="exampleTextarea1">{{ __('Drama Trailer Youtube URL')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="4" name="trailer_yt_url">{{$record['trailer_yt_url']}}</textarea>
        </div>
        <div class="form-group">
            <label for="exampleTextarea1">{{ __('Meta Title')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="4" name="meta_title">{{$record['meta_title']}}</textarea>
        </div>
        <div class="form-group">
            <label for="exampleTextarea1">{{ __('Meta Keywords')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="4" name="meta_kwd">{{$record['meta_kwd']}}</textarea>
        </div>
        <div class="form-group">
            <label for="exampleTextarea1">{{ __('Meta Description')}}</label>
            <textarea class="form-control" id="exampleTextarea1" rows="4" name="meta_desc">{{$record['meta_desc']}}</textarea>
        </div>
    </div>
</div>
</div>
</div>
</div>
<div class="col-md-12">
    <div class="card">
        <div class="card-header"><h3>{{ __('Main Description')}}</h3></div>
        <div class="card-body">
            <textarea class="form-control html-editor" rows="20" name="description">{{$record['description']}}</textarea>
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
@endpush
@endsection