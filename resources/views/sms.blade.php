@extends('layouts.main') 
@section('title', 'Table Bootstrap')
@section('content')
    <!-- push external head elements to head -->
    @push('head')

        <link rel="stylesheet" href="{{ asset('plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">

        <link rel="stylesheet" href="{{ asset('plugins/jquery-toast-plugin/dist/jquery.toast.min.css')}}">
    @endpush

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-credit-card bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Bootstrap Tables')}}</h5>
                            <span>{{ __('lorem ipsum dolor sit amet, consectetur adipisicing elit')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Tables')}}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Bootstrap Tables')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="card p-3">
                    <div class="card-header d-block">
                        <h3>{{ __('Basic Table')}}</h3>
                        <span>use class <code>table</code> inside table element</span>
                    </div>
                    <div class="card-body p-0 table-border-style">
                    <form class="sample-form">   
                        <div class="form-group row p-3">
                            <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">{{ __('Country')}} </label>
                                        <select class="form-control select2" onchange="get_country_services();" id="country_id" name="country_id">  
                                            <option value='' selected>Select a Country</option>
                                            @foreach($country_list as $country)
                                            <option value="{{$country->country_id}}">{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                            </div>
                            <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">{{ __('Service/Project')}} </label>
                                        <select class="form-control select2" id="service_id" name="service_id">

                                           <option value='' selected>Select a Service</option>

                                        </select>
                                    </div>
                            </div>
                            <div class="col-md-6">
                            <div class="row mt-4">
                                <div class="col-md-3">
                                        <div class="form-group">
                                            <button class="btn btn-danger ">Price</button>
                                            <button class="btn btn-primary price_rate">0.0$</button>
                                        </div>
                                </div>

                                <div class="col-md-3">
                                        <div class="form-group">
                                            <button class="btn btn-success ">Get Number</button>
                                        </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </form>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>{{ __('Service/Project	Number(s)')}}</th>
                                        <th>{{ __('Country')}}</th>
                                        <th>{{ __('Phone')}}</th>
                                        <th>{{__('Status')}}</th>
                                        <th>{{ __('Sms code')}}</th>
                                        <th>{{ __('Left')}}</th>
                                        <th>{{ __('Action')}}</th>
                                        <th>{{ __('Whole SMS')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php
                                        $active_numbers = ['1','2','3','4'];
                                        ?>
                                     @foreach($active_numbers as $number)

                                    <tr>
                                        <th scope="row">663662753</th>
                                        <td>Mark</td>
                                        <td>Rasia</td>
                                        <td>855381164977</td>
                                        <td>Press the green button after the SMS is sent</td>
                                        <td>Waiting</td>
                                        <td>17min</td>
                                        <td>
                                            <button  type="button" class="btn btn-success btn-icon ml-2 mb-2"><i class="ik ik-check"></i></button>

                                            <button  type="button"  class="btn btn-danger btn-icon ml-2 mb-2" ><i class="ik ik-minus"></i></button>
                                            <button  type="button" class="btn btn-success btn-icon ml-2 mb-2"><i class="ik ik-plus"></i></button>
                                    </td>
                                        <td>whole</td>
                                    </tr>
                                    @endforeach
                                   
                                  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
      
    
    <!-- push external js -->
    @push('script')  

        <script src="{{ asset('plugins/jquery-toast-plugin/dist/jquery.toast.min.js')}}"></script>
        
        <script src="{{ asset('js/alerts.js')}}"></script>

        <script src="{{ asset('plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

        <script src="{{ asset('js/tables.js') }}"></script>



<script type="text/javascript">
        
        $(document).ready(function(){
                $('#service_id').change(function(){
                var rate = $(this).children('option:selected').data('rate');
                $('.price_rate').text(rate+' $');
                 });


                 $('form').on('submit', function(e){
                    
                    e.preventDefault();
                    var valid = true;
                    var country = $('#country_id').val();
                    var service = $("#service_id").val();


                    if(country == '' || service == '')
                        valid = false;

                    if(!valid) 
                    {
                    $.toast({
                    heading: 'Information',
                    text: 'Loaders are enabled by default. Use `loader`, `loaderBg` to change the default behavior',
                    icon: 'info',
                    loader: true,        // Change it to false to disable loader
                    loaderBg: '#9EC600'  // To change the background
                    });

                    showDangerToast({
    heading: 'Headings',
    text: 'You can use the `heading` property to specify the heading of the toast message.',
});
                    }
                   
                    else
                    {   
                        var form = $(this);
                        var url = "{{url('getnumber')}}"
                        
                        $.ajax({
                               type: "GET",
                               url: url,
                               data: form.serialize(), // serializes the form's elements.
                               success: function(data)
                               {    
                                   showWarningToast();
                                   showSuccessToast();
                                   showInfoToast();
                                   showDangerToast();
                                   //alert(data); // show response from the php script.
                               }
                             });
                    }
                 });

         });


function get_country_services()
    {   
        $('.price_rate').text('0.0$');
        var country = $('#country_id').val();
         $.ajax(
        {
            type:"GET",
            url: "{{url('getSerives')}}",
            data:{ country:country},
            dataType: "json",
            success:function(response)
            {
                $("#service_id").html(response);
            }

        }
        );
       
    }
</script>
@endpush
@endsection
   