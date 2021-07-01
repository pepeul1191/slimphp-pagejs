import SpeakerCollection from '../collections/speaker_collection';

var Event = Backbone.Model.extend({
  initialize : function() {
    this.id = null;
    this.name = null;
    this.description = null;
    this.url = null;
    this.speakers = new SpeakerCollection();
  }
});

export default Event;