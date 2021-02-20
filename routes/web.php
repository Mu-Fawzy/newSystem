<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){
        
    Route::group(['namespace' => 'Frontend','middleware' => 'auth'], function () {
        ############################### Start ForntEndController ###################################
        Route::get('/home/{contract}/restore', 'ForntEndController@restore')->name('home.restore');
        Route::get('/archive', 'ForntEndController@archive')->middleware('ensure.not.empty')->name('home.archive');
        Route::get('/', 'ForntEndController@index')->name('home.page'); // Fronted Homepage
        ################################ End ForntEndController ####################################
    });
        
    Auth::routes(['register' => false]);
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        
    Route::group(['prefix'=>'admin','namespace' => 'Dashboard','middleware' => 'auth'], function () {
        ################################### Start AdminController #######################################
        Route::get('/', 'AdminController@index')->name('admin.home');
        #################################### End AdminController ########################################


        ############################### Start SubContractorController ###################################
        Route::get('/subcontractors/trashed', 'SubContractorController@trashed')->name('subcontractors.trashed');
        Route::post('/update_status/{subcontractor}', 'SubContractorController@updateStatus')->name('update.status');
        Route::post('/update_attachs/{subcontractor}', 'SubContractorController@updateAttachs')->name('update.attachs');
        Route::get('/restore/{subcontractor}', 'SubContractorController@restore')->name('restore.subcontractor');
        Route::get('subcontractor/{subcontractor}/worksites', 'SubContractorController@getWorksites')->name('subcontractor.worksites');
        Route::get('subcontractor/{subcontractor}/workitems', 'SubContractorController@getWorkitems')->name('subcontractor.workitems');
        Route::resource('/subcontractors', 'SubContractorController');
        Route::get('/open/{folder_name}/{attach_name}', 'SubContractorController@openfile')->name('open.file');
        Route::get('/download/{folder_name}/{attach_name}', 'SubContractorController@downloadfile')->name('download.file');
        Route::get('/delete_file/{subcontractor}/{file_name}', 'SubContractorController@deletefile')->name('delete.file');
        ################################ End SubContractorController ####################################


        ################################## Start ContractController #####################################
        Route::DELETE('/contracts/{contract}/deleteForEver', 'ContractController@deleteForEver')->name('contracts.deleteForEver');
        Route::get('/contracts/{contract}/restore', 'ContractController@restore')->name('contracts.restore');
        Route::get('/contracts/archive', 'ContractController@archive')->middleware('ensure.not.empty')->name('contracts.archive');
        Route::post('/update_contract/{contract}', 'ContractController@updateContract')->name('update.contract');
        Route::post('/delete_file/{contract}/{path}/{file_name}', 'ContractController@contractdeletefile')->name('contract.files');
        Route::resource('/contracts', 'ContractController')->except('show');;
        ################################### End ContractController #######################################


        ################################## Start WorksiteController ######################################
        Route::resource('/worksites', 'WorksiteController')->except('show');
        ################################## Start WorksiteController ######################################


        ################################## Start WorkitemsController #####################################
        Route::resource('/workitems', 'WorkitemsController')->except('show');
        ################################## Start WorkitemsController #####################################


        #################################### Start RoleController ########################################
        Route::resource('roles','RoleController');
        #################################### Start RoleController ########################################


        #################################### Start UserController ########################################
        Route::resource('users','UserController');
        ################################### Start UserController #########################################
    });

});

