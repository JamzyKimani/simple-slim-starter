<?php
namespace App\Controllers\Api;

use Medoo\Medoo;

class VoterController 
{
    public function show($election_code, $voter_code)
	{
		$db = container(Medoo::class);
		$voter = $db->get("voters_tb", '*', [ "voter_election_code" => $election_code, 'voter_code' => $voter_code ] );
		return response()->json($voter);
	}

    public function delete($election_code, $voter_code) 
	{
		$db = container(Medoo::class);
		$data = $db->delete('voters_tb', [ "voter_code" => $voter_code, "voter_election_code" => $election_code ] );
		if ( empty($db->errorInfo ) )
		{ 
			$message = Array(
				'success' => true, 
				'message' => 'Voter deleted Successfully'
			);
			return response()->json($message);
		} else {
            $logger = container('logger');
			$logger->error($db->errorInfo);
			$message = Array(
				'success' => false, 
				'message' => 'Voter not deleted due to a database error'
			);
			return response()->json($message);
		}
	}
}