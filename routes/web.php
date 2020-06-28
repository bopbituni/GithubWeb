<?php

use App\Jobs\ForkRepoJob;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider')->name('social-login.redirect');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('social-login.callback');

Route::post('repository/post', 'Repository@setRepositoryToDB')->name('set-repository');
Route::get('repository/get', 'Repository@getRepository')->name('get-repository');

Route::get('repository/clone/display', 'Repository@displayRepository')->name('display-clone');
Route::get('repository/clone/get', 'Repository@getRepository')->name('get-clone');

Route::post('forkRepo/save', 'ForkRepo@saveRepoFork')->name('fork-repo-save');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
