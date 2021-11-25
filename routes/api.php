
<?php
Route::post('users', 'AuthController@register');

Route::post('login', 'AuthController@login');

Route::post('recover', 'AuthController@recover');




Route::get('users', 'UserController@index');

Route::put('users', 'UserController@update');

Route::delete('users', 'UserController@destroy');



Route::get('rol', 'RolController@index');


Route::get('productos', 'ProductosController@index');

Route::post('productos', 'ProductosController@store');

Route::delete('productos/{id}', 'ProductosController@destroy');

Route::put('productos', 'ProductosController@update');


Route::post('pedidos', 'PedidosController@store');
Route::get('pedidos', 'PedidosController@index');


Route::group(['middleware' => ['jwt.auth']], function() {
    Route::get('logout', 'AuthController@logout');









    Route::get('test', function(){
        return response()->json(['foo'=>'bar']);
    });
});
