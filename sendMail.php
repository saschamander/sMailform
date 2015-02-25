<?php
    $TO_EMAIL = 'your@mail.de';
    $TO_NAME = 'Your Name';               

    $ERROR_NO_MESSAGE = "You have no message.";
    $ERROR_EMAIL_NOT_VALID = "Your E-Mail is wrong.";
    $ERROR_NO_SUBJECT = "A subject is required.";    
    $ERROR_QUESTION_WRONG = "You solved the question wrong.";    
    $SUCCESS_MSG = "Your email has been sent successfully.";
    
    
    $EMAIL_HEADER_LINE = "<b>[Contact Form from </b><i>" . $_SERVER["SERVER_NAME"] . "</i><b>]</b>";
    $EMAIL_LABEL_FROM = "From";
    $EMAIL_LABEL_TO = "To";
    $EMAIL_LABEL_SUBJECT = "Subject";
    $EMAIL_LABEL_MESSAGE = "Message";
    
    
    $GLOBALS["SUCCESS"] = "success";
    $GLOBALS["ERROR"] = "danger";    
    $GLOBALS["result_status"] = $SUCCESS;
    $GLOBALS["result_msg"] = "";

    if(session_id() == '') {
        session_start();
    }
    
    // Form variables    
    $from_email=  $_POST['from'];
    $from_name = $_POST['name'];
    $subject = $_POST['subject'];
    $msg = $_POST['msg'];    
    $captcha_answ = $_POST['captcha_answ'];
    $cc = $_POST['cc'];
    
    $captcha_num_1 = $_SESSION["captcha_num_1"];
    $captcha_num_2 = $_SESSION["captcha_num_2"];
    
    if(($captcha_num_1 + $captcha_num_2) != $captcha_answ){
        errorMsg($ERROR_QUESTION_WRONG);
    }
    
    if(!filter_var($from_email, FILTER_VALIDATE_EMAIL)){     
        errorMsg($ERROR_EMAIL_NOT_VALID);
    }
    
    if(trim($subject) == ""){
        errorMsg($ERROR_NO_SUBJECT);
    }
    
    if(trim($msg) == ""){
        errorMsg($ERROR_NO_MESSAGE);
    }
    
    if($result_status === $GLOBALS["SUCCESS"]){
        $header = buildHeader($from_email, $from_name, $cc);
        
        $email_msg  = "<html><body style='font-family: Arial, Helvetica, sans-serif;'>";   
        $email_msg .= $EMAIL_HEADER_LINE."<br /><br />";
        
        $email_msg .= "<table style='font-family: Arial, Helvetica, sans-serif;'>";
            $email_msg .= "<tr>";
               $email_msg .= "<td style='text-align: right;'><b>" . $EMAIL_LABEL_FROM . ":</b></td>";
               $email_msg .= "<td>" . $from_email . "</td>";
           $email_msg .= "</tr>";
           $email_msg .= "<tr>";
               $email_msg .= "<td style='text-align: right;'><b>" . $EMAIL_LABEL_TO . ":</b></td>";
               $email_msg .= "<td>" . $TO_EMAIL . "</td>";
           $email_msg .= "</tr>";
           $email_msg .= "<tr>";
               $email_msg .= "<td style='text-align: right;'><b>" . $EMAIL_LABEL_SUBJECT . ":</b></td>";
               $email_msg .= "<td>" . $subject . "</td>";
           $email_msg .= "</tr>";
           $email_msg .= "<tr>";
               $email_msg .= "<td style='text-align: right; vertical-align: top;'><b>" . $EMAIL_LABEL_MESSAGE . ":</b></td>";
               $email_msg .= "<td>" . $msg . "</td>";
           $email_msg .= "</tr>";
        $email_msg .= "</table >";
        
        $email_msg .= "</body></html>";
        mail($TO_EMAIL, $subject, $email_msg, $header);
        successMsg($SUCCESS_MSG);             
    }
    
    $result = array(
        "status" => $GLOBALS["result_status"],
        "msg" => $GLOBALS["result_msg"]
    );
    header('Content-Type: application/json');
    echo json_encode($result);
    
    function successMsg($msg){
        $GLOBALS["result_status"] = $GLOBALS["SUCCESS"];
        setMsg($msg);
    }
    
    function errorMsg($msg){
        $GLOBALS["result_status"] = $GLOBALS["ERROR"];
        setMsg($msg);
    }
    
    function setMsg($msg){
        if($GLOBALS["result_msg"] != ""){$GLOBALS["result_msg"] .= "<br />";}
        $GLOBALS["result_msg"] .= $msg;
    }
    
    function buildHeader($from_email, $from_name, $cc){
        $header  = "From:". $from_name ."<". $from_email .">\n";
        if($cc == "true"){ $header .= "Cc: ". $from_email ."\n";}
        $header .= "Content-Type: text/html; charset=utf-8";
        return $header;
    }
?>