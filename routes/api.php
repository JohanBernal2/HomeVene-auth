
<?php
Route::post('register', 'AuthController@register');

Route::post('login', 'AuthController@login');

Route::post('recover', 'AuthController@recover');








Route::group(['middleware' => ['jwt.auth']], function() {
    Route::get('logout', 'AuthController@logout');


    Route::get('productos', 'ProductosController@index');

    Route::post('productos', 'ProductosController@store');

    Route::put('productos/{id}', 'ProductosController@update');

    Route::delete('productos/{id}', 'ProductosController@destroy');


    Route::get('test', function(){
        return response()->json(['foo'=>'bar']);
    });
});
