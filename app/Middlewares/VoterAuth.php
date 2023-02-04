<?php
namespace App\Middlewares;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;
use Medoo\Medoo;

class VoterAuth implements IMiddleware
{
	public function handle(Request $request) : void
	{
		$s = session();

        if(empty(session('logged_in')) || (time() - intval(session('last_activity'))) > 3600 || session('user_category') != 'VOTER' ) 
        {
            //user has not logged in or has been inactive for too long
            //destroy session & and log them out
            $user = null;
            $s->flush();

            redirect('/');

            //header('location: '.env('APP_URL').url('login-page'));
            
        } else {
            $voter = [];
            if(session('voter_username') == 'test') {
                $voter['last_login_date'] = date('Y-m-d H:i:s');
                $voter['logged_in'] = true;
                $voter['last_activity'] = time();  
            } else {
                //refresh session
                $db = container(Medoo::class);
                $voter = $db->get('voters_tb', '*', [ "voter_username" => session('voter_username'), "voter_password" => session('voter_password') ] );
                $voter['user_full_name'] = $voter['voter_name'];
                $voter['user_category'] = 'VOTER';
                $voter['last_activity'] = time();
                $voter['logged_in'] = true;
            }
            foreach( array_keys($voter) as $key) { session($key, $voter[$key]); }
        }
	}

}