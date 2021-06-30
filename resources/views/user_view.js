import UserService from '../services/user_service';
import User from '../models/user';

var EventView = Backbone.View.extend({
  el: '#workspace',
	initialize: function(){
	},
	events: {
  },
  loadComponents: function(){

  },
  render: function(){
    var data = {
      STATIC_URL: STATIC_URL,
    };
    var templateCompiled = null;
		$.ajax({
		  url: STATIC_URL + 'templates/user.html',
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
