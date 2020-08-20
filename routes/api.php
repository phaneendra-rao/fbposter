<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group([
    'prefix' => 'auth',
], function () {
    Route::any('login', 'AuthController@login')->name('login');
    Route::any('signup', 'AuthController@signup');
});


Route::get('users', 'UserController@index');
Route::apiResource('groups', 'GroupController');

Route::post('/createpost', 'postscontroller@store');
Route::get('/group_posts/{id}', 'postscontroller@groupPosts');
Route::get('/group_data/{id}', 'postscontroller@groupData');

Route::delete('post/{id}', 'postscontroller@destroy');
Route::post('post/{id}', 'postscontroller@update');
Route::get('/post/{id}', 'postscontroller@show');

//members
Route::post('/members', 'MembersController@store');
Route::get('/members/{id}', 'MembersController@index');

Route::get('posts/{id}/members', 'CommentsController@getMembers');

Route::any('/{any}', function () {
    return response()->json([
        'response' => [
            'api_status' => 0,
            'code' => 404,
            'message' => 'not found'
        ]
    ], 404);
})->where('any', '.*');
