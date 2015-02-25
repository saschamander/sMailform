function sendMail(){
    $('.sendMail').button('loading');
    $("#response").empty();
    var from = $("#from").val();
    var name = $("#name").val();
    var subject = $("#subject").val();
    var msg = $("#msg").val().replace(/\r?\n/g, '<br />');;
    var captcha_answ = $("#captcha").val();
    $("#captcha").val("");
    var cc = $('#cc').prop('checked');

    var ajaxCall = $.ajax({
        type: "POST",
        async: true,
        url: "sendMail.php",
        data: { 
            from: from, 
            name: name, 
            subject: subject, 
            msg: msg, 
            captcha_answ: captcha_answ,
            cc: cc
        }                 
    });

    ajaxCall.done(function(data) {
        $("#response").empty();
        var result_msg = data.msg;
        var result_status = data.status;
        $("#response").html('<div class="alert alert-' + result_status + '" role="alert">' + result_msg + '</div>');
        $('.sendMail').button('reset');
    });

    return false;
}