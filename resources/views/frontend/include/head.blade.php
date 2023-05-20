<?php
$fivicon = asset('storage/site/'.$settings->site_icon);
$default = asset('favicon.png');
?>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
{!! MetaTag::tag('description') !!}{!! MetaTag::tag('keywords') !!}
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="{{ $fivicon ?? $default }}" />
<!-- font awesome library -->
<!-- <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">
 -->
<!-- <script src="{{ asset('js/app.js') }}"></script> -->

<!-- themekit admin template asstes -->

	<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/font-awesome.min096a.css?v=4.7') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/main096a.css?v=4.7') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/mobi096a.css?v=4.7') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/res096a.css?v=4.7') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/plugins/slideshow/css/layerslider096a.css?v=4.8') }}" />



<!-- Stack array for including inline css or head elements -->
@stack('head')

<!-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> -->
