var dataTableSystem = {
  el: "#formTableSystem",
  idTable: "tableSystem",
  targetMensaje: "mensajeRptaSystem",
  mensajes: {
    errorListarAjax: "Error en listar los datos del servidor",
    errorGuardarAjax: "Error en guardar los datos en el servidor",
    success: "Se cargado guardo los cambios en los autores",
  },
  urlGuardar: BASE_URL + "access/system/save",
  urlListar: BASE_URL + "access/system/list",
  fila: {
    id: { // llave de REST
      tipo: "td_id",
      estilos: "color: blue; display:none",
      edicion: false,
    },
    name: { // llave de REST
      tipo: "text",
      estilos: "width: 300px;",
      edicion: true,
    },
    filaBotones: {
      estilos: "width: 80px; padding-left: 15px;"
    },
  },
  tableKeys: ['id', 'name', ],
  filaBotones: [
    {
      tipo: "href",
      claseOperacion: "gesionar-permisos",
      clase: "fa-list",
      estilos: "padding-left: 30px;",
      url: BASE_URL + 'access/#/system/permission/'/*+ system_id*/,
    },
    {
      tipo: "href",
      claseOperacion: "gestionar-roles",
      clase: "fa-id-card-o",
      estilos: "padding-left: 10px;",
      url: BASE_URL + 'access/#/system/role/'/*+ sistema_id*/,
    },
    {
      tipo: "i",
      claseOperacion: "quitar-fila",
      clase: "fa-times",
      estilos: "padding-left: 7px;",
    },
  ],
  collection: new SystemsCollection(),
  model: "System",
};
