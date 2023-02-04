<?php
namespace App;

use Medoo\Medoo;

class Election {

    /**
     * get election details from election_code string or array of company codes
     * @param mixed
     * @return array
     */
    
    public static function getByCode($election_codes){
        $db = container(Medoo::class);
        $user_elections =  $db->select("elections_tb", '*',[
            "election_code" => $election_codes 
        ]);

        return $user_elections;
    } 

    public static function regulatElectionAccess(){
        $parameters = request()->getLoadedRoute()->getParameters();

        if(isset($parameters['election_code']) && !in_array($parameters['election_code'], explode(',', session('user_elections')))) {
            redirect('/login');
        } else {
            //return election details as array 
            return Election::getByCode($parameters['election_code'])[0];
        }
    }

    public static function getQuestions( $election_code) 
    {
        $db = container(Medoo::class);
        $questions = $db->select("ballot_questions_tb", '*', ["q_election_code" => $election_code ]);

        if(!empty($questions))
        {   
            $res = $db->select("question_options_tb", '*', ["opt_election_code" => $election_code ] );
            $options = [];
            foreach($res as $opt) 
            {
                $options[$opt['opt_question_code']] [] = $opt;
            }
            
            foreach($questions as $key => $q) 
            {    
                $questions[$key]['q_nomination_desc_attachments'] = empty($questions[$key]['q_nomination_desc_attachments']) ? [] : json_decode($questions[$key]['q_nomination_desc_attachments'], true);

                $instructions = '';
                $questions[$key]['question_options'] = empty($options[$q['question_code']]) ? [] : $options[$q['question_code']] ;
                
                if( $questions[$key]['q_min_selection'] == 1 ) {  $cand = 'candidate'; } else { $cand = 'candidates'; }

                if($questions[$key]['q_min_selection'] == $questions[$key]['q_max_selection']) {
                    $instructions .= "Select exactly <strong>".$questions[$key]['q_min_selection']." $cand</strong> from the options below.";
                } else {
                    $instructions .= "You can select up to <strong>".$questions[$key]['q_max_selection']." candidates</strong>, but you must choose at least <strong>".$questions[$key]['q_min_selection']." $cand</strong> from the options below.";
                }

                $questions[$key]['question_instructions'] = $instructions;
            }
        }
    
        return $questions;
    }

    public static function deleteQuestion( $election_code, $question_code ) 
    {   
        $db = container(Medoo::class);
        //delete question options
        $data = $db->delete('question_options_tb', [  "opt_question_code" => $question_code, "opt_election_code" => $election_code ] );
		if ( !empty($db->errorInfo) )
		{   
            $logger = container('logger');
			$logger->error($db->errorInfo);
			return false;
		} else {
			//delete question
            $data = $db->delete('ballot_questions_tb', [  "question_code" => $question_code, "q_election_code" => $election_code ] );
            if ( !empty($db->errorInfo) )
            {   
                $logger = container('logger');
                $logger->error($db->errorInfo);
                return false;
            } else {
                //delete question
                return true;
            }
		}
    }
}

