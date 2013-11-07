$(document).ready(function() {

    function showHideStatusMessageForm()
    {
        var sel = $('#afa_admin_player_status');
        var message = $('#afa_admin_player_status_message').closest('.control-group');
        if (sel.length && message.length)
        {
            if (sel.val() == 'active') 
            {
                message.hide();
            }
            else
            {
                message.show();
            }
        }
    }

    $('#afa_admin_player_status').change(showHideStatusMessageForm);
    showHideStatusMessageForm();

});
