var dataTableUserLog = {
  el: "#formTableUserLog",
  idTable: "tableUserLog",
  targetMensaje: "mensajeRptaUserLog",
  mensajes: {
    errorListarAjax: "Error en listar los datos del servidor",
    errorGuardarAjax: "Error en guardar los datos en el servidor",
    success: "Se cargado guardo los cambios en los autores",
  },
  //urlGuardar: BASE_URL + "access/system/save",
  urlListar: BASE_URL + "access/user_log/list",
  fila: {
    id: { // llave de REST
      tipo: "td_id",
      estilos: "color: blue; display:none",
      edicion: false,
    },
    moment: { // llave de REST
      tipo: "lavel",
      estilos: "width: 300px;",
      edicion: true,
    },
  },
  tableKeys: ['id', 'moment', ],
  collection: new UserLogsCollection(),
  model: "UserLog",
};
