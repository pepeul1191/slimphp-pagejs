var UserView = Backbone.View.extend({
	el: '#workspace',
	initialize: function(){
		//this.render();
		//console.log("initialize");
		this.message = "#mensaje";
		this.events = this.events || {};
		this.model = new User();
		this.modalButton = $("#btnModal");
		this.modalContainer = $("#modal-container");
		this.tableUserLog = new TableView(dataTableUserLog);
	},
	events: {
    "click #btnBuscarUsuario": "buscarUsuario",
		"click #btnGenerarUsuario": "generarCorrelativo",
		"click #btnCrearUsuario": "crearUsuario",
		"click #btnActualizarCorreo": "actualizarCorreo",
		"click #btnCambiarContrasenia": "cambiarContrasenia",
		"click #btnReenviarActivacion": "reenviarActivacion",
		"click #btnActualizarEstado": "actualizarEstado",
		"click #btnAsociarSistemasUsuarioNuevo": "asociarSistemasUsuarioNuevo",
		"click #btnVerLogs": "verLogs",
		"click #btnVerSistemas": "verSistemas",
		"click #btnVerRolesPermisos": "verRolesPermisos",
  },
  buscarUsuario: function(event){
    var url = BASE_URL + "access/user/search?user=" + $("#txtUsuario").val();
    var _this = this;
    $.ajax({
      type: "GET",
      url: url,
      data: { },
      headers: {
        [CSRF_KEY]: CSRF,
      },
      async: false,
      success: function(data){
				if(data == "not_found"){
					$(_this.message).removeClass("color-success");
					$(_this.message).removeClass("color-warning");
					$(_this.message).addClass("color-error");
					$(_this.message).html("Usuario no encontrado");
					_this.bloquearFormulario();
				}else{
        	$(_this.message).addClass("color-success");
					$(_this.message).removeClass("color-warning");
					$(_this.message).removeClass("color-error");
					_this.llenarFormulario(JSON.parse(data));
				}
      },
      error: function(xhr, status, error){
        console.error(error);
				var m = JSON.parse(xhr.responseText);
				console.log(m);
        $(_this.message).removeClass("color-success");
				$(_this.message).removeClass("color-warning");
				$(_this.message).addClass("color-error");
				$(_this.message).html("Ocurrió un error en realizar la búsqueda. " + m.mensaje[1]);
				$("#cbmEstado").prop("disabled", true);
				$("#txtCorreo").prop("disabled", true);
				$("#btnActualizarCorreo").prop("disabled", true);
				$("#btnCambiarContrasenia").prop("disabled", true);
				$("#btnReenviarActivacion").prop("disabled", true);
				$("#btnActualizarEstado").prop("disabled", true);
				$("#btnVerLogs").prop("disabled", true);
				$("#btnVerSistemas").prop("disabled", true);
				$("#btnVerRolesPermisos").prop("disabled", true);
      }
    });
	},
	llenarFormulario: function(data){
		// disabled = false
		$("#cbmEstado").prop("disabled", false);
		$("#txtCorreo").prop("disabled", false);
		$("#btnActualizarCorreo").prop("disabled", false);
		$("#btnCambiarContrasenia").prop("disabled", false);
		$("#btnReenviarActivacion").prop("disabled", false);
		$("#btnActualizarEstado").prop("disabled", false);
		$("#btnVerLogs").prop("disabled", false);
		$("#btnVerSistemas").prop("disabled", false);
		$("#btnVerRolesPermisos").prop("disabled", false);
		// llenar form
		$("#txtCorreo").val(data.email);
		$("#cbmEstado").val(data.user_state_id);
		// llenar models
		this.model.set("user_id", data.id);
		this.model.set("email", data.email);
		this.model.set("user_state_id", data.user_state_id);
	},
	bloquearFormulario: function(){
		// disabled = true
		$("#cbmEstado").prop("disabled", true);
		$("#txtCorreo").prop("disabled", true);
		$("#btnActualizarCorreo").prop("disabled", true);
		$("#btnCambiarContrasenia").prop("disabled", true);
		$("#btnReenviarActivacion").prop("disabled", true);
		$("#btnActualizarEstado").prop("disabled", true);
		$("#btnVerLogs").prop("disabled", true);
		$("#btnVerSistemas").prop("disabled", true);
		$("#btnVerRolesPermisos").prop("disabled", true);
		// llenar form
		$("#txtCorreo").val("");
		$("#cbmEstado").val("E");
		// limpiar modelo
		this.model.clear().set(this.model.defaults);
	},
	actualizarCorreo: function(event){
		// update model
		this.model.set("email", $("#txtCorreo").val());
		// ajax
		var url = BASE_URL + "access/user/update_email";
		var _this = this;
		$.ajax({
			type: "POST",
			url: url,
			data: {
				user_id: _this.model.get("user_id"),
				email: _this.model.get("email"),
			},
			headers: {
				[CSRF_KEY]: CSRF,
			},
			async: false,
			success: function(data){
				$(_this.message).html("Correo actualizado");
				$(_this.message).addClass("color-success");
				$(_this.message).removeClass("color-warning");
				$(_this.message).removeClass("color-error");
			},
			error: function(xhr, status, error){
				console.error(xhr.responseText);
				var m = JSON.parse(xhr.responseText);
				$(_this.message).html(m.mensaje[0] + ". " + m.mensaje[1	]);
				$(_this.message).removeClass("color-success");
				$(_this.message).removeClass("color-warning");
				$(_this.message).addClass("color-error");
			}
		});
	},
	actualizarEstado: function(event){
		// update model
		this.model.set("user_state_id", $("#cbmEstado").val());
		// ajax
		var url = BASE_URL + "access/user/update_state";
		var _this = this;
		$.ajax({
			type: "POST",
			url: url,
			data: {
				user_id: _this.model.get("user_id"),
				user_state_id: _this.model.get("user_state_id"),
			},
			headers: {
				[CSRF_KEY]: CSRF,
			},
			async: false,
			success: function(data){
				$(_this.message).html("Estado actualizado");
				$(_this.message).addClass("color-success");
				$(_this.message).removeClass("color-warning");
				$(_this.message).removeClass("color-error");
			},
			error: function(xhr, status, error){
				console.error(xhr.responseText);
				var m = JSON.parse(xhr.responseText);
				$(_this.message).html(m.mensaje[0]);
				$(_this.message).removeClass("color-success");
				$(_this.message).removeClass("color-warning");
				$(_this.message).addClass("color-error");
			}
		});
	},
	cambiarContrasenia: function(event){
		// ajax
		var url = BASE_URL + "access/user/update_pass";
		var _this = this;
		$.ajax({
			type: "POST",
			url: url,
			data: {
				email: _this.model.get("email"),
			},
			headers: {
				[CSRF_KEY]: CSRF,
			},
			async: false,
			success: function(data){
				var m = JSON.parse(data);
				$(_this.message).html(m['mensaje'][0]);
				$(_this.message).addClass("color-success");
				$(_this.message).removeClass("color-warning");
				$(_this.message).removeClass("color-error");
			},
			error: function(xhr, status, error){
				console.error(xhr.responseText);
				var m = JSON.parse(xhr.responseText);
				$(_this.message).html(m.mensaje[0]);
				$(_this.message).removeClass("color-success");
				$(_this.message).removeClass("color-warning");
				$(_this.message).addClass("color-error");
			}
		});
	},
	reenviarActivacion: function(event){
		// ajax
		var url = BASE_URL + "access/user/resend_activation";
		var _this = this;
		$.ajax({
			type: "POST",
			url: url,
			data: {
				email: _this.model.get("email"),
				user_id: _this.model.get("user_id"),
			},
			headers: {
				[CSRF_KEY]: CSRF,
			},
			async: false,
			success: function(data){
				var m = JSON.parse(data);
				$(_this.message).html(m.mensaje[0]);
				$(_this.message).addClass("color-success");
				$(_this.message).removeClass("color-warning");
				$(_this.message).removeClass("color-error");
			},
			error: function(xhr, status, error){
				console.error(xhr.responseText);
				var m = JSON.parse(xhr.responseText);
				$(_this.message).html(m.mensaje[0]);
				$(_this.message).removeClass("color-success");
				$(_this.message).removeClass("color-warning");
				$(_this.message).addClass("color-error");
			}
		});
	},
	crearUsuario: function(event){
		var url = BASE_URL + "access/user/create";
		var _this = this;
		$.ajax({
			type: "POST",
			url: url,
			data: {
			  user: $("#txtUsuarioNuevo").val(),
				email: $("#txtCorreoNuevo").val(),
 			},
			headers: {
				[CSRF_KEY]: CSRF,
			},
			async: false,
			success: function(data){
				data = JSON.parse(data);
				$(_this.message).html("Usuario creado");
				$(_this.message).addClass("color-success");
				$(_this.message).removeClass("color-warning");
				$(_this.message).removeClass("color-error");
				_this.model.set("user_id", data.mensaje[1]);
				console.log(_this.model);
			},
			error: function(xhr, status, error){
				console.error(xhr.responseText);
				var m = JSON.parse(xhr.responseText);
				if(m.mensaje[1] == "repeated"){
					$(_this.message).html("Usuario y/o correo ya se encuentran en uso");
				}else{
					$(_this.message).html(m.mensaje[0] + ". " + m.mensaje[1]);
				}
				$(_this.message).removeClass("color-success");
				$(_this.message).removeClass("color-warning");
				$(_this.message).addClass("color-error");
			}
		});
	},
	generarCorrelativo: function(event){
		var url = BASE_URL + "managment/correlation/create";
		var _this = this;
		$.ajax({
			type: "GET",
			url: url,
			data: { },
			headers: {
				[CSRF_KEY]: CSRF,
			},
			async: false,
			success: function(data){
				$("#txtUsuarioNuevo").val(data);
			},
			error: function(error){
				console.log(error);
				$(_this.message).removeClass("color-success");
				$(_this.message).removeClass("color-warning");
				$(_this.message).addClass("color-error");
				$(_this.message).html("Ocurrió un error en realizar la búsqueda");
			}
		});
	},
	systems: function(){
		var rpta = [];
		var url = BASE_URL + "access/system/list";
		var _this = this;
		$.ajax({
			type: "GET",
			url: url,
			data: { },
			headers: {
				[CSRF_KEY]: CSRF,
			},
			async: false,
			success: function(data){
				rpta = JSON.parse(data);
			},
			error: function(error){
				console.log(error);
				$(_this.message).removeClass("color-success");
				$(_this.message).removeClass("color-warning");
				$(_this.message).addClass("color-error");
				$(_this.message).html("Ocurrió un error en obtener los sistemas");
			}
		});
		return rpta;
	},
	asociarSistemasUsuarioNuevo: function(){
		if( this.model.get("user_id") != null){
			var systems = [];
			$.each($("input[name='systemCheckbox']"), function(){
	      //systems.push($(this).val());
				var temp = $(this).is(":checked");
				var _existe = null;
				if (temp == true){
					_existe = 1;
				}else{
					_existe = 0;
				}
				systems.push({
					id:$(this).attr("system_id"),
	 				existe: _existe,
				});
	    });
			var data = {
				editados: systems,
				extra: {
					user_id: this.model.get("user_id"),
				},
			};
			var url = BASE_URL + "access/user/system_save";
			var _this = this;
			$.ajax({
				type: "POST",
				url: url,
				data: "data="+JSON.stringify(data),
				headers: {
					[CSRF_KEY]: CSRF,
				},
				async: false,
				success: function(data){
					data = JSON.parse(data);
					$(_this.message).html("Sistema(s) asociados al usuario");
					$(_this.message).addClass("color-success");
					$(_this.message).removeClass("color-warning");
					$(_this.message).removeClass("color-error");
				},
				error: function(xhr, status, error){
					console.error(xhr.responseText);
					var m = JSON.parse(xhr.responseText);
					$(_this.message).html(m.mensaje[0] + ". " + m.mensaje[1]);
					$(_this.message).removeClass("color-success");
					$(_this.message).removeClass("color-warning");
					$(_this.message).addClass("color-error");
				}
			});
		}else{
			this.message.removeClass("color-success");
			this.message.removeClass("color-warning");
			this.message.addClass("color-error");
			this.message.html("Debe crear primero al usuario");
		}
	},
	verLogs: function(event){
		var template = _.template(`
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="exampleModalLabel">Logs del Usuario</h4>
						<button type="button" class="close" data-dimdiss="modal" aria-label="Close" id="closeModal">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="formTableUserLog">
						<label class="texto-der" id="mensajeRptaUserLog"></label>
						<table class="table table-striped" style="" id="tableUserLog">
							<thead>
								<tr>
									<th style="width: 10px; display:none;">id</th>
									<th style="width: 200px;">Momento</th>
								</tr>
							</thead>
							<tfoot>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		`);
		this.tableUserLog.urlListar = BASE_URL + "access/user_log/list/" + this.model.get("user_id");
		this.modalContainer.html(template({}));
		this.modalButton.click();
		this.tableUserLog.limpiarBody();
    this.tableUserLog.listar();
	},
	verSistemas: function(event){
		window.location.href = BASE_URL + "access/user/#/system/" + this.model.get("user_id");
	},
	verRolesPermisos: function(event){
		window.location.href = BASE_URL + "access/user/#/roles_permissions/" + this.model.get("user_id");
	},
  showIndex: function(event){
		var template = _.template(`
			<div class="row">
				<div class="col-md-12">
					<h6>Buscar Usuarios</h6>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<label class="texto-der" id="mensaje"></label>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
			    <div class="form-group">
			      <label for="txtUsuario">Usuario</label>
			      <input type="text" class="form-control" id="txtUsuario" placeholder="Ingrese usuario a gestionar" value="">
						<br>
						<button id="btnBuscarUsuario" class="btn btn-default pull-right"><i class="fa fa-search" aria-hidden="true"></i>Buscar Usuario</button>
			    </div>
			  </div>
				<div class="col-md-3">
			    <div class="form-group">
			      <label for="cbmEstado">Estado de Usuario</label>
			      <select class="form-control" id="cbmEstado" disabled>
			        <option value="E"></option>
							<% for (var i = 0; i < states.length; i++){ %>
							<option value="<%= states[i]['id'] %>"><%= states[i]['name'] %></option>
							<% } %>
			      </select>
						<br>
						<button id="btnActualizarEstado" class="btn btn-default pull-right" disabled><i class="fa fa-check" aria-hidden="true"></i>Actualizar Estado</button>
			    </div>
			  </div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="txtCorreo">Correo del Usuario</label>
						<input type="text" class="form-control" id="txtCorreo" disabled placeholder="" value="">
						<br>
						<button id="btnActualizarCorreo" class="btn btn-default pull-right" disabled><i class="fa fa-check" aria-hidden="true"></i>Actualizar Correo</button>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="txtCorreo">Otras Accciones</label>
						<br>
						<button id="btnCambiarContrasenia" disabled class="btn btn-default pull-left"><i class="fa fa-repeat" aria-hidden="true"></i>Cambiar Contraseña</button>
						<br>
						<br>
						<button id="btnReenviarActivacion" disabled class="btn btn-default pull-left"><i class="fa fa-envelope" aria-hidden="true"></i>Reenviar Activación</button>
						<br>
						<br>
						<button id="btnVerLogs" disabled class="btn btn-default pull-left"><i class="fa fa-search" aria-hidden="true"></i>Ver Logs de Ingreso</button>
						<br>
						<br>
						<button id="btnVerSistemas" disabled class="btn btn-default pull-left"><i class="fa fa-laptop" aria-hidden="true"></i>Ver Sistemas Asociados</button>
						<br>
						<br>
						<button id="btnVerRolesPermisos" disabled class="btn btn-default pull-left"><i class="fa fa-list" aria-hidden="true"></i>Roles y Permisos</button>
					</div>
				</div>
			</div>
		`);
		var states = [];
		var _this = this;
		$.ajax({
			type: "GET",
			url: BASE_URL + 'access/user_state/list',
			data: { },
			headers: {
				[CSRF_KEY]: CSRF,
			},
			async: false,
			success: function(data){
				states = JSON.parse(data);
			},
			error: function(xhr, status, error){
				console.error(error);
				var m = JSON.parse(xhr.responseText);
				console.log(m);
				$(_this.message).removeClass("color-success");
				$(_this.message).removeClass("color-warning");
				$(_this.message).addClass("color-error");
				$(_this.message).html("Ocurrió un error en obtener los estados de usuario. " + m.mensaje[1]);
			}
		});
		for (var i = 0; i < states.length; i++){
			states[i]['name'] = states[i][LANG];
		}
		$(this.el).html(template({states: states}));
  },
  showAdd: function(event){
		var template = _.template(`
			<div class="row">
				<div class="col-md-12">
					<h6>Agregar Usuario</h6>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<label class="texto-der" id="mensaje"></label>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
			    <div class="form-group">
			      <label for="txtUsuarioNuevo">Usuario</label>
			      <input type="text" class="form-control" id="txtUsuarioNuevo" placeholder="" value="">
						<br>
						<button id="btnGenerarUsuario" class="btn btn-default pull-right"><i class="fa fa-search" aria-hidden="true"></i>Generar Nombre</button>
			    </div>
			  </div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="txtCorreoNuevo">Correo del Usuario</label>
						<input type="text" class="form-control" id="txtCorreoNuevo" placeholder="" value="">
						<br>
						<button id="btnCrearUsuario" class="btn btn-default pull-right"><i class="fa fa-check" aria-hidden="true"></i>Crear Usuario</button>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="txtCorreoNuevo">Sistemas</label>
						<% for (var i = 0; i < systems.length; i++){ %>
						<div class="form-check">
					    <input type="checkbox" class="form-check-input" name="systemCheckbox" id="system_<%= systems[i]['id'] %>" system_id="<%= systems[i]['id'] %>">
					    <label class="form-check-label" for="system_<%= systems[i]['id'] %>">
								<%= systems[i]['name'] %>
							</label>
					  </div>
						<% } %>
						<br>
						<button id="btnAsociarSistemasUsuarioNuevo" class="btn btn-default"><i class="fa fa-check" aria-hidden="true"></i>Asociar Sistemas</button>
					</div>
				</div>
			</div>
		`);
		$(this.el).html(template({systems: this.systems()}));
  },
});
