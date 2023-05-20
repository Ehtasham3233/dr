@extends('layouts.main') 
@section('title', 'Manage Site Information')
@section('content')

<!-- push external head elements to head -->
    @push('head')

        <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/summernote/dist/summernote-bs4.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/mohithg-switchery/dist/switchery.min.css') }}">

    @endpush

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="fas fa-tv bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Edit Site Pages Meta')}}</h5>
                            <span>{{ __('Edit meta site Page')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Meta Site Page')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card">
                    <div class="card-header d-block">
                        <h3>{{ __('Page Level Variables')}}</h3>
                    </div>
                    <div class="card-body p-0 table-border-style">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="padding-left:1rem ;" class="col-md-6">{{ __('Value')}}</th>
                                        <th class="col-md-6">{{ __('Short Code')}}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                     <?php 

                                     $spm_id = $record['id'];
                                     if(isset($spm_id) and ($spm_id == 1)){?>
                                                    <!--Drama Detail Page-->
                                                    <tr>
                                                        <td>Drama Title</td>
                                                        <td>[drama_title]</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Country Title</td>
                                                        <td>[con_title]</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Drama Status</td>
                                                        <td>[show_dstatus]</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Other Names List (comma spearated)</td>
                                                        <td>[show_other_names]</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Geners Lists (comma spearated)</td>
                                                        <td>[show_geners]</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tags List (comma spearated)</td>
                                                        <td>[show_tags]</td>
                                                    </tr>
                                                    
                                                <?php } ?>
                                                
                                                <?php if(isset($spm_id) and ($spm_id == 2)){?>
                                                    <!--Detail Episode Detail Page-->
                                                    <tr>
                                                        <td>Drama Title</td>
                                                        <td>[drama_title]</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Episode Title</td>
                                                        <td>[epi_title]</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Episode No.</td>
                                                        <td>[epi_no]</td>
                                                    </tr>                                                    
                                                <?php } ?>
                                                
                                               
                                                
                                                <?php if(isset($spm_id) and ($spm_id == 3)){?>
                                                    <!--Drama Listing Page By Country-->
                                                    <tr>
                                                        <td>Country Title</td>
                                                        <td>[con_title]</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Current Year</td>
                                                        <td>[current_year]</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Site Title</td>
                                                        <td>[site_title]</td>
                                                    </tr>                                               
                                                <?php } ?>
                                                
                                                <?php if(isset($spm_id) and ($spm_id == 4)){?>
                                                    <!--Drama Listing Page By Year-->
                                                    <tr>
                                                        <td>Released Year</td>
                                                        <td>[this_year]</td>
                                                    </tr>                                               
                                                <?php } ?>
                                                
                                                <?php if(isset($spm_id) and ($spm_id == 5)){?>
                                                    <!--Drama Listing Page By Drama Status-->
                                                    <tr>
                                                        <td>Drama Status</td>
                                                        <td>[drama_status]</td>
                                                    </tr>                                               
                                                <?php } ?>
                                                
                                                <?php if(isset($spm_id) and ($spm_id == 6)){?>
                                                    <!--Drama Listing Page By Genre-->
                                                    <tr>
                                                        <td>Genre</td>
                                                        <td>[gen_title]</td>
                                                    </tr>                                               
                                                <?php } ?>
                                                
                                                <?php if(isset($spm_id) and ($spm_id == 7)){?>
                                                    <!--Drama Listing Page By Tag-->
                                                    <tr>
                                                        <td>Tag</td>
                                                        <td>[tag_title]</td>
                                                    </tr>                                               
                                                <?php } ?>
                                                
                                                <?php if(isset($spm_id) and ($spm_id == 8)){?>
                                                    <!--Drama Listing Page By Char-->
                                                    <tr>
                                                        <td>Character</td>
                                                        <td>[show_char]</td>
                                                    </tr>                                               
                                                <?php } ?>
                                                
                                                <?php if(isset($spm_id) and ($spm_id == 11)){?>
                                                    <!--Movie Listing Page By Year-->
                                                    <tr>
                                                        <td>Released Year</td>
                                                        <td>[this_year]</td>
                                                    </tr>                                               
                                                <?php } ?>
                                                
                                                <?php if(isset($spm_id) and ($spm_id == 12)){?>
                                                    <!--Movie Listing Page By Movie Status-->
                                                    <tr>
                                                        <td>Movie Status</td>
                                                        <td>[movie_status]</td>
                                                    </tr>                                               
                                                <?php } ?>
                                                
                                                <?php if(isset($spm_id) and ($spm_id == 13)){?>
                                                    <!--Movie Listing Page By Genre-->
                                                    <tr>
                                                        <td>Genre</td>
                                                        <td>[gen_title]</td>
                                                    </tr>                                               
                                                <?php } ?>
                                                
                                                <?php if(isset($spm_id) and ($spm_id == 14)){?>
                                                    <!--Movie Listing Page By Tag-->
                                                    <tr>
                                                        <td>Tag</td>
                                                        <td>[tag_title]</td>
                                                    </tr>                                               
                                                <?php } ?>
                                                
                                                <?php if(isset($spm_id) and ($spm_id == 15)){?>
                                                    <!--Movie Listing Page By Country-->
                                                    <tr>
                                                        <td>Country Title</td>
                                                        <td>[con_title]</td>
                                                    </tr>                                               
                                                <?php } ?>
                                                
                                                <?php if(isset($spm_id) and ($spm_id == 16)){?>
                                                    <!--Movie Main Page-->
                                                    <tr>
                                                        <td>Movie Title</td>
                                                        <td>[movie_title]</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Country Title</td>
                                                        <td>[con_title]</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Movie Status</td>
                                                        <td>[show_dstatus]</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Geners Lists (comma spearated)</td>
                                                        <td>[show_geners]</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tags List (comma spearated)</td>
                                                        <td>[show_tags]</td>
                                                    </tr>
                                                    
                                                <?php } ?>
                                                
                                                <?php if(isset($spm_id) and ($spm_id == 17)){?>
                                                    <!--Movie Detail Page-->
                                                    <tr>
                                                        <td>Movie Title</td>
                                                        <td>[movie_title]</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Country Title</td>
                                                        <td>[con_title]</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Movie Status</td>
                                                        <td>[show_dstatus]</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Geners Lists (comma spearated)</td>
                                                        <td>[show_geners]</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tags List (comma spearated)</td>
                                                        <td>[show_tags]</td>
                                                    </tr>                                        
                                                <?php } ?>
                                                
                                                <?php if(isset($spm_id) and ($spm_id == 19)){?>
                                                    <!--Movie Detail Page-->
                                                    <tr>
                                                        <td>Blog Title</td>
                                                        <td>[art_title]</td>
                                                    </tr>                         
                                                <?php } ?>
                                                
                                                <?php if(isset($spm_id) and ($spm_id == 22)){?>
                                                    <!--Search Page With Results-->
                                                    <tr>
                                                        <td>Type (dramas or movies)</td>
                                                        <td>[show_type]</td>
                                                    </tr>   
                                                    <tr>
                                                        <td>Keyword searched</td>
                                                        <td>[show_kwd]</td>
                                                    </tr>                       
                                                <?php } ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

           <form class="forms-sample" enctype="multipart/form-data" method="POST" action="{{ url('/site_pages_meta/update') }}" >
        @csrf
        <input type="hidden" name="id" value="{{$record['id']}}">
        <div class="row">

            <!-- start message area-->
            @include('include.message')
            <!-- end message area-->

        <div class="col-md-6">
        <div class="card">
        <div class="card-body">
        <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Page Name')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Title" value="{{$record['page_name']}}"name="page_name">
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">{{ __('Main Heading H1')}}</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Title For Menu" value="{{$record['page_title']}}" name="page_title">
            </div>
            <div class="form-group">
                <label for="exampleTextarea1">{{ __('Meta Title')}}</label>
                <textarea class="form-control" id="exampleTextarea1" rows="5" placeholder="Meta Keywords" name="meta_title" >{{$record['meta_title']}}</textarea>
            </div>
                     
            </div>
        </div>
    </div>
</div>
</div>
    <div class="col-md-6">
    <div class="card">
    <div class="card-body">
    <div class="row">
    <div class="col-md-12">
        <div class="form-group">
                <label for="exampleTextarea1">{{ __('Meta Keywords')}}</label>
                <textarea class="form-control" id="exampleTextarea1" rows="5" placeholder="Meta Keywords" name="meta_kwd" >{{$record['meta_kwd']}}</textarea>
            </div>
            <div class="form-group">
                <label for="exampleTextarea1">{{ __('Meta Discription')}}</label>
                <textarea class="form-control" id="exampleTextarea1" rows="5" placeholder="Meta Discription" name="meta_desc">{{$record['meta_desc']}}</textarea>
            </div>
     
        </div>
    </div>
</div>
</div>
</div>
<div class="col-md-12">
    <div class="card">
    <div class="card-body">
    <div class="row">
    <div class="col-md-12">
          <div class="card">
        <div class="card-header"><h3>{{ __('Page Text Top')}}</h3></div>
        <div class="card-body">
            <textarea class="form-control html-editor" rows="10" name="page_text_top">
                {{$record['page_text_top']}}
            </textarea>
        </div>
        </div>
         <div class="card">
        <div class="card-header"><h3>{{ __('Page Text Bottom')}}</h3></div>
        <div class="card-body">
            <textarea class="form-control html-editor" rows="10" name="page_text_bottom">
                {{$record['page_text_bottom']}}
            </textarea>
        </div>
        </div>
     <div class="form-group" style="padding-top: 0.6rem;">
                <button type="submit" style="color: #fff;background-color: #202C50;border-radius: 10px;font-size: 12px; padding: 6px 14px;"data-toggle="tooltip" data-placement="top" title="Update">{{ __('Update')}}</button>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</form>

        </div>


        <!-- push external js -->
@push('script')
    
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('plugins/summernote/dist/summernote-bs4.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
        <script src="{{ asset('plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
        <script src="{{ asset('plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script src="{{ asset('js/form-advanced.js') }}"></script>
        <script src="{{ asset('js/form-components.js') }}"></script>
        
@endpush
@endsection