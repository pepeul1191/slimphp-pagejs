import UserService from '../services/user_service';
import User from '../models/user';
import SpealismCollection from '../collections/speaker_collection';
import Specialism from '../models/specialism';
import Autocomplete from '../libs/autocomplete';
import District from '../models/district';
import DistrictCollection from '../collections/district_collection';
import ValidationForm from '../libs/validation_form';

var UserView = Backbone.View.extend({
  el: '#workspace',
	initialize: function(){
    this.user = new User();
    this.districtAutocomplete = null;
    this.form = null;
	},
	events: {
    'click #btnSave': 'save',
  },
  loadComponents: function(){
    // form
    this.form = new ValidationForm({
      el: '#form',
      entries: [
        // txtDistrict
        {
          id: 'txtDistrict',
          help: 'txtDistrictHelp',
          validations: [
            {
              type: 'notEmpty',
              message: 'Debe de ingresar un distrito',
            }, 
          ],
        },
        // txtAddress
        {
          id: 'txtAddress',
          help: 'txtAddressHelp',
          validations: [
            {
              type: 'notEmpty',
              message: 'Debe de ingresar una dirección',
            }, 
          ],
        },
        // txtPhone
        {
          id: 'txtPhone',
          help: 'txtPhoneHelp',
          validations: [
            {
              type: 'notEmpty',
              message: 'Debe de ingresar su teléfono',
            }, 
          ],
        },
      ],
      classes: {
        textDanger: 'text-danger',
        inputInvalid: 'is-invalid',
        textSuccess: 'text-success',
      },
      messageForm: 'message',
    });
    // district autocomplete
    this.districtAutocomplete = new Autocomplete({
      el: '#districtForm',
      inputText: 'txtDistrict',
      inputHelp: 'txtDistrictHelp',
      hintList: 'districtList',
      service: {
        url: BASE_URL + 'district/search',
        param: 'name',
      },
      model: District,
      collection: new DistrictCollection(),
      formatResponseData: {
        id: 'id',
        name: 'name',
      },
      formatModelData: {
        id: 'id',
        name: 'name',
      },
    });
    this.districtAutocomplete.id = this.user.get('id');
  },
  render: function(){
    // clear user
    this.user = new User();
    // get data
    var resp = UserService.get();
    if(resp.status == 200){
      this.user.set('id', resp.message.id);
      this.user.set('dni', resp.message.dni);
      //this.user.set('code', resp.message.code);
      //this.user.set('tuition', resp.message.tuition);
      this.user.set('names', resp.message.names);
      this.user.set('last_names', resp.message.last_names);
      this.user.set('email', resp.message.email);
      this.user.set('phone', resp.message.phone);
      this.user.set('district_id', resp.message.district_id);
      this.user.set('picture_url', resp.message.picture_url);
      this.user.set('address', resp.message.address);
      this.user.set('district_name', resp.message.district_name);
      // specialisms
      var specialisms = new SpealismCollection();
      resp.message.specialisms.forEach(specialism => {
        var s = new Specialism({
          id: specialism.id,
          name: specialism.name,
          exist: parseInt(specialism.exist),
        });
        specialisms.add(s);
      });
      this.user.set('specialisms', specialisms);
    }
    var data = {
      STATIC_URL: STATIC_URL,
      user: this.user, 
    };
    var templateCompiled = null;
		$.ajax({
		  url: STATIC_URL + 'templates/user.html',
		  type: 'GET',
		  async: false,
		  success: function(resource) {
        var template = _.template(resource);
         // console.log(data)
        templateCompiled = template(data);
      },
      error: function(xhr, status, error){
        console.error(error);
				console.log(JSON.parse(xhr.responseText));
      }
		});
    this.$el.html(templateCompiled);
  },
  save: function(){
    this.form.check();
    if(this.form.isOk == true){
      var phone = $('#txtPhone').val();
      var district_id = this.districtAutocomplete.id;
      var address = $('#txtAddress').val();
      var specialisms = [];
      $("input:checkbox[name=specialisms-checkbox]").each(function(){
        specialisms.push({
          specialism_id: $(this).attr('specialism-id'),
          exist: $(this).is(':checked'),
        });
      });
      var respData = UserService.update(phone, district_id, address, specialisms);
      if(respData.status == 200){
        if(respData.message == ''){
          // is a edited
          $('#message').removeClass('alert-danger');
          $('#message').removeClass('alert-warning');
          $('#message').addClass('alert-success');
          $('#message').html('Datos actualizados');
        }else{
          // error
          $('#message').removeClass('alert-success');
          $('#message').removeClass('alert-warning');
          $('#message').addClass('alert-danger');
          $('#message').html('Ocurrió un error en actualizar sus datos');
        }
      }else{

      }
    }
  },
});

export default UserView;
