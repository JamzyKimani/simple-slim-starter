<?php
namespace App\Controllers;
use App\User;
use Medoo\Medoo;

class AuthController
{
    public function signup(): string
	{    
		return view('signup');
	}

	public function create(): string
	{    
		$data = Array (
			'user_full_name' => trim(input('user_full_name')),
			'user_email' => trim(input('user_email')),	
			'user_company_name' => trim(input('user_company_name')),	
			'p_hash' => password_hash(input('password'), PASSWORD_DEFAULT),	
			'user_created_by' => 'SELF',	
			'username' => trim(input('user_email')),
			'user_category' => 'ADMIN',	
        );

        $db = container(Medoo::class);

        $user = $db->get("users_tb", [
			"user_email",
			"user_full_name",
			"user_category"
		], [
			"user_email" => $data['user_email'],
			"user_category" => 'ADMIN'
		]);

        if(!empty($db->errorInfo)) 
		{
			$message = Array(
				'type' => 'danger', 
				'text' => 'Could not register the member due to a database error. Please try again or contact the system administrator for assistance.'
			);
			
			return view('signup', compact('message'));

		} else {
			if( empty($user) )
			{
				//user does not already exist
				$db->insert('users_tb', $data);
				//return view('login');
				$login_page = env('APP_URL').url('login-page',[],['reg' => true]);
				header("location: $login_page");
			} else {
				$message = Array(
					'type' => 'danger', 
					'text' => 'A user with the email you entered ('.$data['user_email'].') already exists in the system. <a href="'.url('login-page').'" class="fw-semibold text-primary text-decoration-underline"> Click here</a> to login'
				);
				return view('signup', compact('message'));
			}
		}
	}

	public function getLogin(): string
	{    
		$s = session();
		$s->flush(); 
        $reg = input('reg', '0', 'get');
		$message = [];
        if($reg == '1') {
           $message = ["text" => "Your account has been created successfully. Please login below.", "type" => "success" ];
        }
		return view('login', compact('message'));
	}

    public function adminLogin()
    {
        $username = trim(input('username'));
        $pass = trim(input('password'));

        $user = User::fetchByUniqueField('username', $username);

        if(!empty($user)) 
        {
           //user found, confirm password 
            if(password_verify($pass, $user['p_hash']) == true) 
            {   //password correct
                //1. update last login date
                User::update( ['last_login_date' => date('Y-m-d H:i:s')] ,  [ "user_id" => $user['user_id'] ] );

                //2. set session variables
                $user['last_login_date'] = date('Y-m-d H:i:s');
                $user['logged_in'] = true;
                $user['last_activity'] = time();
 
                foreach( array_keys($user) as $key) { session($key, $user[$key]); }
			
                //3. redirect to elections setup page
                $elections_page = env('APP_URL').url('list-elections');
				header("location: $elections_page");
            } else {
                //wrong password
                $message = ["text" => "Incorrect password. Please try again or click 'forgot password' to reset it.", "type" => "danger" ];
		        return view('login', compact('message'));
            }

        } else {
            $message = ["text" => "No user with that username ($username) in the system. <a href=\"".url('login-page')."\" class=\"fw-semibold text-primary text-decoration-underline\"> Click here</a> to register.", "type" => "danger" ];
		    return view('login', compact('message'));
        }        
    }
}