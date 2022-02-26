<?php

require_once dirname(__DIR__ ).'/classes/DB.php';

class Quiz{
    /**
     * function to insert a question in database
     */

    public function insertQuestion($ques,$ans,$type)
    {
        $db = DB::getInstance();
        $insertData  = array(
            "que"   => $ques,
            "ans"   => $ans,
            "name"  => $type
        );

        if($db->insert("Questions",$insertData))
        {
            return json_encode(array("status" => 1, "msg" => "question added successfully"));
        }else{
            return json_encode(array("status" => 0, "msg" => "database insertion failed"));
        }
    }


    /**
     * function to get exercise data
     */
    
    public function getExercise($id)
    {
        $db = DB::getInstance();
        $data = $db->getExercise($id);
        if(count($data) > 0)
        {
            return $data[0];
        }

        return null;
    }

    /**
     * function to getQuiz Questions
     */

    public function getQuizQuestion($exerciseId,$num,$difficulty,$image)
    {
        $db = DB::getInstance();
        $exerciseData = $db->getExercise($exerciseId);

        if(count($exerciseData) == 0)
        {
            return json_encode(array("status" => 0, "msg" => "exercise not found"));
        }
        $exerciseData = $exerciseData[0];

        $get = array(
            "exerciseId" => $exerciseId
        );

        if($image == "1")
        {
            $get['type'] = 0;

            $data = $db->getQuesImage("QuestionBank",$get);
        }else{
            $get['type'] = 1;
            
            $get['difficulty'] = $difficulty;
    
            $data = $db->getQues("QuestionBank",$get);
        }
       

        // print_r($get);

        // print_r($data);
        $count = count($data);
        $dataToReturn = array();
        $dataToReturn['totalCount'] = $count;
        $dataToReturn['status'] = 1;
        shuffle($data);
        
        for($i = 0; $i < $num; $i++)
        {
            $question = $data[$i];
            $options = array();
            $options =  explode("/",$question->options);
            $options[] = $question->ans;
            shuffle($options);

            $dataToReturn['questions'][] = array(
                "question"  => $question->question,
                "id"        => $question->id,
                "options"   => $options,
                "heading"   => $exerciseData->heading,
                "type"      => $question->type
            );
        }

        return json_encode($dataToReturn);
    }

    /**
     * function to check answer
     */

    public function checkAnswer($id,$answer)
    {
        $db = DB::getInstance();
        $data = $db->get("QuestionBank",array("id","=",$id))->results();
        if(count($data) == 1)
        {
            $answer         = trim($answer);
            $correctAnswer  = trim($data[0]->ans);

            if(strcasecmp($answer,$correctAnswer) == 0)
            {
                return json_encode(array("status" => 1, "result" => 1,"feedback" => $data[0]->feedback));
            }else{
                return json_encode(array("status" => 1, "result" => 0,"correctAnswer" => $correctAnswer,"feedback" => $data[0]->feedback));
            }
        }else{
            return json_encode(array("status" => 0, "msg" => "question id not exists"));
        }
    }
}
