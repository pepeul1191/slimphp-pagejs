var userRouter = Backbone.Router.extend({
  userView: null,
  initialize: function() {
    this.userView = null;
    this.userSystemView = null;
    this.userRolePermissionView = null;
  },
  routes: {
    "": "index",
    "add": "add",
    "system/:user_id": "system",
    "roles_permissions/:user_id": "rolesPermissions",
    "*actions" : "default",
  },
  index: function(){
    if(this.userView == null){
      this.userView = new UserView();
    }
    if(this.userView.model.get("user_id") == "E"){
      this.userView.showIndex();
    }
  },
  default: function() {
    //window.location.href = BASE_URL + "error/access/404";
  },
  //modulo
  add: function(){
    if(this.userView == null){
      this.userView = new UserView();
    }
    this.userView.showAdd();
  },
  //system
  system: function(user_id){
    if(this.userSystemView == null){
      this.userSystemView = new UserSystemView();
    }
    this.userSystemView.tableUserSystem.urlListar = BASE_URL + "access/user_system/list/" + user_id;
    this.userSystemView.render();
    this.userSystemView.modalButton.click();
    this.userSystemView.user_id = user_id;
    this.userSystemView.tableUserSystem.limpiarBody();
    this.userSystemView.tableUserSystem.listar();
  },
  rolesPermissions: function(user_id){
    if(this.userRolePermissionView == null){
      this.userRolePermissionView = new UserRolePermissionView();
    }
    this.userRolePermissionView.user_id = user_id;
    this.userRolePermissionView.render();
    this.userRolePermissionView.modalButton.click();
  },
});

$(document).ready(function(){
  router = new userRouter();
  Backbone.history.start();
})
