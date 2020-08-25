$(document).ready( function () {
	 dTable_role = $('#grid_other_user').dataTable({
	 		fixedHeader: true,
			bJQueryUI:false,
			bProcessing:true,
			bServerSide: true,
			sAjaxSource: base_url+"list_user/index_json",
        	aoColumns: [
						{"sName": "users.user_id"},
						{"sName": "ID",
       						"bSearchable": false,
       						"bSortable": false,
						},
						{"sName": "users.username"},
						{"sName": "staff_name"},
						{"sName": "email"},
						{"sName": "email_2"},
						{"sName": "birth_date"},
						{"sName": "contact_number_1"},
						{"sName": "contact_number_2"},
						{"sName": "user_roll_name"},
						{"sName": "users.created_by"},
						{"sName": "users.created_date"},
						{"sName": "users.updated_by"},
						{"sName": "users.updated_date"}
		            			            	
		           ],
			});
});
