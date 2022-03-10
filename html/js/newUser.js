$(document).ready(function () {


    $( "#newUser" ).validate({
        rules: {
            password: {
                minlength : 8
            },
            passwordConfirm: {
                equalTo: "[name='password']",
                minlength : 8
            }
        },
        messages:{
            name:{
                required: 'Toto pole je povinné',
            },
            username:{
                required: 'Toto pole je povinné',
            },
            email:{
                required: 'Toto pole je povinné',
            },
            idRoleType:{
                required: 'Toto pole je povinné',
            },
            idOu:{
                required: 'Toto pole je povinné',
            },
            password:{
                required: 'Toto pole je povinné',
                minlength: 'Minimalní délka hesla je 8 znaků'
            },
            passwordConfirm: {
                required: 'Toto pole je povinné',
                equalTo: "Hesla se neschodují",
                minlength: 'Minimalní délka hesla je 8 znaků'
            }
        }
    });

    $( "#newUser" ).submit(function (e) {
        e.preventDefault();
        if($(this).valid()){

            const formData = new FormData($('#newUser')[0]);

            $.ajax({
                url: '/submits/newUserSubmit.php',
                type: "POST",
                cache: false,
                data: formData,
                contentType: false,
                processData: false,
                success: function (data, status) {
                    console.log(data);
                    console.log(status);
                    if (status === 'success' && data == true) {
                        notify('bottom','right','success','Uživatel byl vytvořen');
                        $("input[name='idOu']").selectpicker('deselectAll');
                        $("input[name='idOu']").selectpicker('refresh');
                        $("input[name='idRoleType']").selectpicker('deselectAll');
                        $("input[name='idRoleType']").selectpicker('refresh');
                        $('#newUser')[0].reset();


                    } else {
                        notify('bottom', 'right', 'danger', 'Někde se stala chyba, uživatel nebyl vytvořen');
                    }
                }, error: function () {
                    alert('CHYBA při vytváření uživatele');
                }
            });

        }
    });
});