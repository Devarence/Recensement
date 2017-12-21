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
    return view('index');
});

Route::post('lolo','MainController@loguser');

Route::post('lolipop','DataController@add_answer');

Route::get('primaire','MainController@primaireform');

Route::get('secondaire','MainController@secondaireform');

Route::get('deco','MainController@logout');

Route::get('back','MainController@back');

Route::get('finish','DataController@finish');

Route::get('Institution', function(){
    return view ('institution');
});

Route::post('logInstitution', 'MainController@logInstitution');

Route::get('logInstitution', function(){
    return view ('ministere');
});

Route::get('users', 'UserController@manageVue');
//route qui renvoie la vue de la liste de tous les users
Route::get('logInstitution/utilisateur','UserController@index');
//route pour la creation d'un utiliateur
Route::get('creerutilisateur', 'UserController@createuser');
//route pour la validation de la creation
Route::post('logInstitution/utilisateurs', 'UserController@storeuser');
//route pour voir un utiliateur
Route::get('voiruser/{id}', 'UserController@showuser');
//route pour voir l'utilisateur a modifier
Route::get('{iduser}', 'UserController@edituser');
//route pour la validation de la modification
Route::post('logInstitution/utilisateur', 'UserController@updateuser');
//route pour la suppression
Route::delete('supprimeruser/{id}', 'UserController@destroyuser');


