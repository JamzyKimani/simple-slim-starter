<?php
namespace App\Controllers;

use Medoo\Medoo;

class UserController
{
    private $db;

    public function __construct(Medoo $db) {
       $this->db = $db;
    }


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
			'p_hash' => password_hash(input('p_hash'), PASSWORD_DEFAULT),	
			'user_created_by' => 'SELF',	
			'username' => trim(input('user_email')),
			'user_category' => 'ADMIN',	
        );

      $user = $this->db->get("users_tb", [
			"user_email",
			"user_full_name",
			"user_category"
		], [
			"user_email" => $data['user_email'],
			"user_category" => 'ADMIN'
		]);

        if(!empty($this->db->errorInfo)) 
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
				$this->db->insert('users_tb', $data);
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
}