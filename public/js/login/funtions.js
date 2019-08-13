var click_inireg = function(elem){
    console.log(elem);
    console.log(elem.innerText);
    if(elem.innerText == "Login"){
        document.getElementById("login").style= "block";
        document.getElementById("register").style = "none"
        
    } else {
        document.getElementById("login").style= "none";
        document.getElementById("register").style = "block"
    }
   
}
var add_credit_card = function(){
    /*action="//yuubbb.com/api-bullcard/api_web/perfil/" method="post"*/
    content = `
		<div class="white-popup content_popup">
		<h2 style="">Añadir Tarjeta</h2>
            <div id="content_sequim_email">
            <form>
                <div class="form-group">
                    <label for="numTarjeta">Tarjeta</label>
                    <input type="text" class="form-control" name="numTarjeta" id="numTarjeta">
                </div>
                <div class="btn_content pt-2">
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
}