<?php
namespace App\Controllers;

use Medoo\Medoo;

class DefaultController
{
    private $db;

    public function __construct(Medoo $db) {
       $this->db = $db;
    }


	public function home()
	{    
        $msg = "This is the election system landing page";
        return sprintf('message: %s', $msg);
        
	}

	public function contact(): string
	{
        return 'DefaultController -> contact';
	}

	public function companies($id = null): string
	{
        return 'DefaultController -> companies -> id: ' . $id;
	}

    public function notFound(): string
    {
        //return 'page not found';

		return view('404');
    }

    public function serverError(): string
    {
		return 'Internal server error. View logs.';
    }

   

}