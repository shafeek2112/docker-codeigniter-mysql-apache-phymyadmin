$(document).ready( function () {
	
	 dTable = $('#grid_role').dataTable({
			bJQueryUI:false,
			bProcessing:true,
			bServerSide: true,
			sAjaxSource: base_url+"core_components/role_json",
			aoColumns: [null , 
			            {"sName": "user_roll_name"},
			            
			            {"sName": "ID",
			            		"bSearchable": false,
			            		"bSortable": false,
			            		"fnRender": function (oObj) {}
			            }
			           ],
			});

	 	 dTable = $('#grid_leave').dataTable({
			bJQueryUI:false,
			bProcessing:true,
			bServerSide: true,
			sAjaxSource: base_url+"core_components/leave_type_json",
			aoColumns: [null , 
			            {"sName": "name"},
			            {"sName": "ID",
			            		"bSearchable": false,
			            		"bSortable": false,
			            		"fnRender": function (oObj) {}
			            }
			           ],
			});
			
		dTable = $('#grid_grant_type').dataTable({
			bJQueryUI:false,
			bProcessing:true,
			bServerSide: true,
			sAjaxSource: base_url+"core_components/grant_type_json",
			aoColumns: [null , 
			            {"sName": "ID",
			            		"bSearchable": false,
			            		"bSortable": false,
			            		"fnRender": function (oObj) {}
			           },
			           {"sName": "ID",
			            		"bSearchable": false,
			            		"bSortable": false,
			            		"fnRender": function (oObj) {}
			           },
			            {"sName": "name"},
						 {"sName": "name"},
			            
			           ],
			});	

});












