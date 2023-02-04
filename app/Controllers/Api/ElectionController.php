<?php
namespace App\Controllers\Api;

use Medoo\Medoo;

class ElectionController 
{
    public function getOption($election_code, $question_code, $option_code)
	{
		$db = container(Medoo::class);
		$option = $db->get("question_options_tb", '*', ["opt_election_code" => $election_code, 'opt_question_code' => $question_code, 'option_code' => $option_code ] );
		return response()->json($option);
	}

	public function deleteUserfile($election_code, $question_code=null, $option_code=null)
	{

	}
}