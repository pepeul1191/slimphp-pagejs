import 'bootstrap/dist/js/bootstrap.min.js';
import EventView from '../views/event_view';
import ModalDocumentView from '../views/modal_document_view';
import ModalVideoView from '../views/modal_video_view';

// views
var eventView = null;
var modalDocumentView = null;
var modalVideoView = null;
// routes
page.base('/');
page('', courses);
page('courses', courses);
page('user/edit', user);
page('video/:event_id', videoModal);
page('document/:event_id', documentModal);
page('*', notfound)
page();

function courses(ctx, next) {
  if(eventView == null){
    eventView = new EventView();
  }
  eventView.loadComponents();
  eventView.render();
  //next();
}

function user(ctx, next){
  alert('user');
}

function documentModal(ctx, next){
  var event_id = ctx.params.event_id;
  if(modalDocumentView == null){
    modalDocumentView = new ModalDocumentView();
  }
  modalDocumentView.loadComponents(event_id);
  modalDocumentView.render();
}

function videoModal(ctx, next){
  var event_id = ctx.params.event_id;
  if(modalVideoView == null){
    modalVideoView = new ModalVideoView();
  }
  modalVideoView.loadComponents(event_id);
  modalVideoView.render();
}

function notfound(ctx, next) {
  //window.location = BASE_URL + 'error/access/404';
}

$('#modal').on('hidden.bs.modal', function (e) {
  if (
    window.location.href.includes('document') ||
    window.location.href.includes('video')
  ){
    page.redirect('/');
  }
});
