<?php
namespace App\Controllers;

class ErrorController
{
	public function notFound(): string
	{    
        return view('404');
	}

    public function serverError(): string
	{    
        return view('500');
	}

    public function forbidden(): string
	{    
        return 'You are forbidden from accessing this election. Confirm the url and try again.';
	}

	public function logout() 
	{
		session()->flush();
		redirect(url('login-page'));
	}

}