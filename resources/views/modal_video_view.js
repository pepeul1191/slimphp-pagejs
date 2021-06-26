import EventVideoService from '../services/event_video_service';
import Video from '../models/video';
import VideoCollection from '../collections/video_collection';

var ModalVideoView = Backbone.View.extend({
  el: '#modal',
  event_id: null,
	initialize: function(event_id){
    this.event_id = event_id;
    this.videos = new VideoCollection();
  },
	events: {
  },
  render: function(){
    var data = {
      STATIC_URL: STATIC_URL,
      videos: this.videos,
    };
		var templateCompiled = null;
		$.ajax({
		  url: STATIC_URL + 'templates/modal_video.html',
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
    this.videos.reset();
    // show data
    this.event_id = event_id;
    var resp = EventVideoService.list(event_id);
    if(resp.status == 200){
      var videos = resp.message;
      videos.forEach(video => {
        var n = new Video({
          id: video.id,
          name: video.name,
          description: video.description,
          url: video.url,
        });
        this.videos.add(n);
      });
    }
  },
});

export default ModalVideoView;