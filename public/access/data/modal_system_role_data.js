var dataSystemRoleView = {
  el: "body",
  containerModal: "modal-container",
  urlTemplate: STATICS_URL + "access/templates/role.html",
  handlebarsTemplateId: "sistema-rol-template",
  targetMensaje: "mensajeRptaRol",
  context: {
    titulo_modal: "Editar Roles del Sistema",
  },
  closeFunction: function(){
    location.replace(BASE_URL + "access/#/");
  },
};
