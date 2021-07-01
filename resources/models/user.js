import SpealismCollection from '../collections/speaker_collection';

var User = Backbone.Model.extend({
  initialize : function() {
    this.id = null;
    this.dni = null;
    this.code = null;
    this.tuition = null;
    this.names = null;
    this.last_names = null;
    this.email = null;
    this.phone = null;
    this.picture_url = null;
    this.address = null;
    this.district_id = null;
    this.specialisms = new SpealismCollection();
  }
});

export default User;