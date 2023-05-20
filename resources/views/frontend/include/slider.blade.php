
<div class="slide_mobilde">
  <div id="layerslider" class="ls-wp-container">

    @foreach(getslider() as $slide)

    <div class="ls-slide" data-ls="slidedelay:3000;transition2d:all;">
      <img src="{{ asset('storage/slider/'.$slide['img']) }}" class="ls-bg" alt="{{$slide->heading}}" title="{{$slide->heading}}" /><a href="{{URL('drama-detail/'.$slide->slug)}}" class="ls-link"></a>
    </div>

    @endforeach

  </div>
</div>