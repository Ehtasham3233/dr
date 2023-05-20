<header>
  <ul class="char-list">
    <li><a href="{{url('drama-list')}}" title="Drama List">ALL</a></li>
    <li><a href="{{ url('drama-list/char-start-other')}}" title="Drama List With Special Character">#</a></li>
    
  
    @foreach (range('A','Z') as $letter)    
    <li>
    <a href="{{ url('drama-list/char-start-'.strtolower($letter))}}" title="Drama List With {{$letter}} Character">{{$letter}}</a>
    </li>
    @endforeach
      </ul>

  <div class="logo">
    <a href="{{ url('/') }}" class="ads-evt" title="Home">
      <img src="{{ asset('frontend/images/logo.jpg') }}" alt="Watchasian - Asian Drama, Movies" />  </a>
    <div class="res_mobi menu_m">
        <div class="left"><a href="#" class="up-down menu_mobile"><img src="{{ asset('frontend/images/mobi/up_down.png') }}" alt="up-dow"></a></div>
        <div class="right"><a href="{{ url('/') }}"><img src="{{ asset('frontend/images/mobi/logo.png') }}" alt="logo">
        </a></div>
</div>
    <form class="search" action="{{ url('search') }}">
      <select name="type" id="search-type">
        <option value="movies">Movies</option>
        <option value="drama">Drama</option>
      </select>
      <input type="text" id="search-key" name="keyword" placeholder="Search">
      <button><img src="{{ asset('frontend/images/button-search.png') }}" alt="button search" /></button>
    </form>
  </div>

  <nav class="menu_top">
    <ul class="navbar">
      <li><a href="{{ url('/') }}" title="Home"><img src="{{ asset('frontend/images/home.png') }}
        " alt="home" /></a></li>
      <li>
        <a href="{{url('drama-list')}}" title="Drama List">Drama List</a>
        <ul class="sub-nav">

            @foreach(country_menu() as $country)

                <li><a href="{{url('country/'.$country['slug'])}}-drama" title="{{$country['title']}} Drama">{{$country['title']}} Drama</a></li>

            @endforeach
                    

                </ul>
      </li>
      <li>
        <a href="{{url('movie-list')}}">Drama Movie</a>
        <ul class="sub-nav">


            @foreach(country_menu() as $country)

                <li><a href="{{url('country/'.$country['slug'])}}-movie" title="{{$country['title']}} Movie">{{$country['title']}} Movie</a></li>

            @endforeach
                </ul>
      </li>
      <li><a href="{{url('kshows')}}" title="KShows">KShow</a></li>
      <li><a href="{{url('most-popular-drama')}}" title="Popular Drama">Popular Drama</a></li>
     
        </li>
        </ul>
  </nav>
</header>