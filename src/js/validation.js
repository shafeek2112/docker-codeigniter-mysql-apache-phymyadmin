
$(document).ready(function(){

	var portal_user_id = $('#portal_user_id').val();
	var user_id = $('#id').val();	
	
	$('select').each(function(index){
		var select_option_count = $(this).children().length;
		
		if(select_option_count > 10){
			if(!$(this).hasClass('select2') && !$(this).hasClass('cs-select')){
				$(this).addClass('select2');
			}
		}else{
			if(!$(this).hasClass('select2-wrapper') && !$(this).hasClass('cs-select')){
				$(this).addClass('select2-wrapper');
			}
		}
	});
	
	$('select.select2').select2();	
	$(".select2-wrapper").select2({minimumResultsForSearch: -1});
	
	$('select').change(function(){
		$(this).removeClass('error');
		$(this).next('span.error').remove();
	});

	//HTML5 editor
	$('.text-editor').wysihtml5();
	/*$('.text-editor2').wysihtml5();
	$('.text-editor3').wysihtml5();
	$('.text-editor4').wysihtml5();*/

	$(".alert-error").show().delay(5000).fadeOut();
	$(".alert-success").show().delay(5000).fadeOut();
	
	$(".Select2PresetDateFormat").select2({
		placeholder: "Please select a system date format",
		allowClear: true,
		ajax: {
			url: base_url+"general/preset_date_format/",
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function(obj) {
						  return { id: obj.id, text: obj.value};
					})
				};
			},
			cache: true
		}
	});

});

/*$.validator.setDefaults({
	submitHandler: function() { return true }
});*/

$(document).ready(function() {
	
	$.validator.addMethod('comboboxNotNone', function(value, element) {
        return (value != '0');
    }, 'Please select an option.');
	
	$.validator.addMethod('lessthan', function(value, element) {
        return (value > '0');
	}, 'Please enter valid value.');
	
	$.validator.addMethod("minDate", function(value, element) {
		var curDate = new Date();
		var inputDate = new Date(value);

		var curdatestring = curDate.getFullYear()+curDate.getMonth()+curDate.getDate(); 
		var inputdatestring = inputDate.getFullYear()+inputDate.getMonth()+inputDate.getDate(); 

		console.log(inputdatestring + '==' + curdatestring);
		if (inputdatestring >= curdatestring)
			return true;
		return false;
	}, "Invalid Date!");

	$.validator.addMethod('checkdatediscount',function(value, element) {
		var start = value;
		var end = $('input[name=effective_end_date]').val();

		if(Date.parse(start) > Date.parse(end))
		{
			return false;
		}
		return true;
	},'Start date must be smaller than End date');

	/*$("#show_tp").timepicker({
		showLeadingZero: true
	});*/

	$("#show_dp").datepicker({
		autoclose: true,
		forceParse: false,
		format: 'D dd MM yyyy'
	});
	$("#show_dp1").datepicker({
		autoclose: true,
		forceParse: false,
		format: 'D dd MM yyyy'
	});

	/*$('.input-append.date').datepicker({
		autoclose: true,
		format: 'D dd MM yyyy',
		todayHighlight: true
    });*/
	$(document).on('change','#date', function (ev) {
		//alert('fsf');
		//alert($(this).attr('name'));
		$(this).removeClass('error');
		$(this).next('span.error').remove();
	});

	var date = new Date();
	date.setDate(date.getDate()-1);

	$('#future_date').datepicker({
	  format: 'D dd MM yyyy',
	  orientation: "auto",
	  startDate: date,
	  autoclose: true,
	  clearBtn: true
	});
	$('#past_date').datepicker({
	  format: 'D dd MM yyyy',
	  orientation: "auto",
	  autoclose: true,
	  endDate: date,
	  clearBtn: true
	});
	
	$("#date_year").datepicker( {
		autoclose: true,
		forceParse: false,
		format: " yyyy",
		viewMode: "years", 
		minViewMode: "years"
	});

	$('#show_dp_today').datepicker({
		autoclose: true,
		format: 'dd MM yyyy',
		todayHighlight: true
    });

	$('.show_date_simple').datepicker({
		autoclose: true,
		format: 'yyyy-mm-dd',
		todayHighlight: true
    });
	
    $('#show_date_simple').datepicker({
		autoclose: true,
		format: 'yyyy-mm-dd',
		todayHighlight: true
    });

    $('#show_date_simple2').datepicker({
		autoclose: true,
		format: 'yyyy-mm-dd',
		todayHighlight: true
    });
	
	$('#show_date_simple3').datepicker({
		autoclose: true,
		format: 'yyyy-mm-dd',
		todayHighlight: true
    });
	
	$('#show_date_simple3').datepicker({
		autoclose: true,
		format: 'yyyy-mm-dd',
		todayHighlight: true
	});
	
	$('#start_date').datepicker({
		orientation: 'bottom',
		autoclose: true,
		format:  'yyyy-mm-dd',
		todayHighlight: true
	});
	
	$('#end_date').datepicker({
	 	orientation: 'bottom',
		autoclose: true,
		format: 'yyyy-mm-dd' ,
		todayHighlight: true
    });

    //for year
    $("#year").datepicker({
    format: "yyyy",
    viewMode: "years", 
    minViewMode: "years"
	});
	$(".months").datepicker({
		autoclose: true,
		todayHighlight: true,
	    format: "mm-yyyy",
	    viewMode: "months", 
	    minViewMode: "months"
	});
	$(".1months").datepicker({
		autoclose: true,
		todayHighlight: true,
	    format: "yyyy-mm",
	    viewMode: "months", 
	    minViewMode: "months"
	});

	$('.my-colorpicker1').colorpicker({
  	});


	/*$('#am').timepicker({
		showLeadingZero: true

	});
	$('#pm').timepicker({
		
		showLeadingZero: true
	});*/

	$("#add_role_form_datatable").validate({
		submitHandler: function(form) 
		{
			$("#role_submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data == 'insert'){
						$('#modal-default').delay(1000).modal('hide');
						$("#role_submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Role Inserted');
						parent.reload_datatable();
					}else if(data == 'update'){
						$('#modal-default').delay(1000).modal('hide');
						$("#role_submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Role Updated');
						parent.reload_datatable();
					}else{
						showErrorMsg('Ops! Something went wrong');
						$("#role_submit").removeAttr('disabled','disabled');
					}
				}
			});
		},
		rules: {
			user_roll_name: {
				required: true
			}
		},
		messages: {
			user_roll_name: "Please enter role."
		}
	});

	
	$("#add_grant_type_form_datatable").validate({
		submitHandler: function(form) 
		{
			$("#add_grant_type_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data == 'insert'){
						$('#modal-default').delay(1000).modal('hide');
						$("#add_grant_type_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully  Inserted');
						parent.reload_datatable();
					}else if(data == 'update'){
						$('#modal-default').delay(1000).modal('hide');
						$("#add_grant_type_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
						parent.reload_datatable();
					}else{
						showErrorMsg('Ops! Something went wrong');
						$("#add_grant_type_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
		},
		rules: {
			grant_type: {
				required: true
			},
			grant_course_type: {
				required: true
			}
		},
		messages:{ 
		    grant_type : {
				required : "Please enter grant type.",
			},
			grant_course_type : {
				required : "Please select course type.",
			}
		}
	});

	$('.btn-delet').on('click', function () {
		return confirm('Are you sure want to delete?');
	});

	$('#btn_user_password_update').click(function(event) {

		if($('#user_password').val() == "")
		{
			$('#error_div').html('<span class="error"><label for="" generated="true" class="error">Please enter password.</label></span>');
		    return false;
		}
		else if($('#user_password_confirm').val() == "")
		{
			$('#error_div').html('<span class="error"><label for="" generated="true" class="error">Please enter Confirm password.</label></span>');
		    return false;
		}
		else if($('#user_password').val() != $('#user_password_confirm').val())
		{
			$('#error_div').html('<span class="error"><label for="" generated="true" class="error">password & confirm pass must be same.</label></span>');
		    return false;
		}
		// get the form data
		// there are many ways to get this data using jQuery (you can use the class or id also)
		var formData = {
			'user_password' 	: $('#user_password').val(),
			'user_password_confirm' 	: $('#user_password_confirm').val(),
			'user_id' 	: $('input[name=user_id]').val()
		};
		// process the form
		$.ajax({
			type 		: 'POST', // define the type of HTTP verb we want to use (POST for our form)
			url 		: CI.base_url+'list_user/save_user_pass', // the url where we want to POST
			data 		: formData, // our data object
			success: function(data) {
				$('#error_div').html('');
				$('#message_div').html('<div class="alert alert-success"><button data-dismiss="alert" class="close"></button>'+data+'</div>');
				$('#user_password').val('');
				$('#user_password_confirm').val('');
			}
		});
		// stop the form from submitting the normal way and refreshing the page
		event.preventDefault();
	});
	
	$("#add_company_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_company_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						$('#modal-large').delay(1000).modal('hide');
						$("#add_company_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
						$('#grid_company').dataTable().api().draw();
					}else if(data.trim() == 'update'){
						$('#modal-large').delay(1000).modal('hide');
						$("#add_company_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
						$('#grid_company').dataTable().api().draw();
					}else{
						showErrorMsg('Ops! Something went wrong');
						$("#add_company_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			company_name: {
				required: true,
				remote: {
			        url: CI.base_url+"company_management/check_company_exist",
			        type: "get",
			        data: {
						company_name: function() {
							return $( "#company_name" ).val();
						},
						id: function() {
							return $( "#id" ).val();
						},
			        }
			      }
			},
			organization_code : {
				required : true,
			},
			email: {
				required: true,
			},
			phone_no: {
				required: true,
			},
		},
		messages: {
			company_name: {
				required : "Please enter a Client Company Name",
				remote: jQuery.validator.format("{0} is already in use")
			},
			email : {
				required : "Please enter an email address",
			},
			organization_code : {
				required : "Please enter an Organization Code",
			},
			phone_no : {
				required : "Please enter a contact number",
			}
		}
	});

	
	$("#add_venue_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_venue_form_datatable #district_submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					$("#add_venue_form_datatable #district_submit").removeAttr('disabled','disabled');
					if(data.trim() == 'insert'){
						$('#modal-large').delay(1000).modal('hide');
						showSuccessMsg('Succesfully Save');
						$('#grid_venue').dataTable().api().draw();
					}else if(data.trim() == 'update'){
						$('#modal-large').delay(1000).modal('hide');
						showSuccessMsg('Succesfully Updated');
						$('#grid_venue').dataTable().api().draw();
					}else{
						showErrorMsg('Ops! Something went wrong');
					}
				}
			});
			
		},
		rules: {
			area: {
				required: true,
				remote: {
			        url: CI.base_url+"company_management/check_area_exist",
			        type: "get",
			        data: {
						area: function() {
							return $( "#area" ).val();
						},
						id: function() {
							return $( "#id" ).val();
						},
						company_id: function() {
							return $( "#company_id" ).val();
						},
			        }
			      }
			},
			area_code: {
				required: true,
				remote: {
			        url: CI.base_url+"company_management/check_area_code_exist",
			        type: "get",
			        data: {
						area_code: function() {
							return $( "#area_code" ).val();
						},
						id: function() {
							return $( "#id" ).val();
						},
						company_id: function() {
							return $( "#company_id" ).val();
						},
			        }
			      }
			},
			company_id: {
				required: true,
			},
		},
		messages: {
			company_id: {
				required : "Please select a compnay",
			},
			area : {
				required : "Please enter an area",
				remote: jQuery.validator.format("{0} is already in use")
			},
			area_code : {
				required : "Please enter an area code.",
				remote: jQuery.validator.format("{0} is already in use")
			}
		}
	});

	$("#add_room_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_room_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						$('#modal-default').delay(1000).modal('hide');
						$("#add_room_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
						$('#grid_room').dataTable().api().draw();
					}else if(data.trim() == 'update'){
						$('#modal-default').delay(1000).modal('hide');
						$("#add_room_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
						$('#grid_room').dataTable().api().draw();
					}else{
						showErrorMsg('Ops! Something went wrong');
						$("#add_room_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			company_id: {
				required: true,
			},
			venue_id: {
				required: true,
			},
			room_no: {
				required: true,
				remote: {
			        url: CI.base_url+"company_management/check_room_no_exist",
			        type: "get",
			        data: {
						room_no: function() {
							return $( "#room_no" ).val();
						},
						id: function() {
							return $( "#id" ).val();
						},
						company_id: function() {
							return $( "#company_id" ).val();
						},
			        }
			      }
			},
			room_size : {
				required : true,
			},
			inside_of : {
				required : function(element){
		            return $("#room_size").val() =="2";
		        }
			}
		},
		messages: {
			company_id: {
				required : "Please select a compnay",
			},
			venue_id: {
				required : "Please select a venue",
			},
			room_no: {
				required : "Please Enter a Room no",
				remote: jQuery.validator.format("{0} is already in use")
			},
			room_size : {
				required : "Please select a Room Size",
			},
			inside_of : {
				required : "Please select a Inside of"
			}
		}
	});

	$("#add_course_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_course_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'course_management'; }, 1000);
						$("#add_course_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
					}else if(data.trim() == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'course_management'; }, 1000);
						$("#add_course_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
						$("#add_course_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			company_id : {
				required : true,
			},
			course_title: {
				required: true,
				remote: {
			        url: CI.base_url+"course_management/check_course_exist",
			        type: "get",
			        data: {
						course_title: function() {
							return $( "#course_title" ).val();
						},
						id: function() {
							return $( "#id" ).val();
						},
			        }
			      }
			},
			course_fees :
			{
				required : true,
			},
			course_code: {
				required: true,
			},
			total_days: {
				required: true,
			},
			total_hr: {
				required: true,
			},
			course_type: {
				required: true,
			},
			prerequisite: {
				required: true,
			},
			organization_develops_the_course: {
				required: true,
			},
			organization_awards_qualification: {
				required: true,
			},
			name_of_award: {
				required: true,
			},
			

			attendance_passing: {
				required: true,
			},
			passing_mark: {
				required: true,
			},
			color_code: {
				required: true,
			},
			max_class_size: {
				required: true,
			},
			min_class_size: {
				required: true,
			},
			course_img: {
				extension: "png|jpe?g|gif|bmp",
			    filesize: 1024288,
			},
			'course_trainer[]':{
				required: true,
			},
			'course_trainer_preference[]':{
				required: true,
			}
		},
		messages: {
			course_fees : {
				required : "Please enter a course fees",
			},
			company_id : {
				required : "Please select a company",
			},
			course_title : {
				required : "Please enter a course title",
				remote: jQuery.validator.format("{0} is already in use")
			},
			course_code : {
				required : "Please enter a course code",
			},
			total_days : {
				required : "Please enter a total Days",
			},
			total_hr : {
				required : "Please enter a total hours",
			},
			course_type : {
				required : "Please select a course type",
			},
			prerequisite : {
				required : "Please select a prerequisite",
			},
			organization_develops_the_course : {
				required : "Please select a Organization Develop The Course",
			},
			organization_awards_qualification : {
				required : "Please select a Organization Awards the Qualification ",
			},
			name_of_award : {
				required : "Please select a Name of Award",
			},
			
			attendance_passing : {
				required : "Please enter a attendance passing",
			},
			passing_mark : {
				required : "Please enter a prssing mark",
			},
			color_code : {
				required : "Please select a color code",
			},
			max_class_size : {
				required : "Please set a maximun class size",
			},
			min_class_size : {
				required : "Please set a minimum class size",
			},
			course_img : {
				extension: "Please File must be JPG, GIF ,BMP or PNG",

			},
			'course_trainer[]':{
				required : "Please select Trainer",
			},
			'course_trainer_preference[]':{
				required : "Please enter Preference",
			}
		},

		errorPlacement: function(error, element) {
			if (element.attr("type") == "radio" && element.attr("name")=="course_type") {
				error.insertAfter("#course_type_error");
			}else if (element.attr("type") == "radio" && element.attr("name")=="prerequisite") {
				error.insertAfter("#prerequisite_error");
			} else {
				error.insertAfter(element);
			}
			
		}
	});

	
	
		$("#add_long_course_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_long_course_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'long_course_management'; }, 1000);
						$("#add_long_course_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
					}else if(data.trim() == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'long_course_management'; }, 1000);
						$("#add_long_course_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
						$("#add_long_course_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			company_id : {
				required : true,
			},
			course_title: {
				required: true,
				remote: {
			        url: CI.base_url+"long_course_management/check_course_exist",
			        type: "get",
			        data: {
						course_title: function() {
							return $( "#course_title" ).val();
						},
						id: function() {
							return $( "#id" ).val();
						},
			        }
			      }
			},
			course_fees :
			{
				required : true,
			},
			course_code: {
				required: true,
			},
			course_type: {
				required: true,
			},
			organization_develops_the_course: {
				required: true,
			},
			organization_awards_qualification: {
				required: true,
			},
			name_of_award: {
				required: true,
			},
			

			attendance_passing: {
				required: true,
			},
			passing_mark: {
				required: true,
			},
			color_code: {
				required: true,
			},
			max_class_size: {
				required: true,
			},
			min_class_size: {
				required: true,
			},
			course_img: {
				extension: "png|jpe?g|gif|bmp",
			    filesize: 1024288,
			},
			'short_module_ids[]': {
				required: true,
			},
		},
		messages: {
			course_fees : {
				required : "Please enter a course fees",
			},
			company_id : {
				required : "Please select a company",
			},
			course_title : {
				required : "Please enter a course title",
				remote: jQuery.validator.format("{0} is already in use")
			},
			course_code : {
				required : "Please enter a course code",
			},
			course_type : {
				required : "Please select a course type",
			},
			organization_develops_the_course : {
				required : "Please select a Organization Develop The Course",
			},
			organization_awards_qualification : {
				required : "Please select a Organization Awards the Qualification ",
			},
			name_of_award : {
				required : "Please select a Name of Award",
			},
			
			attendance_passing : {
				required : "Please enter a attendance passing",
			},
			passing_mark : {
				required : "Please enter a prssing mark",
			},
			color_code : {
				required : "Please select a color code",
			},
			max_class_size : {
				required : "Please set a maximun class size",
			},
			min_class_size : {
				required : "Please set a minimum class size",
			},
			course_img : {
				extension: "Please File must be JPG, GIF ,BMP or PNG",

			},
			'short_module_ids[]': {
				required : "Please select Short/Module Courses Taught",
			},
		},

		errorPlacement: function(error, element) {
			if (element.attr("type") == "radio") {
				error.insertAfter("#course_type_error");
			} else {
				error.insertAfter(element);
			}
			
		}
	});
	
	
	$("#add_module_course_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_module_course_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'module_course_management'; }, 1000);
						$("#add_module_course_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
					}else if(data.trim() == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'module_course_management'; }, 1000);
						$("#add_module_course_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
						$("#add_module_course_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			company_id : {
				required : true,
			},
			course_title: {
				required: true,
				remote: {
			        url: CI.base_url+"module_course_management/check_course_exist",
			        type: "get",
			        data: {
						course_title: function() {
							return $( "#course_title" ).val();
						},
						id: function() {
							return $( "#id" ).val();
						},
			        }
			      }
			},
			course_fees :
			{
				required : true,
			},
			course_code: {
				required: true,
			},
			course_type: {
				required: true,
			},
			organization_develops_the_course: {
				required: true,
			},
			organization_awards_qualification: {
				required: true,
			},
			name_of_award: {
				required: true,
			},
			

			attendance_passing: {
				required: true,
			},
			passing_mark: {
				required: true,
			},
			color_code: {
				required: true,
			},
			total_days: {
				required: true,
			},
			total_hr: {
				required: true,
			},
			max_class_size: {
				required: true,
			},
			min_class_size: {
				required: true,
			},
			course_img: {
				extension: "png|jpe?g|gif|bmp",
			    filesize: 1024288,
			},
			'course_trainer[]':{
				required: true,
			},
			'course_trainer_preference[]':{
				required: true,
			},
		},
		messages: {
			course_fees : {
				required : "Please enter a course fees",
			},
			company_id : {
				required : "Please select a company",
			},
			course_title : {
				required : "Please enter a course title",
				remote: jQuery.validator.format("{0} is already in use")
			},
			course_code : {
				required : "Please enter a course code",
			},
			total_days : {
				required : "Please enter a total Days",
			},
			total_hr : {
				required : "Please enter a total hours",
			},
			course_type : {
				required : "Please select a course type",
			},
			organization_develops_the_course : {
				required : "Please select a Organization Develop The Course",
			},
			organization_awards_qualification : {
				required : "Please select a Organization Awards the Qualification ",
			},
			name_of_award : {
				required : "Please select a Name of Award",
			},
			
			attendance_passing : {
				required : "Please enter a attendance passing",
			},
			passing_mark : {
				required : "Please enter a prssing mark",
			},
			color_code : {
				required : "Please select a color code",
			},
			max_class_size : {
				required : "Please set a maximun class size",
			},
			min_class_size : {
				required : "Please set a minimum class size",
			},
			course_img : {
				extension: "Please File must be JPG, GIF ,BMP or PNG",

			},
			'course_trainer[]':{
				required : "Please select Trainer",
			},
			'course_trainer_preference[]':{
				required : "Please enter Preference",
			},
		},

		errorPlacement: function(error, element) {
			if (element.attr("type") == "radio") {
				error.insertAfter("#course_type_error");
			} else {
				error.insertAfter(element);
			}
			
		}
	});
	
	
	$("#add_cadet_plus_course_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_cadet_plus_course_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'cadet_plus_course_management'; }, 1000);
						$("#add_cadet_plus_course_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
					}else if(data.trim() == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'cadet_plus_course_management'; }, 1000);
						$("#add_cadet_plus_course_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
						$("#add_cadet_plus_course_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			company_id : {
				required : true,
			},
			course_title: {
				required: true,
				remote: {
			        url: CI.base_url+"cadet_plus_course_management/check_course_exist",
			        type: "get",
			        data: {
						course_title: function() {
							return $( "#course_title" ).val();
						},
						id: function() {
							return $( "#id" ).val();
						},
			        }
			      }
			},
			course_fees :
			{
				required : true,
			},
			course_code: {
				required: true,
			},
			color_code: {
				required: true,
			}
		},
		messages: {
			course_fees : {
				required : "Please enter a course fees",
			},
			company_id : {
				required : "Please select a company",
			},
			course_title : {
				required : "Please enter a course title",
				remote: jQuery.validator.format("{0} is already in use")
			},
			course_code : {
				required : "Please enter a course code",
			},
			color_code : {
				required : "Please select a color code",
			},
		},

		errorPlacement: function(error, element) {
			if (element.attr("type") == "radio") {
				error.insertAfter("#course_type_error");
			} else {
				error.insertAfter(element);
			}
			
		}
	});

	$("#add_cadet_plus_student_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_cadet_plus_student_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'cadet_plus_course_management/course_schedule'; }, 1000);
						$("#add_cadet_plus_student_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
					}else if(data.trim() == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'cadet_plus_course_management/course_schedule'; }, 1000);
						$("#add_cadet_plus_student_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
						$("#add_cadet_plus_student_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			company_id : {
				required : true,
			},
			course_title: {
				required: true,
			},
			course_schedule_id :
			{
				required : true,
			},
			name: {
				required: true,
			},
			contact_no: {
				required: true,
			},
			dob : {
				required: true,
			},
			email : {
				required: true,
				email: true,
				remote: {
			        url: CI.base_url+"cadet_plus_course_management/check_student_exist",
			        type: "get",
			        data: {
						id: function() {
							return $( "#id" ).val();
						},
						email: function() {
							return $( "#email" ).val();
						},
			        }
			      }
			},
			nationality : {
				required: true,
			}
		},
		messages: {
			company_id : {
				required : "Please Select a Company",
			},
			course_title : {
				required : "Please Enter a Course",
			},
			course_schedule_id : {
				required : "Please Select a Intake No ",
			},
			name : {
				required : "Please enter a Name",
			},
			contact_no : {
				required : "Please Enter a Contact No",
			},
			dob : {
				required : "Please Enter a Date Of Birth",
			},
			email : {
				required : "Please Enter a Email Address",
				remote: jQuery.validator.format("{0} is already in use")
			},
			nationality : {
				required : "Please Select a Nationality",
			}
		},

		errorPlacement: function(error, element) {
			if (element.attr("type") == "radio") {
				error.insertAfter("#course_type_error");
			} else {
				error.insertAfter(element);
			}
			
		}
	});

	$("#add_seminar_student_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_seminar_student_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'seminar_course_management/course_schedule'; }, 1000);
						$("#add_seminar_student_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
					}else if(data.trim() == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'seminar_course_management/course_schedule'; }, 1000);
						$("#add_seminar_student_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
						$("#add_seminar_student_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			company_id : {
				required : true,
			},
			course_title: {
				required: true,
			},
			course_schedule_id :
			{
				required : true,
			},
			name: {
				required: true,
			},
			contact_no: {
				required: true,
			},
			email : {
				required: true,
				email: true,
				remote: {
			        url: CI.base_url+"cadet_plus_course_management/check_student_exist",
			        type: "get",
			        data: {
						id: function() {
							return $( "#id" ).val();
						},
						email: function() {
							return $( "#email" ).val();
						},
			        }
			      }
			},
			nationality : {
				required: true,
			}
		},
		messages: {
			company_id : {
				required : "Please Select a Company",
			},
			course_title : {
				required : "Please Enter a Course",
			},
			course_schedule_id : {
				required : "Please Select a Intake No ",
			},
			name : {
				required : "Please enter a Name",
			},
			contact_no : {
				required : "Please Enter a Contact No",
			},
			email : {
				required : "Please Enter a Email Address",
				remote: jQuery.validator.format("{0} is already in use")
			},
			nationality : {
				required : "Please Select a Nationality",
			}
		},

		errorPlacement: function(error, element) {
			if (element.attr("type") == "radio") {
				error.insertAfter("#course_type_error");
			} else {
				error.insertAfter(element);
			}
			
		}
	});

	var csv_master_id = $('#csv_master_id').val();
	$("#add_cadet_plus_csv_student_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_cadet_plus_student_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'cadet_plus_course_management/import_student_csv_data/'+csv_master_id; }, 1000);
						$("#add_cadet_plus_student_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
					}else if(data.trim() == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'cadet_plus_course_management/import_student_csv_data/'+csv_master_id; }, 1000);
						$("#add_cadet_plus_student_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
						$("#add_cadet_plus_student_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			company_id : {
				required : true,
			},
			course_title: {
				required: true,
			},
			course_schedule_id :
			{
				required : true,
			},
			name: {
				required: true,
			},
			contact_no: {
				required: true,
			},
			email : {
				required: true,
				email: true,
				remote: {
			        url: CI.base_url+"cadet_plus_course_management/check_csv_student_exist",
			        type: "get",
			        data: {
						id: function() {
							return $( "#id" ).val();
						},
						csv_master_id: function() {
							return csv_master_id;
						},
						email: function() {
							return $( "#email" ).val();
						},
			        }
			      }
			},
			nationality : {
				required: true,
			}
		},
		messages: {
			company_id : {
				required : "Please Select a Company",
			},
			course_title : {
				required : "Please Enter a Course",
			},
			course_schedule_id : {
				required : "Please Select a Intake No ",
			},
			name : {
				required : "Please enter a Name",
			},
			contact_no : {
				required : "Please Enter a Contact No",
			},
			email : {
				required : "Please Enter a Email Address",
				remote: jQuery.validator.format("{0} is already in use")
			},
			nationality : {
				required : "Please Select a Nationality",
			}
		},

		errorPlacement: function(error, element) {
			if (element.attr("type") == "radio") {
				error.insertAfter("#course_type_error");
			} else {
				error.insertAfter(element);
			}
			
		}
	});

	
	
	$("#add_long_course_form_datatable").validate({
		submitHandler: function(form) {

			if($("#min_class_size").val() > $("#max_class_size").val())
			{
				$("#course_type_error").html('Please select Min class size value lesser than Max class size');
				return false;
			}

			$("#add_long_course_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'long_course_management'; }, 1000);
						$("#add_long_course_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
					}else if(data.trim() == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'long_course_management'; }, 1000);
						$("#add_long_course_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
						$("#add_long_course_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			company_id : {
				required : true,
			},
			course_title: {
				required: true,
				remote: {
			        url: CI.base_url+"long_course_management/check_course_exist",
			        type: "get",
			        data: {
						course_title: function() {
							return $( "#course_title" ).val();
						},
						id: function() {
							return $( "#id" ).val();
						},
			        }
			      }
			},
			
			course_code: {
				required: true,
			},
			
			organization_develops_the_course: {
				required: true,
			},
			organization_awards_qualification: {
				required: true,
			},
			name_of_award: {
				required: true,
			},
			attendance_passing: {
				required: true,
				number: true,
			},
			passing_mark: {
				required: true,
				number: true,
			},
			color_code: {
				required: true,
			},
			max_class_size: {
				required: true,
				number: true,
			},
			min_class_size: {
				required: true,
				number: true,
			},
			course_img: {
				extension: "png|jpe?g|gif|bmp",
			    filesize: 1024288,
			},
		},
		messages: {
			
			company_id : {
				required : "Please select a company",
			},
			course_title : {
				required : "Please enter a course title",
				remote: jQuery.validator.format("{0} is already in use")
			},
			course_code : {
				required : "Please enter a course code",
			},
			organization_develops_the_course : {
				required : "Please select a Organization Develop The Course",
			},
			organization_awards_qualification : {
				required : "Please select a Organization Awards the Qualification ",
			},
			name_of_award : {
				required : "Please select a Name of Award",
			},
			
			attendance_passing : {
				required : "Please enter a valid attendance passing",
				number : "Please enter a valid number",
			},
			passing_mark : {
				required : "Please enter a valid passing mark",
				number : "Please enter a valid number",
			},
			color_code : {
				required : "Please select a color code",
			},
			max_class_size : {
				required : "Please set a valid maximun class size",
				number : "Please enter a valid number",
			},
			min_class_size : {
				required : "Please set a valid minimum class size",
				number : "Please enter a valid number",
			},
			course_img : {
				extension: "Please File must be JPG, GIF ,BMP or PNG",

			}
		},

		errorPlacement: function(error, element) {
			if (element.attr("type") == "radio") {
				error.insertAfter("#course_type_error");
			} else {
				error.insertAfter(element);
			}
			
		}
	});

	$("#add_courselog_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_courselog_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'course_management'; }, 1000);
						$("#add_courselog_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
					}else if(data.trim() == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'course_management'; }, 1000);
						$("#add_courselog_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
						$("#add_courselog_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			company_id : {
				required : true,
			},
			course_title: {
				required: true,
				
			},
			course_fees :
			{
				required : true,
			},
			course_code: {
				required: true,
			},
			total_days: {
				required: true,
			},
			total_hr: {
				required: true,
			},
			course_type: {
				required: true,
			},
			prerequisite: {
				required: true,
			},
			organization_develops_the_course: {
				required: true,
			},
			organization_awards_qualification: {
				required: true,
			},
			name_of_award: {
				required: true,
			},
			attendance_passing: {
				required: true,
			},
			passing_mark: {
				required: true,
			},
			color_code: {
				required: true,
			},
			max_class_size: {
				required: true,
			},
			min_class_size: {
				required: true,
			},
			course_img: {
				extension: "png|jpe?g|gif|bmp",
			    filesize: 1024288,
			},
			'course_trainer[]':{
				required: true,
			},
			'course_trainer_preference[]':{
				required: true,
			},
		},
		messages: {
			course_fees : {
				required : "Please enter a course fees",
			},
			company_id : {
				required : "Please select a company",
			},
			course_title : {
				required : "Please enter a course title",
			},
			course_code : {
				required : "Please enter a course code",
			},
			total_days : {
				required : "Please enter a total Days",
			},
			total_hr : {
				required : "Please enter a total hours",
			},
			course_type : {
				required : "Please select a course type",
			},
			prerequisite : {
				required : "Please select a prerequisite",
			},
			organization_develops_the_course : {
				required : "Please select a Organization Develop The Course",
			},
			organization_awards_qualification : {
				required : "Please select a Organization Awards the Qualification ",
			},
			name_of_award : {
				required : "Please select a Name of Award",
			},
			
			attendance_passing : {
				required : "Please enter a attendance passing",
			},
			passing_mark : {
				required : "Please enter a prssing mark",
			},
			color_code : {
				required : "Please select a color code",
			},
			max_class_size : {
				required : "Please set a maximun class size",
			},
			min_class_size : {
				required : "Please set a minimum class size",
			},
			course_img : {
				extension: "Please File must be JPG, GIF ,BMP or PNG",

			},
			'course_trainer[]':{
				required : "Please select Trainer",
			},
			'course_trainer_preference[]':{
				required : "Please enter Preference",
			}
		},

		errorPlacement: function(error, element) {
			if (element.attr("type") == "radio" && element.attr("name")=="course_type") {
				error.insertAfter("#course_type_error");
			}else if (element.attr("type") == "radio" && element.attr("name")=="prerequisite") {
				error.insertAfter("#prerequisite_error");
			} else {
				error.insertAfter(element);
			}
			
		}
	});
	
	$("#add_long_courselog_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_long_courselog_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'long_course_management'; }, 1000);
						$("#add_long_courselog_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
					}else if(data.trim() == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'long_course_management'; }, 1000);
						$("#add_long_courselog_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
						$("#add_long_courselog_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			company_id : {
				required : true,
			},
			course_title: {
				required: true,
				
			},
			course_fees :
			{
				required : true,
			},
			course_code: {
				required: true,
			},
			total_days: {
				required: true,
			},
			total_hr: {
				required: true,
			},
			course_type: {
				required: true,
			},
			organization_develops_the_course: {
				required: true,
			},
			organization_awards_qualification: {
				required: true,
			},
			name_of_award: {
				required: true,
			},
			

			attendance_passing: {
				required: true,
			},
			passing_mark: {
				required: true,
			},
			color_code: {
				required: true,
			},
			max_class_size: {
				required: true,
			},
			min_class_size: {
				required: true,
			},
			course_img: {
				extension: "png|jpe?g|gif|bmp",
			    filesize: 1024288,
			},
			'short_module_ids[]':{
				required: true,
			},
		},
		messages: {
			course_fees : {
				required : "Please enter a course fees",
			},
			company_id : {
				required : "Please select a company",
			},
			course_title : {
				required : "Please enter a course title",
			},
			course_code : {
				required : "Please enter a course code",
			},
			total_days : {
				required : "Please enter a total Days",
			},
			total_hr : {
				required : "Please enter a total hours",
			},
			course_type : {
				required : "Please select a course type",
			},
			organization_develops_the_course : {
				required : "Please select a Organization Develop The Course",
			},
			organization_awards_qualification : {
				required : "Please select a Organization Awards the Qualification ",
			},
			name_of_award : {
				required : "Please select a Name of Award",
			},
			
			attendance_passing : {
				required : "Please enter a attendance passing",
			},
			passing_mark : {
				required : "Please enter a prssing mark",
			},
			color_code : {
				required : "Please select a color code",
			},
			max_class_size : {
				required : "Please set a maximun class size",
			},
			min_class_size : {
				required : "Please set a minimum class size",
			},
			course_img : {
				extension: "Please File must be JPG, GIF ,BMP or PNG",

			},
			'short_module_ids[]':{
				required : "Please select Short/Module Courses Taught",
			},
		},

		errorPlacement: function(error, element) {
			if (element.attr("type") == "radio" && element.attr("name")=="course_type") {
				error.insertAfter("#course_type_error");
			}else if (element.attr("type") == "radio" && element.attr("name")=="prerequisite") {
				error.insertAfter("#prerequisite_error");
			} else {
				error.insertAfter(element);
			}
			
		}
	});
	
	
	$("#add_module_courselog_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_module_courselog_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'module_course_management'; }, 1000);
						$("#add_module_courselog_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
					}else if(data.trim() == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'module_course_management'; }, 1000);
						$("#add_module_courselog_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
						$("#add_module_courselog_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			company_id : {
				required : true,
			},
			course_title: {
				required: true,
				
			},
			course_fees :
			{
				required : true,
			},
			course_code: {
				required: true,
			},
			total_days: {
				required: true,
			},
			total_hr: {
				required: true,
			},
			total_days: {
				required: true,
			},
			total_hr: {
				required: true,
			},
			course_type: {
				required: true,
			},
			organization_develops_the_course: {
				required: true,
			},
			organization_awards_qualification: {
				required: true,
			},
			name_of_award: {
				required: true,
			},
			

			attendance_passing: {
				required: true,
			},
			passing_mark: {
				required: true,
			},
			color_code: {
				required: true,
			},
			max_class_size: {
				required: true,
			},
			min_class_size: {
				required: true,
			},
			course_img: {
				extension: "png|jpe?g|gif|bmp",
			    filesize: 1024288,
			},
			'course_trainer[]':{
				required: true,
			},
			'course_trainer_preference[]':{
				required: true,
			},
		},
		messages: {
			course_fees : {
				required : "Please enter a course fees",
			},
			company_id : {
				required : "Please select a company",
			},
			course_title : {
				required : "Please enter a course title",
			},
			course_code : {
				required : "Please enter a course code",
			},
			total_days : {
				required : "Please enter a total Days",
			},
			total_hr : {
				required : "Please enter a total hours",
			},
			course_type : {
				required : "Please select a course type",
			},
			organization_develops_the_course : {
				required : "Please select a Organization Develop The Course",
			},
			organization_awards_qualification : {
				required : "Please select a Organization Awards the Qualification ",
			},
			name_of_award : {
				required : "Please select a Name of Award",
			},
			
			attendance_passing : {
				required : "Please enter a attendance passing",
			},
			passing_mark : {
				required : "Please enter a prssing mark",
			},
			color_code : {
				required : "Please select a color code",
			},
			max_class_size : {
				required : "Please set a maximun class size",
			},
			min_class_size : {
				required : "Please set a minimum class size",
			},
			course_img : {
				extension: "Please File must be JPG, GIF ,BMP or PNG",

			},
			'course_trainer[]':{
				required : "Please select Trainer",
			},
			'course_trainer_preference[]':{
				required : "Please enter Preference",
			},
		},

		errorPlacement: function(error, element) {
			if (element.attr("type") == "radio") {
				error.insertAfter("#course_type_error");
			} else {
				error.insertAfter(element);
			}
			
		}
	});

	$("#add_cadet_plus_course_log_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_cadet_plus_course_log_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'cadet_plus_course_management'; }, 1000);
						$("#add_cadet_plus_course_log_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
					}else if(data.trim() == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'cadet_plus_course_management'; }, 1000);
						$("#add_cadet_plus_course_log_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
						$("#add_cadet_plus_course_log_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			company_id : {
				required : true,
			},
			course_title: {
				required: true,
			},
			course_fees :
			{
				required : true,
			},
			course_code: {
				required: true,
			},
			color_code: {
				required: true,
			},
		},
		messages: {
			course_fees : {
				required : "Please enter a course fees",
			},
			company_id : {
				required : "Please select a company",
			},
			course_title : {
				required : "Please enter a course title",
			},
			course_code : {
				required : "Please enter a course code",
			},
			color_code : {
				required : "Please select a color code",
			},
		},

		errorPlacement: function(error, element) {
			if (element.attr("type") == "radio") {
				error.insertAfter("#course_type_error");
			} else {
				error.insertAfter(element);
			}
			
		}
	});

	$("#add_long_courselog_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_long_courselog_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'long_course_management'; }, 1000);
						$("#add_long_courselog_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
					}else if(data.trim() == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'long_course_management'; }, 1000);
						$("#add_long_courselog_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
						$("#add_long_courselog_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			company_id : {
				required : true,
			},
			course_title: {
				required: true,
				
			},
			course_code: {
				required: true,
			},
			organization_develops_the_course: {
				required: true,
			},
			organization_awards_qualification: {
				required: true,
			},
			name_of_award: {
				required: true,
			},
			attendance_passing: {
				required: true,
				number: true,
			},
			passing_mark: {
				required: true,
				number: true,
			},
			color_code: {
				required: true,
			},
			max_class_size: {
				required: true,
				number: true,
			},
			min_class_size: {
				required: true,
				number: true,
			},
			course_img: {
				extension: "png|jpe?g|gif|bmp",
			    filesize: 1024288,
			},
		},
		messages: {
			course_fees : {
				required : "Please enter a course fees",
			},
			company_id : {
				required : "Please select a company",
			},
			course_title : {
				required : "Please enter a course title",
			},
			course_code : {
				required : "Please enter a course code",
			},
			organization_develops_the_course : {
				required : "Please select a Organization Develop The Course",
			},
			organization_awards_qualification : {
				required : "Please select a Organization Awards the Qualification ",
			},
			name_of_award : {
				required : "Please select a Name of Award",
			},
			attendance_passing : {
				required : "Please enter a valid  attendance passing",
				number : "Please enter a valid number",
			},
			passing_mark : {
				required : "Please enter a valid  passing mark",
				number : "Please enter a valid number",
			},
			color_code : {
				required : "Please select a color code",
			},
			max_class_size : {
				required : "Please set a valid maximun class size",
				number : "Please enter a valid number",
			},
			min_class_size : {
				required : "Please set a valid minimum class size",
				number : "Please enter a valid number",
			},
			course_img : {
				extension: "Please File must be JPG, GIF ,BMP or PNG",

			}
		},

		errorPlacement: function(error, element) {
			if (element.attr("type") == "radio") {
				error.insertAfter("#course_type_error");
			} else {
				error.insertAfter(element);
			}
			
		}
	});

	$("#add_seminar_course_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_seminar_course_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'seminar_course_management'; }, 1000);
						$("#add_seminar_course_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
					}else if(data.trim() == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'seminar_course_management'; }, 1000);
						$("#add_seminar_course_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
						$("#add_seminar_course_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			company_id : {
				required : true,
			},
			course_name: {
				required: true,
				remote: {
			        url: CI.base_url+"seminar_course_management/check_seminar_course_exist",
			        type: "get",
			        data: {
						course_name: function() {
							return $( "#course_name" ).val();
						},
						id: function() {
							return $( "#id" ).val();
						},
			        }
			      }
			},
			course_code: {
				required: true,
			},
			
			color_code: {
				required: true,
			},
			description: {
				required: true,
			},
		},
		messages: {
			course_fees : {
				required : "Please enter a course fees",
			},
			company_id : {
				required : "Please select a company",
			},
			course_name : {
				required : "Please enter a course title",
				remote: jQuery.validator.format("{0} is already in use")
			},
			course_code : {
				required : "Please enter a course code",
			},
			color_code : {
				required : "Please select a color code",
			},
			description: {
				required: "Please enter a description",
			},
		},

		errorPlacement: function(error, element) {
			if (element.attr("type") == "radio") {
				error.insertAfter("#course_type_error");
			} else {
				error.insertAfter(element);
			}
			
		}
	});

	$("#add_seminar_courselog_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_seminar_courselog_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'seminar_course_management'; }, 1000);
						$("#add_seminar_courselog_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
					}else if(data.trim() == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'seminar_course_management'; }, 1000);
						$("#add_seminar_courselog_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
						$("#add_seminar_courselog_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			company_id : {
				required : true,
			},
			course_name: {
				required: true,
				
			},
			course_code: {
				required: true,
			},
			
			color_code: {
				required: true,
			},
			description: {
				required: true,
			},
		},
		messages: {
			course_fees : {
				required : "Please enter a course fees",
			},
			company_id : {
				required : "Please select a company",
			},
			course_name : {
				required : "Please enter a course title",
			},
			course_code : {
				required : "Please enter a course code",
			},
			color_code : {
				required : "Please select a color code",
			},
			description: {
				required: "Please enter a description",
			},
		},

		errorPlacement: function(error, element) {
			if (element.attr("type") == "radio") {
				error.insertAfter("#course_type_error");
			} else {
				error.insertAfter(element);
			}
			
		}
	});

	$("#add_evaluation_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_evaluation_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'evaluation'; }, 1000);
						$("#add_evaluation_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
					}else if(data.trim() == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'evaluation'; }, 1000);
						$("#add_evaluation_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
						$("#add_evaluation_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			evaluation_type : {
				required : true,
			},
			question: {
				required: true,
				
			},
			start_range: {
				required: true,
			},
			
			end_range: {
				required: true,
			},
			
		},
		messages: {
			evaluation_type : {
				required : "Please select a Evaluation Type",
			},
			question : {
				required : "Please enter a Question",
			},
			start_range : {
				required : "Please enter a Start Range",
			},
			end_range : {
				required : "Please enter a End Range",
			},
			
		},

		errorPlacement: function(error, element) {
			if (element.attr("type") == "radio") {
				error.insertAfter("#course_type_error");
			} else {
				error.insertAfter(element);
			}
			
		}
	});

	$("#add_evaluation_detail_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_evaluation_detail_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'evaluation/evaluation_form'; }, 1000);
						$("#add_evaluation_detail_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
					}else if(data.trim() == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'evaluation/evaluation_form'; }, 1000);
						$("#add_evaluation_detail_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
						$("#add_evaluation_detail_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			form_code : {
				required : true,
			},
			form_name: {
				required: true,
				
			},
			start_range: {
				required: true,
			},
			
			end_range: {
				required: true,
			},
			
		},
		messages: {
			form_code : {
				required : "Please Enter a Form Code",
			},
			form_name : {
				required : "Please enter a Form Name",
			},
			start_range : {
				required : "Please enter a Start Range",
			},
			end_range : {
				required : "Please enter a End Range",
			},
			
		},

		errorPlacement: function(error, element) {
			if (element.attr("type") == "radio") {
				error.insertAfter("#course_type_error");
			} else {
				error.insertAfter(element);
			}
			
		}
	});

var portal_user_id = $('#portal_user_id').val();
var student_id = $('#user_id').val();
var user_id = $('#id').val();
var csv_master_id = $("#csv_master_id").val();


$.validator.addMethod('filesize', function (value, element, param) {
    return this.optional(element) || (element.files[0].size <= param)
}, 'File size is too large');


	$("#add_user_form_datatable").validate({
		submitHandler: function(form) {
			$("#user_submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						$('#modal-default').delay(1000).modal('hide');
						$("#user_submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Saved');
						parent.reload_datatable();
					}else if(data.trim() == 'update'){
						$('#modal-default').delay(1000).modal('hide');
						$("#user_submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
						parent.reload_datatable();
					}else{
						showErrorMsg(data);
						$("#user_submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			user_roll_id: {
				comboboxNotNone: true
			},
			first_name:{				
				required:true
			},
			last_name:{				
				required:true
			},
			email:{				
				required:true,
				email :true,
				remote: {
			        url: CI.base_url+"list_user/check_register_email_ajax",
			        type: "get",
			        data: {
			          email: function() {
			           	if ($("#u_id").val() !== '') {
				            return false;
				        } else {
				            return $( "#email" ).val();
				        }
			          }
			        }
			      }
			},
			username:{				
				required:true,
				remote: {
			        url: CI.base_url+"list_user/check_register_username_ajax",
			        type: "get",
			        data: {
			          username: function() {
			           	if ($("#u_id").val() !== '') {
				            return false;
				        } else {
				            return $( "#reg_username" ).val();
				        }	
			          }
			        }
			      }
			},	
			contact_number_1: {
				number:true,
				maxlength:8,
				minlength:8,
			},		
			password:{				
				required:true,
				minlength : 8,
			},
			password_confirm: {
				required:true,
				equalTo: "#reg_password"
			}
		},
		messages: {
			user_roll_id: "Please select role",
			first_name: "Please enter  first name",
			last_name: "Please enter  last name",
			email: {
				required :  "Please Enter  Email",
				email : "Please Enter Valid Email",
				remote: jQuery.validator.format("{0} is already in use")
			},
			username: {
				required : "Please enter username",
				remote: jQuery.validator.format("{0} is already in use")
			}, 
			contact_number_1: {
				number:"Please Enter Numbers Only",
				maxlength:"Please Enter maximun 8 Number",
				minlength:"Please Enter minimum 8 Number",
			},	
			password:{
				required :"Please enter password",
				minlength : "Password Minimum 8 Character"
				
			},
			password_confirm:{
				required :"Please enter Confrim password",
				equalTo : "Password Not Match"
			} 
		}
	});

	
	$("#system_config_form_datatable").validate({
		submitHandler: function(form) {
			$("#system_config_submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'Success'){
						$("#system_config_submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
					}else{
						showErrorMsg('Ops! Something went wrong');
						$("#system_config_submit").removeAttr('disabled','disabled');
					}
				}
			});
		},
		rules: {
			paypal_mail: {
				required: true
			},
			sender_email: {
				required: true
			},
			receiver_email: {
				required: true
			},
			cancellation_fees: {
				required: true
			},
			paypal_processing_fees: {
				required: true
			},
			subsidy_claim_reminder_days: {
				required: true
			},
			name: {
				required: true
			},
			address: {
				required: true
			},
			email: {
				required: true,
				email : true,
			},
		},
		messages: {
			paypal_mail: "Please enter Paypal Email.",
			sender_email: "Please enter Sender Email.",
			receiver_email: "Please enter Receiver Email.",
			cancellation_fees: "Please enter Refund Fees.",
			paypal_processing_fees: "Please enter Paypal Processing Fees.",
			subsidy_claim_reminder_days: "Please enter Subsidy Claim Reminder Days.",
			name: "Please enter name.",
			address: "Please enter address.",
			email : {
				required : "Please Enter a Email",
				email : "Please Enter a Valid Email",
			},
		}
	});

	$("#add_schedule_form_datatable").validate({
		submitHandler: function(form) {
			$("#submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					$("#submit").removeAttr('disabled','disabled');
					if(data.trim() == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'course_management/course_schedule'; }, 1000);
						showSuccessMsg('Succesfully Save');
					}else if(data.trim() == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'course_management/course_schedule'; }, 1000);
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
					}
				}
			});
			
		},
		rules: {
			company_id : {
				required : true,
			},
			course_id: {
				required: true
			},
			language_id :
			{
				required : true,
			},
			venue_id :
			{
				required : true,
			},
			student_limit :
			{
				required : true,
			},
			course_schedule_status : {
				required: true,
			},
		},
		messages: {
			
			room_id : {
				required : "Please select a Room No",
			}
		},
	});

	$("#add_seminar_schedule_form_datatable").validate({
		submitHandler: function(form) {
			$("#submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					$("#submit").removeAttr('disabled','disabled');
					if(data.trim() == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'seminar_course_management/course_schedule'; }, 1000);
						showSuccessMsg('Succesfully Save');
					}else if(data.trim() == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'seminar_course_management/course_schedule'; }, 1000);
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
					}
				}
			});
			
		},
		rules: {
			company_id : {
				required : true,
			},
			course_id: {
				required: true
			},
			language_id :
			{
				required : true,
			},
			
			student_limit :
			{
				required : true,
			},
			course_schedule_status : {
				required: true,
			},
		},
		messages: {
			
			room_id : {
				required : "Please select a Room No",
			}
		},
	});

	$("#add_cadet_plus_course_schedule_form_datatable").validate({
		submitHandler: function(form) {
			$("#submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					$("#submit").removeAttr('disabled','disabled');
					if(data.trim() == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'cadet_plus_course_management/course_schedule'; }, 1000);
						showSuccessMsg('Succesfully Save');
					}else if(data.trim() == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'cadet_plus_course_management/course_schedule'; }, 1000);
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
					}
				}
			});
			
		},
		rules: {
			company_id : {
				required : true,
			},
			course_id: {
				required: true
			},
			min_student :
			{
				required : true,
			},
			max_student :
			{
				required : true,
			},
			course_schedule_status : {
				required: true,
			},
		},
		messages: {
			company_id : {
				required : "Please select a Organization",
			},
			course_id : {
				required : "Please select a Course",
			},
			min_student : {
				required : "Please Enter a Min Student",
			},
			max_student : {
				required : "Please Enter a Max Student",
			},
			course_schedule_status : {
				required: "Please Select a Course Schedule Status",
			},
		},
	});

	$("#add_staff_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_staff_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'staff_management'; }, 1000);
						$("#add_staff_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
					}else if(data == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'staff_management'; }, 1000);
						$("#add_staff_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
						$("#add_staff_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			company_id : {
				required : true,

			},
			user_roll_id : {
				required : true,
			},
			staff_name : {
				required : true,
				remote: {
			        url: CI.base_url+"staff_management/check_staff_ajax",
			        type: "get",
			        data: {
			          staff_name: function() {
			           	if ($("#id").val() !== '') {
				            return false;
				        } else {
				            return $( "#staff_name" ).val();
				        }
			          }
			        }
			      }
			},
			email: {
				required: true,
				email:true,
				remote: {
			        url: CI.base_url+"staff_management/check_email_ajax",
			        type: "get",
			        data: {
			          email: function() {
			           	if ($("#id").val() !== '') {
				            return false;
				        } else {
				            return $( "#email" ).val();
				        }
			          }
			        }
			      }
			},
			mobile_no :
			{
				required : true,
				number:true,
				maxlength:8,
				minlength:8,
				remote: {
			        url: CI.base_url+"staff_management/check_mobile_ajax",
			        type: "get",
			        data: {
			          mobile_no: function() {
			           	if ($("#id").val() !== '') {
			           		return false;
				        } else {
				            return $( "#mobile_no" ).val();
				        }
			          }
			        }
			      }
			},
			password: {
				required: true,
				minlength : 8,
			},
			confirm_password : {
				minlength : 8,
                equalTo : "#password"
			},
			id_type: {
				required: true,
			},
			
			nric: {
				required: true,
				remote: {
			        url: CI.base_url+"staff_management/check_nric_ajax",
			        type: "get",
			        data: {
			          nric: function() {
			           	if ($("#id").val() !== '') {
				            return false;
				        } else {
				        	var nric = $( "#nric" ).val();
							return nric;
		             	}
			          },
			          id_type: function() {
			           	if ($("#id").val() !== '') {
				            return false;
				        } else {
				        	var id_type = $( "#id_type" ).val();
							return id_type;
		             	}
			          }
			          
			        }
			      }
			},
			citizen: {
				required: true,
			},
			full_part_time: {
				required: true,
			},
			dob :{
				required : true,
			},
			address :{
				required : true,
			},
			postal_code :{
				required : true,
			},
			register_date :{
				required : true,
			},
			salary :{
				required : true,
			},
			employment_status :{
				required : true,
			},
			
			
		},
		messages: {
			company_id : {
				required : "Please Select a Organization",
			},
			user_roll_id : {
				required : "Please Select a User Role",
			},
			staff_name : {
				required : "Please Enter a Staff Name",
				remote: jQuery.validator.format("{0} is already in use")
			},
			email : {
				required : "Please Enter a Email",
				email : "Please Enter a Valid Email",
				remote: jQuery.validator.format("{0} is already in use")
			},
			mobile_no : {
				required : "Please Enter a mobile Number",
				number:"Please Enter Numbers Only",
				maxlength:"Please Enter maximun 8 Number",
				minlength:"Please Enter minimum 8 Number",
				remote: jQuery.validator.format("{0} is already in use")
			},
			password:
			{
				required :"Please enter password",
				minlength : "Password Minimum 8 Character",
			},
			confirm_password : 
			{
				required : "Please Enter a Confrim Password",
				equalTo : "Password Not a Match",
			},
			id_type : {
				required : "Please Select a Id Type",
			},
			nric : {
				required : "Please Enter a Id No",
				remote: jQuery.validator.format("{0} is already in use")
			},
			citizen : {
				required : "Please Select a Citizenship",
			},
			full_part_time : {
				required : "Please Select a Full/Part Time",
			},
			dob : {
				required : "Please Enter a Date Of Birth",
			},
			address : {
				required : "Please Enter a Address",
			},
			postal_code : {
				required : "Please Enter a Postal Code",
			},
			register_date : {
				required : "Please Enter a Register Date",
			},
			
			salary : {
				required : "Please Enter a Salary",
			},
			employment_status : {
				required : "Please Select a Employment Status",
			},

		},
		errorPlacement: function(error, element) {
			if (element.attr("type") == "radio") {
				error.insertAfter("#citizen_detail");
			} else {
				error.insertAfter(element);
			}
			
		}
	});
	$("#add_language_datatable").validate({
		submitHandler: function(form) {
			$("#lang_submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == ''){
						$('#modal-default').delay(1000).modal('hide');
						$("#lang_submit").removeAttr('disabled','disabled');
						showSuccessMsg('Data saved succesfully');
						parent.reload_datatable();
					}else{
						showErrorMsg('Ops! Something went wrong');
						$("#lang_submit").removeAttr('disabled','disabled');
					}
				}
			});
		},
		rules: {
			english: {
				required: true
			},
			chinese: {
				required: true
			},
			thai: {
				required: true
			},
			vietnamese: {
				required: true
			},
			filipino: {
				required: true
			},
			burmese: {
				required: true
			}
		},
		messages: {
			english: "Please enter english text.",
			chinese: "Please enter chinese text.",
			thai: "Please enter thai text.",
			vietnamese: "Please enter vietnamese text.",
			filipino: "Please enter filipino text.",
			burmese: "Please enter burmese text."
		}
	});

	$("#add_revision_datatable").validate({
		submitHandler: function(form) {
			$("#lang_submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == ''){
						$('#modal-default').delay(1000).modal('hide');
						$("#lang_submit").removeAttr('disabled','disabled');
						showSuccessMsg('Data saved succesfully');
						parent.reload_datatable();
					}else{
						showErrorMsg(data);
						$("#lang_submit").removeAttr('disabled','disabled');
					}
				}
			});
		},
		rules: {
			revision_document: {
				required: true
			},
			approved_date_of_course_revision: {
				required: true
			},
		},
		messages: {
			revision_document: "Please Select a Pdf file.",
			approved_date_of_course_revision  : "Please Select a Approved Date Of Course Revision.",
		}
	});

	var trainer_id = $('#user_id').val();
	var trainer = $('#id').val();
	$("#add_trainer_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_trainer_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'trainer_management'; }, 1000);
						$("#add_trainer_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
					}else if(data == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'trainer_management'; }, 1000);
						$("#add_trainer_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
						$("#add_trainer_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			trainer_name : {
				required : true,
			},
			email: {
				required: true,
				email:true,
				remote: {
			        url: CI.base_url+"trainer_management/check_email_ajax",
			        type: "get",
			        data:{
				          email: function() {
					           return $("#email").val();
				          },
				          	id : trainer_id,
			        	}
			        }
			},
			mobile_no :
			{
				required : true,
				number:true,
				maxlength:8,
				minlength:8,
				remote: {
			        url: CI.base_url+"trainer_management/check_mobile_ajax",
			        type: "get",
			        data:{
				          mobile_no: function() {
					           return $("#mobile_no").val();
				          },
				          	id : trainer,
			        	}
			        }
			},
			password: {
				required: true,
				minlength : 8,
			},
			confirm_password : {
				minlength : 8,
                equalTo : "#password"
			},
			id_type: {
				required: true,
			},
			
			nric: {
				required: true,
				remote: {
			        url: CI.base_url+"trainer_management/check_nric_ajax",
			        type: "get",
			        data: {
			          nric: function() {
			           	if ($("#id").val() !== '') {
				            return false;
				        } else {
				        	var nric = $("#nric").val();
							return nric;
		             	}
			          },
			          id_type: function() {
			           	if ($("#id").val() !== '') {
				            return false;
				        } else {
				        	var id_type = $( "#id_type" ).val();
							return id_type;
		             	}
			          }
			          
			        }
			      }
			},
			citizen: {
				required: true,
			},
			
			current_salary: {
				required: true,
			},
			
			dob :{
				required : true,
			},
			address :{
				required : true,
			},
			postal_code :{
				required : true,
			},
			register_date :{
				required : true,
			},

			"resume_cv[]" : 
			{
				
				// required: function(element) {
				//     if ($("#resume_cv_count").val() > 0) {
				//             return false;
				//         } else {
				//             return true;
				//         }
				//     },
				extension: "gif|jpg|png|jpeg|txt|zip|xls|pdf|doc|docx|csv",
				filesize: 2048576,
			},
			"wsq_specialist_diploma_in_wsh[]" :
			{
				   // required: function(element) {
				   //  if ($("#wsq_specialist_diploma_in_wsh_count").val() > 0) {
				   //          return false;
				   //      } else {
				   //          return true;
				   //      }
				   //  },
				   extension: "gif|jpg|png|jpeg|txt|zip|xls|pdf|doc|docx|csv",
				   filesize: 2048576,
			},
			"wsq_advance_certificate_in_wsh[]": 
			{
				// required: function(element) {
				//     if ($("#wsq_advance_certificate_in_wsh_count").val() > 0) {
				//             return false;
				//         } else {
				//             return true;
				//         }
				//     },
				extension: "gif|jpg|png|jpeg|txt|zip|xls|pdf|doc|docx|csv",
				filesize: 2048576,
			},
			"acta_certificate[]": 
			{
				// required: function(element) {
				//     if ($("#acta_certificate_count").val() > 0) {
				//             return false;
				//         } else {
				//             return true;
				//         }
				//     },
				extension: "gif|jpg|png|jpeg|txt|zip|xls|pdf|doc|docx|csv",
				filesize: 2048576,
			},
			"code_of_ethics[]": 
			{
				// required: function(element) {
				//     if ($("#code_of_ethics_count").val() > 0) {
				//             return false;
				//         } else {
				//             return true;
				//         }
				//     },
				extension: "gif|jpg|png|jpeg|txt|zip|xls|pdf|doc|docx|csv",
				filesize: 2048576,
			},
			
		},
		messages: {
			trainer_name : {
				required : "Please Enter a Trainer Name",
			},
			email : {
				required : "Please Enter a Email",
				email : "Please Enter a Valid Email",
				remote: jQuery.validator.format("{0} is already in use")
			},
			mobile_no : {
				required : "Please Enter a mobile Number",
				number:"Please Enter Numbers Only",
				maxlength:"Please Enter maximun 8 Number",
				minlength:"Please Enter minimum 8 Number",
				remote: jQuery.validator.format("{0} is already in use")
			},
			password:
			{
				required :"Please enter password",
				minlength : "Password Minimum 8 Character",
			},
			confirm_password : 
			{
				required : "Please Enter a Confrim Password",
				equalTo : "Password Not a Match",
			},
			id_type : {
				required : "Please Select a Id Type",
				remote: jQuery.validator.format("{0} is already in use")
			},
			nric : {
				required : "Please Enter a Id No",
				remote: jQuery.validator.format("{0} is already in use")
			},
			citizen : {
				required : "Please Select a Citizenship",
			},
			current_salary: {
				required: "Please Enter a Current Salary",
			},
			
			dob : {
				required : "Please Enter a Date Of Birth",
			},
			address : {
				required : "Please Enter a Address",
			},
			postal_code : {
				required : "Please Enter a Postal Code",
			},
			register_date : {
				required : "Please Enter a Register Date",
			},
			
			
			resume_cv :
			{
				extension: "File must be gif,jpg,png,jpeg,txt,zip,xls,pdf,doc,docx,csv",
			},
			wsq_specialist_diploma_in_wsh :
			{
				extension: "File must be gif,jpg,png,jpeg,txt,zip,xls,pdf,doc,docx,csv",
			},
			wsq_advance_certificate_in_wsh :
			{
				extension: "File must be gif,jpg,png,jpeg,txt,zip,xls,pdf,doc,docx,csv",
			},
			acta_certificate :
			{
				extension: "File must be gif,jpg,png,jpeg,txt,zip,xls,pdf,doc,docx,csv",
			},
			code_of_ethics :
			{
				extension: "File must be gif,jpg,png,jpeg,txt,zip,xls,pdf,doc,docx,csv",
			},
			
			
			
		},
		errorPlacement: function(error, element) {
			if (element.attr("type") == "radio") {
				error.insertAfter("#citizen_detail");
			} else {
				error.insertAfter(element);
			}
			
		}
	});
$("#add_assessment_type_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_assessment_type_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						$('#modal-default').delay(1000).modal('hide');
						$("#add_assessment_type_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
						$('#grid_assessment_type').dataTable().api().draw();
					}else if(data.trim() == 'update'){
						$('#modal-default').delay(1000).modal('hide');
						$("#add_assessment_type_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
						$('#grid_assessment_type').dataTable().api().draw();
					}else{
						showErrorMsg('Ops! Something went wrong');
						$("#add_assessment_type_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			assessment_type_name: {
				required: true,
				remote: {
			        url: CI.base_url+"assessment_type/check_assessment_type_name_exist",
			        type: "get",
			        data: {
						assessment_type_name: function() {
							return $( "#assessment_type_name").val();
						},
						id: function() {
							return $( "#id" ).val();
						},
			        }
			      }
			},
		},
		messages: {
			company_name: {
				required : "Please enter Assessment Type Name",
				remote: jQuery.validator.format("{0} is already in use")
			}
		}
	});
	$("#add_course_fees_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_course_fees_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						$('#modal-default').delay(1000).modal('hide');
						$("#add_course_fees_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
						$('#grid_course_fees').dataTable().api().draw();
					}else if(data.trim() == 'update'){
						$('#modal-default').delay(1000).modal('hide');
						$("#add_course_fees_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
						$('#grid_course_fees').dataTable().api().draw();
					}else{
						showErrorMsg('Ops! Something went wrong');
						$("#add_course_fees_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			course_fees: {
				required: true,
			},
			effective_date: {
				required: true,
			},
		},
		messages: {
			course_fees : {
				required : "Please enter a course fees",
			},
			effective_date : {
				required : "Please select an effective date",
			}
		}
	});
	$("#add_seminar_course_fees_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_seminar_course_fees_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						$('#modal-default').delay(1000).modal('hide');
						$("#add_seminar_course_fees_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
						$('#grid_seminar_course_fees').dataTable().api().draw();
					}else if(data.trim() == 'update'){
						$('#modal-default').delay(1000).modal('hide');
						$("#add_seminar_course_fees_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
						$('#grid_seminar_course_fees').dataTable().api().draw();
					}else{
						showErrorMsg('Ops! Something went wrong');
						$("#add_seminar_course_fees_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			course_fees: {
				required: true,
			},
			effective_date: {
				required: true,
			},
		},
		messages: {
			course_fees : {
				required : "Please enter a course fees",
			},
			effective_date : {
				required : "Please select an effective date",
			}
		}
	});
	
	$("#add_long_course_fees_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_long_course_fees_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						$('#modal-default').delay(1000).modal('hide');
						$("#add_long_course_fees_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
						$('#grid_course_fees').dataTable().api().draw();
					}else if(data.trim() == 'update'){
						$('#modal-default').delay(1000).modal('hide');
						$("#add_long_course_fees_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
						$('#grid_course_fees').dataTable().api().draw();
					}else{
						showErrorMsg('Ops! Something went wrong');
						$("#add_long_course_fees_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			course_fees: {
				required: true,
			},
			effective_date: {
				required: true,
			},
		},
		messages: {
			course_fees : {
				required : "Please enter a course fees",
			},
			effective_date : {
				required : "Please select an effective date",
			}
		}
	});
	
	$("#add_module_course_fees_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_module_course_fees_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						$('#modal-default').delay(1000).modal('hide');
						$("#add_module_course_fees_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
						$('#grid_course_fees').dataTable().api().draw();
					}else if(data.trim() == 'update'){
						$('#modal-default').delay(1000).modal('hide');
						$("#add_module_course_fees_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
						$('#grid_course_fees').dataTable().api().draw();
					}else{
						showErrorMsg('Ops! Something went wrong');
						$("#add_long_course_fees_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			course_fees: {
				required: true,
			},
			effective_date: {
				required: true,
			},
		},
		messages: {
			course_fees : {
				required : "Please enter a course fees",
			},
			effective_date : {
				required : "Please select an effective date",
			}
		}
	});

	$("#add_cadet_plus_course_fees_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_cadet_plus_course_fees_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						$('#modal-default').delay(1000).modal('hide');
						$("#add_cadet_plus_course_fees_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
						$('#grid_course_fees').dataTable().api().draw();
					}else if(data.trim() == 'update'){
						$('#modal-default').delay(1000).modal('hide');
						$("#add_cadet_plus_course_fees_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
						$('#grid_course_fees').dataTable().api().draw();
					}else{
						showErrorMsg('Ops! Something went wrong');
						$("#add_cadet_plus_course_fees_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			course_fees: {
				required: true,
			},
			effective_date: {
				required: true,
			},
		},
		messages: {
			course_fees : {
				required : "Please enter a course fees",
			},
			effective_date : {
				required : "Please select an effective date",
			}
		}
	});
	var stu_id = $('#student_id').val();
	$("#add_student_form_datatable").validate({
		submitHandler: function(form) {
			$("#submit").attr('disabled','disabled');
			var Type_validation = $('#Type_validation').val();
			
			var multi_chk_error = false;
			
			var multi_chk_error_course_schedule_id_p = false;
			
			if(Type_validation=='T')
			{
				$('#add_student_form_datatable select[name="course_schedule_id_p[]"]').each(function() {
	        
	              if($(this).val() == "")
	                {
	                    multi_chk_error = true;
	                    multi_chk_error_course_schedule_id_p = true;
	                }
	        	});
			}
			
	        if(multi_chk_error == true && multi_chk_error_course_schedule_id_p == true){
	        	showErrorMsg('Please Select a Practical Date');
	        }
			if(multi_chk_error == false) {
			    $("#add_student_form_datatable #submit").attr('disabled','disabled');
				jQuery(form).ajaxSubmit({
					success: function(data){
						$("#add_student_form_datatable #submit").removeAttr('disabled','disabled');
						if(data == 'insert'){
							setTimeout(function(){ window.location.href =  base_url + 'student_management'; }, 1000);
							showSuccessMsg('Succesfully Save');
						}else if(data == 'update'){
							setTimeout(function(){ window.location.href =  base_url + 'student_management'; }, 1000);
							showSuccessMsg('Succesfully Updated');
						}else{
							showErrorMsg(data);
						}
					}
				});
			}
		},
		rules: {
			company_id :
			{
				required : true,
			},
			type : {
				required : true,
			},
			course_id: {
				required: true,
			},
			language_id :
			{
				required : true,
			},
			venue_id: {
				required: true,
			},
			course_schedule_id: {
				required: true,
			},
			'nric[]': {
				remote: {
			        url: CI.base_url+"student_management/check_nric_ajax",
			        type: "get",
			        data: {
			          	nric: function() {
		          			return $( "#nric" ).val();
		          		},
			          	id_type: function() {
		          			return $( "#id_type" ).val();
			          	},
			          	student_type: function() {
		          			return $( "#student_type" ).val();
			          	},
			          	id : stu_id,
			        }
			      }
			},
			'id_type[]': {
				required: true,
				remote: {
			        url: CI.base_url+"student_management/check_nric_ajax",
			        type: "get",
			        data: {
			        	id_type: function() {
			        		return $( "#id_type" ).val();
			          	},
			          	nric: function() {
		          			return $( "#nric" ).val();
			          	},
			          	student_type: function() {
		          			return $( "#student_type" ).val();
			          	},
			          	id : stu_id,
			        }
			      }
			},
			'name[]': {
				required: true,
			},
			'dob[]': {
				required: true,
			},
			'course_schedule_id_p[]': {
				required: true,
			},
			'photo[]' :{
				
				extension: "png|jpe?g|gif",
			},
			/*'nric_front[]' : 
			{
				
				extension: "png|jpe?g|gif",
			},
			'nric_back[]' : 
			{
			   
			   extension: "png|jpe?g|gif",
			},*/
			
			
			'email[]': {
				required: function() {
					return $('.student_type').val() == '1';
		        },
				email : true,
				// remote: {
			 //        url: CI.base_url+"general/check_register_email_ajax_admin",
			 //        type: "get",
			 //        data: {
			 //          	email: function() {
			 //          	return $( "#email" ).val();
			 //           },
			 //           	student_type: function() {
			 //          		return $( "#student_type" ).val();
				        
			 //          	},
			 //          id : stu_id,
			 //        }
			 //      }
			},
			'mobile[]': {
				required: function() {
		          return $('.student_type').val() == '1';
		        },
				remote: {
			        url: CI.base_url+"student_management/check_mobile_ajax",
			        type: "get",
			        data:{
			          	mobile_no: function() {
				           return $("#mobile_no").val();
			          	},
			          	id : stu_id,
		        	}
		        }
			},
			'password[]' :
			{
				minlength : 8,
			},
			'confirm_password[]' :
			{
			    equalTo :"#password",
			},
			
		},
		messages: {
			company_id : 
			{
				required: "Please Select a Organization",
			},
			type : {
				required : "Please Select a Student Type",
			},
			course_id : {
				required : "Please Select a Course",
			},
			language_id : {
				required : "Please Select a language",
			},
			venue_id : {
				required : "Please Select a Vanue",
			},
			course_schedule_id : {
				required : "Please Select a Commencement Date",
			},
			
			'photo[]' :
			{
				extension: "Please File must be JPG, GIF or PNG",
			},
			/*'nric_front[]' : {
				extension: "Please File must be JPG, GIF or PNG",
			},
			'nric_back[]' : 
			{
				extension: "Please File must be JPG, GIF or PNG",
			},*/
			
			'email[]' : {
				required : "Please Enter a Email",
				email : "Please Enter a Valid Email",
				// remote: jQuery.validator.format("{0} is already in use")
				
			},
			'name[]' : {
				required : "Please Enter a Name",
			},
			'dob[]' : {
				required : "Please Select a Date of Birth",
			},
			'course_schedule_id_p[]' : {
				required : "Please Select Practical Date",
			},
			'nric[]' : {
				remote: jQuery.validator.format("{0} is already in use")
				
			},
			
			'mobile[]' : {
				required : "Please Enter a Mobile Number",
				remote: jQuery.validator.format("{0} is already in use")
				
			},
			'password[]' : 
			{
				minlength : "Please add Password Min 8 Character",
			},
			'confirm_password[]' : 
			{
				equalTo : "Password Not a Match",
			},
			'id_type[]' :{
				
				required: "Please Select ID no.",
				remote: jQuery.validator.format("{0} is already in use")
			},
			
		},
	});
	$("#edit_student_form_datatable").validate({
		submitHandler: function(form) {
			$("#edit_student_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'student_management'; }, 1000);
						$("#edit_student_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
					}else if(data == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'student_management'; }, 1000);
						$("#edit_student_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
						$("#edit_student_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			company_id :
			{
				required : true,
			},
			type : {
				required : true,
			},
			course_id: {
				required: true,
			},
			language_id :
			{
				required : true,
			},
			venue_id: {
				required: true,
			},
			course_schedule_id: {
				required: true,
			},
			'name[]' : {
				required : true,
			},
			'dob[]': {
				required: true,
			},
			'nric[]': {
				
				remote: {
			        url: CI.base_url+"student_management/check_nric_ajax",
			        type: "get",
			        data: {
			          	nric: function() {
			          	
				            return $( "#nric" ).val();
				        
			          	},
			          	id_type: function() {
			          	
				            return $( "#id_type" ).val();
				        
			          	},
			          	student_type: function() {
		          			return $( "#student_type" ).val();
			          	},
			          	id : stu_id,
			        }
			      }
			},
			'id_type[]': {
				required: true,
				remote: {
			        url: CI.base_url+"student_management/check_nric_ajax",
			        type: "get",
			        data: {
			        	id_type: function() {
			        		return $( "#id_type" ).val();
			          	},
			          	nric: function() {
		          			return $( "#nric" ).val();
			          	},
			          	student_type: function() {
		          			return $( "#student_type" ).val();
			          	},
			          	id : stu_id,
			        }
			      }
			},
			
			'photo[]' :{
				
				extension: "png|jpe?g|gif",
			},
			/*'nric_front[]' : 
			{
				
				extension: "png|jpe?g|gif",
			},
			'nric_back[]' : 
			{
			   
			   extension: "png|jpe?g|gif",
			},*/
			
			'mobile[]': {
				remote: {
			        url: CI.base_url+"student_management/check_mobile_ajax",
			        type: "get",
			        data:{
			          	mobile_no: function() {
				           return $("#mobile_no").val();
			          	},
			          	id : stu_id,
		        	}
		        }
			},
			'password[]' :
			{
				minlength : 8,
			},
			'confirm_password[]' :
			{
			    equalTo :"#password",
			},
			
			
		},
		messages: {
			company_id : 
			{
				required: "Please Select a Organization",
			},
			type : {
				required : "Please Select a Student Type",
			},
			course_id : {
				required : "Please Select a Course",
			},
			language_id : {
				required : "Please Select a language",
			},
			venue_id : {
				required : "Please Select a Vanue",
			},
			course_schedule_id : {
				required : "Please Select a Commencement Date",
			},
			'name[]' : {
				required : "Please Enter a Name",
			},
			'dob[]' : {
				required : "Please Select a Date of Birth",
			},
			'id_type[]' :
			{
				required: "Please select a ID No.",
				remote: jQuery.validator.format("{0} is already in use")
			},
			'photo[]' :
			{
				extension: "Please File must be JPG, GIF or PNG",
			},
			/*'nric_front[]' : {
				extension: "Please File must be JPG, GIF or PNG",
			},
			'nric_back[]' : 
			{
				extension: "Please File must be JPG, GIF or PNG",
			},*/
			
			'email[]' : {
				email : "Please Enter a Valid Email",
			},
			'nric[]' : {
				remote: jQuery.validator.format("{0} is already in use")
				
			},
			'mobile[]' : {
				remote: jQuery.validator.format("{0} is already in use")
				
			},
			'password[]' : 
			{
				minlength : "Please add Password Min 8 Character",
			},
			'confirm_password[]' : 
			{
				equalTo : "Password Not a Match",
			},
			
		},
	});

	

	$('#add_invoice_config').validate({
		submitHandler: function(form) {
			$("#add_invoice_config #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						$('#modal-default').delay(1000).modal('hide');
						parent.reload_datatable();
						showSuccessMsg('Succesfully Save');
					}else if(data.trim() == 'update'){
						parent.reload_datatable();
						$('#modal-default').delay(1000).modal('hide');
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
						$("#add_invoice_config #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			'approve_by[]' : {
				required : true,
			},
			min_amount: {
				required: true,
			},
		}
	});
		
});
function check_number_validation()
{
	var returnA = 1;
	var start_amount = $("#start_amount").val();
	var end_amount = $("#end_amount").val();
	var id = $("input[name=id]").val();
	var error = '';
	if(parseFloat(start_amount) > parseFloat(end_amount)) 
	{
		returnA = 0;
		error += "Please choose 'End Amount' greater than 'Start Amount' limit.";
	}
	if(parseFloat(start_amount) == parseFloat(end_amount))
	{
		returnA = 0;
		error += "Please choose different 'Start Amount' and 'End Amount'.";
	}
	if(error == '')
	{
		url = CI.base_url+"rewards/check_number_validation";
		$.ajax({
			url : url,
			type: "POST",
			data: {
				id: id,
				start_amount: start_amount,
				end_amount: end_amount,
			},
			async: false,
			success: function(data)
			{
				if(data=='recordfound')
				{
					returnA = 0;
					error = 'System already has a record within the Start and End Amount range.';
				}
			},
		});
	}
	if(returnA == 0)
	{
		$(".containerfdfdf1").show();
		$(".containerfdfdf1").html('<div class="alert alert-danger" role="alert"><button class="close" data-dismiss="alert"></button>'+error+'</div>');
		return false;
	}
	return true;
}

$("#add_lead_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_lead_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'lead_management'; }, 1000);
						$("#add_lead_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
					}else if(data == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'lead_management'; }, 1000);
						$("#add_lead_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
						$("#add_lead_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			company_id : {
				required : true,

			},
			lead_type : {
				required : true,

			},
			course_type : {
				required : true,

			},
			interested_course_id : {
				required : true,

			},
			course_topic : {
				required : true,

			},
			marketing_source : {
				required : true,

			},
			status : {
				required : true,

			},
			closing_rate : {
				required : true,
				number:true,

			},
			name : {
				required : true,
			},
			email: {
				required: true,
				email:true,
				remote: {
			        url: CI.base_url+"lead_management/check_email_ajax",
			        type: "get",
			        data: {
						id: function() {
							return $( "#id" ).val();
						},
						email: function() {
							return $( "#email" ).val();
						},
			        }
			      }
			},
			contact_number :
			{
				required : true,
				number:true,
			},			
			gender: {
				required: true,
			},
		},
		messages: {
			company_id : {
				required : "Please Select a Organization",
			},
			lead_type : {
				required : "Please Select a Lead Type",
			},
			course_type : {
				required : "Please Select a Course Type",
			},
			interested_course_id : {
				required : "Please Select a Interested Course",
			},
			course_topic : {
				required : "Please Select a Course Topic",
			},
			marketing_source : {
				required : "Please Select a Marketing Source",
			},
			status : {
				required : "Please Select a Status",
			},
			closing_rate : {
				required : "Please enter Closing Rate",
				number:"Please Enter Numbers Only",
			},
			name : {
				required : "Please Enter a Name",
			},
			email : {
				required : "Please Enter a Email",
				email : "Please Enter a Valid Email",
				remote: jQuery.validator.format("{0} is already in use")
			},
			contact_number : {
				required : "Please Enter a contact Number",
				number:"Please Enter Numbers Only",
			},
			gender : {
				required : "Please Select a Gender",
			},
		},
		errorPlacement: function(error, element) {
			if (element.attr("type") == "radio") {
				error.insertAfter("#gender_detail");
			} else {
				error.insertAfter(element);
			}
			
		}
	});

	$("#update_outcome_form_datatable").validate({
		submitHandler: function(form) {
			$("#update_outcome_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					var obj = jQuery.parseJSON(data);
					var action_id =  obj.action;
					var lead_id =  obj.id;
					if(data.trim() == 'insert'){
						$('#modal-large').delay(1000).modal('hide');
						$("#update_outcome_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
						$('#grid_lead').dataTable().api().draw();
					}
					else if(action_id == 'update'){
						$('#modal-large').delay(1000).modal('hide');
						$("#update_outcome_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
						$('#grid_lead').dataTable().api().draw();
					}
					else if(action_id == 'briefing'){
						$('#modal-large').delay(1000).modal('hide');
						setTimeout(function(){ window.location.href =  base_url + 'lead_management/briefing_schedules_list_for_stud/'+lead_id; }, 1000);
						$("#update_outcome_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
						$('#grid_briefing_schedule').dataTable().api().draw();
					}else{
						showErrorMsg('Ops! Something went wrong');
						$("#update_outcome_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			lead_status: {
				required: true,
			},
			outcome_remark: {
				required: true,
			},
		},
		messages: {
			lead_status: {
				required : "Please select a status",
			},
			outcome_remark: {
				required : "Please enter a remark",
			},
		}
	});

	$("#add_briefing_schedule_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_briefing_schedule_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'lead_management/briefing_schedules_list'; }, 1000);
						$("#add_briefing_schedule_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
					}else if(data.trim() == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'lead_management/briefing_schedules_list'; }, 1000);
						$("#add_briefing_schedule_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
						$('#grid_briefing_schedule').dataTable().api().draw();
					}else{
						showErrorMsg('Ops! Something went wrong');
						$("#add_briefing_schedule_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			/*class_size: {
				required:true,
				number:true,
			},*/
			date: {
				required:true,
			},
			company_id: {
				required:true,
			},
			trainer_id: {
				required:true,
			},
			venue_id: {
				required:true,
			},
			room_id: {
				required:true,
			},
		},
		messages: {
			/*class_size: {
				required:"Please enter class size",
				number:"Please Enter Numbers Only",
			},*/
			date: {
				required:"Please select date",
			},
			company_id: {
				required:"Please select a Organization",
			},
			trainer_id: {
				required:"Please select trainer",
			},
			venue_id: {
				required:"Please select a Venue",
			},
			room_id: {
				required:"Please select a Room",
			},
		}
	});

	$("#add_assessment_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_assessment_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'lead_management'; }, 1000);
						$("#add_assessment_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
					}else if(data.trim() == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'lead_management'; }, 1000);
						$("#add_assessment_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
						//$('#add_assessment_form_datatable').dataTable().api().draw();
					}else{
						showErrorMsg('Ops! Something went wrong');
						$("#add_assessment_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			moodle: {
				required:true,
				number:true,
			},
			entrance_test: {
				required:true,
				number:true,
			},
			SQI_psychometric_assessment: {
				required:true,
				number:true,
			},
			personality_style_assessment: {
				required:true,
				number:true,
			},
			interviewer1: {
				required:true,
			},
			interview_score1: {
				required:true,
				number:true,
			},
			/* recommended_course: {
				required:true,
			}, */
			status: {
				required:true,
			},
		},
		messages: {
			moodle: {
				required:"Please enter moodle marks",
				number:"Please Enter Numbers Only",
			},
			entrance_test: {
				required:"Please enter entrance test marks",
				number:"Please Enter Numbers Only",
			},
			SQI_psychometric_assessment: {
				required:"Please enter SQI psychometric assessment marks",
				number:"Please Enter Numbers Only",
			},
			personality_style_assessment: {
				required:"Please enter personality style assessment marks",
				number:"Please Enter Numbers Only",
			},
			interviewer1: {
				required:"Please select interviewer",
			},
			interview_score1: {
				required:"Please enter interview score",
				number:"Please Enter Numbers Only",
			},
			/* recommended_course: {
				required:"Please select recommended course",
			}, */
			status: {
				required:"Please select outcome",
			},
		}
	});

	$("#application_form_datatable").validate({
		submitHandler: function(form) {
			$("#application_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'lead_management'; }, 1000);
						$("#application_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
					}else if(data.trim() == 'update'){
						$('#modal-large').delay(1000).modal('hide');
						setTimeout(function(){ window.location.href =  base_url + 'lead_management'; }, 1000);
						$("#application_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
						$('#grid_lead').dataTable().api().draw();
					}else{
						showErrorMsg('Ops! Something went wrong');
						$("#application_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			username: {
				required:true,
			},
			password: {
				required:true,
			},
		},
		messages: {
			username: {
				required:"Please enter username",
			},
			password: {
				required:"Please enter password",
			},
		}
	});

	$("#register_form_datatable").validate({
		submitHandler: function(form) {
			$("#register_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'lead_management'; }, 1000);
						$("#register_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
					}else if(data.trim() == 'update'){
						$('#modal-large').delay(1000).modal('hide');
						//setTimeout(function(){ window.location.href =  base_url + 'lead_management'; }, 1000);
						$("#register_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
						$('#grid_lead').dataTable().api().draw();
					}else{
						showErrorMsg('Ops! Something went wrong');
						$("#application_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			username: {
				required:true,
			},
			password: {
				required:true,
			},
		},
		messages: {
			username: {
				required:"Please enter username",
			},
			password: {
				required:"Please enter password",
			},
		}
	});

$("#add_email_template_datatable").validate({
		submitHandler: function(form) {
			$("#add_email_template_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data =='update'){
						$('#modal-default').delay(1000).modal('hide');
						$("#add_email_template_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
						location.reload();
					}else{
						showErrorMsg('Ops! Something went wrong');
						$("#add_email_template_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		ignore:[],
		debug: false,
		rules: {
			subject: {
				required: true,
			},
			description:{
             	required: function() 
            	{
             		CKEDITOR.instances.description.updateElement();
            	},
                        }
		},
		messages: {
			subject : {
				required : "Please Select Subject",
			},
			description : {
				required : "Please Enter Description",
			}
		}
	});

$("#add_online_lead_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_online_lead_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'online_application/thankyou'; }, 1000);
						$("#add_online_lead_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('form has been successfully submitted');
					}else if(data == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'online_application/thankyou'; }, 1000);
						$("#add_online_lead_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
						$("#add_online_lead_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			name : {
				required : true,
			},
			email: {
				required: true,
				email:true,
				remote: {
			        url: CI.base_url+"online_application/check_email_ajax",
			        type: "get",
			        data: {
						id: function() {
							return $( "#id").val();
						},
						email: function() {
							return $( "#email").val();
						},
			        }
			      }
			},
			contact_number :
			{
				required : true,
				number:true,
			},			
		},
		messages: {
			name : {
				required : "Please Enter a Name",
			},
			email : {
				required : "Please Enter a Email",
				email : "Please Enter a Valid Email",
				remote: jQuery.validator.format("{0} is already in use")
			},
			contact_number : {
				required : "Please Enter a contact Number",
				number:"Please Enter Numbers Only",
			},
		},
	});

$("#add_module_schedule_form_datatable").validate({
		submitHandler: function(form) {
			$("#submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					$("#submit").removeAttr('disabled','disabled');
					if(data.trim() == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'module_course_management/module_course_schedule_list'; }, 1000);
						showSuccessMsg('Succesfully Save');
					}else if(data.trim() == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'module_course_management/module_course_schedule_list'; }, 1000);
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
					}
				}
			});
			
		},
		rules: {
			company_id : {
				required : true,
			},
			course_id: {
				required: true
			},
			language_id :
			{
				required : true,
			},
			venue_id :
			{
				required : true,
			},
			student_limit :
			{
				required : true,
			},
			course_schedule_status : {
				required: true,
			},
		},
		messages: {
			
			room_id : {
				required : "Please select a Room No",
			}
		},
	});
	
$("#add_module_course_cover_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_module_course_cover_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						$('#modal-default').delay(1000).modal('hide');
						$("#add_module_course_cover_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
						$('#grid_course_cover').dataTable().api().draw();
					}else if(data.trim() == 'update'){
						$('#modal-default').delay(1000).modal('hide');
						$("#add_module_course_cover_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
						$('#grid_course_cover').dataTable().api().draw();
					}else{
						showErrorMsg('Ops! Something went wrong');
						$("#add_module_course_cover_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		ignore:[],
		debug: false,
		rules: {
			cover_heading: {
				required: true,
			},
			course_cover_details: {
				required: function() 
            	{
             		CKEDITOR.instances.course_cover_details.updateElement();
            	},
			},
		},
		messages: {
			cover_heading : {
				required : "Please enter a  cover heading",
			},
			course_cover_details : {
				required : "Please enter a course cover details",
			},
		}
	});		

$("#add_seminar_csv_student_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_seminar_csv_student_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						setTimeout(function(){ window.location.href =  base_url + 'seminar_course_management/import_student_csv_data/'+csv_master_id; }, 1000);
						$("#add_seminar_csv_student_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
					}else if(data.trim() == 'update'){
						setTimeout(function(){ window.location.href =  base_url + 'seminar_course_management/import_student_csv_data/'+csv_master_id; }, 1000);
						$("#add_seminar_csv_student_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
					}else{
						showErrorMsg(data);
						$("#add_seminar_csv_student_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			company_id : {
				required : true,
			},
			course_title: {
				required: true,
			},
			course_schedule_id :
			{
				required : true,
			},
			name: {
				required: true,
			},
			contact_no: {
				required: true,
			},
			email : {
				required: true,
				email: true,
				remote: {
			        url: CI.base_url+"seminar_course_management/check_csv_student_exist",
			        type: "get",
			        data: {
						id: function() {
							return $( "#id" ).val();
						},
						csv_master_id: function() {
							return csv_master_id;
						},
						email: function() {
							return $( "#email" ).val();
						},
			        }
			      }
			},
			nationality : {
				required: true,
			}
		},
		messages: {
			company_id : {
				required : "Please Select a Company",
			},
			course_title : {
				required : "Please Enter a Course",
			},
			course_schedule_id : {
				required : "Please Select a Intake No ",
			},
			name : {
				required : "Please enter a Name",
			},
			contact_no : {
				required : "Please Enter a Contact No",
			},
			email : {
				required : "Please Enter a Email Address",
				remote: jQuery.validator.format("{0} is already in use")
			},
			nationality : {
				required : "Please Select a Nationality",
			}
		},

		errorPlacement: function(error, element) {
			if (element.attr("type") == "radio") {
				error.insertAfter("#course_type_error");
			} else {
				error.insertAfter(element);
			}
			
		}
	});
	
$("#add_long_course_phase_two_setting_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_long_course_phase_two_setting_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						$('#modal-default').delay(1000).modal('hide');
						$("#add_long_course_phase_two_setting_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
						$('#grid_course_phase_two_settings').dataTable().api().draw();
					}else if(data.trim() == 'update'){
						$('#modal-default').delay(1000).modal('hide');
						$("#add_long_course_phase_two_setting_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
						$('#grid_course_phase_two_settings').dataTable().api().draw();
					}else{
						showErrorMsg('Ops! Something went wrong');
						$("#add_long_course_phase_two_setting_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			no_of_day: {
				required: true,
			},
			effective_date: {
				required: true,
			},
		},
		messages: {
			no_of_day : {
				required : "Please enter No of Days",
			},
			effective_date : {
				required : "Please select an effective date",
			}
		}
	});	
	
	
	$("#add_long_course_revision_document_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_long_course_revision_document_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						$('#modal-default').delay(1000).modal('hide');
						$("#add_long_course_revision_document_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
						$('#grid_course').dataTable().api().draw();
					}else if(data.trim() == 'update'){
						$('#modal-default').delay(1000).modal('hide');
						$("#add_long_course_revision_document_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
						$('#grid_course').dataTable().api().draw();
					}else{
						showErrorMsg('Ops! Something went wrong');
						$("#add_long_course_revision_document_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			review_attachment: {
				extension: "doc|docx|pdf|xls|csv",
			    filesize: 1024288,
			},
			review_remark: {
				required: true,
			},
		},
		messages: {
			review_attachment : {
				extension: "Please File must be doc, docx ,pdf or xls",

			},
			review_remark : {
				required : "Please enter remark",
			}
		}
	});
	
	$("#add_module_course_revision_document_form_datatable").validate({
		submitHandler: function(form) {
			$("#add_module_course_revision_document_form_datatable #submit").attr('disabled','disabled');
			jQuery(form).ajaxSubmit({
				success: function(data){
					if(data.trim() == 'insert'){
						$('#modal-default').delay(1000).modal('hide');
						$("#add_module_course_revision_document_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Save');
						$('#grid_course').dataTable().api().draw();
					}else if(data.trim() == 'update'){
						$('#modal-default').delay(1000).modal('hide');
						$("#add_module_course_revision_document_form_datatable #submit").removeAttr('disabled','disabled');
						showSuccessMsg('Succesfully Updated');
						$('#grid_course').dataTable().api().draw();
					}else{
						showErrorMsg('Ops! Something went wrong');
						$("#add_module_course_revision_document_form_datatable #submit").removeAttr('disabled','disabled');
					}
				}
			});
			
		},
		rules: {
			review_attachment: {
				extension: "doc|docx|pdf|xls|csv",
			    filesize: 1024288,
			},
			review_remark: {
				required: true,
			},
		},
		messages: {
			review_attachment : {
				extension: "Please File must be doc, docx ,pdf or xls",

			},
			review_remark : {
				required : "Please enter remark",
			}
		}
	});