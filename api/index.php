<?php

require_once dirname(__DIR__).'/classes/Quiz.php';

if(isset($_POST['s']))
{
    switch($_POST['s'])
    {
        case 'addQue':
            addQue();
            break;
        case 'checkAns':
            checkAns();
            break;
        case 'getQues':
            getQue();
            break;
        
    }
}


function addQue()
{
    if(isset($_POST['que'],$_POST['ans'],$_POST['type']))
    {
        // echo "imhere";
        $quiz = new Quiz();
        echo $quiz->insertQuestion($_POST['que'],$_POST['ans'],$_POST['type']);
    }
}

function getQue()
{
    $qno = null;
    if(isset($_POST['exercise'],$_POST['questionCount'],$_POST['difficulty'],$_POST['image']))
    {
        $quiz = new Quiz();
        echo $quiz->getQuizQuestion($_POST['exercise'],$_POST['questionCount'],$_POST['difficulty'],$_POST['image']);
        
    }
   
}

function checkAns()
{
    if(isset($_POST['id'],$_POST['ans']))
    {
        // echo "imhere";
        $quiz = new Quiz();
        echo $quiz->checkAnswer($_POST['id'],$_POST['ans']);
    }    
}