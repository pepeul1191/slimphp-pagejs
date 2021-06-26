import EventDocumentService from '../services/event_document_service';
import Document from '../models/document';
import DocumentCollection from '../collections/document_collection';

var ModalDocumentView = Backbone.View.extend({
  el: '#modal',
  event_id: null,
	initialize: function(event_id){
    this.event_id = event_id;
    this.documents = new DocumentCollection();
  },
	events: {
  },
  render: function(){
    var data = {
      STATIC_URL: STATIC_URL,
      documents: this.documents,
    };
    console.log(data)
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
  loadComponents: function(event_id){
    // clear collection
    this.documents.reset();
    // show data
    this.event_id = event_id;
    var resp = EventDocumentService.list(event_id);
    if(resp.status == 200){
      var documents = resp.message;
      documents.forEach(document => {
        var n = new Document({
          id: document.id,
          name: document.name,
          description: document.description,
          url: document.picture_url,
        });
        this.documents.add(n);
      });
    }
  },
});

export default ModalDocumentView;