
<?php
Route::post('register', 'AuthController@register');

Route::post('login', 'AuthController@login');

Route::post('recover', 'AuthController@recover');


Route::get('productos', 'ProductosController@index');

Route::post('productos', 'ProductosController@store');

Route::delete('productos/{id}', 'ProductosController@destroy');

Route::put('productos', 'ProductosController@update');


Route::get('users', 'UserController@index');

Route::put('users', 'UserController@update');


Route::group(['middleware' => ['jwt.auth']], function() {
    Route::get('logout', 'AuthController@logout');









    Route::get('test', function(){
        return response()->json(['foo'=>'bar']);
    });
});
