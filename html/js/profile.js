$(document).ready(function () {

    $('#editProfileSubmit').bind('click',function (e) {
        e.preventDefault();
        $.post("/submits/editProfileSubmit.php",
            {
                editProfile: true,
                username: $("#editProfileForm input[name='username']").val(),
                email: $("input[name='email']").val(),
                name: $("input[name='name']").val(),
                idOu: $("select[name='idOu']").val(),
            },
            function(data, status){
                if(data === '1'  && status === 'success'){
                    notify('bottom','right','success','Údaje byly změněny')
                }else{
                    notify('bottom','right','danger','Někde se stala chyba údaje nebyly změněny')
                }
            });
    });

    $('#passwordChangeForm').validate({
        rules: {
            oldPass: {required:true,
                minlength: 6},
            newPass: {required:true,
                minlength: 6},
            newPassVerify: {
                equalTo: "#newPass",
                minlength: 6
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-danger');
        },
        success: function(element) {
            $(element).closest('.form-group').removeClass('has-danger').addClass('has-success');
        },
        errorPlacement : function(error, element) {
            $(element).append(error);
        }
    });

    $('#changePasswordSubmit').bind('click',function (e) {
        e.preventDefault();
        if($('#passwordChangeForm').valid()){
            $.post("/submits/changePasswordSubmit.php",
                {
                    changePassword: true,
                    username: $("#passwordChangeForm input[name='username']").val(),
                    oldPass: $("input[name='oldPass']").val(),
                    newPass: $("input[name='newPass']").val(),
                    newPassVerify: $("input[name='newPassVerify']").val(),
                },
                function(data, status){
                    data = $.parseJSON(data);
                    console.log(data);
                    if(status === 'success' && data['status'] == true){
                        notify('bottom','right','success','Heslo bylo změněno, musíte se znovu přihlásit');
                        setTimeout(function(){window.location.replace(data['baseUrl'])},2000)
                    }else if(data['status'] == false){
                        notify('bottom','right','danger','Někde se stala chyba heslo nebyly změněno, zkontrolujte zadané údaje.')
                    }
                });
        }
    });
});