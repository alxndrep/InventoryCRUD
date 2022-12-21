$(document).ready(function() {
    $.ajax
    ({
        url: 'notifications/notifications.php',
        data: '',
        cache: false,
        success: function(a){
           var data = JSON.parse(a);
           $('.bajostock').html(data[0]['total']);
        }
    });
});
