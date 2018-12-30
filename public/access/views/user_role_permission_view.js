var UserRolePermissionView = Backbone.View.extend({
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
		this.tableUserRole = new TableView(dataTablaUserRole);
    this.tablaUserPermission = new TableView(dataTablaUserPermission);
	},
	events: {
    "change #cbmSystem": "seleccionarSistema",
    // tabla roles de usuario
    "change #tablaUserRole > tbody > tr > td > .input-check": "clickCheckBoxRolUsuario",
    "click #tablaUserRole > tfoot > tr > td > button.guardar-tabla": "guardarTablaRolUsuario",
    // tabla permisos de usuario
    "change #tablaUserPermission > tbody > tr > td > .input-check": "clickCheckBoxPermisoUsuario",
    "click #tablaUserPermission > tfoot > tr > td > button.guardar-tabla": "guardarTablaPermisoUsuario",
		// modal
    "keydown": "keyAction",
    "click .close": "modalClose",
  },
	render: function(event){
		var template = _.template(`
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="exampleModalLabel">Roles y Permisos del Usuario</h4>
						<button type="button" class="close" data-dimdiss="modal" aria-label="Close" id="closeModal">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-4" id="formTableUserSystem">
								<label class="texto-der" id="mensajeRptaUserSystem"></label>
                <div class="form-group">
                  <label for="cbmEstado">Sistemas Asignados al Usuario</label>
                  <select class="form-control" id="cbmSystem">
                    <option value="E"></option>
                    <% for (var i = 0; i < systems.length; i++){ %>
                      <% if (systems[i]['existe'] == 1) { %>
                        <option value="<%= systems[i]['id'] %>"><%= systems[i]['name'] %></option>
                      <% } %>
                    <% } %>
                  </select>
                </div>
							</div>
						</div>
            <div class="row row-tables">
              <div class="col-md-6"id="formTableUserRole">
                <h6 class="subtitulo" style="margin-bottom:15px">Roles del Sistema Asociados al Usuario</h6>
                <label class="texto-der" id="mensajeRptaUserRole"></label>
                <table class="table table-striped" style="" id="tablaUserRole">
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
              <div class="col-md-6"id="formTableUserPermission">
                <h6 class="subtitulo" style="margin-bottom:15px">Permisos del Sistema Asociados al Usuario</h6>
                <label class="texto-der" id="mensajeRptaUserPermission"></label>
                <table class="table table-striped" style="" id="tablaUserPermission">
                  <thead>
                    <tr>
                      <th style="width: 10px; display:none;">id</th>
                      <th style="width: 150px;">Llave</th>
                      <th style="width: 150px;">Descripción</th>
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
    var systems = [];
    var _this = this;
    $.ajax({
      type: "GET",
      url: BASE_URL + 'access/user_system/list/' + _this.user_id,
      data: { },
      headers: {
        [CSRF_KEY]: CSRF,
      },
      async: false,
      success: function(data){
				systems = JSON.parse(data);
      },
      error: function(xhr, status, error){
        console.error(error);
				var m = JSON.parse(xhr.responseText);
				console.log(m);
        $(_this.message).removeClass("color-success");
				$(_this.message).removeClass("color-warning");
				$(_this.message).addClass("color-error");
				$(_this.message).html("Ocurrió un error en obtener los sistemas. " + m.mensaje[1]);
      }
    });
    this.modalContainer.html(template({systems: systems}));
	},
  // combo
  seleccionarSistema: function(event){
    var system_id = event.target.value;
    var user_id = this.user_id;
    //borrar body de tablas
    if(system_id != "E"){
      $("#row-tables").removeClass("oculto");
      //llenar tabla de roles
      this.tableUserRole.limpiarBody();
      this.tableUserRole.urlListar = BASE_URL + "access/user_role/list/" + user_id + "/" + system_id;
      this.tableUserRole.listar();
      this.tableUserRole.userId = user_id;
      this.tableUserRole.systemId = system_id;
      //llenar tabla de permisos
      this.tablaUserPermission.limpiarBody();
      this.tablaUserPermission.urlListar = BASE_URL + "access/user_permission/list/" + user_id + "/" + system_id;
      this.tablaUserPermission.listar();
      this.tablaUserPermission.userId = user_id;
      this.tablaUserPermission.systemId = system_id;
    }else{
      this.tableUserRole.limpiarBody();
      this.tablaUserPermission.limpiarBody();
    }
  },
  // modal
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
  // tabla role
  clickCheckBoxRolUsuario: function(event){
    this.tableUserRole.clickCheckBox(event);
  },
  guardarTablaRolUsuario: function(event){
    this.tableUserRole.extraData = {
      system_id: this.tableUserRole.systemId,
      user_id: this.tableUserRole.userId,
    };
    this.tableUserRole.guardarTabla(event);
  },
  // table permission
  clickCheckBoxPermisoUsuario: function(event){
    this.tablaUserPermission.clickCheckBox(event);
  },
  guardarTablaPermisoUsuario: function(event){
    this.tablaUserPermission.extraData = {
      system_id: this.tablaUserPermission.systemId,
      user_id: this.tablaUserPermission.userId,
    };
    this.tablaUserPermission.guardarTabla(event);
  },
});
