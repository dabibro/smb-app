function states_local(state, dst) {
    $.post(ajax_path + 'global', {
        states_locals: 1,
        state: state
    }, function (response) {
        $(dst).html(response);
    });
}