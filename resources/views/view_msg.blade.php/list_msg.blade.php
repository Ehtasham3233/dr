@extends('layouts.main') 
@section('title', 'Users')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
    @endpush

    
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-3">
                    <div class="page-header-title">
                        <i class="fas fa-tv bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Massages List')}}</h5>
                            <span>{{ __('Complete list of Massages')}}</span>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-7">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <a href="{{ url('tags/add') }}">
                    <button style="color: #fff;background-color: #202C50;border-radius: 10px;font-size: 12px; padding: 8px 16px;"data-toggle="tooltip" data-placement="top" title="Add Tags">{{ __('Add Tags')}}</button>    
                        </a>  
                    </nav>
                </div>
                <div class="col-lg-2">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Massages List')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- start message area-->
            @include('include.message')
            <!-- end message area-->
            <div class="col-md-12">
                <div class="card p-5">
                  <!--   <div class="card-header"><h3>{{ __('Users')}}</h3></div> -->
                    <div class="card-body">
                        <table id="msgs_table" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Name')}}</th>
                                    <th>{{ __('Email')}}</th>
                                    <th>{{ __('Subject')}}</th>
                                    <th>{{ __('Body')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <!--server side users table script-->
    <!-- <script src="{{ asset('js/custom.js') }}"></script> -->


    <script type="text/javascript">
           //drama data table
    $(document).ready(function()
    {

        var searchable = [];
        var selectable = []; 
        

        var dTable = $('#msgs_table').DataTable({

            order: [],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            processing: true,
            responsive: false,
            serverSide: true,
            processing: true,
            language: {
              processing: '<i class="ace-icon fa fa-spinner fa-spin orange bigger-500" style="font-size:60px;margin-bottom:30px;margin-top:30px;"></i>'
            },
            scroller: {
                loadingIndicator: false
            },
            pagingType: "full_numbers",
            dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
            ajax: {
                url: 'get-msg-list',
                type: "get"
            },
            columns: [
                /*{data:'serial_no', name: 'serial_no'},*/
                {data:'name', name: 'name'},
                {data:'email', name: 'email'},
                {data:'subject', name: 'subject'},
                //only those have manage_user permission will get access
                {data:'body', name: 'body'}

            ],
            buttons: [],
            initComplete: function () {
                var api =  this.api();
                api.columns(searchable).every(function () {
                    var column = this;
                    var input = document.createElement("input");
                    input.setAttribute('placeholder', $(column.header()).text());
                    input.setAttribute('style', 'width: 140px; height:25px; border:1px solid whitesmoke;');

                    $(input).appendTo($(column.header()).empty())
                    .on('keyup', function () {
                        column.search($(this).val(), false, false, true).draw();
                    });

                    $('input', this.column(column).header()).on('click', function(e) {
                        e.stopPropagation();
                    });
                });
            }
        });
    });
    </script>

    @endpush
@endsection
