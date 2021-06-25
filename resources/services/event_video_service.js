var EventDocumentService = {
  list: function(event_id){
    var resp = {};
    $.ajax({
      type: 'GET',
      url: BASE_URL + 'event/video',
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
};

export default EventDocumentService;