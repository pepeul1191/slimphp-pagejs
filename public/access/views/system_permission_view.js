var SystemPermissionView = ModalView.extend({
  initialize: function(options){
    this.targetMensaje = options["targetMensaje"];
    // herencia de atributos, móetodos y eventos
    ModalView.prototype.initialize.apply(this, [options])
    this.inheritEvents(ModalView);
    // delegación de eventos
    this.delegateEvents();
    this.tablePermission = new TableView(dataTablePermission);
  },
  events: {
    // se está usando asignacion dinamica de eventos en el constructor
    // table permisos
    "click #tablePermission > tfoot > tr > td > button.agregar-fila": "agregarFilaPermission",
    "click #tablePermission > tfoot > tr > td > button.guardar-table": "guardarTablaPermission",
    "keyup #tablePermission > tbody > tr > td > input.text": "inputTextEscribirPermission",
    "click #tablePermission > tbody > tr > td > i.quitar-fila": "quitarFilaPermission",
    // modal
    "keydown": "keyAction",
    "click .close": "modalClose",
  },
  //eventos table de permisos
  inputTextEscribirPermission: function(event){
    this.tablePermission.inputTextEscribir(event);
  },
  quitarFilaPermission: function(event){
    this.tablePermission.quitarFila(event);
  },
  guardarTablaPermission: function(event){
    this.tablePermission.extraData = {system_id: this.systemId};
    this.tablePermission.guardarTabla(event);
  },
  agregarFilaPermission: function(event){
    this.tablePermission.agregarFila(event);
  },
  // modal
  keyAction: function(event){
    var code = event.keyCode || event.which;
    if(code == 27){
      this.modalContainer.modal('hide');
      window.location.href = BASE_URL + "access/#/system";
    }
  },
  modalClose: function(event){
    this.modalContainer.modal('hide');
    window.location.href = BASE_URL + "access/#/system";
  },
});
