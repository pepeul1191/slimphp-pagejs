var dataTablePermission = {
  el: "#formTablePermission",
  idTable: "tablePermission",
  targetMensaje: "mensajeRptaPermission",
  mensajes: {
    errorListarAjax: "Error en listar los datos del servidor",
    errorGuardarAjax: "Error en guardar los datos en el servidor",
    success: "Se cargado guardo los cambios en los autores",
  },
  urlGuardar: BASE_URL + "access/permission/save",
  urlListar: BASE_URL + "access/permission/list",
  fila: {
    id: { // llave de REST
      tipo: "td_id",
      estilos: "color: blue; display:none",
      edicion: false,
    },
    name: { // llave de REST
      tipo: "text",
      estilos: "width: 150px;",
      edicion: true,
    },
    description: { // llave de REST
      tipo: "text",
      estilos: "width: 300px;",
      edicion: true,
    },
    filaBotones: {
      estilos: "width: 80px; padding-left: 7px;"
    },
  },
  tableKeys: ['id', 'name', 'description'],
  filaBotones: [
    {
      tipo: "i",
      claseOperacion: "quitar-fila",
      clase: "fa-times",
      estilos: "padding-left: 25px;",
    },
  ],
  collection: new PermissionsCollection(),
  model: "Permission",
};
