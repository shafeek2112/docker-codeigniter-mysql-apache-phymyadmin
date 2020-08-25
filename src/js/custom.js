var table_total_col = $('table.table thead tr').children().length;
$('body').on('hidden.bs.modal','#modal-default', function() {
	$(this).removeData('bs.modal');
	$(this).find('.modal-header').html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i></button><h5>Loading....</h5>');
	$(this).find('.modal-body').html('<div style="text-align:center;"><i class="fa fa-spinner fa fa-6x fa-spin" id="animate-icon"></i></div>');
	$(this).find('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
	$(this).find('.modal-content').html('');
});

$('body').on('hidden.bs.modal','#attendanceEditModal', function() {
	location.reload();
});

$('body').on('hidden.bs.modal','#modal-large', function() {
	$(this).removeData('bs.modal');
	$(this).find('.modal-header').html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i></button><h5>Loading....</h5>');
	$(this).find('.modal-body').html('<div style="text-align:center;"><i class="fa fa-spinner fa fa-6x fa-spin" id="animate-icon"></i></div>');
	$(this).find('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
	$(this).find('.modal-content').html('');
});

//************ if use 2 modal popup close secnod popup by class 'close_second_modal'  */
$(document).on('click','.close_second_modal',function(){
	$('#second-modal').delay(1000).modal('hide');
})


function student_checkbox_value($student_id){
	var student_id = $student_id;
	if($('.student_checkbox_'+student_id).is(":checked")) {
	   var message = [];
	    $('.student_checkbox_'+student_id+':checked').each(function(i){
	        if($('#student_ids').val() != ''){
		        message[i] = $('#student_ids').val() + "," + $('.student_checkbox_'+student_id).val();
		    }else{
		        message[i] = $(this).val();
		    }
	     });
	    $('#student_ids').attr("value",message);
	}
	if($('.student_checkbox_'+student_id).is(":unchecked")) {
   		var value = $('.student_checkbox_'+student_id).val();
   		var student_values =  $('#student_ids').val();
   		var separator = ",";
	  	var values = student_values.split(separator);
	  	for(var i = 0 ; i < values.length ; i++) {
		    if(values[i] == value) {
		      values.splice(i, 1);
		      var message = values.join(separator);
		    }
		} 
		$('#student_ids').attr("value",message);
	}
}



$(document).on('click','.class-attendance-get-students',function(){
	var class_detail_id = $(this).attr("data-class-id");
	var class_attendance_date = $(this).attr("data-attendance-date");
	var $csrf_token_id_value = $("#csrf_token_id").val();	
	var $this = $(this);
	
	$(".class-attendance-get-students").each(function() {
		var class_detail_id_new = $(this).attr("data-class-id");
		
		if(class_detail_id_new != class_detail_id){
			$(this).addClass("collapsed");
			$("#collapse"+class_detail_id_new).removeClass("in")
			
			$(this).find(".more-less").removeClass("glyphicon-minus")
			$(this).find(".more-less").addClass('glyphicon-plus ');
		}
	});
	
	$this.find(".more-less").toggleClass('glyphicon-plus glyphicon-minus');
	
	if($("#attendance-box-"+class_detail_id).html() == ""){
		$.ajax({
			type: "POST",
			url: CI.base_url+"attendance/get_student_list_by_class_detail_id/",
			data: { 
				class_detail_id:class_detail_id,
				class_attendance_date:class_attendance_date,
				u_token:$csrf_token_id_value
			},
			success: function(data) {
				$("#attendance-box-"+class_detail_id).html('Loading.......');
				$("#attendance-box-"+class_detail_id).html(data);
			}
		});
	}
})

$(document).on('click','.class-seminar_attendance-get-students',function(){
	var class_detail_id = $(this).attr("data-class-id");
	var class_attendance_date = $(this).attr("data-attendance-date");
	var $csrf_token_id_value = $("#csrf_token_id").val();	
	var $this = $(this);
	
	$(".class-seminar_attendance-get-students").each(function() {
		var class_detail_id_new = $(this).attr("data-class-id");
		
		if(class_detail_id_new != class_detail_id){
			$(this).addClass("collapsed");
			$("#collapse"+class_detail_id_new).removeClass("in")
			
			$(this).find(".more-less").removeClass("glyphicon-minus")
			$(this).find(".more-less").addClass('glyphicon-plus ');
		}
	});
	
	$this.find(".more-less").toggleClass('glyphicon-plus glyphicon-minus');
	
	if($("#attendance-box-"+class_detail_id).html() == ""){
		$.ajax({
			type: "POST",
			url: CI.base_url+"seminar_course_management/get_student_list_by_class_detail_id/",
			data: { 
				class_detail_id:class_detail_id,
				class_attendance_date:class_attendance_date,
				u_token:$csrf_token_id_value
			},
			success: function(data) {
				$("#attendance-box-"+class_detail_id).html('Loading.......');
				$("#attendance-box-"+class_detail_id).html(data);
			}
		});
	}
})

$(document).on('click','.add_attendance_submit',function(){
	var class_detail_id = $(this).attr("data-class-id");
	var $csrf_token_id_value = $("#csrf_token_id").val();
	var class_attendance_date = $("#attendance_date").val();
	
	$.ajax({
		type: "POST",
		url: CI.base_url+"attendance/add/",
		data: $("#add_attendance_form_"+class_detail_id).serialize(),
		success: function(data) {
			$.ajax({
				type: "POST",
				url: CI.base_url+"attendance/get_student_list_by_class_detail_id/",
				data: { 
					class_detail_id:class_detail_id,
					class_attendance_date:class_attendance_date,
					u_token:$csrf_token_id_value
				},
				success: function(data) {
					$("#attendance-box-"+class_detail_id).html('Loading.......');
					$("#attendance-box-"+class_detail_id).html(data);
				}
			});
			
			showSuccessMsg('Record sucessfully saved.');
		}
	});
})

$(document).on('click','.add_seminar_attendance_submit',function(){
	var class_detail_id = $(this).attr("data-class-id");
	var $csrf_token_id_value = $("#csrf_token_id").val();
	var class_attendance_date = $("#attendance_date").val();
	
	$.ajax({
		type: "POST",
		url: CI.base_url+"seminar_course_management/add_attendance/",
		data: $("#add_attendance_form_"+class_detail_id).serialize(),
		success: function(data) {
			$.ajax({
				type: "POST",
				url: CI.base_url+"seminar_course_management/get_student_list_by_class_detail_id/",
				data: { 
					class_detail_id:class_detail_id,
					class_attendance_date:class_attendance_date,
					u_token:$csrf_token_id_value
				},
				success: function(data) {
					$("#attendance-box-"+class_detail_id).html('Loading.......');
					$("#attendance-box-"+class_detail_id).html(data);
				}
			});
			
			showSuccessMsg('Record sucessfully saved.');
		}
	});
})

$(document).on('click','.btn-course-class',function(){
	var btn_data_class = $(this).attr("data-class");
	var btn_data_value = $(this).attr("data-value");
	
	if(btn_data_value == "Absent"){
		if(confirm("Are you sure want to mark absent?")){
			
		}
		else{
			return false;
		}
	}
	
	$(this).closest(".btn-class-group").find("#attendance_value").val(btn_data_value);
	
	$(this).closest(".btn-class-group").find(".btn-course-class").each(function() {
		var btn_data_class_old = $(this).attr("data-class");
		
		$(this).removeClass("btn-default");
		$(this).removeClass("btn-"+btn_data_class_old);
		
		if(btn_data_class_old == btn_data_class){
			$(this).addClass("btn-"+btn_data_class);
		}
		else{
			$(this).addClass("btn-default");
		}
	});
})



$(document).on('click','.btn-course-class',function(){
	var btn_data_class = $(this).attr("data-class");
	var btn_data_value = $(this).attr("data-value");
	
	$(this).closest(".btn-class-group").find("#attendance").val(btn_data_value);
	
	$(this).closest(".btn-class-group").find(".btn-course-class").each(function() {
		var btn_data_class_old = $(this).attr("data-class");
		
		$(this).removeClass("btn-default");
		$(this).removeClass("btn-"+btn_data_class_old);
		
		if(btn_data_class_old == btn_data_class){
			$(this).addClass("btn-"+btn_data_class);
		}
		else{
			$(this).addClass("btn-default");
		}
	});
})
$(document).on('click','.btn-att-class',function(){
	var btn_data_class = $(this).attr("data-class");
	var btn_data_value = $(this).attr("data-value");
	
	$(this).closest(".btn-class-group").find("#attendance_btn").val(btn_data_value);
	
	$(this).closest(".btn-class-group").find(".btn-att-class").each(function() {
		var btn_data_class_old = $(this).attr("data-class");
		
		$(this).removeClass("btn-default");
		$(this).removeClass("btn-"+btn_data_class_old);
		
		if(btn_data_class_old == btn_data_class){
			$(this).addClass("btn-"+btn_data_class);
		}
		else{
			$(this).addClass("btn-default");
		}
	});
})


//************ if use 2 modal popup reload first modal  */
$(document).on('click','.first_modal',function(){
	$('#first-modal').removeData('bs.modal');
	$('#first-modal').find('.modal-header').html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i></button><h5>Loading....</h5>');
	$('#first-modal').find('.modal-body').html('<div style="text-align:center;"><i class="fa fa-spinner fa fa-6x fa-spin" id="animate-icon"></i></div>');
	$('#first-modal').find('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
})
//************ if use 2 modal popup reload second modal  */
$(document).on('click','.close_second_modal',function(){
	$('#second-modal').removeData('bs.modal');
	$('#second-modal').find('.modal-header').html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i></button><h5>Loading....</h5>');
	$('#second-modal').find('.modal-body').html('<div style="text-align:center;"><i class="fa fa-spinner fa fa-6x fa-spin" id="animate-icon"></i></div>');
	$('#second-modal').find('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
})
function reload_datatable(){
	// alert(typeof(dTable));
	if(typeof dTable != 'undefined')
		dTable.fnStandingRedraw();
	if(typeof dTable_role != 'undefined')	
		dTable_role.fnStandingRedraw();
	if(typeof dTable_1 != 'undefined')	
		dTable_1.fnStandingRedraw();
	if(typeof dTable_p != 'undefined')	
		dTable_p.fnStandingRedraw();
	if(typeof dTable_contract != 'undefined')	
		dTable_contract.fnStandingRedraw();
	if(typeof dTable_sub_center != 'undefined')	
		dTable_sub_center.fnStandingRedraw();
	if(typeof dTable_currency_rounding != 'undefined')	
		dTable_currency_rounding.fnStandingRedraw();
	if(typeof dTable_taxtype != 'undefined')	
		dTable_taxtype.fnStandingRedraw();
	if(typeof dTable_term != 'undefined')	
		dTable_term.fnStandingRedraw();
	if(typeof dTable_highest_qualification != 'undefined')	
		dTable_highest_qualification.fnStandingRedraw();
	if(typeof dTable_retention_type != 'undefined')	
		dTable_retention_type.fnStandingRedraw();
	if(typeof dTable_sourcing_channel != 'undefined')	
		dTable_sourcing_channel.fnStandingRedraw();
	if(typeof dTable_teacher_type != 'undefined')	
		dTable_teacher_type.fnStandingRedraw();
	if(typeof dTable_absence_reason != 'undefined')	
		dTable_absence_reason.fnStandingRedraw();
	if(typeof dTable_student_reletion != 'undefined')	
		dTable_student_reletion.fnStandingRedraw();
	if(typeof dTable_student_siblings != 'undefined')	
		dTable_student_siblings.fnStandingRedraw();
	if(typeof dTable_marketing_source != 'undefined')	
		dTable_marketing_source.fnStandingRedraw();
	if(typeof dTable_mode_of_enquiry != 'undefined')	
		dTable_mode_of_enquiry.fnStandingRedraw();
	if(typeof dTable_center_course_material != 'undefined')
		dTable_center_course_material.fnStandingRedraw();
	if(typeof dTable_center_request_teacher != 'undefined')
		dTable_center_request_teacher.fnStandingRedraw();
	if(typeof dTable_course_material != 'undefined')
		dTable_course_material.fnStandingRedraw();
	if(typeof dTable_course_lesson_material != 'undefined')
		dTable_course_lesson_material.fnStandingRedraw();
	if(typeof dTable_set_center_course_material_fee != 'undefined')
		dTable_set_center_course_material_fee.fnStandingRedraw();
	//dTable.fnStandingRedraw();
}
function deleterecord(url,id)
{

	var conf = confirm("Are you sure you want to delete this record?");
	if(conf == true){
		document.formmain.action = url+'/delete/'+id;
		document.formmain.submit();
	}
}
function delete_record(url,id)
{
	
	var conf = confirm("Are you sure you want to delete this record?");
	if(conf == true){
		document.formmain.action = url+'/'+id;
		document.formmain.submit();
	}
}


// alert('dfdf');
$(document).ready(function(){
	var add_model_link_html = $("#add_model_link").html();
	$("div.dataTables_length").after(add_model_link_html);
	$("#add_model_link").remove();
	$(".dataTables_processing").html('<div style="text-align: center;width: auto;position: absolute;margin-left: 50%;"><i style="display:inline-block;font-size: 80px;" class="fa fa-spinner fa fa-6x fa-spin" id="animate-icon"></i></div>');
	$('input').keyup(function(e){
	  if(e.which==40)
	   $(this).closest('tr').next().find('td:eq('+$(this).closest('td').index()+')').find('input').focus();
	  else if(e.which==38)
	   $(this).closest('tr').prev().find('td:eq('+$(this).closest('td').index()+')').find('input').focus();
	});

	if($('#type').val() == '')
	{
		$('.timepicker_am').timepicker('setTime', '12:' + '00' + ' AM');
	}

	if($('#type').val() == '')
	{
		$('.timepicker_pm').timepicker('setTime', '12:' + '00' + ' PM');
		$('.pm_end_time').timepicker('setTime', '12:' + '00' + ' PM');
	}

});


$(document).on('click','.printpage',function(){
	var print_div = $(this).attr('data-div')
	var printContents = document.getElementById(print_div).innerHTML;
	var originalContents = document.body.innerHTML;
	document.body.innerHTML = printContents;
	window.print();
	document.body.innerHTML = originalContents;
	window.location.reload();
});
// Profile page start
if(CI.controller_name == 'profile' || CI.controller_name == 'list_user')
{

	function changepic(){

		$("#uploadpic").trigger('click');		
	}
	function previewUploadImg(input) {
		
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			
			reader.onload = function (e) {
				
				$('#previewimg')
					.attr('src', e.target.result);
				uploadpicture();
			};
			reader.readAsDataURL(input.files[0]);
		}
	}
	function uploadpicture(){
		$("#uploadpic_form").ajaxForm(
		{
			success: function(data){
				if(data != ''){
					
				}
			},
			beforeSubmit: function(arr, $form, options) {
				 
			}
		}).submit();
	}
	
	function rotateImage(degrees){
		$("#rotateImage_form_"+degrees).ajaxForm(
		{
			success: function(data){
				if(data != ''){
					
				}
			},
			beforeSubmit: function(arr, $form, options) {
				 
			}
		}).submit();
		
		var pimageURL = $("#previewimg").attr('src');
		$("#previewimg").attr('src',pimageURL+"?random="+new Date().getTime());
	}
}

if(CI.controller_name == 'add_privilege')
{
	$(function() {
		$("#add_privilege_form").validate({

			submitHandler: function(form) {
				event.preventDefault();
				$.ajax({
					url: CI.base_url+"add_privilege/add",
					type: 'POST',
					data: $("#add_privilege_form").serialize(),
					success: function (data) {
						$('#modal-success').modal();
					}
				});  
			},
			rules: {
				user_roll_id: {
					comboboxNotNone: true
				}
			}
		});
	});	
	
	function checked_action(role_id){
		var frmobj = document.add_privilege_form;
		for(var i=0; i < frmobj['action[]'].length; i++)
		{
			frmobj['action[]'][i].checked = false;
			$("#unchk_"+frmobj['action[]'][i].value).show();
			$("#chk_"+frmobj['action[]'][i].value).hide();
		}
		
		var $csrf_token_id_value = $("#csrf_token_id").val();
		$.ajax({
			type:'post',
  			url: CI.base_url+'add_privilege/get_existing_privilege',
			data: {role_id:role_id,u_token:$csrf_token_id_value},
  			success: function(data) {
  	  			var obj = $.parseJSON(data);
  	  			//alert(obj.length);return false;
  	  			console.log(frmobj);
  	  			console.log(obj);
  	  			if(obj.length > 0){
  	  				for(var i=0; i < frmobj['action[]'].length; i++)
				    {
  	  	  				for(var j=0;j<obj.length;j++){
  	  	  					//console.log(frmobj['action[]'][i].value+'===='+obj[j]);
  	  	  	  				if(frmobj['action[]'][i].value == obj[j]){
  	  	  						//alert(obj[j]);
  	  	  						frmobj['action[]'][i].checked = true;
  	  	  						//console.log($("input#chkbox_"+obj[j])[0]);
  	  	  						//console.log($($("input#chkbox_"+obj[j])[0]));
  	  	  						//$($("input#chkbox_"+obj[j])[0]).attr('checked', true);
  	  	  						//$("#unchk_"+obj[j]).hide();
  	  	  	    				//$("#chk_"+obj[j]).show();
  	  	  	  				}
  	  	  	  			}
				    }
  	  	  		}else{
					for(var i=0; i < frmobj['action[]'].length; i++)
				    {
				        frmobj['action[]'][i].checked = false;
				        $("#unchk_"+frmobj['action[]'][i].value).show();
	  	    			$("#chk_"+frmobj['action[]'][i].value).hide();
				    } 
  	  	  	  	}
    			
  			}
		});
	}
}

function checked_unchecked(val,id){
		
		if(val == 0){
			
			var mySplitResult = id.split("_");
			var checkbox = document.getElementById("chkbox_"+mySplitResult[0]+"_3");
			var checkbox_viewown = document.getElementById("chkbox_"+mySplitResult[0]+"_7");
			var checkbox_viewdept = document.getElementById("chkbox_"+mySplitResult[0]+"_12");

			if(checkbox_viewown)
			{
				if((checkbox && mySplitResult[0]+"_3" != id) && (checkbox_viewown && mySplitResult[0]+"_7" != id) && (checkbox_viewdept && mySplitResult[0]+"_12" != id)){
					if(checkbox.checked == false && checkbox_viewown.checked == false && checkbox_viewdept.checked == false){
						alert("You should give view right.");
					}else{
						$("#unchk_"+id).hide();
						$("#chk_"+id).show();
						document.getElementById("chkbox_"+id).checked = true;
					}
				}else{
					$("#unchk_"+id).hide();
					$("#chk_"+id).show();
					document.getElementById("chkbox_"+id).checked = true;
				}
			}
			else if(checkbox_viewdept)
			{
				if((checkbox && mySplitResult[0]+"_3" != id) && (checkbox_viewown && mySplitResult[0]+"_7" != id) && (checkbox_viewdept && mySplitResult[0]+"_12" != id)){
					if(checkbox.checked == false && checkbox_viewown.checked == false && checkbox_viewdept.checked == false){
						alert("You should give view right.");
					}else{
						$("#unchk_"+id).hide();
						$("#chk_"+id).show();
						document.getElementById("chkbox_"+id).checked = true;
					}
				}else{
					$("#unchk_"+id).hide();
					$("#chk_"+id).show();
					document.getElementById("chkbox_"+id).checked = true;
				}
			}
			else
			{
				if(checkbox && mySplitResult[0]+"_3" != id){
					if(checkbox.checked == false){
						alert("You should give view right.");
					}else{
						$("#unchk_"+id).hide();
						$("#chk_"+id).show();
						document.getElementById("chkbox_"+id).checked = true;
					}
				}else{
					$("#unchk_"+id).hide();
					$("#chk_"+id).show();
					document.getElementById("chkbox_"+id).checked = true;
				}
			}	
		}
		if(val == 1){
			$("#unchk_"+id).show();
			$("#chk_"+id).hide();
			document.getElementById("chkbox_"+id).checked = false;
		}
	}

$(document).ready(function(){

	$('#forgot_password_link').click(function(){
		$('#forgot_password_div').slideToggle();
	});
});

function dt_delete(table,where_col,where_col_id,DataTable = null){
	if(confirm('Are you sure you want to delete this record?')) {
		if(table == "user_roll" && where_col_id == 1)
		{
			showErrorMsg('Sorry! You can not delete Role:Admin');
			return false;
		}
		if(table == "user_roll" && where_col_id == 2)
		{
			showErrorMsg('Sorry! You can not delete Role:Candidate');
			return false;
		}
		
		$.ajax({
			type: "GET",
			url: CI.base_url+"general/delete",
			data: { table: table, where_col: where_col,where_col_id:where_col_id},
			success: function(data) {
				//parent.reload_datatable();
				if(table == 'assessment_sub_header' || table == 'assessment_detail'|| table == 'student_temp' )
				{
					location.reload();
				}
				$('#'+DataTable).dataTable().api().draw();

				
				if(data == 1) {
					showSuccessMsg('Record sucessfully deleted.');
				}else if(data != ""){
					showErrorMsg(data);
				}else {
					showErrorMsg('Ops! Something went wrong');
				}
			}
		});
	}
	return false;
}


function dt_delete_rate(table,where_col,where_col_id,DataTable = Null){
	if(confirm('Are you sure you want to delete this record?')) {
		
		$.ajax({
			type: "GET",
			url: CI.base_url+"general/delete",
			data: { table: table, where_col: where_col,where_col_id:where_col_id},
			success: function(data) {

				if(data == 1) 
				{
					$('#modal-large').delay(1000).modal('hide');
					showSuccessMsg('Record sucessfully deleted.');
				}else if(data != ""){
					showErrorMsg(data);
				}else {
					showErrorMsg('Ops! Something went wrong');
				}
			}
		});
	}
	return false;
}

function dt2_delete(table,where_col_id){
	console.log(table);
	var obj_table = $.parseJSON(table);
	console.log(obj_table);
	if(confirm('Are you sure you want to delete this record?')) {

		$.ajax({
			type: "GET",
			url: CI.base_url+"general/delete2",
			data: obj_table,
			success: function(data) {
				console.log(data);
				parent.reload_datatable();
				if(data == '') {
					showSuccessMsg('Record sucessfully deleted.');
				}else {
					showErrorMsg('Ops! Something went wrong');
				}
			}
		});
	}
	return false;
}


function reminder(id){
	
		// alert(id);
		$.ajax({
			type: "GET",
			url: CI.base_url+"consultancy_project/reminder",
			data: { id },
			success: function(data) {
				if(data == 1) {
					showSuccessMsg('Reminder Email Sent Sucessfully');
				}else {
					showErrorMsg('Ops! Email Not Sent.');
				}
			}
		});
	
	return false;
}

function dt_soft_delete(table,where_col,where_col_id){
	if(confirm('Are you sure you want to delete this record?')) {
		$.ajax({
			type: "GET",
			url: CI.base_url+"general/soft_delete",
			data: { table: table, where_col: where_col,where_col_id:where_col_id},
			success: function(data) {
				//parent.reload_datatable();
				location.reload();
				if(data == 1) {
					$('#modal-success').modal();
				}else {
					$('#modal-danger .modal-body').html("<p>Ops! Something went wrong</p>");	
					$('#modal-danger').modal();
				}
			}
		});
	}
	return false;
}

function _delete(table,where_col,where_col_id){
	if(confirm('Are you sure you want to delete this record?')) {
		$.ajax({
			type: "POST",
			url: CI.base_url+"general/delete",
			data: { table: table, where_col: where_col,where_col_id:where_col_id},
			success: function(data) {
				location.reload();
			}
		});
	}
	return false;
}

function dt_login(id){
	$.ajax({
		type: "POST",
		url: CI.base_url+"general/do_login/"+id,
		data: { },
		success: function(data) {
			if(data == 1) {
				window.location.href = CI.base_url;
			}else {
				showErrorMsg('Ops! Something went wrong');
			}
		}
	});
	return false;
}

function showSuccessMsg(msg){
	$.notify({
	message: msg
	},{
		type: 'success'
	})
}

function showErrorMsg(msg){
	$.notify({
	message: msg
	},{
		type: 'danger'
	})
}
	
function addTimes (startTime, endTime) {
  var times = [ 0, 0, 0 ]
  var max = times.length

  var a = (startTime || '').split(':')
  var b = (endTime || '').split(':')

  // normalize time values
  for (var i = 0; i < max; i++) {
    a[i] = isNaN(parseInt(a[i])) ? 0 : parseInt(a[i])
    b[i] = isNaN(parseInt(b[i])) ? 0 : parseInt(b[i])
  }

  // store time values
  for (var i = 0; i < max; i++) {
    times[i] = a[i] + b[i]
  }

  var hours = times[0]
  var minutes = times[1]
  var seconds = times[2]

  if (seconds >= 60) {
    var m = (seconds / 60) << 0
    minutes += m
    seconds -= 60 * m
  }

  if (minutes >= 60) {
    var h = (minutes / 60) << 0
    hours += h
    minutes -= 60 * h
  }

  return ('0' + hours).slice(-2) + ':' + ('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2)
}



$(document).on('click','#check_all',function(){
  $(".check").prop('checked', true);
})
$(document).on('click','#uncheck_all',function(){
   $(".check").prop('checked', false);
})
$(document).on('click','#view_all',function(){
  if($(".check_view").prop('checked') == true){
    $(".check_view").prop('checked', false);
  }else{
    $(".check_view").prop('checked', true);
  }
})
$(document).on('click','#edit_all',function(){
  if($(".check_edit").prop('checked') == true){
    $(".check_edit").prop('checked', false);
  }else{
    $(".check_edit").prop('checked', true);
  }
})
$(document).on('click','#add_all',function(){
  if($(".check_add").prop('checked') == true){
    $(".check_add").prop('checked', false);
  }else{
    $(".check_add").prop('checked', true);
  }
})
$(document).on('click','#check_delete_all',function(){
  if($(".check_delete").prop('checked') == true){
    $(".check_delete").prop('checked', false);
  }else{
    $(".check_delete").prop('checked', true);
  }
})

function clone_template($this){
	var master_block_id = $($this).closest('div.rowdata').attr("id");
	
	var template_block = $("#"+master_block_id+"_template").html();
	
	var att_id = $($this).attr("data-id");
	
	if(typeof att_id == "undefined") 
	{
		att_id = $("#training_master_div_parent").children().length;	
	}
	
	
	var template_block_new = template_block.replace(/PID/g, att_id);
	
	$($this).closest('div.rowdata').find("#"+master_block_id+"_parent").append(template_block_new);
	
	$($this).closest('div.rowdata').closest("#"+master_block_id+"_parent").append(template_block_new);
}

$(document).on('click','#export_pdf_button',function(){
	var export_country_id = $("#country_id").val();
	var export_center = $("#center").val();
	var export_course = $("#course").val();
	var export_teacher = $("#teacher").val();
	var export_attendance_date = $("#attendance_date").val();
	
	$("#export_country_id").val(export_country_id);
	$("#export_center").val(export_center);
	$("#export_course").val(export_course);
	$("#export_teacher").val(export_teacher);
	$("#export_attendance_date").val(export_attendance_date);
	
	if(export_center == "" && export_course == "" && export_teacher == "")
		showErrorMsg("Please select center/course/teacher");
	else if(export_attendance_date == "")
		showErrorMsg("Please select attendance date");
	else
		$("#export_file").submit();
})


function add_new_sub_row(id){
	var sub_no = $('#sub_count_'+id).val();
	sub_no++;
    $('#sub_count_'+id).val(sub_no);
    var sub_div = $('#sub_template').html();
	$('#sub_div_'+ id).append($("<div id='sub_no_"+id+"_"+ sub_no + "'></div>"));
    $('#sub_no_'+id+'_'+ sub_no).append(sub_div);
    $('#sub_no_'+id+'_'+ sub_no + ' #sub_remove').append($('<button class="btn btn-danger btn-sm" style="margin-top: 3px;float: right;margin-right: 13%;" type="button" onclick="remove_sub_row(0,'+id+','+sub_no+')"><i class="fa fa-remove"></i></button>'));
    // $('#sub_no_'+id+'_'+ sub_no + ' #input_id input').attr('name', 'sub_id_'+id+'[]');
    $('#sub_no_'+id+'_'+ sub_no + ' #input input').attr('name', 'title_'+id+'[]');
    $('#sub_no_'+id+'_'+ sub_no + ' #input2 input').attr('name', 'sequence_'+id+'[]');
    // $('#sub_no_'+id+'_'+ sub_no +' input.id').attr('name','sub_id_'+id+'[]');
}



$(document).on('click','.btn_reload',function()
{
	location.reload();
})

function showNotificationMsg(msg){
	$.notify({
	message: msg
	},{
		type: 'info'
	})
}

function open_chat_window(user_id,user_type){
	if($("#last_msg_"+user_type+"_"+user_id).length == 0) {
		$.ajax({
		    type: "GET",
		    url:  base_url +"live_chat/get_user_chat_data/"+user_id+'/'+user_type,
		    success: function(data) {
		    	$(".chat_box_wrap").append(data);
		    }
		});
	}
}

function update_chat_data(to_user_type,to_user_id)
{
	$.ajax({
        type: "GET",
        url: base_url +"live_chat/update_chat_data/"+to_user_type+"/"+to_user_id,
       	success: function(data) {
       			
    	} 
    });
} 

$(document).on('click', '.class_add', function() {
	clone_template(this);
	$('.getAmDuration').removeClass('select2-wrapper select2-hidden-accessible');
	$('.getAmDuration').addClass('select2');
	
	$('.getPmDuration').removeClass('select2-wrapper select2-hidden-accessible');
	$('.getPmDuration').addClass('select2');
	var master_block_id = $(this).closest('div.rowdata').attr("id");
	
	var div_no = 1;
	$('.traning_day').each(function(){
		$(this).text('Training Day '+div_no);
		div_no ++;
	});
	
	$('.datepicker').datepicker({
        autoclose: true,
        format : 'yyyy-mm-dd',
	})
		
	$('.timepicker').timepicker({
        showMeridian: false, 
        showInputs:true, 
        showSeconds:false, 
        minuteStep:15
	})

	$('.schedule_timepicker').timepicker({
        showMeridian: true, 
        showInputs:true, 
        showSeconds:false, 
        minuteStep:15
    })
	
	$(this).closest('div.rowdata').find(".timepicker_am").timepicker('setTime', '12:' + '00' + ' AM');
	$(this).closest('div.rowdata').find(".timepicker_am").timepicker({
        showMeridian: false, 
        showInputs:true, 
        showSeconds:false, 
        minuteStep:15
	}).on('changeTime.timepicker', function (e) {
		console.log(e)
        if (e.time.meridian !== "AM") {
            $(this).closest('div.rowdata').find(".timepicker_am").timepicker('setTime', '12:' + e.time.minutes + ' AM');
        }
    });


	$(this).closest('div.rowdata').find(".timepicker_pm").timepicker('setTime', '12:' + '00' + ' PM');
    $(this).closest('div.rowdata').find(".timepicker_pm").timepicker({
        showMeridian: false, 
        showInputs:true, 
        showSeconds:false, 
        minuteStep:15
	}).on('changeTime.timepicker', function (e) {
        if (e.time.meridian !== "PM") {
            $(this).closest('div.rowdata').find(".timepicker_pm").timepicker('setTime', '12:' + e.time.minutes + ' PM');
        }
    });

	$("#"+master_block_id+"_parent .select2-container").each(function() {
		$(this).remove();
	});
	
	$('.Select2Trainer').select2({
        placeholder: "Select a trainer",
        allowClear: true,
        ajax: {
            url: CI.base_url+"general/GetCompanyTrainerList/",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    company_id: $('#company_id').val()
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.name};
                    })
                };
            },
            cache: true
        }
    })
	
});
$(document).on('click', '.clone_delete', function() {
	$(this).closest('div.rowdata').remove();
	
	var div_no = 1;
	$('.traning_day').each(function(){
		$(this).text('Training Day '+div_no);
		div_no ++;
	});
});

$(document).on('click','.change_status',function(){
	var table = $(this).attr('data-table');
	var id = $(this).attr('data-id');
	var status = $(this).attr('data-status');
	var column_name = $(this).attr('data-column');
	var update_column  = $(this).attr('data-changecolumn');
	var u_token  = $(this).attr('data-u-token');
	var datatable = $(this).attr('data-datatable');
	var othercolumn1 = $(this).attr('data-changeothercolumn1');
	var othercolumn2 = $(this).attr('data-changeothercolumn2');
	var updatecolumn = $(this).attr('data-updatecolumn');

	$.ajax({
		type: "POST",
		url: CI.base_url+"general/change_status/",
		data: { 
			table : table,
			id : id,
			status : status,
			column_name : column_name,
			update_column : update_column,
			u_token : u_token,
			othercolumn1 : othercolumn1,
			othercolumn2 : othercolumn2,
			updatecolumn : updatecolumn,
		},
		success: function(data) {
			var result = jQuery.parseJSON(data);
			if(result == 1) {
				if(datatable == null)
				{
					parent.reload_datatable();
				}
				else
				{	
					var table = $('#'+datatable).dataTable();
					table.api().draw();
				}
			}else {
				showErrorMsg('Ops! Something went wrong');
			}
		}
	});
	
})

$(document).on('click','.status_update_long_course',function(){
	var id = $(this).attr('data-id');
	var status = $(this).attr('data-status');
	$.ajax({
		type: "GET",
		url: CI.base_url+"long_course_management/update_long_course_status/",
		data: { 
			id : id,
			status : status,
		},
		success: function(data) {
			if(data.trim() == '') {
				location.reload();
				showSuccessMsg('Sucessfully Status Updated')
			}else {
				showErrorMsg('Ops! Something went wrong');
			}
		}
	});
	
})

$(document).on('click','.status_update_module_course',function(){
	var id = $(this).attr('data-id');
	var status = $(this).attr('data-status');
	$.ajax({
		type: "GET",
		url: CI.base_url+"module_course_management/update_module_course_status/",
		data: { 
			id : id,
			status : status,
		},
		success: function(data) {
			if(data.trim() == '') {
				location.reload();
				showSuccessMsg('Sucessfully Status Updated')
			}else {
				showErrorMsg('Ops! Something went wrong');
			}
		}
	});
	
})

$(document).on('click','.status_update_course_schedule',function(){
	var id = $(this).attr('data-id');
	var status = $(this).attr('data-status');
	$.ajax({
		type: "GET",
		url: CI.base_url+"course_management/update_course_schedule_status/",
		data: { 
			id : id,
			status : status,
		},
		success: function(data) {
			if(data.trim() == '') {
				var table = $('#grid_course_schedule').dataTable();
				table.api().draw();
				showSuccessMsg('Sucessfully Status Updated')
			}else {
				showErrorMsg('Ops! Something went wrong');
			}
		}
	});
	
})

$(document).on('click','.status_update_seminar_schedule',function(){
	var id = $(this).attr('data-id');
	var status = $(this).attr('data-status');
	$.ajax({
		type: "GET",
		url: CI.base_url+"seminar_course_management/update_seminar_schedule_status/",
		data: { 
			id : id,
			status : status,
		},
		success: function(data) {
			if(data.trim() == '') {
				var table = $('#grid_seminar_course_schedule').dataTable();
				table.api().draw();
				showSuccessMsg('Sucessfully Status Updated')
			}else {
				showErrorMsg('Ops! Something went wrong');
			}
		}
	});
	
})

$(document).on('click','.status_update_cadet_course_schedule',function(){
	var id = $(this).attr('data-id');
	var status = $(this).attr('data-status');
	$.ajax({
		type: "GET",
		url: CI.base_url+"cadet_plus_course_management/update_course_schedule_status/",
		data: { 
			id : id,
			status : status,
		},
		success: function(data) {
			console.log(data);
			if(data.trim() == '') {
				var table = $('#grid_course_schedule').dataTable();
				table.api().draw();
				showSuccessMsg('Sucessfully Status Updated')
			}else {
				showErrorMsg('Ops! Something went wrong');
			}
		}
	});
	
})

$(document).on('click','.status_update_course',function(){
	var id = $(this).attr('data-id');
	var status = $(this).attr('data-status');
	$.ajax({
		type: "GET",
		url: CI.base_url+"course_management/update_course_status/",
		data: { 
			id : id,
			status : status,
		},
		success: function(data) {
			if(data.trim() == '') {
				location.reload();
				showSuccessMsg('Sucessfully Status Updated')
			}else {
				showErrorMsg('Ops! Something went wrong');
			}
		}
	});
	
})

$(document).on('click','.status_update_cadet_plus_course',function(){
	var id = $(this).attr('data-id');
	var status = $(this).attr('data-status');
	$.ajax({
		type: "GET",
		url: CI.base_url+"cadet_plus_course_management/update_course_status/",
		data: { 
			id : id,
			status : status,
		},
		success: function(data) {
			if(data.trim() == '') {
				location.reload();
				showSuccessMsg('Sucessfully Status Updated')
			}else {
				showErrorMsg('Ops! Something went wrong');
			}
		}
	});
	
})

$(document).on('click','.status_update_seminar_course',function(){
	var id = $(this).attr('data-id');
	var status = $(this).attr('data-status');
	$.ajax({
		type: "GET",
		url: CI.base_url+"seminar_course_management/update_course_status/",
		data: { 
			id : id,
			status : status,
		},
		success: function(data) {
			if(data.trim() == '') {
				location.reload();
				showSuccessMsg('Sucessfully Status Updated')
			}else {
				showErrorMsg('Ops! Something went wrong');
			}
		}
	});
	
})
function clone_template_category($this){
	var master_block_id = $($this).closest('div.main_catrow').attr("id");
	// alert(master_block_id);
	var template_block = $("#"+master_block_id+"_template").html();
	var att_id = $($this).attr("data-id");
	
	if(typeof att_id == "undefined") 
	{
		att_id = $("#rowdata_category").children().length;	
	}
	
	var template_block_new = template_block.replace(/PID/g, att_id);
	
	// $($this).closest(".add_second_rowband").append(template_block_new);
	
	$($this).closest('div.main_catrow').find(".add_second_rowband").append(template_block_new);
	
}

function clone_template_trainer($this){
	var master_block_id = $($this).closest('div.main_trainerrow').attr("id");
	var template_block = $("#"+master_block_id+"_template").html();
	var att_id = $($this).attr("data-id");
	if(typeof att_id == "undefined") 
	{
		att_id = $("#rowdata_trainer").children().length;	
	}
	var template_block_new = template_block.replace(/PID/g, att_id);
	$($this).closest('div.main_trainerrow').find(".add_second_rowband").append(template_block_new);
}

$(document).on('click', '.more_category_add', function() {
	var master_block_id = $(this).closest('div.main_catrow').attr("id");
	var row_no = $(this).closest('.main_catrow').find('.rowdata_category:last-child').find('#row_count').val();
	row_no++;
	clone_template_category(this);
	
	$(this).closest('.main_catrow').find('.rowdata_category:last-child').find('#row_count').val(row_no);
	$('#'+master_block_id).find('.rowdata_category:last-child').addClass('main_class'+row_no);
	
	$('.main_class'+row_no).find('.categorytype').attr('name','evaluation_detail['+row_no+'][category_type]');
	$('.main_class'+row_no).find('.category').attr('name','evaluation_detail['+row_no+'][category]');

	$('.categorytype').removeClass('select2-wrapper select2-hidden-accessible');
	$('.categorytype').removeClass('Select2');
	$('.main_catagory .select2-container').remove();
	
	$('.evaluation').removeClass('select2-wrapper select2-hidden-accessible');
	$('.evaluation').addClass('select2');
	$('.rowdata_evaluation .select2-container').remove();
});


$(document).on('click', '.more_trainer_add', function() {
	var master_block_id = $(this).closest('div.main_trainerrow').attr("id");
	var row_no = $(this).closest('.main_trainerrow').find('.rowdata_trainer:last-child').find('#row_count').val();
	row_no++;

	clone_template_trainer(this);
	
	$(this).closest('.main_trainerrow').find('.rowdata_trainer:last-child').find('#row_count').val(row_no);
	$('#'+master_block_id).find('.rowdata_trainer:last-child').addClass('main_class'+row_no);
	
	$('.main_class'+row_no).find('.short_trainer').attr('name','short_course_trainer['+row_no+'][trainer]');
	$('.main_class'+row_no).find('.preference').attr('name','short_course_trainer['+row_no+'][preference]');

	$('.short_trainer').removeClass('select2-wrapper select2-hidden-accessible');
	$('.short_trainer').addClass('Select2');
	$('.main_catagory .select2-container').remove();
   $('.Select2Trainer').select2({
        placeholder: "Select a trainer",
        allowClear: true,
        ajax: {
            url: CI.base_url+"general/GetCompanyTrainerList/",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    company_id: $('#company_id').val()
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.name};
                    })
                };
            },
            cache: true
        }
    })

});

$(document).on('click', '.more_course_trainer_add', function() {
	var master_block_id = $(this).closest('div.main_trainerrow').attr("id");
	var row_no = $(this).closest('.main_trainerrow').find('.rowdata_trainer:last-child').find('#row_count').val();
	row_no++;

	clone_template_trainer(this);
	
	$(this).closest('.main_trainerrow').find('.rowdata_trainer:last-child').find('#row_count').val(row_no);
	$('#'+master_block_id).find('.rowdata_trainer:last-child').addClass('main_class'+row_no);
	
	$('.main_class'+row_no).find('.short_trainer').attr('name','course_trainer[]');
	$('.main_class'+row_no).find('.preference').attr('name','course_trainer_preference[]');

	$('.short_trainer').removeClass('select2-wrapper select2-hidden-accessible');
	$('.short_trainer').addClass('Select2');
	$('.main_catagory .select2-container').remove();
   $('.Select2Trainer').select2({
        placeholder: "Select a trainer",
        allowClear: true,
        ajax: {
            url: CI.base_url+"general/GetCompanyTrainerList/",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    company_id: $('#company_id').val()
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.name};
                    })
                };
            },
            cache: true
        }
    })

});
$(document).on('click', '.category_clone_delete', function() {
	var row_no = $(this).closest('.rowdata_category').closest('#category_master_div_parent').closest('#category_master_div').find('#row_count').val()-1;
	
	$(this).closest('.rowdata_category').closest('#category_master_div_parent').closest('#category_master_div').find('#row_count').val(row_no);
	$(this).closest('div.rowdata_category').remove();
});

$(document).on('click', '.trainer_clone_delete', function() {
	var row_no = $(this).closest('.rowdata_trainer').closest('#trainer_master_div_parent').closest('#category_master_div').find('#row_count').val()-1;
	
	$(this).closest('.rowdata_trainer').closest('#trainer_master_div_parent').closest('#category_master_div').find('#row_count').val(row_no);
	$(this).closest('div.rowdata_trainer').remove();
});

// Blended Course Start

function clone_template_evaluation($this){
	var master_block_id = $($this).closest('div.evaluation_master_div_parent').attr("id");
	// alert(master_block_id);
	var template_block = $("#"+master_block_id+"_template").html();
	var att_id = $($this).attr("data-id");
	
	if(typeof att_id == "undefined") 
	{
		att_id = $("div.rowdata_evaluation").children().length;	
	}
	
	var template_block_new = template_block.replace(/PID/g, att_id);
	// second_evaluation
	$($this).closest('div.evaluation_master_div_parent').find('div.add_second_catrow').append(template_block_new);
	
	// $($this).closest('div.rowdata_evaluation').closest("#"+master_block_id+"_parent").append(template_block_new);
}
$(document).on('click', '.more_evaluation_add', function() {
	clone_template_evaluation(this);
	var row_no = $(this).closest('#evaluation_master_div').find('#evaluation_count').val();
	var no = $(this).closest('#category_master_div_parent').closest('.rowdata_category').find('#row_count').val();
	row_no++;
	$(this).closest('#evaluation_master_div').find('#evaluation_count').val(row_no);
	$(this).closest('.evaluation_master_div_parent').find('.main_evaluation:last-child').find('.evaluation').attr('name','evaluation_detail['+no+'][evaluation_id]['+row_no+'][]');

	$('.evaluation').removeClass('select2-wrapper select2-hidden-accessible');
	$('.evaluation').addClass('select2');
	$('.rowdata_evaluation .select2-container').remove();
});


$(document).on('click', '.evaluation_clone_delete', function() {
	
	var row_no = $(this).closest('#evaluation_master_div').find('#evaluation_count').val()-1;
	$(this).closest('#evaluation_master_div').find('#evaluation_count').val(row_no);
	$(this).closest('div.rowdata_evaluation').remove();
});


$(document).on('change', '.short_trainer', function() {
	var seleted_value = this.value;
	var no = 0;
	$(".short_trainer").each(function() {
		if (this.value > 0 ) {
			if (seleted_value == this.value) {
				no += Number(1);
			}
		}
	});
	if (no > 1) {
		showErrorMsg('Trainer Already Exits');
		$(this).val('');
		$(this).text('');

	}
});


function clone_template_cat3_info($this){
	var master_block_id = $($this).closest('div.cat3_info_master_div_parent').attr("id");
	var template_block = $("#"+master_block_id+"_template").html();
	var att_id = $($this).attr("data-id");
	
	if(typeof att_id == "undefined") 
	{
		att_id = $("div.rowdata_cat3_info").children().length;	
	}
	
	var template_block_new = template_block.replace(/PID/g, att_id);
	// second_cat3_info
	$($this).closest('div.cat3_info_master_div_parent').find('div.add_second_inforow').append(template_block_new);
}
$(document).on('click', '.more_cat3_info_add', function(event) {
	clone_template_cat3_info(this);
	var row_no = $(this).closest('#cat3_info_master_div').find('#cat3_info_count').val();
	var no = $(this).closest('#category_master_div_parent').closest('.rowdata_category').find('#row_count').val();
	row_no++;
	$(this).closest('#cat3_info_master_div').find('#cat3_info_count').val(row_no);
	$(this).closest('.cat3_info_master_div_parent').find('.main_cat3_info:last-child').find('.info_title').attr('name','evaluation_detail['+no+'][title]['+row_no+'][]');

});

$(document).on('click', '.cat3_info_clone_delete', function() {
	
	var row_no = $(this).closest('#cat3_info_master_div').find('#cat3_info_count').val()-1;
	$(this).closest('#cat3_info_master_div').find('#cat3_info_count').val(row_no);
	$(this).closest('div.rowdata_cat3_info').remove();
});
function delete_evaluation(form_detail_id){
	if(confirm('Are you sure you want to delete this evaluation?')) {
		$.ajax({
			type: "POST",
			url: CI.base_url+"evaluation/delete_evaluation",
			data: { form_detail_id: form_detail_id},
			success: function(data) {
				if(data == 1){
					showSuccessMsg('evaluation Successfully Deleted.');
					location.reload();
				}
				
			}
		});
	}
	return false;
}
function delete_info_title(form_detail_id){
	if(confirm('Are you sure you want to delete this title?')) {
		$.ajax({
			type: "POST",
			url: CI.base_url+"evaluation/delete_info_title",
			data: { form_detail_id: form_detail_id},
			success: function(data) {
				if(data == 1){
					showSuccessMsg('title Successfully Deleted.');
					location.reload();
				}
				
			}
		});
	}
	return false;
}
$('.lead_datepicker').datepicker({
	autoclose: true,
	format: "MM yyyy",
    viewMode: "months", 
    minViewMode: "months"
})

function checkDuplicateCsvData(objThis,csv_controller_name,newentry=0,table)
{
	var postData = {data_ID:objThis,data_table:table};
	var formURL = CI.base_url+csv_controller_name+"/check_duplicate_csv_data/"+objThis;
	$.ajax({
		type: "GET",
		url: formURL,
		data: postData,
		success: function(data) {
			if(data == 1) {
				if(csv_controller_name == "cadet_plus_course_management"){
					showErrorMsg('Duplicate or Incorrect payment Records Found.');
				}
				if(csv_controller_name == "seminar_course_management"){
					showErrorMsg('Duplicate or Incorrect payment Records Found.');
				}
			}else {
				if(confirm('Are you sure you want to import all records?')) {
					if(newentry == 1){
						var country_id = 0;
						var course_id = 0;
						if(csv_controller_name == 'cadet_plus_course_management')
						{
							if(table == 'student')
							{	
								var country_id = 0;
							}
						}
						if(csv_controller_name == 'seminar_course_management')
						{
							if(table == 'seminar_student')
							{	
								var country_id = 0;
							}
						}
						window.location.href = CI.base_url+csv_controller_name+"/csv_data_save_new/"+objThis+'/'+country_id+'/'+table;
					}
				}	
			}
		}
	});
	return false;
}


function student_course_status($status,$stu_id,$course_id){

	var status = $status;
	var stu_id = $stu_id;
	var stu_course_id = $course_id;
	if(status == '1'){
		if(confirm('Are you sure you want to Accept?')) {
			$.ajax({
				type: "GET",
				url: CI.base_url+"cadet_plus_course_management/student_course_change_status",
				data: { stu_id:stu_id, status:status,stu_course_id:stu_course_id},
				success: function(data) {
					location.reload(true);
					if(data == 1) {
						showSuccessMsg('Status Successfully Approved.');
					}
				}
			});
		}
	}else if(status == '2'){
		if(confirm('Are you sure you want to Reject?')) {
			$.ajax({
		        type: "GET",
		        url: base_url +"cadet_plus_course_management/student_course_change_status",
		        data: { stu_id:stu_id, status:status,stu_course_id:stu_course_id},
		       	success: function(data) {
		       		alert(data)
		       		location.reload(true);
					if(data == 0) {
						showSuccessMsg('Status Successfully Rejected.');
					}	
		    	} 
		    });
			
		}
	}
	
	return false;
}

function student_seminar_course_status($status,$stu_id,$course_id){

	var status = $status;
	var stu_id = $stu_id;
	if(status == '1'){
		if(confirm('Are you sure you want to Accept?')) {
			$.ajax({
				type: "GET",
				url: CI.base_url+"seminar_course_management/student_course_change_status",
				data: { stu_id:stu_id, status:status},
				success: function(data) {
					location.reload(true);
					if(data == 1) {
						showSuccessMsg('Status Successfully Approved.');
					}
				}
			});
		}
	}else if(status == '2'){
		if(confirm('Are you sure you want to Reject?')) {
			$.ajax({
		        type: "GET",
		        url: base_url +"seminar_course_management/student_course_change_status",
		        data: { stu_id:stu_id, status:status},
		       	success: function(data) {
		       		alert(data)
		       		location.reload(true);
					if(data == 0) {
						showSuccessMsg('Status Successfully Rejected.');
					}	
		    	} 
		    });
			
		}
	}
	
	return false;
}
$(document).on('click','.status_update_module_course_schedule',function(){
	var id = $(this).attr('data-id');
	var status = $(this).attr('data-status');
	$.ajax({
		type: "GET",
		url: CI.base_url+"module_course_management/update_module_course_schedule_status/",
		data: { 
			id : id,
			status : status,
		},
		success: function(data) {
			if(data.trim() == '') {
				var table = $('#grid_course_schedule').dataTable();
				table.api().draw();
				showSuccessMsg('Sucessfully Status Updated')
			}else {
				showErrorMsg('Ops! Something went wrong');
			}
		}
	});
	
})