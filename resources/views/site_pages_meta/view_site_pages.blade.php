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
                            <h5>{{ __('View Site Pages Meta')}}</h5>
                            <span>{{ __('Information of meta site Pages')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Meta Site Page')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card">
                    <!-- <div class="card-header d-block">
                        <h3>{{ __('Hover Table')}}</h3>
                        <span>use class <code>table-hover</code> inside table element</span>
                    </div> -->
                    <div class="card-body p-0 table-border-style">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="col-md-2">#</th>
                                        <th class="col-md-8">{{ __('First Name')}}</th>
                                        <th class="col-md-2">{{ __('Last Name')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $row)
                                     <?php
                                     // echo "<pre>";
                                     // print_r($row);
                                     // die();


                                      ?>

                                    <tr>
                                        <th scope="row">{{$row['id']}}</th>
                                        <td>{{$row['page_name']}}</td>
                                        <td>
                                        <a href="{{url('edit_site_pages/'.$row['id'])}}"><i class="ik ik-edit-2 btn btn-primary "data-toggle="tooltip" data-placement="top" title="Edit"></i></a></td>
                                    </tr>
                                    @endforeach
                                    <!-- <tr>
                                        <th scope="row">2</th>
                                        <td>Jacob</td>
                                        <td>
                                        <a href="#"><i class="ik ik-edit-2 btn btn-primary "data-toggle="tooltip" data-placement="top" title="Edit"></i></a></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>Larry</td>
                                        <td>
                                        <a href="#"><i class="ik ik-edit-2 btn btn-primary "data-toggle="tooltip" data-placement="top" title="Edit"></i></a></td>
                                    </tr> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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