(function (window, undefined) {
    'use strict';
    let login_page = document.getElementById('login-page');

    /*
    NOTE:
    ------
    PLACE HERE YOUR OWN JAVASCRIPT CODE IF NEEDED
    WE WILL RELEASE FUTURE UPDATES SO IN ORDER TO NOT OVERWRITE YOUR JAVASCRIPT CODE PLEASE CONSIDER WRITING YOUR SCRIPT HERE.  */
    if (!login_page) {
        $('#content-loader').addClass('hidden');
        $('#main-content').removeClass('hidden');
    }

    $('.app-form').bootstrap3Validate(function (e, data) {
        "use strict";
        e.preventDefault();
        var btn = $('.form-button').html();
        $('.form-button').html('<i class="fal feather fa-spinner-third fa-spin"></i> Processing...');
        $.ajax({
            url: this.action,
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $("#form-response").html(data);
                $('.form-button').html(btn);
            },
            error: function () {
            }
        });

    });

    $('#DeleteForm').bootstrap3Validate(function (e, data) {
        "use strict";
        e.preventDefault();
        var btn = $('.ConfirmDelete').html();
        $('.ConfirmDelete').html('<i class="fal feather fa-spinner-third fa-spin"></i> Processing...');
        $.ajax({
            url: this.action,
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $('.ConfirmDelete').html(btn);
                $('#DeleteRequest').modal('hide');
                $("#AjaxResponses").html(data);
            },
            error: function () {
            }
        });

    });

    $('#DeleteRequest').on('hide.bs.modal', function (e) {
        $('#DeleteRequest #message').html('');
        $('#DeleteRequest form').attr('action', '');
        $('#DeleteRequest form #pk').val('');
        $('#DeleteRequest form #callback').val('');
    });

    $(".toggle-checkbox").on('click', function () {
        if (this.checked) {
            $('.' + this.id + ' :checkbox').each(function () {
                this.click();
                this.checked = true;
            });
        } else {
            $('.' + this.id + ' :checkbox').each(function () {
                this.checked = false;
            });
        }
    });

})(window);

function passwordToggle(elem, btn) {
    "use strict";
    var x = document.getElementById(elem);
    if (x.type === "password") {
        x.type = "text";
        $(btn).html('<i class="feather icon-eye">');
    } else {
        $(btn).html('<i class="feather icon-eye-off">');
        x.type = "password";
    }
}

function DeleteWarning(params) {
    $('#DeleteRequest #message').html(params.message);
    $('#DeleteRequest form').attr('action', params.action);
    $('#DeleteRequest form #pk').val(params.row_id);
    $('#DeleteRequest form #callback').val(params.callback);
    $('#DeleteRequest').modal({backdrop: 'static'});
}

function TablePostRequest(message, param, action = "") {

    let table_action = document.getElementById('table-action');
    let checked = 0;

    $("table tbody input[type=checkbox]").each(function (e) {
        if (this.checked) checked++;
    });
    if (checked === 0) {
        alert('No item selected!');
    } else {
        if (confirm(message)) {
            if (table_action && action !== "") {
                table_action.value = action;
            }
            $("#" + param).submit();
        }
    }
}
