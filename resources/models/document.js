var Document = Backbone.Model.extend({
  initialize : function() {
    this.id = null;
    this.name = null;
    this.description = null;
    this.url = null;
  }
});

export default Document;