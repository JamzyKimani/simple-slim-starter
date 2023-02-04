<?php
/**
 * This file contains all the routes for the project
 */

use App\Router;


Router::csrfVerifier(new \App\Middlewares\CsrfVerifier());

Router::setDefaultNamespace('\App\Controllers');


Router::group(['exceptionHandler' => \App\Handlers\CustomExceptionHandler::class], function () {

    Router::setCustomClassLoader(new \App\Handlers\CustomClassLoader());

	Router::get('/', 'DefaultController@home')->setName('home');

    Router::get('/404', 'ErrorController@notFound')->setName('not-found');
    Router::get('/403', 'ErrorController@forbidden')->setName('forbidden');
    Router::get('/500', 'ErrorController@serverError')->setName('server-error');
    Router::get('/session/error', function() { return 'SESSION ERROR: please log in again.'; })->setName('session-error');
    Router::get('/logout', 'ErrorController@logout')->setName('logout');

    //admin pre-auth pages
    Router::get('/signup', 'AuthController@signup')->setName('signup-page');
    Router::post('/signup', 'AuthController@create')->setName('submit-signup');
    Router::get('/login', 'AuthController@getLogin')->setName('login-page');
    Router::post('/login', 'AuthController@adminLogin')->setName('login-admin');
    

    //voter pre-auth pages
    Router::get('/elections/{election_code}/login','VoterController@showVoterLogin')->setName('show-voter-login');
    Router::post('/elections/{election_code}/login','VoterController@voterLogin')->setName('voter-login');
    Router::get('/elections/{election_code}/nominations/login','VoterController@showNominationsLogin')->setName('show-nominations-login');
    Router::post('/elections/{election_code}/nominations/login','VoterController@nominationsLogin')->setName('nominations-login');
   
    //admin post-auth pages
    Router::group(['middleware' => \App\Middlewares\Authorization::class], function() {
        //admin post-auth pages
        Router::get('/elections','ElectionController@list')->setName('list-elections');
        Router::post('/elections','ElectionController@create')->setName('create-election');
        Router::get('/elections/{election_code}/dashboard','ElectionController@dashboard')->setName('election-dashboard');
        Router::get('/elections/{election_code}/settings','ElectionController@settings')->setName('election-settings');
        Router::put('/elections/{election_code}/settings','ElectionController@update')->setName('update-election');
        Router::get('/elections/{election_code}/questions','ElectionController@ballot')->setName('election-ballot');
        Router::get('/elections/{election_code}/questions/{question_code}/options','ElectionController@ballot'); //questions are viewed/edited on same page
        Router::get('/elections/{election_code}/questions/{question_code}/options/{option_code}','ElectionController@ballot'); //options are viewed/edited on same page
        Router::get('/elections/{election_code}/questions/{question_code}','ElectionController@ballot'); //questions are viewed/edited on same page
        Router::get('/elections/{election_code}/file','ElectionController@ballot'); //questions are viewed/edited on same page

        Router::post('/elections/{election_code}/questions','ElectionController@createQuestion')->setName('create-question');
        Router::put('/elections/{election_code}/questions/{question_code}','ElectionController@updateQuestion')->setName('update-question');
        Router::post('/elections/{election_code}/questions/{question_code}/options','ElectionController@createOption')->setName('create-option');
        Router::put('/elections/{election_code}/questions/{question_code}/options/{option_code}','ElectionController@updateOption')->setName('update-option');
        Router::delete('/elections/{election_code}/questions/{question_code}/options/{option_code}','ElectionController@deleteOption')->setName('delete-option');
        Router::delete('/elections/{election_code}/questions/{question_code}','ElectionController@deleteQuestion')->setName('delete-question');
        Router::delete('/elections/{election_code}/file','ElectionController@deleteElectionFile')->setName('delete-election-file');
        Router::get('/elections/{election_code}/preview','ElectionController@preview')->setName('election-preview');

        Router::get('/elections/{election_code}/voters','VoterController@list')->setName('election-voters');
        Router::post('/elections/{election_code}/voters','VoterController@create')->setName('create-voters');
        Router::delete('/elections/{election_code}/voters','VoterController@delete')->setName('delete-voters');
        Router::put('/elections/{election_code}/voters/{voter_code}','VoterController@update')->setName('update-voter');
        Router::get('/elections/{election_code}/voters/{voter_code}','VoterController@list');
        Router::get('/elections/{election_code}/voters/all/download','VoterController@download')->setName('download-voter-list');       
    });

    //voter post-auth pages
    Router::group(['middleware' => \App\Middlewares\VoterAuth::class], function() {
        Router::get('/elections/{election_code}', 'VoterController@showBallot')->setName('voting_booth');
        Router::post('/elections/{election_code}', 'VoterController@submitVote')->setName('submit-vote');

        Router::get('/elections/{election_code}/nominations', 'VoterController@showElectionNominations')->setName('election-nominations');
        Router::get('/elections/{election_code}/nominations', 'VoterController@showMyNomination')->setName('my-nomination');

        Router::get('/elections/{election_code}/questions/{question_code}/nominations', 'VoterController@showNominationApplication')->setName('nomination-application');
        Router::post('/elections/{election_code}/questions/{question_code}/nominations', 'VoterController@createNominationCandidate')->setName('submit-nomination-application');
    });
    
	Router::get('/contact', 'DefaultController@contact')->setName('contact');
	Router::basic('/companies/{id?}', 'DefaultController@companies')->setName('companies');

    // API
	Router::group(['prefix' => '/api', 'middleware' => \App\Middlewares\ApiVerification::class], function () {
        //TODO: implement ApiVerification.
		//Router::resource('/demo', '\App\Controllers\Api\ApiController');
        Router::get('/elections/{election_code}/questions/{question_code}/options/{option_code}', '\App\Controllers\Api\ElectionController@getOption' )->setName('api-get-option');
        Router::get('/elections/{election_code}/voters/{voter_code}', '\App\Controllers\Api\VoterController@show' )->setName('api-show-voter');
        Router::delete('/elections/{election_code}/voters/{voter_code}', '\App\Controllers\Api\VoterController@delete' )->setName('api-delete-voter');
	});

    // CALLBACK EXAMPLES
    Router::get('/foo', function() {
        return 'foo';
    });

    Router::get('/foo-bar', function() {
        return 'foo-bar';
    });

});