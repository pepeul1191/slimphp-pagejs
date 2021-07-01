import EventService from '../services/event_service';
import Event from '../models/event';
import EventCollection from '../collections/event_collection';
import Speaker from '../models/speaker';
import ModalEventView from './modal_event_view';

var EventView = Backbone.View.extend({
  el: '#workspace',
	initialize: function(){
    this.events_ = new EventCollection();
    this.modalEventView = null;
	},
	events: {
    'click button.btn-recent-event': 'viewRecent',
  },
  loadComponents: function(){
    // clear collection
    this.events_.reset();
    // get data
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
        this.events_.add(n);
      });
    }
  },
  loadComponentsRecent:function(){
    // clear collection
    this.events_.reset();
    // get data
    var resp = EventService.recentList();
    if(resp.status == 200){
      var events = resp.message;
      events.forEach(event => {
        var e = new Event({
          id: event.id,
          name: event.name,
          description: event.description,
          url: event.picture_url,
          init_date: event.init_date,
          event_type_name: event.event_type_name,
          hours: event.hours,
        });
        event.speakers.forEach(speaker => {
          var s = new Speaker({
            names: speaker.names,
            last_names: speaker.last_names,
            url: speaker.picture_url,
          });
          e.speakers.add(s);
        });
        this.events_.add(e);
      });
    }
  },
  render: function(template){
    var data = {
      STATIC_URL: STATIC_URL,
      events: this.events_,
      REMOTE_URL: REMOTE_URL,
      WEB_URL: WEB_URL,
    };
    var templateCompiled = null;
		$.ajax({
		  url: STATIC_URL + 'templates/' + template + '.html',
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
  },
  viewRecent: function(event){
    var event_id = event.currentTarget.getAttribute('event-id');
    var _this = this;
    this.modalEventView = new ModalEventView(event_id, _this.events_);
    this.modalEventView.render();
  },
});

export default EventView;
