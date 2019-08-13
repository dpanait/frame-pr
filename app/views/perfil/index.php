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
    .tarjeta{
        display: grid;
        margin-bottom: 40px;
    }
    .tarjeta img{
        width: 100%;
    }
    .num_tarjeta{
        position: relative;
        margin-top: -61px;
        color: white;
        margin-left: 40px;
        font-size: 19px;
        font-weight: 700;
    }
    .content_btn{
        width: 120px;
        margin: 0 auto;
    }
    .quit_tarjeta{
        width: 22px;
        height: 22px;
        background-color: red;
        color: white;
        font-size: 19px;
        line-height: 19px;
        font-weight: 700;
        text-align: center;
        vertical-align: middle;
        border-radius: 12px;
        margin-bottom: 4px;
        margin-left: 95%;
    }
    .btn_content{
        text-align: center;
    }
    .content_popup{
        width: 400px;
        height: 210px;
        margin: 0 auto;
        background-color: #fff;
        padding: 10px;
        border-radius: 9px;
    }
</style>
      
<script>
    var add_tarjeta = function(){

        var num_tarjeta = document.getElementById("numTarjeta").value;
        //console.log(num_tarjeta);
        //console.log("users_id",<?=$_SESSION[CURRENT_USER_SESSION_NAME];?>);
        var users_id = <?=$_SESSION[CURRENT_USER_SESSION_NAME];?>;
        var url = '//yuubbb.com/api-bullcard/api_web/api/?action=add_tarjeta';
        var data = {users_id: users_id,num_tarjeta: num_tarjeta};
        request = $.ajax({
            url: url,
            type: "post",
            data: data,

    });
 

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        var res = JSON.parse(response);
        //console.log(res.status)
        if(res.status){
            location.reload();
            var content_popup = `<div class="bg-danger text-white"><div class='p-3'>${res.msg}</div></div>`;
        } else {
            $.magnificPopup.close();
            var content_popup = `<div class="bg-danger text-white"><div class='p-3'>${res.msg}</div></div>`;
        }

        content = `
		<div class="white-popup content_popup">
		<h2 style="">Mensaje</h2>
            <div id="content_sequim_email">
            ${content_popup}
                <div class="btn_content mt-4">
                    <div type="button" class="btn btn-secondary" onclick="$.magnificPopup.close();">Cancelar</div>
                    <button type="button" class="btn btn-primary" onclick="add_tarjeta();">Guardar</button>
                </div>
            </form>
			</div>
	    </div> `;

        $.magnificPopup.open({
            items: {
                src: content, // can be a HTML string, jQuery object, or CSS selector
                type: 'inline'
            },
            modal: false,
            closeOnContentClick: false,
            closeOnBgClick: false,
            showCloseBtn: true,
            enableEscapeKey: false,
            showCloseBtn: true,
            callbacks: {
                open: function(){
                    //setTimeout(load_panel_ofertas,500);
                    //add_new_category(cat_id);
                },
                close: function(){
                    //console.log('_magnificPopup_close_');

                }
            }
        });
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });

}
</script>
<div class="container mt-5">
    <div class="row justify-content-center row">
    <div class="col-md-6">   
        <div class="bg-danger text-white"></div>
        <h2 class="">Usuario</h2>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="name" name="name" placeholder="Nombre" aria-label="Nombre" aria-describedby="basic-addon2" value="<?=$name;?>" readonly>
                <div class="input-group-append">
                    <a class="btn btn-outline-secondary" href='<?=PROOT?>perfil/edit' type="button">Editar</a>
                </div>
            </div>
            <div id="tarjeta_cont" class="form-group">
                <?php if(isset($tarjetas) && count($tarjetas) > 0):?>
                    <?php foreach ($tarjetas as $tarjeta):?>
                    <div class="tarjeta">
                        <div class="quit_tarjeta" onclick="quit_tarjeta(this);">x</div>
                        <img src="<?=URLPUBLIC?>img/creditcard_generic.png">
                        <div class="num_tarjeta"><?= $tarjeta->number;?></div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?> 
                    <div class="tarjeta">
                    </div>
                <?php endif;?>
            </div>
            <div class="content_btn pt-2">
                <button type="submit" class="btn btn-primary" onclick="add_credit_card();">Añadir Tarjeta</button>
            </div>
    </div> 
    </div> 
</div>
<script>
    "<?php echo isset($refresh);?>";
    <?php echo ($refresh != false);?>;
    <?php if($refresh):?>
        var refresh = <?=$refresh?>;
    <?php else:?>
        var refresh = false;
    <?php endif;?>   

    var quit_tarjeta = function(elem){

        console.log("elem",elem);
        let tarjeta = elem.parentElement;
        console.log("tarjeta",tarjeta);
        var num_tarjeta = tarjeta.getElementsByClassName("num_tarjeta")[0].innerText;
        console.log(num_tarjeta);
        console.log("users_id",<?=$_SESSION[CURRENT_USER_SESSION_NAME];?>);
        var users_id = <?=$_SESSION[CURRENT_USER_SESSION_NAME];?>;
        var url = '//yuubbb.com/api-bullcard/api_web/api/?action=remove_tarjeta';
        var data = {users_id: users_id,num_tarjeta: num_tarjeta};
        let fetchData = {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json'//x-www-form-urlencoded
                },
        };
        fetch(url,fetchData)
        .then(res => {
            return res.json()
        })
        .catch(error => {
            console.error('Error:', error)
        })
        .then(res =>{
            console.log('Success:', res)

            if(res.status){
                console.log("Recargar");
                //tarjeta.remove();
                location.reload();
            } else {
                console.log("No recargar");
            }
        });

    }
</script>

<?php $this->end(); ?>