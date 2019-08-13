<?php $this->start('body');?>

<style>
    @font-face {
        font-family: "Futura PT Medium";
       
        src: url("<?=URLPUBLIC?>fonts/LemonMilklightitalic.otf") format("otf");
        src: url("<?=URLPUBLIC?>fonts/Majesti-Banner-Heavy.otf") format("otf");
        src: url("<?=URLPUBLIC?>fonts/MyriadPro-Regular.otf") format("otf");
        src: url("<?=URLPUBLIC?>fonts/brown-light-webfont.ttf") format("ttf");
        src: url("<?=URLPUBLIC?>fonts/Futura PT Medium.ttf");
    }
    body{
        font-family: "Futura PT Medium"
    }
    .tooltip-inner{
        max-width: 217px;
        color: rgba(0,0,0,.9);
        background-color: #b3d7ff;
        word-wrap: break-word;
        text-align: left;
        white-space: pre-wrap;
    }
    .text-danger{
        color: #fff!important;
    }
    /*
    onsubmit="check_password(event);"
    */
    </style>
    <div class="container mt-5">
        <div class="row justify-content-center"><h2>Usuario</h2></div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="bg-danger text-white"><?=$this->displayErrors;?></div>
                <form action="<?=PROOT?>perfil/edit" method="post" id="form_edit"  onsubmit="return check_password(event);">   
                <div class="form-group mb-1">
                    <label for="name">Nombre</label>
                    <input class="form-control" id="name" name="name" value="<?=$users_data->entry_firstname;?>">
                </div>
                <div class="form-group mb-1">
                    <label for="password_new">Contraseña Nueva&nbsp;<i class="fa fa-question-circle" data-toggle="tooltip" title="Si quieres cambiar la contraseña tienes que rellenar este campo, si no tienes que dejarlo vacio."></i></label>
                    <input type="password" class="form-control" id="password_new" name="password_new" value="">
                </div>
                <div class="form-group mb-1">
                    <label for="password_new_check">Repita contaseña&nbsp;<i class="fa fa-question-circle" data-toggle="tooltip" title="Si quieres cambiar la contraseña tienes que rellenar este campo."></i></label>
                    <input type="password" class="form-control" id="password_new_check" name="password_new_check" value=""> 
                </div>
                <div class="form-group mb-1">
                    <label for="password_old">Contraseña antigua&nbsp;<i class="fa fa-question-circle" data-toggle="tooltip" title="Para cualquier cambio este campo es obligatorio."></i></label>
                    <input type="password" class="form-control" id="password_old" name="password_old" value="" required>
                </div>
                <div class="form-group mb-1">
                    <label for="email">Email</label>
                    <input type="Email" class="form-control" id="email" name="email" value="<?=$users_data->entry_emailE;?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                </div>
                <div class="form-group mb-1">
                    <label for="telephone">Teléfono</label>
                    <input class="form-control" id="telephone" name="telephone" value="<?=$users_data->entry_telephone;?>">
                </div>
                <div class="form-group mb-1">
                    <label for="nif">DNI</label>
                    <input class="form-control" id="nif" name="nif" value="<?=$users_data->entry_NIF;?>">
                </div>
                <div class="row pt-2 justify-content-center"">
                    <button type="button" class="btn btn-primary mr-5 w-25" onclick="volver_atras();">Atras</button>
                    <button type="submit" class="btn btn-primary w-25">Guardar</button>
                </div>
                </form>
            </div>
        </div>
        <div style="display: none"><?=$msg;?></div>
    </div>
    <script>
        var volver_atras = function(){
           //history.back();
           location.href='<?=PROOT?>perfil/';
        }
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
            
        })
        var bak = "<?=$back?>";
        if(bak == "1"){
            //volver_atras();
        }
        
        $('#password_new_check').on("keyup",function(event){
            console.log(event);
            let password_new = $('#password_new').val();
            let check_pass = $(this).val();
            console.log("text",check_pass);
            if(check_pass === password_new){
                console.log("check",check_pass);
                $('#password_new_check').css("border-color","#ced4da");
            } else {
                console.log("no_coincide",check_pass);
                $('#password_new_check').css("border-color","red");
            }

        })
        var check_password = function(evt){
            let check_pass = $('#password_new_check').val();
            let password_new = $('#password_new').val();
            if(check_pass == "" && password_new != ""){
                alert("Tienes que rellenar el campo de 'Repita contaseña'");
                return false;
            }
            return true;
        }

    </script>


    <?php $this->end(); ?>