@extends('layouts.main') 
@section('title', 'CMS Pages List')
@section('content')

   <!-- push external head elements to head -->
    @push('head')

        <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/summernote/dist/summernote-bs4.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/mohithg-switchery/dist/switchery.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">

    @endpush
     <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-12">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ url('cms-pages/add') }}">{{ __('CMS Pages')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('List')}}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>{{ __('CMS Pages List')}}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('cms-pages/add') }}">
                                    <button style="color: #fff;background-color: #202C50;border-radius: 10px;font-size: 12px; padding: 8px 16px;"data-toggle="tooltip" data-placement="top" title="Add CMS Pages">{{ __('Add CMS Pages')}}</button>    
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
       <!-- <form class="forms-sample" enctype="multipart/form-data" method="POST" action="{{ url('cms-pages/fetch') }}" >
        @csrf
        <div class="row">
        <div class="col-md-12">
        <div class="card">
        <div class="card-body">
        <div class="row">
        <div class="col-md-3">
           <div class="form-group">
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Title For URL" name="title_url">
            </div>
            </div>
            <div class="col-md-2">
           <div class="form-group">
                <select class="form-control select2" name="status">
                    <option value="cheese">{{ __('Cheese')}}</option>
                    <option value="tomatoes">{{ __('Tomatoes')}}</option>
                    <option value="mozarella">{{ __('Mozzarella')}}</option>
                    <option value="mushrooms">{{ __('Mushrooms')}}</option>
                    <option value="pepperoni">{{ __('Pepperoni')}}</option>
                    <option value="onions">{{ __('Onions')}}</option>
                </select>
            </div>
         </div>
         <div class="col-md-2">
           <div class="form-group">
                <select class="form-control select2" name="status">
                    <option value="cheese">{{ __('Cheese')}}</option>
                    <option value="tomatoes">{{ __('Tomatoes')}}</option>
                    <option value="mozarella">{{ __('Mozzarella')}}</option>
                    <option value="mushrooms">{{ __('Mushrooms')}}</option>
                    <option value="pepperoni">{{ __('Pepperoni')}}</option>
                    <option value="onions">{{ __('Onions')}}</option>
                </select>
            </div>
         </div>
         <div class="col-md-1">
           <div class="form-group">
                <button type="submit" class="btn btn-success mr-2" name="search">{{ __('Search')}}</button>
            </div>
         </div>
         <div class="col-md-1">
           <div class="form-group">
               <button type="submit" class="btn btn-danger mr-2" name="clear">{{ __('Clear')}}</button>
            </div>
         </div>
        </div>
        </div>
        </div>
        </div>
        </div>
       </form> -->
        <div class="row">
            <!-- start message area-->
            @include('include.message')
            <!-- end message area-->
            <div class="col-sm-12">
                <div class="card">
                    <!-- <div class="card-header d-block">
                        <h3>{{ __('CMS Pages list')}}</h3>
                    </div> -->
                    <div class="card-body">
                        <div class="dt-responsive container-fluid">
                            <table id="simpletable"
                                   class="table table-striped table-bordered nowrap">
                                <thead>
                                <tr>
                                    <th>{{ __('Status')}}</th>
                                    <th>{{ __('Page Title')}}</th>
                                    <th>{{ __('Title For Menu')}}</th>
                                    <th>{{ __('URL Title')}}</th>
                                    <th>{{ __('IP')}}</th>
                                    <th>{{ __('Create date')}}</th>
                                    <th>{{ __('Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                   @foreach($data as $row)
                                   <tr>
                                        <td>
                                        {{$row['status']==1?'Active':'Inactive'}}</td>
                                        <td>{{$row['page_title']}}</td>
                                        <td>{{$row['title_menu']}}</td>
                                        <td>{{$row['slug']}}</td>
                                        <td>{{$row['ip']}}</td>
                                        <td>{{$row['created_at']}}</td>
                                        <td><div class="table-actions">
                                          <a href="{{url('cms-pages/edit/'.$row['id'])}}"><i class="ik ik-edit-2 btn btn-success "data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                                            <a href="{{url('cms-pages/delete/'.$row['id'])}}"><i class="ik ik-trash-2 btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
                                        </div></td>
                                    </tr>

                                   @endforeach 
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>{{ __('Status')}}</th>
                                    <th>{{ __('Page Title')}}</th>
                                    <th>{{ __('Title For Menu')}}</th>
                                    <th>{{ __('URL Title')}}</th>
                                    <th>{{ __('IP')}}</th>
                                    <th>{{ __('Create date')}}</th>
                                    <th>{{ __('Action')}}</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <!-- push external js -->
    @push('script')  
    <script src="{{ asset('plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('js/tables.js') }}"></script>
        <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('plugins/summernote/dist/summernote-bs4.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
        <script src="{{ asset('plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
        <script src="{{ asset('plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script src="{{ asset('js/form-advanced.js') }}"></script>
        <script src="{{ asset('js/form-components.js') }}"></script>
        <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
        <script src="{{ asset('js/datatables.js') }}"></script>
    @endpush
@endsection