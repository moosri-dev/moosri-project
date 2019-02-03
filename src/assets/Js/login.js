$(function(){
    $('#frmLogin').submit(function (e) {
        e.preventDefault();
        alert(e);

        $.ajax({
            type: "POST",
            url: "login.php",
            data: "data",
            dataType: "dataType",
            success: function (response) {
                alert(response)
            }
        }); 
    });
})