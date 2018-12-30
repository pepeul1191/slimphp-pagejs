var UserSystemView = Backbone.View.extend({
	el: 'body',
	initialize: function(){
		//this.render();
		//console.log("initialize");
		this.events = this.events || {};
		this.model = new User();
    this.modalButton = $("#btnModal");
    this.user_id = null;
		this.modalContainer = $("#modal-container");
    this.delegateEvents();
		this.tableUserSystem = new TableView(dataTablaUserSystem);
	},
	events: {
		// tabla usuer system
		"change #tablaUserSystem > tbody > tr > td > .input-check": "clickCheckBoxSistemaUsuario",
    "click #tablaUserSystem > tfoot > tr > td > button.guardar-tabla": "guardarTablaSistemaUsuario",
    "keydown": "keyAction",
    "click .close": "modalClose",
  },
	render: function(event){
		var template = _.template(`
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="exampleModalLabel">Sistemas del Usuario</h4>
						<button type="button" class="close" data-dimdiss="modal" aria-label="Close" id="closeModal">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12" id="formTableUserSystem">
								<h6 class="subtitulo" style="margin-bottom:15px">Sistema Asociados al Usuario</h6>
								<label class="texto-der" id="mensajeRptaUserSystem"></label>
								<table class="table table-striped" style="" id="tablaUserSystem">
									<thead>
										<tr>
											<th style="width: 10px; display:none;">id</th>
											<th style="width: 200px;">Nombre</th>
											<th style="width: 60px;">Existe</th>
											<th style="display:none;">Botones</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<td colspan="1000" style="text-align:right">
												<button class="btn btn-default guardar-tabla"> <i class="fa fa-check" style="margin-right:5px"></i>Guardar Cambios</button>
											</td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		`);
    this.modalContainer.html(template({}));
	},
	clickCheckBoxSistemaUsuario: function(event){
    this.tableUserSystem.clickCheckBox(event);
  },
  guardarTablaSistemaUsuario: function(event){
    this.tableUserSystem.extraData = {
      user_id: this.user_id,
    };
    this.tableUserSystem.guardarTabla(event);
  },
  keyAction: function(event){
    var code = event.keyCode || event.which;
    if(code == 27){
      window.location.href = BASE_URL + "access/user/#/";
    }
  },
  modalClose: function(event){
    this.modalContainer.modal('hide');
    window.location.href = BASE_URL + "access/user/#/";
  },
});
