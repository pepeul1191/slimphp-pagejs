function loadEvents(){
  $.ajax({
    type: 'GET',
    // url: BASE_URL + 'admin/event/get',
    url: 'http://localhost:8080/admin/event/recent-list',
    data: {},
    headers: {
      //[CSRF_KEY]: CSRF,
    },
    async: false,
    success: function(data){
      var events = JSON.parse(data);
      var html = [];
      var i = 0;
      events.forEach(event => {
        var card = '';
        if(i == 0){
          card = `
          <div class="carousel-item active">
            <div class="col-md-4">
              <div class="card" style="width: 18rem;">
              <img class="card-img-top" src="${REMOTE_URL}${event.picture_url}" alt="Card image cap">
              <div class="card-body">
                <h5 class="card-title">${event.name}</h5>
                <p class="card-text">${event.init_date}</p>
                <a href="#" class="btn btn-primary">Ver Más</a>
              </div>
              </div>
            </div>
          </div>
          `;
          i++;
        }else{
          card = `
          <div class="carousel-item">
            <div class="col-md-4">
              <div class="card" style="width: 18rem;">
              <img class="card-img-top" src="${REMOTE_URL}${event.picture_url}" alt="Card image cap">
              <div class="card-body">
                <h5 class="card-title">${event.name}</h5>
                <p class="card-text">${event.init_date}</p>
                <a href="#" class="btn btn-primary">Ver Más</a>
              </div>
              </div>
            </div>
          </div>
          `;
        }
        $("#events-carousel").append(card);
        html.card;
      });
    },
    error: function(xhr, status, error){
      var resp = {};
      console.error(error);
      resp.message = JSON.parse(xhr.responseText);
      resp.status = xhr.status;
    }
  });
  // carousel
  $('#recipeCarousel').carousel({
    interval: 3000
  })
  $('.carousel .carousel-item').each(function(){
    var minPerSlide = 3;
    var next = $(this).next();
    if (!next.length) {
    next = $(this).siblings(':first');
    }
    next.children(':first-child').clone().appendTo($(this));
    for (var i=0;i<minPerSlide;i++) {
      next=next.next();
      if (!next.length) {
        next = $(this).siblings(':first');
      }
      next.children(':first-child').clone().appendTo($(this));
    }
  });
}

function loadSpeakers(){
  $.ajax({
    type: 'GET',
    url: BASE_URL + 'speaker/random-list',
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
  loadEvents()
});
