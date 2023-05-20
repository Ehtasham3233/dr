@php
    $settings = get_setting();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
<head>
<title>{!! MetaTag::get('title') !!}</title>
    <!-- initiate head with meta tags, css and script -->
    @include('frontend.include.head')

   
    @if(isset($settings->befor_head))
     <!--  /////// before Head Code From Admin Side -->
    {!!$settings->befor_head!!}
    @endif
</head>

<body>
    <div class="container">
        <!-- initiate header-->
        @include('frontend.include.header')

        <div class="content">
                <!-- yeild contents here -->
                @yield('content')
        </div>


        <!-- initiate footer section-->
        @include('frontend.include.footer')
    </div>

    <!-- initiate scripts-->
    @include('frontend.include.script')  




    @if(isset($settings->before_body))
    <!--  /////// before Body Close Code From Admin Side -->
    {!!$settings->before_body!!}
    @endif
</body>
</html>