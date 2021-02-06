$(document).on('click', '#button-refresh', function(e){
    $.ajax({url: "http://localhost:8000/wp-admin/admin-ajax.php?action=miusage_data", success: function(result){
        $("#info").html(result);
      }});
});