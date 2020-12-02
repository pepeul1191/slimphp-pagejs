var events_data = [];

function modalContactClick(event){
  $('#eventModal').modal('toggle');
  page.redirect('/contacto');
}

function showEvent(event, id){
  var eventSearched = {};
  var speakers = '';
  for(var i = 0; i < events_data.length; i++){
    if(parseInt(events_data[i]['id']) == id){
      eventSearched = events_data[i];
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
          <button type="button" class="btn btn-primary" onclick="modalContactClick(event)">Contáctanos</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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

function loadEvents(){
  $.ajax({
    type: 'GET',
    url: BASE_URL + 'event/recent-list',
    data: {},
    headers: {
      //[CSRF_KEY]: CSRF,
    },
    async: false,
    success: function(data){
      var events = JSON.parse(data);
      var html = [];
      var i = 0;
      events_data = events;
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
                <p class="card-text">Fecha de Inicio: ${event.init_date}</p>
                <a href="#" class="btn btn-primary" onclick="showEvent(event, ${event.id})">Ver Más</a>
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
                <p class="card-text">Fecha de Inicio: ${event.init_date}</p>
                <a href="#" class="btn btn-primary" onclick="showEvent(event, ${event.id})">Ver Más</a>
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
  console.log(email);
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
  loadSpeakers();
  loadEvents();
  router();
  page();
});
