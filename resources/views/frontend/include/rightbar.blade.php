
    @php
         $segment1 = request()->segment(1);
         $segment2 = request()->segment(2);
         $segment3 = request()->segment(3);

         $setting = $sidebar['settings'];

    @endphp

<div class="content-right">

@if($segment1 == '')

@endif
<div class="clr"></div>
<div class="block-tab">
    <ul class="tab">
        <li data-tab="right-tab-1" >Ads</li>
        <li data-tab="right-tab-2" >Coming Eps</li>
        <li data-tab="right-tab-3" class="selected">Ongoing</li>
    </ul>
    <div class="block tab-container list-right">
        <div class="tab-content right-tab-1">
            <h4 class="content-right-title"><i class="fa fa-clock-o"></i> Ads</h4>
        </div>
        <div class="tab-content right-tab-2">
            <h4 class="content-right-title"><i class="fa fa-clock-o"></i> Coming Episode</h4>

            <ul>
                @if(count($sidebar['upcoming'])>0)
                        @foreach($sidebar['upcoming'] as $row)
                        <li><h3><a href="{{url('drama-detail/'.$row['slug'])}}">{{$row['title']}}</a></h3>
                            <span class="time">Delayed</span>
                        </li>
                        @endforeach    
                @endif

                   <!--  <span class="time">About 5 days</span> -->
            </ul>
            <div class="view-more">
                <a href="{{url('popular/upcoming-series')}}">View more</a>
            </div>
        </div>
        <div class="tab-content right-tab-3 selected">
            <h4 class="content-right-title"><i class="fa fa-heart"></i> Popular Ongoing</h4>
            <ul>
                @if(count($sidebar['ongoing'])>0)
                        @foreach($sidebar['ongoing'] as $row)
                        <li><h3><a href="{{url('drama-detail/'.$row['slug'])}}">{{$row['title']}}</a></h3>
                        </li>
                        @endforeach    
                @endif
            </ul>
        <div class="view-more">
            <a href="{{url('popular/ongoing-series')}}">View more</a>
        </div>
    </div>
</div>
</div>
</div>