<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\GithubSocialiteController;
use App\Http\Controllers\Auth\GoogleSocialiteController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\FollowController;
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
// Route::get('/', function () {return view('home');});
/**
 * LOGIN WITH GOOGLE: 
 * */
Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
})->name('login-google');

Route::get('/auth/callback', [GoogleSocialiteController::class, 'handleCallback']);

/**
 * LOGIN WITH GITHUB: 
 * */
Route::get('auth/github', [GithubSocialiteController::class, 'gitRedirect']);
Route::get('auth/github/callback', [GithubSocialiteController::class, 'handleCallback']);

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/adopt', [AdoptionController::class, 'index'])->name('adopt');
Route::post('/adopt', [AdoptionController::class, 'store'])->name('adopt.store');

Route::get('/adopt/create', [AdoptionController::class, 'createPet'])->name('createPet');
Route::post('/adopt/create', [AdoptionController::class, 'storePet'])->name('storePet');

Route::get('/adopt/select/{id}', [AdoptionController::class, 'select'])->name('adopt.select');


Route::middleware(['auth'])->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts');
    Route::get('/showPost/{id}', [PostController::class, 'show'])->name('posts.show');

    Route::get('/createPost', [PostController::class, 'create'])->name('createPost');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    // Route::get('/editpost/{id}', [PostController::class, 'edit'])->name('editPost');
    Route::get('/editPost/{id}', [PostController::class, 'edit'])->name('editPost');

    Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');

    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::post('/comments/fetch', [CommentController::class, 'fetch'])->name('comments.fetch');

    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');


    Route::get('/myprofile', [MyProfileController::class, 'index'])->name('myprofile');
    Route::get('/myprofile/edit', [MyProfileController::class, 'edit'])->name('myprofile.edit');
    Route::put('/myprofile', [MyProfileController::class, 'update'])->name('myprofile.update');

    Route::get('/search', [SearchController::class, 'index'])->name('search');

    Route::get('/users/{username}', [UserController::class, 'showProfile'])->name('user.profile');
    Route::post('/users/{user}/follow', [UserController::class, 'followUser'])->name('followUser');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/createUser', [UserController::class, 'create'])->name('users.create');
    Route::post('/createUser', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{user}', [UserController::class, 'editUser'])->name('users.edit');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::put('/users/{user}', [UserController::class, 'updateUser'])->name('users.update');

    // Ruta para seguir a un usuario
    Route::post('/follow/{user}', [FollowController::class, 'followUser'])->name('followUser');

    // Ruta para dejar de seguir a un usuario
    Route::delete('/unfollow/{user}', [FollowController::class, 'unfollowUser'])->name('unfollowUser');


    /**ADMIN: PETS */
    //que hago para la vista de pets.index.... uso las rutas de adoptar? le cambio el nombre a las rutas..? help
    // //aunque si son vistas diferentes, aunque me sirva el mismo metodo, en el metodo hago return de otra vista, no?
    Route::get('/pets', [PetController::class, 'index'])->name('pets.index');

    Route::get('/pets/edit/{pet}', [PetController::class, 'edit'])->name('pets.edit');
    Route::put('/pets/{pet}', [PetController::class, 'update'])->name('pets.update');


    Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create');
    Route::post('/pets', [PetController::class, 'store'])->name('pets.store');

    Route::get('/pets/select/{id}', [PetController::class, 'select'])->name('pets.select');

  
    Route::delete('/pets/{pet}', [PetController::class, 'destroy'])->name('pets.destroy');

    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
});

/** 
 * RUTAS ADMIN:
 */
// Route::group(['middleware' => ['admin']], function() {


// Route::get('/admin/users', 'UserController@index')->name('admin.users.index');
// Route::resource('users', UsersController::class);

// Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');



// });


Auth::routes();
