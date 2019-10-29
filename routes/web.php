<?php

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

Route::get('/', function () {
    // return view('welcome');
	return redirect()->to('admin');
});
Route::post('admin/changeSession', function () {
	$setting = Voyager::model('Setting')->where('key', 'site.session')->first();
	$setting->value = request()->session;
	$setting->save();
	return redirect()->back();
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
	
	Route::get('paiements-personnel',['uses' =>'PaiementController@paiementsPersonnelBrowse', 'as' =>'paiementsPersonnelBrowse']);
	Route::get('paiements-personnel/create',['uses' =>'PaiementController@paiementsPersonnelCreate', 'as' =>'paiementsPersonnelCreate']);
	Route::get('paiements-personnel/{id}/edit',['uses' =>'PaiementController@paiementsPersonnelEdit', 'as' =>'paiementsPersonnelEdit']);
	Route::get('paiements-etudiant',['uses' =>'PaiementController@paiementsEtudiantBrowse', 'as' =>'paiementsEtudiantBrowse']);
	Route::get('paiements-etudiant/create',['uses' =>'PaiementController@paiementsEtudiantCreate', 'as' =>'paiementsEtudiantCreate']);
	Route::get('paiements-etudiant/{id}/edit',['uses' =>'PaiementController@paiementsEtudiantEdit', 'as' =>'paiementsEtudiantEdit']);
});
