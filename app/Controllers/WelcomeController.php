<?php 
namespace App\Controllers;

use Medoo\Medoo;

Class WelcomeController 
{
    public function index( $request, $response) 
    {
        $response->getBody()->write("Welcome Controller. Hello world!");
        return $response;
    }

    public function show($response, $name) 
    {
        $response->getBody()->write("Welcome Controller. Hello $name!");
        return $response;
    }

    public function db($response, Medoo $db) 
    {
        $tests = $db->select( "test_tb", ["test_name"], ["test_id" => 1] );
        $response->getBody()->write("Test name fetched from database is ".$tests[0]['test_name']);
        return $response;
    }
}