import EventService from '../services/event_service';
import Event from '../models/event';
import EventCollection from '../collections/event_collection';
import Speaker from '../models/speaker';

var ModalEventView = Backbone.View.extend({
  el: '#modal',
	initialize: function(event_id, events){
    this.events_ = events;
    this.event_id = event_id;
	},
	events: {
    'click button.btn-recent-event': 'viewRecent',
  },
  loadComponents: function(){
  },
  render: function(){
    var data = {
      STATIC_URL: STATIC_URL,
      events: this.events_,
      event_id: this.event_id,
      REMOTE_URL: REMOTE_URL,
      WEB_URL: WEB_URL,
    };
    var templateCompiled = null;
		$.ajax({
		  url: STATIC_URL + 'templates/modal_event.html',
		  type: 'GET',
		  async: false,
		  success: function(resource) {
        var template = _.template(resource);
         // console.log(data)
        templateCompiled = template(data);
      },
      error: function(xhr, status, error){
        console.error(error);
				console.log(JSON.parse(xhr.responseText));
      }
    });
    //console.log(templateCompiled)
    this.$el.html(templateCompiled);
    this.$el.modal('toggle');
  },
  viewRecent: function(event){
    var event_id = event.currentTarget.getAttribute('event-id');
    this.render('modal_event', event_id);
  },
});

export default ModalEventView;
