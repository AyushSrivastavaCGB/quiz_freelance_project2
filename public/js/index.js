$(document).ready(function (){

    const config = {
        type : false,
        questionCount: null,
        difficulty : null,
        sound:true
    }
    
    const scoreCard = {
        correct     :   0,
        incorrect   :   0,
        total       : 0,
        currentQuestion : 0,
        question : "",
        questionId: null,
        questionBank:null,
        timer:null
    }

    const enterOperations = {
        enable:true,
        showNext:false,

    }

        //variables for timer
    var start,diff = 0,minutes,seconds,duration;
    var countdown;
    var clearTimer = false;
    var mcq_selected_ans = null;

    var scores = {};


    // getQuestions();


    function getQuestions() {
        $.ajax({
            type:"POST",
            url: "../api/",
            data:{
                s:"getQues",
                exerciseId:exerciseID,
                difficulty:config.difficulty,
                questionCount:config.questionCount,
                image:image
            },
            dataType: "json",
            success: function (data){
                console.log(data);
                if(data.status === 1)
                {
                    scoreCard.questionBank = data.questions;
                    scoreCard.total = data.totalCount;
                    scoreCard.question = scoreCard.questionBank[0].question;
                    scoreCard.questionId = scoreCard.questionBank[0].id;
                    if(data.totalCount === 0) {
                        alert("No question found");
                        return;
                    }
                    makePage();

                    $("#instructions_div").css({"display":"none"});
                    $("#q1").removeClass("hide");
                    $("#q1").fadeIn();
                    initSubmit_enter_listener();
                
            
                    duration = 60 * 10,
                    display = document.querySelector('#time_left');
                    startTimer(display);
                    console.log(scoreCard);
                }
            }
        });
    }


    $("#start_quiz").click(function () {
        //get configuration
        let questionLayout = $('input[name="ques_type"]:checked').val();
        let num_ques = $('input[name="num_ques"]:checked').val();
        let difficulty = $('#difficulty_selected').find(":selected").val();
        config.questionCount = num_ques;
        config.difficulty = difficulty;
        config.type = questionLayout;
        // alert(config.difficulty + "\n" + config.questionCount + "\n" + config.type);
        getQuestions();
        

    });


    function makePage() {
        //for score
        scoreCard.correct = 0;
        scoreCard.incorrect = 0;
        for (let key in scores) {
            if (scores.hasOwnProperty(key)) {
                if(scores[key] === 1)
                {
                    scoreCard.correct += 1;
                }else{
                    scoreCard.incorrect += 1;
                }
            }
            console.log(scoreCard);
        }

        $("#correctAns").text(scoreCard.correct);
        $("#incorrectAns").text(scoreCard.incorrect);
        $("#feedback_div").html("");

        let ques = scoreCard.questionBank[scoreCard.currentQuestion];
        if(ques['type'] === "0" && image === "1")
        {
            //SHOW IMAGE 
            let str = `<img src="../images/${ques['question']}" alt="quiz question" style="max-height:350px;max-width:550px">`;
            $("#question").html(str);
        }else{
            let question = (scoreCard.currentQuestion + 1) + ". " + scoreCard.question;
            $("#question").html(question);
            
        }

        $("#heading").html(ques['heading']);
        let number = (scoreCard.currentQuestion + 1) + " of " + scoreCard.total;
        $("#number").text(number);

        $("#result_div").html(``);

        $("#operation_div").html(
            `<button class="btn btn-primary" id="check">Check<span class="fas fa-arrow-right"></span> </button> `
        );
        

        if(config.type == 'multiple_choice')
        {
            //display multiple choice layout
            
            console.log(ques);
            $("#mulitple_choice_layout").addClass("show");
            $("#mulitple_choice_layout").removeClass("hide");

            $("#fill_in_layout").addClass("hide");
            $("#fill_in_layout").removeClass("show");

            let strOptions = ``;
            for(let i = 0 ; i < ques['options'].length ; i++){
                strOptions += `<button type="button" class="btn btn-outline-dark mcq"  id="mcq_button_${i}" style="margin-bottom:10px;color:black">${ques['options'][i]}</button>`;
            }
            $("#multiple_choice_button_holder").html(strOptions);
            
        }else{
            //display fill in the blank layout

            $("#mulitple_choice_layout").addClass("hide");
            $("#mulitple_choice_layout").removeClass("show");

            $("#fill_in_layout").addClass("show");
            $("#fill_in_layout").removeClass("hide");

            $("#answer").val("");
            $("#answer").focus();

        }



    
        enterOperations.enable = true;
        enterOperations.showNext = false;
        // initSubmit_enter_listener();

        

        updateProgress();
    }

    $("body").on('click', 'button[id^=check]',function(e){
        e.preventDefault();
        $(this).prop('disabled', true);
        //process this question checking
        checkCurrentAnswer();

    });

    $("body").on('click', 'button[id^=next]',function(e){
        e.preventDefault();
        // alert("next button clicked");
        $(this).prop('disabled', true);
        //process this question checking
        // checkCurrentAnswer();
        getNextQuestion();

    });

    $("body").on('click', 'button[id^=reset]',function(e){
        e.preventDefault();
        $(this).prop('disabled', true);
        location.reload();

    });

    $("body").on('click', 'button[class^=Tgno]',function(e){
        e.preventDefault();
        let ans = $("#answer").val();
        ans += $(this).text();
        $("#answer").val(ans);
        $("#answer").focus();
    
    });

    $("body").on('click', 'button[id^=mcq_button]',function(e){
        e.preventDefault();
        mcq_selected_ans = $(this).text();
        $(this).css('background',"#17a2b8");
        $(".mcq").prop("disabled",true);
        checkCurrentAnswer();

    });

    $('.speaker').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        if(!$(this).hasClass('on'))
        {
     
            config.sound = false;
        }else{
           
            config.sound = true;
        }
        $(this).toggleClass('on');
    });

    function checkCurrentAnswer()
    {
        let answer = null;
       if(config.type == 'multiple_choice')
       {
            if(mcq_selected_ans === null)
            {
                    alert("Select an option to check the answer");
                    return;
            }
            answer = mcq_selected_ans;
       }else{
            answer = $("#answer").val();
            if(answer.length == 0)
            {
                alert("Please enter the answer");
                $("#check").prop("disabled",false);
                enterOperations.enable = true;
                return;
            }
       }

        $.ajax({
            type:"POST",
            url: "../api/",
            data : {
                s:"checkAns",
                id:scoreCard.questionId,
                ans:answer
            },
            dataType: "json",
            success: function (data){
                mcq_selected_ans = null;
                console.log(data);
                if(data.status === 1)
                {
                    if(data.result === 1)
                    {
                        if(config.sound)
                        {
                            document.getElementById('success_sound').play();
                        }

                        scores[scoreCard.questionId] = 1;
                        
                        scoreCard.correct += 1;

                        $("#correctAns").text(scoreCard.correct);
                        $("#result_div").html(
                            ` <div class="alert alert-success">
                            <strong>Correct Answer!</strong>
                 
                        </div>`
                        );
                        $("#operation_div").html(
                            `<button class="btn btn-primary" id="next">Next<span class="fas fa-arrow-right"></span> </button> `
                        );

                        $("#feedback_div").html(`<h5 style="text-align:center;">${data.feedback}</h5>`);

                    }else{
                        if(config.sound)
                        {
                            document.getElementById('error_sound').play();
                        }
                        scoreCard.incorrect += 1;
                        scores[scoreCard.questionId] = 0;
                        $("#incorrectAns").text(scoreCard.incorrect);
                        $("#result_div").html(
                            `<div class="alert alert-danger">
                            <strong>Your Answer - </strong> <span style="color:green;margin-left:10px">${answer}</span>
                            <br>
                            <strong>Correct Answer - </strong> <span style="color:green;margin-left:10px">${data.correctAnswer}</span>           
                        </div>`
                        );
                        $("#operation_div").html(
                            `<button class="btn btn-primary" id="next">Next<span class="fas fa-arrow-right"></span> </button> `
                        );

                        $("#feedback_div").html(`<h5 style="text-align:center;">${data.feedback}</h5>`);
                    }
                    enterOperations.enable = true;
                    enterOperations.showNext  = true;
                    console.log(scores);
                    checkFinish();
                }
            }
        });
    }

    function getNextQuestion()
    {
        scoreCard.currentQuestion += 1;

        if(scoreCard.currentQuestion >= scoreCard.total)
        {
            alert("end of test");
        }else{
            scoreCard.question = scoreCard.questionBank[scoreCard.currentQuestion].question;
            scoreCard.questionId = scoreCard.questionBank[scoreCard.currentQuestion].id;
            makePage();    
        }
    }

    function updateProgress()
    {
        let current = scoreCard.currentQuestion + 1;
        let total = scoreCard.total ;

        let percentage = ((current/total)*100) + "%";
        console.log("percentage: " + percentage);
        
        $("#progress_bar").css({"width":percentage});
    }


    function checkFinish()
    {
        let current = scoreCard.currentQuestion + 1;
        let total = scoreCard.total ;
        if(current == total)
        {
            $("#operation_div").html(
                `<button class="btn btn-primary" id="view_result">View Result <span class="fas fa-arrow-right"></span> </button> `
            );

            clearTimer = true;
            enterOperations.enable = false;
            $("#view_result").click(function(){
                finishTest();
            });
           
        }
    }

    function startTimer(display) {
        start = Date.now();
        // we don't want to wait a full second before the timer starts
        timer();
        countdown = setInterval(timer, 1000);
    }

    function timer() {
        // get the number of seconds that have elapsed since 
        // startTimer() was called

        diff += 1;
        if(clearTimer)
        {
            clearInterval(countdown);
        }

        minutes = (diff / 60) | 0;
        seconds = (diff % 60) | 0;




        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        $("#time_left").text(minutes + ":" + seconds);

        // display.textContent = minutes + ":" + seconds; 

        if (diff <= 0) {
            // add one second so that the count down starts at the full duration
            // example 05:00 not 04:59
            start = Date.now() + 1000;
        }

       
    };

    function initSubmit_enter_listener() {
        $("#answer").unbind(); 
        document.querySelector('#answer').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();

             if(enterOperations.enable)
             {
                enterOperations.enable = false;
                if(enterOperations.showNext)
                {
                    getNextQuestion();
                }else{
                    checkCurrentAnswer();
                }
                
             }   
            }
        });
    }

    function finishTest(){

        
        let x = (minutes*60) + seconds;

        // does the same job as parseInt truncates the float
        minutes1 = (x / 60) | 0;
        seconds1 = (x % 60) | 0;

        minutes1 = minutes1 < 10 ? "0" + minutes1 : minutes1;
        seconds1 = seconds1 < 10 ? "0" + seconds1 : seconds1;

        var currentdate = new Date(); 
        var datetime = "Submitted at : " + currentdate.getDate() + "/"
                    + (currentdate.getMonth()+1)  + "/" 
                    + currentdate.getFullYear() + " @ "  
                    + currentdate.getHours() + ":"  
                    + currentdate.getMinutes() + ":" 
                    + currentdate.getSeconds();

        let type = "Multiple choice";
        if(config.type == 'multiple_choice')
        {
            type = "Multiple choice";
        }else{
            type = "Fill in the blanks";
        }

        $("#main_div").removeClass('main_div_class');
        $("#main_div").addClass('result_div_class');

        //result div
        let str =  `<div>
        <h4 class="modal-title">Result</h4>
            </div>
            <div>
                <div id="header_score" class="d-flex align-items-center" >
                    <div class="p-2">
                        <h3 style="color:black"> <i class="far fa-check-square" style="color:green"></i> <span >${scoreCard.correct}</span> </h3>
                        
                    </div>

                    <div class="p-2" style="margin-left: 20px;">
                        <h3 style="color:black"> <i class="far fa-times-circle" style="color:red"></i> <span>${scoreCard.incorrect}</span> </h3>
                        
                    </div>

                    <div class="p-2 ml-auto" style="margin-left: 20px;">
                        <h3 style="color:black"> Time Taken : ${minutes1} : ${seconds1}</h3>
                        <h5 style="color:black">${datetime}</h5>

                    </div>
                </div>

                <div>
                    <h3>Total Questions - ${scoreCard.total}</h3>
                </div>

                <div>
                    <h3>Attempted - ${scoreCard.correct + scoreCard.incorrect}</h3>
                </div>

                <div>
                    <h3>Percentage - ${Math.round((scoreCard.correct * 100)/scoreCard.total)} %</h3>
                </div>

                <div>
                    <h3>Total Score - ${scoreCard.correct}/${scoreCard.total}</h3>
                </div>

                <div>
                    <h3>Type of question - ${type}</h3>
                </div>

                <div>
                    <h3>No. of questions - ${scoreCard.total}</h3>
                </div>
                `;

            if(image === "0")
            {
                let difficulty = "";
                switch(config.difficulty)
                {
                    case "0":
                        difficulty = "Basic";
                        break;
                    case "1":
                        difficulty = "Intermediate";
                        break;
                    case "2":
                        difficulty = "Advanced";
                        break;
                    case "3":
                        difficulty = "Mixed";
                        break;
                        
                }
                str += ` <div>
                        <h3>Difficulty - ${difficulty}</h3>
                </div>`;
            }

            str += `</div>
            <div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="color:black" id="reset">Reset</button>
            </div>`;

        $("#main_div").html(str);

    }



});