<?php 
if(session_id() == '') {
    session_start();
}
?>
<html>
    <head>
        <title>Mailform</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <!-- Latest compiled and minified JavaScript -->
        <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
       
        <link rel="stylesheet" href="css/mailform.css">
        <script src="js/mailform.js"></script>
    </head>
    <body>
        <?php
        $_SESSION["captcha_num_1"] = rand(1, 10);
        $_SESSION["captcha_num_2"] = rand(1, 10);       
        ?>
        
        
        <form id="mail-form" class="well" onsubmit="return sendMail()">
            <div id="response"></div>
            <div class="input-group">
                <span class="input-group-addon">E-Mail:</span>
                <input id="from" type="text" class="form-control" placeholder="" required>
            </div>
            <div class="input-group">
                <span class="input-group-addon">Name:</span>
                <input id="name" type="text" class="form-control" placeholder="" required>
            </div>
            <div class="input-group">
                <span class="input-group-addon">Subject:</span>
                <input id="subject" type="text" class="form-control" placeholder="" required>
            </div>
            <div class="input-group">
                <span class="input-group-addon">Message:</span>
                <textarea id="msg" class="form-control"></textarea>
            </div>
            <div class="input-group">
                <label class="btn btn-default">
                    <input id="cc" type="checkbox" autocomplete="off"> Send a copy of this mail to me
                </label>
            </div>
            <div class="input-group">
                <span class="input-group-addon"><?php echo $_SESSION["captcha_num_1"] ?> + <?php echo $_SESSION["captcha_num_2"] ?> =</span>
                <input id="captcha" type="text" class="form-control" placeholder="Solve" required>
            </div>            
            <button type="submit" data-loading-text="Send message" class="btn btn-primary sendMail"><span class="glyphicon glyphicon-send"></span> Send Mail</button>            
        </form>    
    </body>
</html>