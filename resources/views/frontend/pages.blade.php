@extends('frontend.layouts.main') 
@section('content')
<div class="content">


	<div class="content-left">
            
  <div class="block">
	<h1>{{$data->page_title}}</h1>
	{!! $data->content !!}
      @if(Request::segment(1) == 'contact-us')
      @include('frontend.include.contactus')
      @endif
  </div>

 
   </div>



        
        
        @include('frontend.include.rightbar',['sidebar' => $sidebar])
    </div>
    
    @endsection