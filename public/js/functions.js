/*
 * Notifications
 */
function readAllNotifications() {
    $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });
    $.ajax({
        type: "POST",
        url: '/notifications/read/all',
        success: function(response) {
            $('#mynotifications').html(response);
        }
    });
}