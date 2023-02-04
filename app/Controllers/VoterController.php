<?php
namespace App\Controllers;

use Medoo\Medoo;
use App\Election;

class VoterController
{
    public function list($election_code) 
    {
        $page_title = 'Voters';
        $election = Election::regulatElectionAccess();
        $db = container(Medoo::class);
        $voters = $db->select("voters_tb", '*',["voter_election_code" => $election_code ]);
        return view('voters', compact('page_title', 'election', 'voters' ));
    }

    public function create($election_code) 
    {
        $page_title = 'Voters';
        $election = Election::regulatElectionAccess();
        $db = container(Medoo::class);
        $type = input('new_user_type', 'SINGLE');

        if($type == 'BULK')
        {   //processing bulk upload csv
            //prevent double loading from refreshing page
            $batch = $db->select("voters_tb", '*',["voter_election_code" => $election_code, "voter_batch_code" => input('voter_batch_code', 'XXXX') ]);
            if(count($batch) < 1) 
            {   //batch not found
                $csv = input()->file('upload_template');
                if($csv->getType() === 'text/csv') 
                {   //read uploaded file
                    if (($handle = fopen($csv->getTmpName(), "r")) !== FALSE) {
                        $row = 0;
                        $voters_data = [];
                        while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
                            $num = count($data); 
                            if($row > 0)
                            {   
                                if(trim($data[1]) != 'test')
                                {
                                    $voter = Array(
                                        'voter_code' => uniqid('v_'),
                                        'voter_name' => trim($data[0]),
                                        'voter_username' => trim($data[1]),
                                        'voter_password' => trim($data[2]),
                                        'voter_email' => trim($data[3]),
                                        'voter_phone' => trim($data[4]),
                                        'voter_election_code' => $election_code,
                                        'voter_added_by' => session('username'),
                                        'voter_batch_code' => trim(input('voter_batch_code'))
                                    );
                                    $voters_data[] = $voter;
                                }
                            }  
                            $row++;
                        }
                        fclose($handle);

                        $db->insert("voters_tb", $voters_data);
                        if(empty($db->error))
                        {
                            $message = Array(
                                'type' => 'success', 
                                'text' => 'The voters were successfully added. Please try again'
                            );
                        } else {
                            $logger = container('logger');
			                $logger->error($db->errorInfo);
                            $message = Array(
                                'type' => 'danger', 
                                'text' => 'Failed to add users into the database. Please try again or contact the system administrator'
                            );
                        }

                    } else {
                        $message = Array(
                            'type' => 'danger', 
                            'text' => 'Could not read the csv file you uploaded. Please try again'
                        );
                    }
                } else {
                    $message = Array(
                        'type' => 'danger', 
                        'text' => 'The template file you uploaded was not in csv format. Please try again'
                    );
                }
            } else {
                $message = Array(
                    'type' => 'danger', 
                    'text' => 'The template file you uploaded was is already processed.'
                );
            }
            $voters = $db->select("voters_tb", '*',["voter_election_code" => $election_code ]);
            return view('voters', compact('page_title', 'election', 'voters', 'message'));
        } else {
            //saving new individual voter
            $batch = $db->select("voters_tb", '*',["voter_election_code" => $election_code, "voter_code" => input('voter_code') ]);
            if(count($batch) < 1) 
            {   //no user with that code
                $voter = Array(
                    'voter_code' => trim(input('voter_code')),
                    'voter_name' => trim(input('voter_name')),
                    'voter_username' => trim(input('voter_username')),
                    'voter_password' => trim(input('voter_password')),
                    'voter_email' => trim(input('voter_email')),
                    'voter_phone' => trim(input('voter_phone')),
                    'voter_election_code' => $election_code,
                    'voter_added_by' => session('username'),
                );

                if($voter['voter_name'] == 'test')
                {
                    $message = Array(
                        'type' => 'danger', 
                        'text' => "A voter's username cannot be '<strong>test</strong>'. Test username is reserved for previews only"
                    );
                } else {
                    $db->insert("voters_tb", $voter);
                    if(empty($db->error))
                    {
                        $message = Array(
                            'type' => 'success', 
                            'text' => 'The voter was added successfully'
                        );
                    } else {
                        $logger = container('logger');
                        $logger->error($db->errorInfo);
                        $message = Array(
                            'type' => 'danger', 
                            'text' => 'Failed to save the voter to the database. Contact the system administrator for assistance.'
                        );
                    }
                }
            } else {
                $message = Array(
                    'type' => 'danger', 
                    'text' => 'The voter is already saved into the database. Look for the voter in the register below.'
                );
            }
            $voters = $db->select("voters_tb", '*',[ "voter_election_code" => $election_code ]);
            return view('voters', compact('page_title', 'election', 'voters', 'message'));
        }
    }

    public function update($election_code, $voter_code) 
    {
        $page_title = 'Voters';      
		$election = Election::regulatElectionAccess();
		$db = container(Medoo::class);
        
		$v = [];
		if(!empty(input('voter_name'))) { $v['voter_name'] = trim(input('voter_name')); }
		if(!empty(input('voter_username'))) { $v['voter_username'] = trim(input('voter_username')); }
		if(!empty(input('voter_password'))) { $v['voter_password'] = trim(input('voter_password')); }
		if(!empty(input('voter_email'))) { $v['voter_email'] = trim(input('voter_email')); }
        if(!empty(input('voter_phone'))) { $v['voter_phone'] = trim(input('voter_phone')); }
		
		$db->update('voters_tb', $v, [ 'voter_election_code' => $election['election_code'], 'voter_code' => $voter_code ] );
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
			$voters = $db->select("voters_tb", '*',[ "voter_election_code" => $election_code ]);
			return view('voters', compact('page_title', 'election', 'voters', 'message'));
		}	
    }

    public function download($election_code) 
    {
		$election = Election::regulatElectionAccess();
		$db = container(Medoo::class);
        $voters = $db->select("voters_tb", ['voter_name','voter_username','voter_password','voter_email'],["voter_election_code" => $election_code ]);
        $voters = [['voter_name','voter_username','voter_password','voter_email'], ...$voters];
        array_to_csv_download($voters, 'export.csv', ','); //helper function in helpers.php
    }
    
    public function delete($election_code)
    {   
        $page_title = 'Voters';    
        $election = Election::regulatElectionAccess();
        $db = container(Medoo::class);

        $where  = [ "voter_election_code" => $election_code ];
        if(input('voter_codes', '') != 'ALL'){
            $where[ 'election_code' ] = explode( ',', input('voter_codes') ) ;
        }
		$data = $db->delete('voters_tb', $where );
		if ( !empty($db->errorInfo ) )
		{
			$logger = container('logger');
			$logger->error($db->errorInfo);
			//redirect('/500');
		} else {
			$message = Array(
				'type' => 'success', 
				'text' => 'Voter list has been cleared successfully'
			);
			$voters = $db->select("voters_tb", '*',[ "voter_election_code" => $election_code ]);
			return view('voters', compact('page_title', 'election', 'voters', 'message'));
		}
    }

    public function showVoterLogin($election_code)
	{    
		$page_title = 'Voter Login';
		$election = Election::getByCode($election_code)[0];

        $form_action = url( 'voter-login', [ 'election_code' => $election['election_code'] ] ) ;
		if(empty($election))
		{
			redirect('/404');
		} else {
			return view('voter_login', compact('page_title', 'election', 'form_action'));
		}	
	}

    public function voterLogin($election_code) 
    {
        $election = Election::getByCode($election_code)[0];
        $form_action = url( 'voter_login', [ 'election_code' => $election['election_code'] ] ) ;
		if(empty($election))
		{
			redirect('/404');
            exit();
		} 

        if($election['launched'] == 0 || time() < strtotime($election['election_start_date']))
        {   
            if(input('username', '') == 'test' && input('password', '') == 'test')
            {   
                $voter = Array(
                    'voter_code' => 'test',
                    'voter_name' => 'Test Voter',
                    'voter_username' => 'test',
                    'voter_password' => 'test',
                    'voter_election_code' => $election_code,
                    'voter_is_nominee' => 1
                );
                $voter['user_full_name'] = $voter['voter_name'];
                $voter['user_category'] = 'VOTER';
                $voter['last_login_date'] = date('Y-m-d H:i:s');
                $voter['logged_in'] = true;
                $voter['last_activity'] = time();  
                foreach( array_keys($voter) as $key) { session($key, $voter[$key]); }
                redirect( url('voting_booth', ['election_code' => $election_code]) );
            } else {
                $page_title = 'Voter Login';
                $message = ["text" => "Election is not yet launched. The election is scheduled to start on ". date('d M, Y (H:i)', strtotime($election['election_start_date'])), "type" => "danger" ];
                return view('voter_login', compact('page_title', 'election', 'message', 'form_action'));
            }
            
        } else {
            $db = container(Medoo::class);
            $voter = $db->get('voters_tb', '*', [ "voter_username" => input('username', ''), "voter_password" => input('password', '') ] );
            
            if(!empty($voter)) 
            {
                $voter['last_login_date'] = date('Y-m-d H:i:s');
                $voter['logged_in'] = true;
                $voter['last_activity'] = time();

                foreach( array_keys($voter) as $key) { session($key, $voter[$key]); }
                redirect( url('voting_booth', ['election_code' => $election_code]) );
            } else {
                $page_title = 'Voter Login';
                $message = ["text" => "Incorrect password or username. Please try.", "type" => "danger" ];
                return view('voter_login', compact('page_title', 'election', 'message', 'form_action'));
            }
        }
    }

    public function showBallot($election_code) 
    {   
        $page_title = 'Voting Booth';
        $election = Election::getByCode($election_code)[0];
		if(empty($election))
		{
			redirect('/404');
		} else {
            $voter_code = session('voter_code');
            if($voter_code == 'test')
            {
                $questions = Election::getQuestions($election_code);
                return view('voting_booth', compact('page_title', 'election', 'questions'));
            } else {
                //check if voter has already voted
                $db = container(Medoo::class);
                $vs = $db->select('votes_tb', '*', ['vote_election_code' => $election_code, 'vote_voter_code' => $voter_code ]);
                if( count($vs) > 0 )
                {   
                    if(time() < strtotime($election['election_end_date']))
                    {
                        $msg = $election['vote_confirmation_msg'];
                    } else {
                        $msg = $election['after_election_message'];
                    }
                    $message = ["text" => $msg, "type" => "success" ];
                    return view('after_vote', compact('page_title', 'election', 'message'));
                } else {
                    $questions = Election::getQuestions($election_code);
                    return view('voting_booth', compact('page_title', 'election', 'questions'));
                }
            }  
		}	
    }

    public function submitVote($election_code)
    {  
        $page_title = 'Vote Submitted';
        $election = Election::getByCode($election_code)[0];
        $goto_page = 'after_vote';
        //ensure voter_code sent from browser matches voter_code in session... 
        //Scenario: two people logged in on the same browser on diff tabs
        if(session('voter_code') != input('voter_code', ''))
        {   //have user log in again
            redirect( url('session-error') );  
            exit(); 
        }
        $voter_code = session('voter_code');

        if($voter_code == 'test')
        {   
            $message = ["text" => $election['vote_confirmation_msg'], "type" => "success" ];
            return view('after_vote', compact('page_title', 'election', 'message'));
            exit();
        } 

        //ensure voter is allowed to perticipate in this election
        $db = container(Medoo::class);
        $voter = $db->get('voters_tb', '*', ['voter_election_code' => $election_code, 'voter_code' => $voter_code ] );
        if(empty($voter))
        {   //voter not present in election list ... have user log in again
            redirect( url('session-error') );  
            exit(); 
        }
        //ensure voter hasn't already voted
        $vs = $db->select('votes_tb', '*', ['vote_election_code' => $election_code, 'vote_voter_code' => $voter_code ]);
        if(count($vs) > 0)
        {   
            $goto_page = 'after_vote';
            $message = ["text" => "You have already voted in this election.", "type" => "danger" ];
        } else {
            $vdata= json_decode(input('vote_data', '[]'), true);
            $questions = Election::getQuestions($election_code);
            //ensure the voter has submitted the required number of votes.
            //1. get required max and min vote options for each question
            $questions = Election::getQuestions($election_code);
            $qs = [];
            foreach($questions as $q) {
                $qs[$q['question_code']] = $q;
            }
            //2. compare with what is submitted
            $v_counts = [];
            foreach($vdata as $v)
            {
                if( empty($v_counts[$v['question_code']]) )
                {  
                    $v_counts[$v['question_code']] = 1; 
                } else {
                    $v_counts[$v['question_code']]++;
                }
            }
            //3. ensure member has submitted a vote in every category/question
            //   also ensures question codes provided are in the relevant election
            if( array_diff( array_keys($v_counts), array_keys($qs) ) )
            {
                $goto_page = 'voting_booth';
                $message = ["text" => "Vote did not count. You did not make a selection in each category. Log in again if this issue persists.", "type" => "danger" ];
            } else {
                //4: ensure number of votes submitted are within the min and max of each category/question
                $all_good = true;
                $msg = '';
                foreach(array_keys($v_counts) as $q_code) 
                {
                    if( $v_counts[$q_code] < $qs[$q_code]['q_min_selection'] || $v_counts[$q_code] > $qs[$q_code]['q_max_selection'] )
                    {
                        $all_good = false;
                        $msg = "The number of selections made under the category titled <strong>".$qs[$q_code]['q_title']."</strong> are over or below what is required.";
                    }
                }

                if($all_good) 
                {   
                    $votes = [];
                    foreach($vdata as $vt)
                    {   
                        $vote = Array (
                            'vote_election_code' => $election_code,
                            'vote_question_code' => $vt['question_code'],
                            'vote_option_code' => $vt['option_code'],
                            'vote_voter_code' => session('voter_code'),
                            'vote_voter_name' => session('voter_name'),
                            'vote_time' => date('Y-m-d H:i:s'),
                            'voter_ip_address' => $_SERVER['REMOTE_ADDR'],	
                            'voter_browser' => $_SERVER['HTTP_USER_AGENT']	
                        );
                        $votes[] = $vote;
                    }
                    $db->insert('votes_tb', $votes);
                    if(empty($db->errorInfo))
                    {
                        $goto_page = 'after_vote';
                        $message = ["text" => $election['vote_confirmation_msg'], "type" => "success" ];
                    } else {
                        $goto_page = 'voting_booth';
                        $message = ["text" => $msg, "type" => "danger" ];
                    }
                } else {
                    $goto_page = 'voting_booth';
                    $message = ["text" => $msg, "type" => "danger" ];
                }   
            }
        }
        return view($goto_page, compact('page_title', 'election', 'message'));
    }

    public function showNominationsLogin($election_code)
	{    
		$page_title = 'Voter Login';
		$election = Election::getByCode($election_code)[0];

        $form_action = url( 'nominations-login', [ 'election_code' => $election['election_code'] ] ) ;
		if(empty($election))
		{
			redirect('/404');
		} else {
			return view('voter_login', compact('page_title', 'election', 'form_action'));
		}	
	}

    public function nominationsLogin($election_code) 
    {
        $election = Election::getByCode($election_code)[0];
        $form_action = url( 'nominations-login', [ 'election_code' => $election['election_code'] ] ) ;
		if(empty($election))
		{
			redirect('/404');
            exit();
		} 

        if( $election['enable_nominations'] == 0 || time() < strtotime($election['nomination_start_date']) || time() > strtotime($election['nomination_end_date']) )
        {   
            if(input('username', '') == 'test' && input('password', '') == 'test')
            {   
                $voter = Array(
                    'voter_code' => 'test',
                    'voter_name' => 'Test Voter',
                    'voter_username' => 'test',
                    'voter_password' => 'test',
                    'voter_election_code' => $election_code
                );
                $voter['user_full_name'] = $voter['voter_name'];
                $voter['user_category'] = 'VOTER';
                $voter['last_login_date'] = date('Y-m-d H:i:s');
                $voter['logged_in'] = true;
                $voter['last_activity'] = time();  
                foreach( array_keys($voter) as $key ) { session($key, $voter[$key]); }
                redirect( url('election-nominations', ['election_code' => $election_code]) );
            } else {
                $page_title = 'Voter Login';
                $message = ["text" => "The nomination period for this election has passed or nominations have not been activated for this election.", "type" => "danger" ];
                return view('voter_login', compact('page_title', 'election', 'message', 'form_action'));
            }
            
        } else {
            $db = container(Medoo::class);
            $voter = $db->get('voters_tb', '*', [ "voter_username" => input('username', ''), "voter_password" => input('password', '') ] );
            
            if(!empty($voter)) 
            {
                $voter['last_login_date'] = date('Y-m-d H:i:s');
                $voter['logged_in'] = true;
                $voter['last_activity'] = time();

                foreach( array_keys($voter) as $key) { session($key, $voter[$key]); }
                redirect( url('election-nominations', ['election_code' => $election_code]) );
            } else {
                $page_title = 'Voter Login';
                $message = ["text" => "Incorrect password or username. Please try.", "type" => "danger" ];
                return view('voter_login', compact('page_title', 'election', 'message', 'form_action'));
            }
        }
    }

    public function showElectionNominations($election_code)
    {
        $page_title = 'Election Nominations';
		$election = Election::getByCode($election_code)[0];
        $questions = Election::getQuestions($election_code);
        
        foreach($questions as $key => $q)
        {   
            $questions[$key]['has_nominees'] = count($q['question_options']) > 0? true : false ; 
        }

        $hide_my_nomination_area = true;

        if(empty($election))
		{
			redirect('/404');
		} else {
            if(isset($_GET['apply']))
            {
                $hide_my_nomination_area = false;
            }
			return view('nominations', compact('page_title', 'election', 'hide_my_nomination_area', 'questions'));
		}
    }

    function showNominationApplication($election_code, $question_code)
    {   
        $page_title = 'Nomination Application';
		$election = Election::getByCode($election_code)[0];

        $db = container(Medoo::class);
        $question = $db->get("ballot_questions_tb", '*',[ "q_election_code" => $election_code, 'question_code' => $question_code ]);
        
        $attachments = json_decode($question['q_nomination_desc_attachments'], true);

        if(empty($question['q_nomination_supporting_docs']))
        {
            $application_files = [];
        } else {
            $application_files = explode(',', $question['q_nomination_supporting_docs'] );
        }
        
        return view('nomination-application', compact('page_title', 'election', 'question', 'attachments', 'application_files' ));
    }

    public function createNominationCandidate($election_code, $question_code) 
	{  
     
		$election = $election = Election::getByCode($election_code)[0];
        $page_title = 'Nomination Application';

        $hide_my_nomination_area = true;
        
		$active_q = $question_code;
		$option_code = trim(input('option_code'));
    
        $db = container(Medoo::class);
        $question = $db->get("ballot_questions_tb", '*',[ "q_election_code" => $election_code, 'question_code' => $question_code ]);
        $application_files = explode( ',', $question['q_nomination_supporting_docs'] );

		//check if ballot question exists avoid double submit from refreshing page
		$o = $db->get("question_options_tb", '*', [ "option_code" => $option_code ]);

		if(empty($o)) 
		{	
            //upload nomination supporting documents 
            $docs_allowed = ['pdf', 'jpeg', 'jpg', 'png'];
            $docs = input()->file('supporting_documents');
            $files_all_good = false;
            $destinationFilename = '';
            $supporting_docs = [];
            foreach($docs as $i => $doc)
            {
                if( in_array($doc->getExtension(), $docs_allowed) ) 
                {
                    $destinationFilename = sprintf('%s.%s', uniqid(), $doc->getExtension());
                    $supporting_docs[] = array('name' => $application_files[$i], 'file' => $destinationFilename);
                    $doc->move(sprintf('../public/assets/app_files/%s', $destinationFilename));
                } else {
                    $files_all_good = true;
                    break;
                }
            }
            //todo: handle if files_all_good is false
             
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
                'opt_approval_stage' => 1,
                'opt_nomination_supporting_docs' => json_encode( $supporting_docs ),
				'opt_created_by' => session('voter_name')
			);

			$db->insert('question_options_tb', $option);

			$message = Array(
				'type' => 'success', 
				'text' => 'Your application has was submitted successfully.'
			);
			$questions = Election::getQuestions($election_code);
            foreach($questions as $key => $q)
            {   
                $questions[$key]['has_nominees'] = count($q['question_options']) > 0? true : false ; 
     
            }
			return view('nominations', compact('page_title', 'election', 'hide_my_nomination_area', 'questions', 'message'));
		} else {
			$message = Array(
				'type' => 'danger', 
				'text' => 'Your application was already submitted.'
			);
			$questions = Election::getQuestions($election_code);
            foreach($questions as $key => $q)
            {   
                $questions[$key]['has_nominees'] = false; 
                foreach($q['question_options'] as $o)
                {

                    $questions[$key]['has_nominees'] = count($q['question_options']) > 0? true : false ; 
                    
                }
            }
			return view('nominations', compact('page_title', 'election', 'hide_my_nomination_area', 'questions', 'message'));
		}
	}
}

?>


