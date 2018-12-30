var SystemView = Backbone.View.extend({
	el: '#workspace',
	initialize: function(){
		//this.render();
		//console.log("initialize");
		this.events = this.events || {};
    this.tableSystem =  new TableView(dataTableSystem);
	},
	events: {
		// se está usando asignacion dinamica de eventos en el constructor
    //eventos table de departamentos
    "click #tableSystem > tfoot > tr > td > button.agregar-fila": "agregarFilaSystem",
		"click #tableSystem > tfoot > tr > td > button.guardar-table": "guardarTablaSystem",
		"keyup #tableSystem > tbody > tr > td > input.text": "inputTextEscribirSystem",
		"click #tableSystem > tbody > tr > td > i.quitar-fila": "quitarFilaSystem",
	},
	render: function() {
		this.$el.html(this.getTemplate());
	},
	getTemplate: function() {
		var data = { };
		var template_compiled = null;
		$.ajax({
		   url: STATICS_URL + 'access/templates/system.html',
		   type: "GET",
		   async: false,
		   success: function(source) {
		   	var template = Handlebars.compile(source);
		   	template_compiled = template(data);
		   }
		});
		return template_compiled;
	},
	mostrarTabla: function(){
		this.tableSystem.listar();
	},
  //evnetos table de departamentos
  inputTextEscribirSystem: function(event){
    this.tableSystem.inputTextEscribir(event);
  },
  quitarFilaSystem: function(event){
    this.tableSystem.quitarFila(event);
  },
  guardarTablaSystem: function(event){
    this.tableSystem.guardarTabla(event);
  },
  agregarFilaSystem: function(event){
    this.tableSystem.agregarFila(event);
  },
});
