@extends('frontend.layouts.main') 

@section('content')


<?php

// print_r(Request::segment(2));
// die();


?>


<div class="content-left">

    <div class="ads_place"></div>
    <div class="block list">

        <div class="filter">
            <select id="select-genre">
                <option value="">-Select Genre-</option>
                @foreach(movie_genre_menu() as $genry)
                <option value="{{$genry['name']}}">{{$genry['name']}}</option>
                @endforeach
            </select>

            <select id="select-year">
                <option value="">-Select Year-</option>
                 @foreach(movie_realse_year_menu() as $year)
                <option value="{{$year['release_year']}}">{{$year['release_year']}}</option>
                @endforeach
            </select>

            <select id="select-country">
                <option value="">-Select Country-</option>
                @foreach(country_menu() as $country)
                <option value="{{$country['id']}}">{{$country['title']}}</option>
                @endforeach
            </select>
            
            <select id="select-status">
                <option value="">-Select Status-</option>
                <option value="2">Ongoing</option>
                <option value="3">Completed</option>
                <option value="1">Upcoming</option>
            </select>
        </div>

        <div>

            @foreach($dramas as $key => $row)

            <div class="list-content">
                <div class="title-list">
                    <a href="{{url('movie-list/char-start-'.strtolower($key))}}">View More</a>
                    <h4>{{$key}}</h4>
                </div>

                <ul class="filter-char">
            @foreach($row as $list)
                <li class="show filter-item year_{{$list['year']}} country_{{$list['country']}} status_{{$list['status']}}"
                 data-genre='{{ json_encode($list["genre"])}}'>
                 <span class="year">{{$list['year']}}</span>
                 <a href="{{url('movie-detail/'.$list['slug'])}}">{{$list['title']}}</a>
                </li>
            @endforeach

        </ul>
        </div>

        @endforeach
</div>
</div>

</div>

@include('frontend.include.rightbar')



 <!-- push external js -->
    @push('script')  
    
    <script>
        $(".filter select").change(function () {
            var year = $("#select-year").val();
            var country = $("#select-country").val();
            var status = $("#select-status").val();
            var genre = $("#select-genre").val();
            var filter = '.filter-item';
            if (year) {
                filter += '.year_' + year;
            }
            if (country) {
                filter += '.country_' + country;
            }
            if (status) {
                filter += '.status_' + status;
            }

            $(".filter-item").removeClass('show').addClass('hidden');

            $('.filter-char').each(function () {
                if (genre) {
                    filter += "[data-genre*='" + genre + "']";
                }
                $(this).find(filter).each(function (index) {
                    if (index >= 6) {
                        return;
                    } else {
                        $(this).removeClass('hidden').addClass('show');
                    }
                });
            });
        });

    </script>

    @endpush
@endsection