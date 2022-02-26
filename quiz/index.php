<?php
require_once dirname(__DIR__ ).'/classes/Quiz.php';

if(isset($_GET['id']))
{
    $exerciseId = $_GET['id'];
    $exercise = "";

    //get exercise name
    $quiz = new Quiz();
    $data = $quiz->getExercise($exerciseId);
    if($data != null)
    {   
        $exercise = $data->exercise;
    }else{
        http_response_code(404);
        die();
    }
}else{
    //return page not found
    http_response_code(404);
    die();
}
$image = 0;
if(isset($_GET['image']) && $_GET['image'] == "true")
{
    $image = 1;
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="../public/css/index.css" >
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script type="text/javascript">
    const exercise = "<?php echo $exercise; ?>";
    const exerciseID = "<?php echo $exerciseId; ?>";
    const image = "<?php echo $image?>";
</script>

<script src="../public/js/index.js" type="text/javascript"></script>
</head>
<body>



<div class="main_div_class"  id="main_div">

<!-- Start quiz div select all the config then procede -->

    <div class="modal-content" id="instructions_div">

        <!-- Modal Header -->
        <div class="modal-header">
        <h4 class="modal-title">Topic : <span style="color:blue"> <?php echo $exercise ?> </span></h4>
        
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <div class="container">
                <div class="col-auto" style="margin-bottom:2vh;border-bottom:1px solid black">
                    <label class="mr-sm-2">Select Question type</label>
                    <div class="form-check-inline">
                        <label class="form-check-label" for="radio1">
                            <input type="radio" class="form-check-input" id="radio1" name="ques_type" value="multiple_choice" checked>Multiple Choice
                        </label>
                    </div>
                    <div class="form-check-inline" style="padding-bottom:20px">
                        <label class="form-check-label" for="radio2">
                            <input type="radio" class="form-check-input" id="radio2" name="ques_type" value="fill_in">Fill in the blanks
                        </label>
                    </div>
                </div>

                <div class="col-auto" style="margin-top:2vh !important;border-bottom:1px solid black">
                    <label class="mr-sm-2">Number of questions</label>
                    <div class="form-check-inline">
                        <label class="form-check-label" for="radio3">
                            <input type="radio" class="form-check-input" id="radio3" name="num_ques" value="10" checked>10
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label" for="radio4">
                            <input type="radio" class="form-check-input" id="radio4" name="num_ques" value="20">20
                        </label>
                    </div>
                    <div class="form-check-inline" style="padding-bottom:20px">
                        <label class="form-check-label" for="radio5">
                            <input type="radio" class="form-check-input" id="radio5" name="num_ques" value="30">30
                        </label>
                    </div>
                </div>

                
                <div class="col-auto" style="margin-top:2vh !important" id="difficulty_div">
                    <label class="mr-sm-2" for="difficulty_selected">Difficulty Level</label>
                    <select class="custom-select mr-sm-2" id="difficulty_selected">
                        <option selected value="0">Basic</option>
                        <option value="1">Intermediate</option>
                        <option value="2">Advanced</option>
                        <option value="3">Mixed</option>
                    </select>
                </div>

            </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" style="color:black" id="start_quiz">Start</button>
        </div>

    </div>

    <div class="wrap hide" id="q1">
        <div style="margin-bottom: 5vh;">
            <div id="header_score" class="d-flex justify-content-between align-items-center" >
                <div class="p-2 d-flex">
                    <div class="p-2">
                        <h3 style="color:black"> <i class="far fa-check-square" style="color:green"></i> <span id="correctAns">0</span> </h3>
                    </div>

                    <div class="p-2" style="margin-left: 20px;">
                        <h3 style="color:black"> <i class="far fa-times-circle" style="color:red"></i> <span id="incorrectAns">0</span> </h3>
                    </div>
                </div>
              

                <div class="p-2 text-center">
                    <div class="h6 font-weight-bold">Question : <span id="number"> </span></div>
                </div>

                <div class="p-2 d-flex" style="margin-right: 20px;">
                
                
                    <div class="p-2" >
                        <h5 style="color:black"> Time : <span id="time_left"></span></h5>
                        
                    </div>
                    <div class="p-2">
                        <div class="round">
                            <div class="speaker">
                                <div id="mute" class="mute"></div>
                                <span></span>
                            </div>
                        </div>

                    </div>
                </div>

              
              
            </div>

            <div class="progress">
                <div class="progress-bar bg-info" id="progress_bar" style="width:0%"></div>
            </div>
        </div>

        <div class="h5" id="heading" style="margin-bottom:15px;text-align:center"> This is the heading for the given question</div>
       
        <div class="h4 font-weight-bold" id="question" style="margin-bottom:24px;text-align:center"> 1. Who is the Prime Minister of India?</div>

        <div id="fill_in_layout" style="max-width:480px;margin:auto;">
            <div  class="_1pfIGPTC">
                <div class="_3MyjHJfU">
                    <input type="text" placeholder="Type your answer here..." autocomplete="off" id="answer" />
                </div>
                
                <div class="_1oEuIWgz">
                    <button class="Tgno-7hq">á</button>
                    <button class="Tgno-7hq">é</button>
                    <button class="Tgno-7hq">í</button>
                    <button class="Tgno-7hq">ó</button>
                    <button class="Tgno-7hq">ú</button>
                    <button class="Tgno-7hq">ñ</button>
                    <button class="Tgno-7hq">¿</button>
                    <button class="Tgno-7hq">¡</button>
                </div>
            </div>

            <h6 style="padding:10px;color:red">
                    *Multiple answers are seperated by "," . example answer1,answer2
            </h6>
        </div>

        <div id="mulitple_choice_layout" style="max-width:480px;margin:auto">
            <div style="display:flex;flex-direction:column" id="multiple_choice_button_holder">

            </div>
        </div>

        <div class="pt-4" id="result_div" style="min-height: 80px">
            
        </div>

        <div  id="feedback_div">
            
        </div>

        <div class="d-flex justify-content-end pt-2" id="operation_div"> 
          
        </div>
    </div>

</div>


<div style="position:absolute; left:5vw;bottom:1vh;">
    <div class="h3 font-weight-bold text-white">Go Dark</div> <label class="switch"> <input type="checkbox"> <span class="slider round"></span> </label>
</div>

<audio id="error_sound" src="../public/sound/error.mp3" preload="auto"></audio>
<audio id="success_sound" src="../public/sound/success.mp3" preload="auto"></audio>



<script>

 
    document.addEventListener('DOMContentLoaded', function() {
        const main = document.querySelector('body')
        const toggleSwitch = document.querySelector('.slider')
        toggleSwitch.addEventListener('click', () => {
            main.classList.toggle('dark-theme')
        })

        if(image === "1")
        {
            $("#difficulty_div").css("display", "none");
        } 
    })
</script>
    
</body>
</html>


