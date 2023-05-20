<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\ServicesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/ 


Route::get('/', 'FrontendController@index');


Route::get('login', [LoginController::class,'showLoginForm'])->name('login');
Route::post('login', [LoginController::class,'login']);
// Route::post('register', [RegisterController::class,'register']);

Route::get('password/forget',  function () { 
	return view('pages.forgot-password'); 
})->name('password.forget');
Route::post('password/email', [ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class,'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class,'reset'])->name('password.update');


   
   Route::group(['prefix' => 'site-setting'], function(){

	Route::get('/add', 'SiteSettingsController@create');
   Route::post('/store', 'SiteSettingsController@store');

	});
	
	Route::get('/site_pages_meta', 'SitePagesMetaController@index');
	Route::get('/edit_site_pages/{id}', 'SitePagesMetaController@edit');
	Route::post('/site_pages_meta/update', 'SitePagesMetaController@update');

	Route::post('/contact_us/store', 'ContactusController@store');





		// SITEMAPS (XML)
		Route::get('sitemaps.xml', 'SitemapController@site');

		Route::get('sitemap/drama.xml', 'SitemapController@drama');
		Route::get('sitemap/movie.xml', 'SitemapController@movie');
		Route::get('sitemap/episodes.xml', 'SitemapController@episodes');
		Route::get('sitemap/movie-watch.xml', 'SitemapController@movie_watch');

		Route::get('sitemap/drama/{date}.xml', 'SitemapController@mapdramadate');

		Route::get('sitemap/movie/{date}.xml', 'SitemapController@mapmoviedate');

		Route::get('sitemap/episodes/{date}.xml', 'SitemapController@mapepisodesdate');

		Route::get('sitemap/movie-watch/{date}.xml', 'SitemapController@mapmoviewatchdate');

	


Route::group(['middleware' => 'auth'], function(){
	// logout route
	Route::get('/logout', [LoginController::class,'logout']);
	Route::get('/clear-cache', [HomeController::class,'clearCache']);

	Route::get('/dashboard', 'HomeController@index')->name('dashboard');






	Route::get('/getsms', 'SmsController@index');

	Route::get('/getnumber', 'SmsController@get_number');
	


	Route::get('/getSerives', 'SmsController@get_Servicesby_country');



	Route::get('/refresh', 'SiteSettingsController@destroy');

   Route::get('/massages/list', 'ContactusController@index');
	Route::get('/massages/get-msg-list', 'ContactusController@get_msg_list');












	Route::group(['prefix' => 'drama'], function(){
		Route::get('/fetch', 'DramaController@fetch')->name('fetch_drama');
		Route::post('/fetch', 'DramaController@fetch_drama')->name('get_drama');
		Route::post('/save', 'DramaController@save_drama')->name('save_drama');
		Route::get('/add', 'DramaController@create');
		Route::get('/list', 'DramaController@index');
		Route::get('/edit/{id}', 'DramaController@edit');
		Route::post('/store', 'DramaController@store');
		Route::post('/update', 'DramaController@update');
		Route::get('/delete/{id}', 'DramaController@destroy');
		Route::get('/fetch/episodes', 'DramaController@fetch_episodes');
		Route::get('get-drama-list', 'DramaController@get_drama_list');

	});

	Route::group(['prefix' => 'episode'], function(){
		Route::get('/add/{id}', 'EpisodesController@create');
		Route::get('/list/{id?}', 'EpisodesController@index');
		Route::get('/edit/{id}', 'EpisodesController@edit');
	    Route::post('/store', 'EpisodesController@store');
	    Route::post('/update', 'EpisodesController@update');
        Route::get('/delete/{id}', 'EpisodesController@destroy');
        Route::get('get-episode-list', 'EpisodesController@get_episode_list');

	});
	
	Route::group(['prefix' => 'genre'], function(){

		Route::get('/add', 'GenreController@create');
		Route::get('/list', 'GenreController@index');
		Route::get('/edit/{id}', 'GenreController@edit');
	    Route::post('/store', 'GenreController@store');
	    Route::post('/update', 'GenreController@update');
       Route::get('/delete/{id}', 'GenreController@destroy');
       Route::get('/get-genre-list', 'GenreController@get_genre_list');

	});

	Route::group(['prefix' => 'tags'], function(){

		Route::get('/add', 'TagsController@create');
		Route::get('/list', 'TagsController@index');
		Route::get('/edit/{id}', 'TagsController@edit');
		Route::post('/store', 'TagsController@store');
		Route::post('/update', 'TagsController@update');
        Route::get('/delete/{id}', 'TagsController@destroy');
        Route::get('/get-tags-list', 'TagsController@get_tags_list');
        

	});

	Route::group(['prefix' => 'movies'], function(){

		Route::get('/fetch', 'MovieController@fetch')->name('fetch_movie');
		Route::post('/fetch', 'MovieController@fetch_movie')->name('get_movie');

		Route::post('/save', 'MovieController@save_movie')->name('save_movie');


		Route::get('/fetch/video', 'MovieController@fetch_videos')->name('fetch_video');
		Route::get('/add', 'MovieController@create');
		Route::get('/list', 'MovieController@index');
		Route::get('/edit/{id}', 'MovieController@edit');
		Route::post('/store', 'MovieController@store');
		Route::post('/update', 'MovieController@update');
      Route::get('/delete/{id}', 'MovieController@destroy');
      Route::get('/list/{id?}', 'MovieController@list_video');

      Route::get('/get-movie-list', 'MovieController@get_movie_list');


	});

	Route::group(['prefix' => 'menus'], function(){

		Route::get('/add', 'MenusController@create');
		Route::get('/list', 'MenusController@index');
		Route::get('/edit/{id}', 'MenusController@edit');
	    Route::post('/store', 'MenusController@store');
	    Route::post('/update', 'MenusController@update');
        Route::get('/delete/{id}', 'MenusController@destroy');

	});

	Route::group(['prefix' => 'slider'], function(){

		Route::get('/add', 'SliderController@create');
		Route::get('/list', 'SliderController@index');
		Route::get('/edit/{id}', 'SliderController@edit');
	    Route::post('/store', 'SliderController@store');
	    Route::post('/update', 'SliderController@update');
        Route::get('/delete/{id}', 'SliderController@destroy');
        Route::get('/get-slider-list', 'SliderController@get_sider_list');

	});

	Route::group(['prefix' => 'servers'], function(){

		Route::get('/add', 'ServerController@create');
		Route::get('/list', 'ServerController@index');
		Route::get('/edit/{id}', 'ServerController@edit');
	    Route::post('/store', 'ServerController@store');
	    Route::post('/update', 'ServerController@update');
        Route::get('/delete/{id}', 'ServerController@destroy');
        Route::get('/get-server-list', 'ServerController@get_server_list');

	});

	Route::group(['prefix' => 'cms-pages'], function(){

		Route::get('/add', 'CmsPagesController@create');
		Route::get('/list', 'CmsPagesController@index');
		Route::get('/edit/{id}', 'CmsPagesController@edit');
	    Route::post('/store', 'CmsPagesController@store');
	    Route::post('/update', 'CmsPagesController@update');
        Route::get('/delete/{id}', 'CmsPagesController@destroy');
        Route::get('cms-pages-list', 'CmsPagesController@get_list_cms');

	});

	Route::group(['prefix' => 'publisher'], function(){

		Route::get('/add', 'PublisherController@create');
		Route::get('/list', 'PublisherController@index');
		Route::get('/edit/{id}', 'PublisherController@edit');
	    Route::post('/store', 'PublisherController@store');
	    Route::post('/update', 'PublisherController@update');
        Route::get('/delete/{id}', 'PublisherController@destroy');
        Route::get('/get-publisher-list', 'PublisherController@get_publisher_list');

	});

	




	

	Route::group(['prefix' => 'countries'], function(){

		Route::get('/add', 'CountriesController@create');
		Route::post('/store', 'CountriesController@store');
		Route::get('/list', 'CountriesController@index');
		Route::get('/edit/{id}', 'CountriesController@edit');
		Route::post('/update', 'CountriesController@update');
      Route::get('/delete/{id}', 'CountriesController@destroy');
      Route::get('/get-country-list', 'CountriesController@get_list_country');

	});


	Route::group(['prefix' => 'services'], function(){
		Route::get('/list', [ServicesController::class,'create']);

	});


	//only those have manage_user permission will get access
	Route::group(['middleware' => 'can:manage_user'], function(){
	Route::get('/users', [UserController::class,'index']);
	Route::get('/user/get-list', [UserController::class,'getUserList']);
		Route::get('/user/create', [UserController::class,'create']);
		Route::post('/user/create', [UserController::class,'store'])->name('create-user');
		Route::get('/user/{id}', [UserController::class,'edit']);
		Route::post('/user/update', [UserController::class,'update']);
		Route::get('/user/delete/{id}', [UserController::class,'delete']);
	});

	//only those have manage_role permission will get access
	Route::group(['middleware' => 'can:manage_role|manage_user'], function(){
		Route::get('/roles', [RolesController::class,'index']);
		Route::get('/role/get-list', [RolesController::class,'getRoleList']);
		Route::post('/role/create', [RolesController::class,'create']);
		Route::get('/role/edit/{id}', [RolesController::class,'edit']);
		Route::post('/role/update', [RolesController::class,'update']);
		Route::get('/role/delete/{id}', [RolesController::class,'delete']);
	});


	//only those have manage_permission permission will get access
	Route::group(['middleware' => 'can:manage_permission|manage_user'], function(){
		Route::get('/permission', [PermissionController::class,'index']);
		Route::get('/permission/get-list', [PermissionController::class,'getPermissionList']);
		Route::post('/permission/create', [PermissionController::class,'create']);
		Route::get('/permission/update', [PermissionController::class,'update']);
		Route::get('/permission/delete/{id}', [PermissionController::class,'delete']);
	});

	// get permissions
	Route::get('get-role-permissions-badge', [PermissionController::class,'getPermissionBadgeByRole']);


	// permission examples
    Route::get('/permission-example', function () {
    	return view('permission-example'); 
    });
    // API Documentation
    Route::get('/rest-api', function () { return view('api'); });
    // Editable Datatable
	Route::get('/table-datatable-edit', function () { 
		return view('pages.datatable-editable'); 
	});

    // Themekit demo pages
	Route::get('/calendar', function () { return view('pages.calendar'); });
	Route::get('/charts-amcharts', function () { return view('pages.charts-amcharts'); });
	Route::get('/charts-chartist', function () { return view('pages.charts-chartist'); });
	Route::get('/charts-flot', function () { return view('pages.charts-flot'); });
	Route::get('/charts-knob', function () { return view('pages.charts-knob'); });
	Route::get('/forgot-password', function () { return view('pages.forgot-password'); });
	Route::get('/form-addon', function () { return view('pages.form-addon'); });
	Route::get('/form-advance', function () { return view('pages.form-advance'); });
	Route::get('/form-components', function () { return view('pages.form-components'); });
	Route::get('/form-picker', function () { return view('pages.form-picker'); });
	Route::get('/invoice', function () { return view('pages.invoice'); });
	Route::get('/layout-edit-item', function () { return view('pages.layout-edit-item'); });
	Route::get('/layouts', function () { return view('pages.layouts'); });

	Route::get('/navbar', function () { return view('pages.navbar'); });
	Route::get('/profile', function () { return view('pages.profile'); });
	Route::get('/project', function () { return view('pages.project'); });
	Route::get('/view', function () { return view('pages.view'); });

	Route::get('/table-bootstrap', function () { return view('pages.table-bootstrap'); });
	Route::get('/table-datatable', function () { return view('pages.table-datatable'); });
	Route::get('/taskboard', function () { return view('pages.taskboard'); });
	Route::get('/widget-chart', function () { return view('pages.widget-chart'); });
	Route::get('/widget-data', function () { return view('pages.widget-data'); });
	Route::get('/widget-statistic', function () { return view('pages.widget-statistic'); });
	Route::get('/widgets', function () { return view('pages.widgets'); });

	// themekit ui pages
	Route::get('/alerts', function () { return view('pages.ui.alerts'); });
	Route::get('/badges', function () { return view('pages.ui.badges'); });
	Route::get('/buttons', function () { return view('pages.ui.buttons'); });
	Route::get('/cards', function () { return view('pages.ui.cards'); });
	Route::get('/carousel', function () { return view('pages.ui.carousel'); });
	Route::get('/icons', function () { return view('pages.ui.icons'); });
	Route::get('/modals', function () { return view('pages.ui.modals'); });
	Route::get('/navigation', function () { return view('pages.ui.navigation'); });
	Route::get('/notifications', function () { return view('pages.ui.notifications'); });
	Route::get('/range-slider', function () { return view('pages.ui.range-slider'); });
	Route::get('/rating', function () { return view('pages.ui.rating'); });
	Route::get('/session-timeout', function () { return view('pages.ui.session-timeout'); });
	Route::get('/pricing', function () { return view('pages.pricing'); });


	// new inventory routes
	Route::get('/inventory', function () { return view('inventory.dashboard'); });
	Route::get('/pos', function () { return view('inventory.pos'); });
	Route::get('/products', function () { return view('inventory.product.list'); });
	Route::get('/products/create', function () { return view('inventory.product.create'); }); 
	Route::get('/categories', function () { return view('inventory.category.index'); }); 
	Route::get('/sales', function () { return view('inventory.sale.list'); });
	Route::get('/sales/create', function () { return view('inventory.sale.create'); }); 
	Route::get('/purchases', function () { return view('inventory.purchase.list'); });
	Route::get('/purchases/create', function () { return view('inventory.purchase.create'); }); 
	Route::get('/customers', function () { return view('inventory.people.customers'); }); 
	Route::get('/suppliers', function () { return view('inventory.people.suppliers'); }); 
	
});






	Route::get('/drama-list/{slug?}', 'FrontendController@drama_list');
	Route::get('/kshows', 'FrontendController@drama_list');
	Route::get('/movie-list/{slug?}', 'FrontendController@movie_list');
	Route::get('/video-watch/{slug}', 'FrontendController@episode_detail');
	Route::get('/drama-detail/{slug}', 'FrontendController@drama_details');
	Route::get('/movie-detail/{slug}', 'FrontendController@movie_details');
	Route::get('/movie-watch/{slug}', 'FrontendController@movie_watch');
	Route::get('/country/{name}', 'FrontendController@all_drama_country');
	Route::get('/popular/{status}', 'FrontendController@all_drama_status');
	Route::get('/most-popular-drama', 'FrontendController@mostpopular');
	Route::get('/recently-added/{type}', 'FrontendController@mostrecently');
	Route::get('/released-in-{year}', 'FrontendController@released_in');
	Route::get('/genre/{name}', 'FrontendController@drama_by_genre');
	Route::get('/tags/{name}', 'FrontendController@drama_by_tags');


	

	Route::get('/episode', 'FrontendController@drama_episode');
	Route::get('/list_star', 'FrontendController@actors_list');
	Route::get('/star/{name}', 'FrontendController@actors_details');
	Route::get('/search', 'FrontendController@search');
Route::get('/register', function () { return view('pages.register'); });
Route::get('/login-pub', function () { return view('pages.login'); });


Route::get('/{slug}', 'FrontendController@cms_pages');


