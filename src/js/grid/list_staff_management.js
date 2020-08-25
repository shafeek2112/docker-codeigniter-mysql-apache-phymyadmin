$(document).ready(function(){
    var table_total_col = $('table#grid_trainer thead tr').children().length;
    var table_searchCols = [];
    var filter_col_data_temp = [];
    if (filter_col_data.length > 0) {
      for(_filter_col_key in filter_col_data){
        var filter_col_name = filter_col_data[_filter_col_key]['filter_col'];
        var filter_col_value = filter_col_data[_filter_col_key]['filter_col_value'];
        var sel_filter_col = $(".filter#"+filter_col_name).attr('data-column');
        filter_col_data_temp[sel_filter_col] = filter_col_value;
      }
  
      for (var j = 0;j <= table_total_col - 1; j++) {
        if (filter_col_data_temp[j] === undefined) {
          table_searchCols[j] = null;
        }else{
          table_searchCols[j] = {"search": filter_col_data_temp[j]};
        }
        }
    }

    dTable = $('#grid_trainer').dataTable({
        fixedHeader: true,
         bJQueryUI:false,
         bProcessing:true,
         bServerSide: true,
         sAjaxSource: base_url+"staff_management/index_json",
         "searchCols": table_searchCols,
         aoColumns: [
                     {"sName": "id"},
                     {"sName": "ID",
                            "bSearchable": false,
                            "bSortable": false,
                     },
                     {"sName": "staff_name"},
                     {"sName": "role_name"},
                     {"sName": "email"},
                     {"sName": "mobile_no"},
                     {"sName": "nric"},
                     {"sName": "salary"},
                     {"sName": "address"},
                     {"sName": "register_date"}
                     //{"sName": "status"},
                    // {"sName": "id"},
                     		            	
                ],
    });

    if(filter_col_data.length == '0'){
		dTable.api().columns().search('').draw();
	}
		
    $('.filter').on('keyup change', function() {
        //clear global search values
        var i =$(this).attr('data-column'); // getting column index
        var v =$(this).val(); // getting search input value
        dTable.api().columns(i).search(v).draw();
    });
})

