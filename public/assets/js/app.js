function loadSpeakers(){
  $.ajax({
    type: 'GET',
    // url: BASE_URL + 'admin/event/get',
    url: 'http://localhost:8080/admin/speaker/random-list',
    data: {
      number: 6
    },
    headers: {
      //[CSRF_KEY]: CSRF,
    },
    async: false,
    success: function(data){
      var speakers = JSON.parse(data);
      var html = [];
      var card = '<div class="row">';
      for(var i = 0; i < speakers.length; i++){
        card = card + `
        <div class="col-md-6">
          <div class="blockquote-box clearfix">
            <div class="square pull-left">
              <img width="85" height="85" src="${REMOTE_URL}${speakers[i].picture_url}" alt="" class="" />
            </div>
            <div class="text">
              <h4>${speakers[i].names} ${speakers[i].last_names}</h4>
              <p>${speakers[i].resume.substring(0, 200)}</p>
            </div>
          </div>
        </div>
        `;

      }
      $("#speakers-row").append(card);
    },
    error: function(xhr, status, error){
      var resp = {};
      console.error(error);
      resp.message = JSON.parse(xhr.responseText);
      resp.status = xhr.status;
    }
  });
}

$(document).ready(function() {
  // load speakers/events
  loadSpeakers();
  // loadEvents()
});