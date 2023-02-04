<?php
namespace App\Middlewares;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;
use App\User;

class Authorization implements IMiddleware
{
	public function handle(Request $request) : void
	{
		$s = session();
        if(empty(session('logged_in')) || (time() - intval(session('last_activity'))) > 3600 ) 
        {
            //user has not logged in or has been inactive for too long
            //destroy session & and log them out
            $user = null;
            $s->flush();

            header('location: '.env('APP_URL').url('login-page'));
            
        } else {
            //refresh session
            $user = User::fetchByUniqueField('username', session('username'));
            $user['last_activity'] = time();
            $user['logged_in'] = true;
            foreach( array_keys($user) as $key) { session($key, $user[$key]); }
        }
	}

}