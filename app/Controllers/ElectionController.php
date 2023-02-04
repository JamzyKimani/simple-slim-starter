<?php
namespace App\Controllers;

use Medoo\Medoo;
use App\User;
use App\Election;

class ElectionController
{
	public function list(): string
	{    
		$message = [];
		if(isset($_GET['new'])) 
		{   
			$page_title = 'Create Election';
			$hide_create_election = false;
			$err = isset($_GET['err']) ? intval($_GET['err']) : 0;
			switch ($err) {
				case 1:
					$message = Array(
						'type' => 'danger', 
						'text' => 'Another election with similar details has already been created in the database. Try again.'
					);
				break;
			}
			$elections = [];
			return view('elections', compact('hide_create_election', 'page_title', 'elections', 'message'));
		} else {
			if( empty(session('user_elections')) )
			{   //go to the create new elections page if the user does not have any elections created
				header("location: ".env('APP_URL').url('list-elections',[],['new' => true]));
			} else {
				$page_title = 'List Election';
				$hide_create_election = true;
				//fetch user elections and list them
				$u_elections = explode(',', session('user_elections'));
				$db = container(Medoo::class);
				$elections = $db->select("elections_tb", '*',[
					"election_code" => $u_elections 
				]);

				return view('elections', compact('hide_create_election', 'page_title', 'elections', 'message'));
			}
		}
	}

	public function create(): string
	{    
		$db = container(Medoo::class);
		//check if election exists
		$e = $db->get("elections_tb", '*', [
			"election_code" => trim(input('election_code')),
		]);

		if(empty($e)) 
		{
			$election = Array (
				'election_code' => trim(input('election_code')),
				'election_title' => trim(input('election_title')),
				'election_start_date' => trim(input('election_start_date')),
				'election_end_date'	=> trim(input('election_end_date')),
				'election_created_by' => session('username'),	
			);
			$db->insert('elections_tb', $election);

			$message = Array(
				'type' => 'success', 
				'text' => 'The election was successfully created.'
			);
	        
			if(empty(session('user_elections')))
			{
				$u_elections = [];
			} else {
				$u_elections = explode(',', session('user_elections'));
			}

			$u_elections[] = trim(input('election_code'));
			$u_elections_str = implode(',', $u_elections);
			session('user_elections', $u_elections_str); //update session
			User::update([ 'user_elections' => $u_elections_str ], ['user_id' => session('user_id')] ); //update users_tb
	
			$elections = $db->select("elections_tb", '*',[
				"election_code" => $u_elections 
			]);
			$hide_create_election = empty(input('new', '', 'get'));
			$page_title = $hide_create_election ? 'Election List' :  'Create Election';

			return view('elections', compact('hide_create_election', 'page_title', 'elections', 'message'));
		} else {
			header("location: ".env('APP_URL').url('list-elections',[],['new' => true, 'err'=> 1]));
		}

	}

	public function update($election_code) 
	{   
	
		$page_title = 'Settings';      
		$election = Election::regulatElectionAccess();
		$setting_form = input('setting_form');

		$db = container(Medoo::class);
        
		$e = [];
        if(!empty(input('election_description'))) { $e['election_description'] = trim(input('election_description')); }
		if(!empty(input('election_title'))) { $e['election_title'] = trim(input('election_title')); }
		if(!empty(input('election_start_date'))) { $e['election_start_date'] = trim(input('election_start_date')); }
		if(!empty(input('election_end_date'))) { $e['election_end_date'] = trim(input('election_end_date')); }
		if(!empty(input('election_time_zone'))) { $e['election_time_zone'] = trim(input('election_time_zone')); }
        if(!empty(input('login_instructions'))) { $e['login_instructions'] = trim(input('login_instructions')); }
		if(!empty(input('vote_confirmation_msg'))) { $e['vote_confirmation_msg'] = trim(input('vote_confirmation_msg')); }
		if(!empty(input('after_election_message'))) { $e['after_election_message'] = trim(input('after_election_message')); }
		if(!empty(input('enable_nominations'))) { $e['enable_nominations'] = 1; }
		if(!empty(input('nomination_process_type'))) { $e['nomination_process_type'] = trim(input('nomination_process_type')); }
		if(!empty(input('nomination_start_date'))) 
		{ 
			$nom_start = trim(input('nomination_start_date'));
			if(strtotime($nom_start) < strtotime($election['election_start_date'])) {
				$e['nomination_start_date'] = $nom_start; 
			} else {
				$message = Array(
					'type' => 'danger', 
					'text' => 'The nomination start date needs to be earlier than the election voting start date.'
				);
				return view( 'settings', compact('page_title', 'election', 'message', 'setting_form') );
			}
		}

		if(!empty(input('nomination_end_date'))) 
		{ 
			$nom_end = trim(input('nomination_end_date'));
			$nom_start = trim(input('nomination_start_date'));
			if( strtotime($nom_end) < strtotime($election['election_start_date']) && strtotime($nom_end) > strtotime($nom_start) ) {
				$e['nomination_end_date'] = $nom_end; 
			} else {
				$message = Array(
					'type' => 'danger', 
					'text' => 'The nomination end date needs to be later nomination start date and earlier than the election voting start date.'
				);
				return view( 'settings', compact('page_title', 'election', 'message', 'setting_form') );
			}
		}
		
		
		$image = input()->file('election_logo');
		if(!empty($image)){
			if($image->getType() === 'image/jpeg' || $image->getType() === 'image/png') 
			{
				$destinationFilename = sprintf('%s.%s', uniqid(), $image->getExtension());
				$image->move(sprintf('../public/assets/app_files/%s', $destinationFilename));
				$e['election_logo'] = $destinationFilename;
			}
		}
		$db->update('elections_tb', $e, [ 'election_id' => $election['election_id'] ] );
		if ( !empty($db->errorInfo) )
		{
			$logger = container('logger');
			$logger->error($db->errorInfo);
			redirect('/500');
		} else {
			$message = Array(
				'type' => 'success', 
				'text' => 'Updated Successfully'
			);
			$election = $db->get('elections_tb', '*', [ 'election_id' => $election['election_id'] ]);
			return view( 'settings', compact('page_title', 'election', 'message', 'setting_form') );
		}	
	}

	public function dashboard($election_code) 
	{
		$page_title = 'Overview';
		$election = Election::regulatElectionAccess();
		$questions = Election::getQuestions($election_code);
		$db = container(Medoo::class);
		$voters = $db->select("voters_tb", '*',[ "voter_election_code" => $election_code ]);
		return view( 'overview', compact('page_title', 'election', 'questions', 'voters') );
	}

	public function settings($election_code) 
	{
		$setting_form = 'general-settings';
		$page_title = 'Settings';      
		$election = Election::regulatElectionAccess();
		return view( 'settings', compact('page_title', 'election', 'setting_form') );
	}

	public function ballot($election_code)
	{
		$page_title = 'Ballot Setup';      
		$election = Election::regulatElectionAccess();
		$db = container(Medoo::class);
		$questions = Election::getQuestions($election_code);
		$active_q = $questions[0]['question_code'];
		return view( 'ballot', compact('page_title', 'election', 'questions', 'active_q') );
	}

	public function createQuestion($election_code) 
	{
		$page_title = 'Ballot Setup';      
		$election = Election::regulatElectionAccess();
	
		$question_code = trim(input('question_code'));
		$active_q = $question_code;

		if(empty(input('q_randomize_options'))) { $q_randomize_options = 0; } else { $q_randomize_options = 1; }

		$db = container(Medoo::class);

		//ensure e_min_selection < e_max_selection
		if(abs(intval(input('q_min_selection'))) < abs(intval(input('q_max_selection')))) {
			$questions = Election::getQuestions($election_code);
			$message = Array(
				'type' => 'danger', 
				'text' => 'Minimum options a voter can select must be less than maximum options and both cannot be negative values'
			);
			return view( 'ballot', compact('page_title', 'election', 'questions', 'message', 'active_q') );
		} else {
				//check if ballot question exists avoid double submit from refreshing page
			$e = $db->get("ballot_questions_tb", '*', ["question_code" => trim(input('question_code'))]);

			if(empty($e)) 
			{
				$question = Array (
					'question_code' => $question_code,
					'q_election_code' => $election_code,
					'q_type' => 'MULTIPLE_CHOICE',
					'q_title' => trim(input('q_title')),
					'q_description' => trim(input('q_description')),
					'q_min_selection' => trim(input('q_min_selection')),
					'q_max_selection' => trim(input('q_max_selection')),
					'q_randomize_options' => $q_randomize_options,
					'q_created_by' => session('username')
				);

				$db->insert('ballot_questions_tb', $question);

				$message = Array(
					'type' => 'success', 
					'text' => 'The ballot question was successfully created.'
				);
				$questions = Election::getQuestions($election_code);
				$res = $db->select("question_options_tb", '*', ["q_election_code" => $election_code ] );
				$options = [];
				foreach($res as $opt) 
				{
					$options[$opt['opt_question_code']] [] = $opt;
				}

				foreach($questions as $key => $q) 
				{
					$questions[$key]['question_options'] = empty($options[$q['question_code']]) ? [] : $options[$q['question_code']] ;
				}
				return view( 'ballot', compact('page_title', 'election', 'questions', 'message', 'active_q') );
			} else {
				$message = Array(
					'type' => 'danger', 
					'text' => 'The ballot question you are trying to create is already created.'
				);
				$questions = Election::getQuestions($election_code);
				$res = $db->select("question_options_tb", '*', ["q_election_code" => $election_code ] );
				$options = [];
				foreach($res as $opt) 
				{
					$options[$opt['opt_question_code']] [] = $opt;
				}

				foreach($questions as $key => $q) 
				{
					$questions[$key]['question_options'] = empty($options[$q['question_code']]) ? [] : $options[$q['question_code']] ;
				}
				return view( 'ballot', compact('page_title', 'election', 'questions', 'message', 'active_q') );
			}
		}		
	}

    public function updateQuestion($election_code, $question_code) 
	{   
		$page_title = 'Ballot Setup';      
		$election = Election::regulatElectionAccess();
		$active_q = $question_code;
		$db = container(Medoo::class);
		if(abs(intval(input('q_min_selection'))) > abs(intval(input('q_max_selection')))) {
			$questions = Election::getQuestions($election_code);
			$message = Array(
				'type' => 'danger', 
				'text' => 'Minimum options a voter can select must be less than maximum options and both cannot be negative values'
			);
			return view( 'ballot', compact('page_title', 'election', 'questions', 'message', 'active_q') );
		} else {
			if(empty(input('q_randomize_options'))) { $q_randomize_options = 0; } else { $q_randomize_options = 1; }
			$q = [];
			//upload file
			$file = input()->file('file');
			if(!empty($file))
			{
				$file_ext = $file->getExtension();
				$allowed_extensions = ['pdf', 'png', 'jpeg', 'jpg', 'xlsx', 'xls', 'doc', 'docx'];
				if(in_array($file_ext, $allowed_extensions)) 
				{   //get current file list for the contest's nomination attachments
					$question = $db->get('ballot_questions_tb', '*', ['question_code' => $question_code, 'q_election_code' => $election_code ]);
					if(empty($question['q_nomination_desc_attachments'])) {
						$attachments = [];
					} else {
						$attachments = json_decode($question['q_nomination_desc_attachments']);
					}

					$destinationFilename = $destinationFilename = sprintf('%s.%s', uniqid(), $file->getExtension());
					if($file->move(sprintf('../public/assets/app_files/%s', $destinationFilename)))
					{   
						$attachments[] = Array('name' => $file->getFilename(), 'file' => $destinationFilename);
						$q['q_nomination_desc_attachments'] = json_encode($attachments);
					}
				}
			}

			if(!empty(input('q_title'))) { $q['q_title'] = trim(input('q_title')); }
			if(!empty(input('q_description'))) { $q['q_description'] = trim(input('q_description')); }
			if(!empty(input('q_min_selection'))) { $q['q_min_selection'] = trim(input('q_min_selection')); }
			if(!empty(input('q_max_selection'))) { $q['q_max_selection'] = trim(input('q_max_selection')); }
			if(!empty(input('q_randomize_options'))) { $q['q_randomize_options'] = trim(input('q_randomize_options')); }
            if(!empty(input('q_nomination_description'))) { $q['q_nomination_description'] = trim(input('q_nomination_description')); }
			if(!empty(input('q_nomination_supporting_docs'))) { $q['q_nomination_supporting_docs'] = trim(input('q_nomination_supporting_docs')); }
            if(!empty(input('q_nomination_min_supporters'))) { $q['q_nomination_min_supporters'] = trim(input('q_nomination_min_supporters')); }


			$data = $db->update('ballot_questions_tb', $q, [ 'q_election_code' => $election_code, 'question_code' => $question_code ] );
			if ( !empty($db->errorInfo) )
			{
				$logger = container('logger');
				$logger->error($db->errorInfo);
				redirect('/500');
			} else {
				
				if($data->rowCount() > 0) {
					$message = Array(
						'type' => 'success', 
						'text' => 'Updated Successfully'
					);
					$questions = Election::getQuestions($election_code);
					return view( 'ballot', compact('page_title', 'election', 'questions', 'message', 'active_q') );
				} else {
					//no question with code provided  exists in the eleciton
					$message = Array(
						'type' => 'danger', 
						'text' => 'Failed to update. Ballot question was not found or no change made.'
					);
					$questions = Election::getQuestions($election_code);
					return view( 'ballot', compact('page_title', 'election', 'questions', 'message', 'active_q') );
				}	
			}
		}
	}
	
	public function createOption($election_code, $question_code) 
	{  
		$page_title = 'Ballot Setup';      
		$election = Election::regulatElectionAccess();
		$active_q = $question_code;
		$option_code = trim(input('option_code'));
    
		$db = container(Medoo::class);
		//check if ballot question exists avoid double submit from refreshing page
		$o = $db->get("question_options_tb", '*', [ "option_code" => $option_code ]);

		if(empty($o)) 
		{	
			//upload Image	if is present
			$destinationFilename = '';
			$image = input()->file('opt_image');
			if($image->getType() === 'image/jpeg' || $image->getType() === 'image/png') 
			{
				$destinationFilename = sprintf('%s.%s', uniqid(), $image->getExtension());
				$image->move(sprintf('../public/assets/app_files/%s', $destinationFilename));
			}	

			$option = Array (
				'option_code' => $option_code,
				'opt_question_code' => $question_code,
				'opt_election_code' => $election_code,
				'opt_title' => trim(input('opt_title')),
				'opt_short_description' => trim(input('opt_short_description')),
				'opt_long_description' => trim(input('opt_long_description')),
				'opt_image' => $destinationFilename,
				'opt_created_by' => session('username')
			);

			$db->insert('question_options_tb', $option);

			$message = Array(
				'type' => 'success', 
				'text' => 'The voter response option was successfully created.'
			);
			$questions = Election::getQuestions($election_code);
			return view( 'ballot', compact('page_title', 'election', 'questions', 'message', 'active_q') );
		} else {
			$message = Array(
				'type' => 'danger', 
				'text' => 'The voter response option you are trying to create is already created.'
			);
			$questions = Election::getQuestions($election_code);
			return view( 'ballot', compact('page_title', 'election', 'questions', 'message', 'active_q') );
		}
	}

	public function updateOption($election_code, $question_code, $option_code) 
	{
		$page_title = 'Ballot Setup';      
		$election = Election::regulatElectionAccess();
		$active_q = $question_code;
		$db = container(Medoo::class);

		$o = [];
		if(!empty(input('opt_title'))) { $o['opt_title'] = trim(input('opt_title')); }
		if(!empty(input('opt_short_description'))) { $o['opt_short_description'] = trim(input('opt_short_description')); }
		if(!empty(input('opt_long_description'))) { $o['opt_long_description'] = trim(input('opt_long_description')); }
		
		$image = input()->file('opt_image');
		if($image->getType() === 'image/jpeg' || $image->getType() === 'image/png') 
		{
			$destinationFilename = sprintf('%s.%s', uniqid(), $image->getExtension());
			$image->move(sprintf('../public/assets/app_files/%s', $destinationFilename));
			$o['opt_image'] = $destinationFilename;
		}

		$data = $db->update('question_options_tb', $o, [ "option_code" => $option_code, "opt_question_code" => $question_code, "opt_election_code" => $election_code ] );
		if ( !empty($db->errorInfo) )
		{
			$logger = container('logger');
			$logger->error($db->errorInfo);
			redirect('/500');
		} else {
			if($data->rowCount() > 0) {
				$message = Array(
					'type' => 'success', 
					'text' => 'Updated Successfully'
				);
				$questions = Election::getQuestions($election_code);
				return view( 'ballot', compact('page_title', 'election', 'questions', 'message', 'active_q') );
			} else {
				$message = Array(
					'type' => 'danger', 
					'text' => 'Failed to update. Ballot question was not found or no change made.'
				);
				$questions = Election::getQuestions($election_code);
				return view( 'ballot', compact('page_title', 'election', 'questions', 'message', 'active_q') );
			}	
		}
	}

	public function deleteOption($election_code, $question_code, $option_code) 
	{
		$page_title = 'Ballot Setup';      
		$election = Election::regulatElectionAccess();
		$active_q = $question_code;
		$db = container(Medoo::class);
		$data = $db->delete('question_options_tb', [ "option_code" => $option_code, "opt_question_code" => $question_code, "opt_election_code" => $election_code ] );
		if ( empty($db->errorInfo) )
		{ 
			$message = Array(
				'type' => 'success', 
				'text' => 'Deleted Successfully'
			);
			$questions = Election::getQuestions($election_code);
			return view( 'ballot', compact('page_title', 'election', 'questions', 'message', 'active_q') );
		} else {
			$message = Array(
				'type' => 'danger', 
				'text' => 'Failed to delete candidate/option'
			);
			$questions = Election::getQuestions($election_code);
			return view( 'ballot', compact('page_title', 'election', 'questions', 'message', 'active_q') );
		}
	}

	public function deleteQuestion($election_code, $question_code) 
	{
		$page_title = 'Ballot Setup';      
		$election = Election::regulatElectionAccess();
		$done  = Election::deleteQuestion( $election_code, $question_code );
		if ( $done === true )
		{ 
			$message = Array(
				'type' => 'success', 
				'text' => 'Deleted Successfully'
			);
			$questions = Election::getQuestions($election_code);
			$active_q = $questions[0]['question_code'];
			return view( 'ballot', compact('page_title', 'election', 'questions', 'message', 'active_q') );
		} else {
			$message = Array(
				'type' => 'danger', 
				'text' => 'Failed to delete the question. Try again or contact the system administrator for assistance.'
			);
			$questions = Election::getQuestions($election_code);
			$active_q = $questions[0]['question_code'];
			return view( 'ballot', compact('page_title', 'election', 'questions', 'message', 'active_q') );
		}
	}

	public function deleteElectionFile($election_code) 
	{   

		$page_title = 'Ballot Setup';      
		$election = Election::regulatElectionAccess();
		
		$db = container(Medoo::class);
		
		$delete_params = json_decode(trim(input('delete_params')), true);

		switch($delete_params['file_type'])
		{
			case 'nomination_description_attachment':
				$question_code = $delete_params['question_code'];
				$filename = $delete_params['file_name'];
				//delete from db list
				$q = $db->get('ballot_questions_tb', '*', ['question_code' => $question_code, 'q_election_code' => $election_code ]);
				$attachments = json_decode($q['q_nomination_desc_attachments'], true);
			
				foreach($attachments as $i => $a )
				{   if($a['file'] == $filename)
					{
						unset($attachments[$i]);
					}
				}
				$db->update('ballot_questions_tb', ['q_nomination_desc_attachments' => json_encode($attachments)], ['question_code' => $question_code, 'q_election_code' => $election_code ]);
				if(file_exists(base_path('public/assets/app_files/'.$filename))){
					unlink(base_path('public/assets/app_files/'.$filename));
				}
				$message = Array(
					'type' => 'success', 
					'text' => 'Attachment deleted Successfully'
				);
				$active_q = $question_code;
			break;
			default: 
				$message = Array(
					'type' => 'danger', 
					'text' => 'Deletion was unsuccessfull. Error: Default case.'
				);
			break;
		}
		$questions = Election::getQuestions($election_code);
	    if(Empty($active_q)) { $active_q = $questions[0]['question_code']; }
		return view( 'ballot', compact('page_title', 'election', 'questions', 'message', 'active_q') );
	}

	public function preview($election_code)
	{
		$page_title = 'Preview';      
		$election = Election::regulatElectionAccess();
		$questions = Election::getQuestions($election_code);
		return view('preview', compact('page_title', 'election', 'questions') );
	}
	
}