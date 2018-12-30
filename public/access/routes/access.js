function limpiarURL(url_original, parametro){
  return url_original + parametro;
}

var accessRouter = Backbone.Router.extend({
  systemView: null,
  systemPermissionView: null,
  systemRoleView: null,

  permissionView: null,
  roleView: null,

  initialize: function() {
  },
  routes: {
    "": "systemIndex",
    "system" : "systemIndex",
    "system/permission/:system_id" : "systemPermission",
    "system/role/:system_id" : "systemRole",
    "*actions" : "default",
  },
  index: function(){
    //window.location.href = BASE_URL + "accesos/#/modulo";
  },
  default: function() {
    //window.location.href = BASE_URL + "error/access/404";
  },
  //system
  systemIndex: function(){
    if(this.systemView == null){
      this.systemView = new SystemView();
    }
    this.systemView.render();
    this.systemView.tableSystem.listar();
  },
  //modal permission
  systemPermission: function(system_id){
    if(this.systemPermissionView == null){
      this.systemPermissionView = new SystemPermissionView(dataSystemPermissionView);
    }
    this.systemPermissionView.render();
    this.systemPermissionView.tablePermission.urlListar =
      limpiarURL(BASE_URL + "access/permission/list/" , system_id);
    this.systemPermissionView.systemId = system_id;
    this.systemPermissionView.tablePermission.listar(system_id);
  },
  //modal role
  systemRole: function(system_id){
    if(this.systemRoleView == null){
      this.systemRoleView = new SystemRoleView(dataSystemRoleView);
    }
    this.systemRoleView.render();
    this.systemRoleView.tableRole.urlListar =
      limpiarURL(BASE_URL + "access/role/list/" , system_id);
    this.systemRoleView.systemId = system_id;
    this.systemRoleView.tableRole.listar(system_id);
    this.systemRoleView.tableRolePermission.systemId = system_id;
  },
  //permission
  permissionIndex: function(){
    if(this.permissionView == null){
      this.permissionView = new PermissionView();
    }
    this.permissionView.render();
    this.permissionView.tablePermission.listar();
  },
  //role
  roleIndex: function(){
    if(this.roleView == null){
      this.roleView = new RoleView();
    }
    this.roleView.render();
    this.roleView.tableRole.listar();
  },
});

$(document).ready(function(){
  router = new accessRouter();
  Backbone.history.start();
})
