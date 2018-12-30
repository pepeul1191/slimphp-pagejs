var dataTablaUserPermission = {
  el: "#formTableUserPermission",
  idTable: "tablaUserPermission",
  targetMensaje: "mensajeRptaUserPermission",
  mensajes: {
    errorListarAjax: "Error en listar los datos del servidor",
    errorGuardarAjax: "Error en guardar los datos en el servidor",
    success: "Se cargado guardo los cambios en los autores",
  },
  urlGuardar: BASE_URL + "access/user_permission/save",
  urlListar: BASE_URL + "access/user_permission/list/",
  fila: {
    id: { // llave de REST
      tipo: "td_id",
      estilos: "color: blue; display:none",
      edicion: false,
    },
    name: { // llave de REST
      tipo: "label",
      estilos: "width: 200px;",
      edicion: true,
    },
    description: { // llave de REST
      tipo: "label",
      estilos: "width: 200px;",
      edicion: true,
    },
    existe: {
      tipo: "check",
      estilos: "width: 30px; padding-left:20px;",
      edicion: true,
      key: "existe",
    },
    filaBotones: {
      estilos: "display: none;"
    },
  },
  tableKeys: ['id', 'name', 'description','existe'],
  filaBotones: [
    {
      tipo: "i",
      claseOperacion: "quitar-fila",
      clase: "fa-times",
      estilos: "padding-left: 10px;",
    },
  ],
  collection: new PermissionsCollection(),
  model: "Permission",
};
