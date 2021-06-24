var ModalDocumentView = Backbone.View.extend({
  el: '#modal',
  event_id: null,
	initialize: function(event_id){
    this.event_id = event_id;
  },
	events: {
  },
  render: function(data, type){
		var templateCompiled = null;
		$.ajax({
		  url: STATIC_URL + 'templates/modal_document.html',
		  type: 'GET',
		  async: false,
		  success: function(resource) {
        var template = _.template(resource);
        templateCompiled = template(data);
      },
      error: function(xhr, status, error){
        console.error(error);
				console.log(JSON.parse(xhr.responseText));
      }
    });
    var _this = this;
    this.$el.html(templateCompiled);
    this.$el.modal('toggle');
  },
  loadComponents: function(){

  },
});

export default ModalDocumentView;