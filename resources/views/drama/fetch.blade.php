@extends('layouts.main') 
@section('title', 'Fetch Drama')
@section('content')

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="fas fa-tv bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Fatch Drama')}}</h5>
                            <span>{{ __('Fatch drama by url')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Fatch Drama')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">

                <!-- start message area-->
            @include('include.message')
            <!-- end message area-->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        
                        <h3>{{ __('Fetch Drama Data')}}</h3>
                    </div>
                    <div class="card-body">
            
                            <form class="forms-sample" method="POST" action="{{ url('drama/fetch') }}" >
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputUsername1">{{ __('Drama URl')}}</label>
                                <input type="text" value="{{$drama_url ?? ''}}" name="url" class="form-control" id="exampleInputUsername1" placeholder="URL">
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">{{ __('Submit')}}</button>
    
                          </form>
                    </div>
                </div>
            </div>

        </div>

        @if(!empty($drama_details))
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="row">
                        <div class="col-md-8">
                        <div class="card-header">
                        <h3>{{ __('Fetch Drama Data')}}</h3>
                        </div>
                        </div>
                            <div class="col-md-4">

                            <form class="forms-sample" method="POST" action="{{ url('drama/save') }}" >
                            @csrf
                            <div class="form-group">
                                <input type="hidden" value="{{ json_encode($drama_details)}}" name="drama_data" class="form-control">

                                <input type="hidden" name="reff_url" value="{{$drama_url}}">
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">{{ __('Save Drama In Database')}}</button>
                          </form>
                            </div>
                    </div>
                    <div class="card-body">
            
                <div class="container">
                  <div class="row">
                    <div class="col-sm-4 mb-20" class="card">
                      <img class="img-fluid" src="{{$drama_details['drama_icon']['drama_icon']}}"  alt="Card image">
                    </div>
                    <div class="col-sm-6">
                     <div class="card-title"> <h3>{{$drama_details['title_and_url']['drama_title']}}</h3></div>
 
                      <p class="card-text">
                        @if(isset($drama_details['getinfo']['drama_desc']))
                         <b>Discription:</b>
                      {{$drama_details['getinfo']['drama_desc']}}</p>
                      @endif

                      <p><b>URL:</b> {{$drama_details['title_and_url']['drama_title_url']}}</p>

                      @if(!empty($drama_details['getinfo']['drama_country']))
                            <p><b>Country:</b> {{$drama_details['getinfo']['drama_country']}}</p>
                      @endif 

                      @if(!empty($drama_details['getinfo']['drama_status']))
                            <p><b>Status:</b> {{$drama_details['getinfo']['drama_status']}}</p>
                      @endif 

                      @if(!empty($drama_details['getinfo']['drama_release_year']))
                            <p><b>Released:</b> {{$drama_details['getinfo']['drama_release_year']}}</p>
                      @endif 


                      @if(count($drama_details['getinfo']['drama_genre'])>0)       
                        <p><b>Genre:</b> 
                        {{implode(',',$drama_details['getinfo']['drama_genre'])}}
                    </p>
                      @endif


                      @if(count($drama_details['get_tag']['drama_tags'])>0) 
                        <p><b>Tags:</b> {{implode(',',$drama_details['get_tag']['drama_tags'])}}</p>
                      @endif

                    @if($drama_details['drama_cast']['status'])

                        <p><b>Cost:</b>{{$drama_details['drama_cast']['drama_cast']}}</p>
                                
                    @endif
  
                    @if($drama_details['other_names']['status'])

                    <?php
                    $names='';
                    foreach ($drama_details['other_names']['other_names'] as $key => $name) 
                        $names .= ' /'.$name;
                       ?> 
                        <p><b>Other Names:</b>{{$names}}</p>
                                
                    @else
                    <p><b>Other Names:</b>{{$drama_details['other_names']['msg']}}</p>
                    @endif


                          

                    </div>

                    @if($drama_details['drama_trailer']['status'])
                    <div class="col-sm-6" style="margin-bottom: 30px;">
                         <iframe width="728" height="459" src="https://www.youtube.com/embed/{{$drama_details['drama_trailer']['yt_vid_id']}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>         
                    @endif

                    @if(isset($drama_details['get_episodes']['drama_pisodes']) and count($drama_details['get_episodes']['drama_pisodes'])>0)

                    @foreach($drama_details['get_episodes']['drama_pisodes'] as $drama)
                    <div class="col-sm-12">
                        <button type="button" class="btn btn-primary">{{$drama['type']}}</button><label style="padding-left: 1cm"> {{$drama['title']}}</label>
                    </div>
                    @endforeach
                    @endif
                    
                  </div>
                 
                </div>
                
            
                    </div>
                </div>
            </div>

        </div>
        @endif

    
    </div>
    
    <!-- push external js -->
    @push('script')
        <script src="{{ asset('js/form-components.js') }}"></script>
    @endpush
@endsection