var recentEvents = [];
var passedEvents = [];
var actualEventPage = 1;

function modalContactClick(event, eventName){
  $('#eventModal').modal('toggle');
  $('#txtMessage').val('Consulta evento: ' + eventName);
  page.redirect('/contacto');
}

function prevEventPage(e){
  if(actualEventPage != 1){
    searchEvents(e, actualEventPage - 1);
  }else{
    e.preventDefault();
    return false;
  }
};

function nextEventPage(e){
  var pageNumber = $('#paginationEvents').children().length - 2;
  if((actualEventPage + 1) <= pageNumber){
    searchEvents(e, actualEventPage + 1);
  }else{
    e.preventDefault();
    return false;
  }
};

function searchEvents(e, page){
  if(typeof page === 'undefined'){
    actualEventPage = 1;
  }else{
    actualEventPage = page;
  }
  $.ajax({
    type: 'GET',
    url: BASE_URL + 'event/search',
    data: {
      specialism_id: $('#sclSpecialism').val(),
      page: actualEventPage,
      step: 6,
      date: 'past',
      event_type_id: $('#sclType').val(),
    },
    headers: {
      //[CSRF_KEY]: CSRF,
    },
    async: false,
    success: function(data){
      passedEvents = JSON.parse(data);
      var cards = '';
      // cards
      $("#events-row").empty();
      passedEvents.list.forEach(event => {
        var card = `
            <div class="col-md-4">
              <div class="card" style="">
              <img class="card-img-top" src="${REMOTE_URL}${event.picture_url}" alt="Card image cap">
              <div class="card-body">
                <h5 class="card-title">${event.name}</h5>
                <a href="#" class="btn btn-primary" onclick="showEvent(event, ${event.id})">Ver Más - ${event.event_type_name}</a>
              </div>
              </div>
            </div>
          `;
        cards = cards + card;
      });
      $("#events-row").append(cards);
      // pagination
      var pagination = 
        `<li class="page-item">
          <a class="page-link" href="#" aria-label="Previous" onclick="prevEventPage(event)">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
          </a>
        </li>`;
      for(var i = 0; i < passedEvents.pages; i++){
        var link = '';
        if(actualEventPage == (i + 1)){
          link = `
            <li class="page-item">
              <a class="page-link active-page" href="#" onclick="searchEvents(event, ${i + 1})">${i + 1}</a>
            </li>`;
        }else{
          link = `
            <li class="page-item">
              <a class="page-link" href="#" onclick="searchEvents(event, ${i + 1})">${i + 1}</a>
            </li>`;
        }
        pagination = pagination + link;
      }
      pagination = pagination + 
        `<li class="page-item">
          <a class="page-link" href="#" aria-label="Next" onclick="nextEventPage(event)">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Siguiente</span>
          </a>
        </li>`;
      $("#paginationEvents").empty();
      $("#paginationEvents").append(pagination);
    },
    error: function(xhr, status, error){
      var resp = {};
      console.error(error);
      resp.message = JSON.parse(xhr.responseText);
      resp.status = xhr.status;
    }
  });
  e.preventDefault();
  return false;
}

function showEvent(event, id){
  var eventSearched = {};
  var speakers = '';
  for(var i = 0; i < passedEvents.list.length; i++){
    if(parseInt(passedEvents.list[i]['id']) == id){
      eventSearched = passedEvents.list[i];
    }
  }
  for(var i = 0; i < eventSearched.speakers.length; i++){
    var name = eventSearched.speakers[i].names + eventSearched.speakers[i].last_names;
    var temp = `
      <div class="media">
        <div class="media-left">
          <a href="#">
            <img class="media-object"  width="100" height="100" src="${REMOTE_URL}${eventSearched.speakers[i].picture_url}" alt="${name}">
          </a>
        </div>
        <div class="media-body">
          ${name}
        </div>
      </div>
    `;
    speakers = speakers + temp;
  }
  if(speakers != ''){
    speakers = '<p>Expositores:</p>' + speakers;
  }
  var modalContent = `
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">${eventSearched.event_type_name} - ${eventSearched.name}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <img class="card-img-top" src="${REMOTE_URL}${eventSearched.picture_url}" alt="Card image cap">
            </div>
            <div class="col-md-6">
              <p>Fecha de Inicio: ${eventSearched.init_date}</p>
              <p>Hora de Inicio: ${eventSearched.init_hour}</p>
              <p>Duración(horas): ${eventSearched.hours}</p>
              <p>Detalle del Evento: <br> ${eventSearched.description}</p>
              ${speakers}
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="modalContactClick(event, '${eventSearched.name}')"><i class="fa fa-envelope-o" aria-hidden="true"></i> Contáctanos</button>
          <a target="_blank" href="https://api.whatsapp.com/send?phone=51993907419&amp;text=Consulta:%2C%20${eventSearched.name}" class="btn btn-success"><i class="fa fa-whatsapp" aria-hidden="true"></i> WhastApp</a >
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>
          Cerrar</button>
        </div>
      </div>
    </div>
  `;
  $('#eventModal').empty();
  $('#eventModal').append(modalContent);
  $('#eventModal').modal('toggle');
  // prevent default
  event.preventDefault();
  return false;
}

function loadSpecialisms(){
  $.ajax({
    type: 'GET',
    url: BASE_URL + 'specialism/list',
    data: {},
    headers: {
      //[CSRF_KEY]: CSRF,
    },
    async: false,
    success: function(data){
      var specialisms = JSON.parse(data);
      var options = '<option value="E">Todas</option>';
      specialisms.forEach(specialism => {
        var select = `<option value="${specialism.id}">${specialism.name}</option>`;
        options = options + select;
      });
      $('#sclSpecialism').append(options);
    },
    error: function(xhr, status, error){
      var resp = {};
      console.error(error);
      resp.message = JSON.parse(xhr.responseText);
      resp.status = xhr.status;
    }
  });
}

function showRecentEvents(event, id){
  var eventSearched = {};
  var speakers = '';
  for(var i = 0; i < recentEvents.length; i++){
    if(parseInt(recentEvents[i]['id']) == id){
      eventSearched = recentEvents[i];
    }
  }
  for(var i = 0; i < eventSearched.speakers.length; i++){
    var name = eventSearched.speakers[i].names + eventSearched.speakers[i].last_names;
    var temp = `
      <div class="media">
        <div class="media-left">
          <a href="#">
            <img class="media-object"  width="100" height="100" src="${REMOTE_URL}${eventSearched.speakers[i].picture_url}" alt="${name}">
          </a>
        </div>
        <div class="media-body">
          ${name}
        </div>
      </div>
    `;
    speakers = speakers + temp;
  }
  if(speakers != ''){
    speakers = '<p>Expositores:</p>' + speakers;
  }
  var modalContent = `
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">${eventSearched.event_type_name} - ${eventSearched.name}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="modalContactClick(event)">Contáctanos</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  `;
}

function loadRecentEvents(){
  $.ajax({
    type: 'GET',
    url: BASE_URL + 'event/search',
    data: {
      date: 'future',
      page: 1,
      step: 6,
    },
    headers: {
      //[CSRF_KEY]: CSRF,
    },
    async: false,
    success: function(data){
      var events = JSON.parse(data);
      var recentEvents = '';
      var i = 0;
      if(events.list.length > 1){
        // slider
        recentEvents = `<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">`;
        events.list.forEach(event => {
          var item = '';
          if (i == 0){
            item =
              `<div class="carousel-item active">
                <img class="d-block w-100"  src="${REMOTE_URL}${event.picture_url}" alt="${event.name}">
              </div>`;
          }else{
            item =
            `<div class="carousel-item">
              <img class="d-block w-100"  src="${REMOTE_URL}${event.picture_url}" alt="${event.name}">
            </div>`;
          }
          recentEvents = recentEvents + item;
          i++;
        });
        recentEvents = recentEvents +  `
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>`;
        $('#rowNextEvents').append(recentEvents);
        console.log(recentEvents)
        $('.carousel').carousel();
      }else{
        // solo imagen
        events = `<img class="d-block w-100" src="${REMOTE_URL}${events.list[0].picture_url}" alt="${event.name}"></img>`;
        $('#rowNextEvents').append(events);
      }
    },
    error: function(xhr, status, error){
      var resp = {};
      console.error(error);
      resp.message = JSON.parse(xhr.responseText);
      resp.status = xhr.status;
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
      var card = '<div class="row">';
      for(var i = 0; i < speakers.length; i++){
        card = card + `
        <div class="col-md-6 col-sm-12 col-sx-12 ">
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

function sendEmail(event){
  var name = $('#txtName').val();
  var email = $('#txtEmail').val();
  var message = $('#txtMessage').val();
  var validationOk = true;
  // name
  if(name == ''){
    validationOk = false;
    $('#txtName').attr('placeholder', 'Ingrese su nombre'); 
    $('#txtName').addClass('input-warning');
  }else{
    $('#txtName').removeClass('input-warning');
  }
  // email
  if(email == ''){
    validationOk = false;
    $('#txtEmail').attr('placeholder', 'Ingrese su correo'); 
    $('#txtEmail').addClass('input-warning');
  }else{
    var regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(regex.test(email) == false){
      validationOk = false;
      $('#txtEmail').val('');
      $('#txtEmail').attr('placeholder', 'Ingrese su correo válido'); 
    $('#txtEmail').addClass('input-warning');
    }else{
      $('#txtEmail').removeClass('input-warning');
    }
  }
  // message
  console.log(message);
  if(message == ''){
    validationOk = false;
    $('#txtMessage').attr('placeholder', 'Ingrese su mensaje'); 
    $('#txtMessage').addClass('input-warning');
  }else{
    $('#txtMessage').removeClass('input-warning');
  }
  // validation ok, send email
  if(validationOk){
    $('#messageForm').html('');
    $.ajax({
      type: 'POST',
      url: BASE_URL + 'email/send',
      data: {
        name: name,
        email: email,
        message: message,
      },
      headers: {
        [CSRF_KEY]: CSRF,
      },
      async: false,
      beforeSend: function(){
        $('#btnContact').attr('disabled', true);
      },
      complete: function(){
        $('#btnContact').attr('disabled', false);
      },
      success: function(data){
        // show message
        $('#txtName').val('');
        $('#txtEmail').val('');
        $('#txtMessage').val('');
        $('#messageForm').html('Su mensaje ha sido enviado con éxito');
      },
      error: function(xhr, status, error){
        // show message
        $('#messageForm').html('Ocurrió un error no controlado en grabar el detalle del ponente');
        console.error(error);
      }
    });
  }else{
    $('#messageForm').html('Complete los campos indicados');
  }
}

function router(){
  var pos = 0;
  page('/', function(){
    pos = $('#home').offset().top - 100;
    $('html, body').animate({ 
      scrollTop: pos
    }, 900);
    $('.nav-item').removeClass('active');
    $('#linkInicio').addClass('active');
  });
  page('/nosotros', function(){
    pos = $('#about').offset().top - 100;
    $('html, body').animate({ 
      scrollTop: pos
    }, 900);
    $('.nav-item').removeClass('active');
    $('#linkNosotros').addClass('active');
    $('.navbar-collapse').collapse('hide');
  });
  page('/capacitaciones', function(){
    pos = $('#events').offset().top - 100;
    $('html, body').animate({ 
      scrollTop: pos
    }, 900);
    $('.nav-item').removeClass('active');
    $('#linkCapacitaciones').addClass('active');
    $('.navbar-collapse').collapse('hide');
  });
  page('/ponentes', function(){
    pos = $('#speakers').offset().top - 100;
    $('html, body').animate({ 
      scrollTop: pos
    }, 900);
    $('.nav-item').removeClass('active');
    $('#linkPonentes').addClass('active');
    $('.navbar-collapse').collapse('hide');
  });
  page('/contacto', function(){
    pos = $('#contact').offset().top - 100;
    $('html, body').animate({ 
      scrollTop: pos
    }, 900);
    $('.nav-item').removeClass('active');
    $('#linkContacto').addClass('active');
    $('.navbar-collapse').collapse('hide');
  });
  page('*', function(){
    alert('notFound')
  })
}

$(document).ready(function() {
  // load speakers/events
  loadSpecialisms();
  loadSpeakers();
  // showRecentEvents();
  loadRecentEvents();
  router();
  page();
  $("#bthSearch").click();
});
