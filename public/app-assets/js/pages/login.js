//---------------------------------------------------------------------------------------------------
$('#login-form').bootstrap3Validate(function (e, data) {
    "use strict";
    e.preventDefault();
    var btn = $('.login-button').html();
    $('.login-button').html('<i class="fal fa-spinner-third fa-spin mr-2"></i> Please Wait. Processing...');
    $.ajax({
        url: this.action,
        type: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            $("#login-response").html(data);
            $('.login-button').html(btn);
        },
        error: function () {
        }
    });

});

//---------------------------------------------------------------------------------------------------


function passwordToggle(elem, btn) {
    var x = document.getElementById(elem);
    if (x.type === "password") {
        x.type = "text";
        $(btn).html('<i class="feather icon-eye">');
    } else {
        $(btn).html('<i class="feather icon-eye-off">');
        x.type = "password";
    }
}

//---------------------------------------------------------------------------------------------------
function multiSignInExit(id) {
    $.post('ajaxRequest.php', {
        multiSignIn: id
    }, function (resp) {
        $("#login-response").html(resp);
    });
}

//---------------------------------------------------------------------------------------------------

