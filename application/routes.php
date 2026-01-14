<?php

// La page index est une liste des albums
Route::get('/', function() {
    $albums = Album::with('user')->order_by('updated_at', 'desc')->paginate(5);
    return View::make('home')
        ->with('albums', $albums);
});

Route::get('admin', array('before' => 'auth', 'do' => function() {
    $user = Auth::user();
    return View::make('new')->with('user', $user);
}));


// Route pour al page admin/new
Route::get('admin/new-album', array('before' => 'auth', 'do' => function() {
	$user = Auth::user();
    return View::make('new-album')->with('user', $user);
}));

/* grouping routes 
Route::group(array('before' => 'auth'), function()
{
    Route::get('panel', function()
    {
        //
    });

    Route::get('dashboard', function()
    {
        //
    });
});
*/

Route::delete('album/(:num)', array('before' => 'auth', 'do' => function($id){
    $delete_album = Album::with('user')->find($id);
    $delete_album -> delete();
    return Redirect::to('/')
            ->with('success_message', true);
})) ;


// When the new album is submitted we handle that here
Route::post('admin', array('before' => 'auth', 'do' => function() {

    $new_album = array(
        'album_name'    => Input::get('album_name'),
        'album_body'     => Input::get('album_body'),
        'album_songs'   => Input::get('album_songs'),
        'album_price'    => Input::get('album_price'),
        'album_quantity'     => Input::get('album_quantity'),
        'album_tags'     => Input::get('album_tags'),
        'album_author'   => Input::get('album_author')
    );

    $rules = array(
        'album_name'     => 'required|min:0|max:255',
        'album_body'      => 'required|min:10'
    );
    
    $validation = Validator::make($new_album, $rules);
    if ( $validation -> fails() )
    {
        
        return Redirect::to('admin')
                ->with('user', Auth::user())
                ->with_errors($validation)
                ->with_input();
    }


    // create the new album after passing validation
    $album = new Album($new_album);
    $album->save();

    
    // redirect to viewing all albums
    return Redirect::to('/admin');
}));

// Present the user with login form
Route::get('login', function() {
	return View::make('login');
});

// Process the login form
Route::post('login', function() {

	$userinfo = array(
        'username' => Input::get('username'),
        'password' => Input::get('password')
    );
    if ( Auth::attempt($userinfo) )
    {
        return Redirect::to('admin');
    }
    else
    {
        return Redirect::to('login')
            ->with('login_errors', true);
    }
});

// Process Logout process
Route::get('logout', function() {
	Auth::logout();
    return Redirect::to('/');
});


/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Router::register('GET /', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});