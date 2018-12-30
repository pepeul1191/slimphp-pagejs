var dataTableRole = {
  el: "#formTableRole",
  idTable: "tableRole",
  targetMensaje: "mensajeRptaRole",
  mensajes: {
    errorListarAjax: "Error en listar los datos del servidor",
    errorGuardarAjax: "Error en guardar los datos en el servidor",
    success: "Se cargado guardo los cambios en los autores",
  },
  urlGuardar: BASE_URL + "access/role/save",
  urlListar: BASE_URL + "access/role/list",
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
    filaBotones: {
      estilos: "width: 80px; padding-left: 7px;"
    },
  },
  tableKeys: ['id', 'name', ],
  filaBotones: [
    {
      tipo: "i",
      claseOperacion: "ver-permisos",
      clase: "fa-chevron-right",
      estilos: "padding-left: 23px;",
    },
    {
      tipo: "i",
      claseOperacion: "quitar-fila",
      clase: "fa-times",
      estilos: "padding-left: 5px;",
    },
  ],
  collection: new RolesCollection(),
  model: "Role",
};
