import 'bootstrap/dist/js/bootstrap.min.js';
import EventView from '../views/event_view';

// views
var eventView = null;
var videoView = null;
var docuemntView = null;
// routes
page.base('/');
page('', courses);
page('courses', courses);
page();

function courses(ctx, next) {
  if(eventView == null){
    eventView = new EventView();
  }
  eventView.loadComponents();
  eventView.render();
  next();
}
