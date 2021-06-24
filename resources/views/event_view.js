import EventService from '../services/event_service';
import Event from '../models/event';
import EventCollection from '../collections/event_collection';

var EventView = Backbone.View.extend({
  el: '#workspace',
	initialize: function(){
    this.events = new EventCollection();
	},
	events: {
    // form
    'click #btnSave': 'save',
    'click #btnViewPicture': 'viewPicture',
    // documents and videos
    'click #btnDocuments': 'showDocuments',
    'click #btnVideos': 'showVideos',
    'click #btnManStudent': 'manStudent',
    'click #btnManSpeaker': 'manSpeaker',
  },
  loadComponents: function(){
    var resp = EventService.list();
    if(resp.status == 200){
      var events = resp.message;
      events.forEach(event => {
        var n = new Event({
          id: event.id,
          name: event.name,
          description: event.description,
          url: event.picture_url,
        });
        this.events.add(n);
      });
    }
  },
  render: function(){
    var data = {
      STATIC_URL: STATIC_URL,
      events: this.events,
    };
    var templateCompiled = null;
		$.ajax({
		  url: STATIC_URL + 'templates/event.html',
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
    this.$el.html(templateCompiled);
  },
});

export default EventView;
