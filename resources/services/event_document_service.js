var EventDocumentService = {
  list: function(event_id){
    var resp = {};
    $.ajax({
      type: 'GET',
      url: BASE_URL + 'event/document',
      data: {
        event_id: event_id,
      },
      headers: {
        [CSRF_KEY]: CSRF,
      },
      async: false,
      success: function(data){
        resp.message = JSON.parse(data);
        resp.status = 200;
      },
      error: function(xhr, status, error){
        console.error(error);
				resp.message = JSON.parse(xhr.responseText);
        resp.status = xhr.status;
      }
    });
    return resp;
  },
  get: function(event_id, document_id, document_name){
    var resp = {};
    $.ajax({
      type: 'GET',
      url: BASE_URL + 'document/get',
      data: {
        event_id: event_id,
        document_id: document_id,
      },
      headers: {
        [CSRF_KEY]: CSRF,
      },
      xhrFields: {
        responseType: 'blob'
      },
      async: true,
      success: function(data){
        //resp.message = JSON.parse(data);
        var a = document.createElement('a');
        var url = window.URL.createObjectURL(data);
        a.href = url;
        a.download = document_name + '.pdf';
        document.body.append(a);
        a.click();
        a.remove();
        window.URL.revokeObjectURL(url);
      },
      error: function(xhr, status, error){
        console.error(error);
				resp.message = JSON.parse(xhr.responseText);
        resp.status = xhr.status;
      }
    });
    return resp;
  },
};

export default EventDocumentService;