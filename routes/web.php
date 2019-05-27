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
    return view('welcome');
});
//namespace добавляется папкой Blog
Route::group(['namespace' => 'Blog', 'prefix' => 'blog'], function() {
  //без 'namespace' => 'Blog', 'prefix' => 'blog' в
  // Route::resource('posts', 'PostController') надо добавить
  // Route::resource('Blog/posts', 'Blog/PostController')
  Route::resource('posts', 'PostController')->names('blog.posts');
});

Route::resource('rest', 'RestTestController')->names('restTest');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Админка блога
$groupData = [
  'namespace' => 'Blog\Admin',
  'prefix'    => 'admin/blog',
];
Route::group($groupData, function () {
  //BlogCategory
  $methods =['index', 'create', 'edit', 'store', 'update'];
  Route::resource('categories', 'CategoryController')
    ->only($methods)
    ->names('blog.admin.categories');

  // BlogPost
    Route::resource('posts', 'PostController')
      ->except(['show'])
      ->names('blog.admin.posts');
});

//Route::resource('rest', 'RestTestController')->names('restTest');