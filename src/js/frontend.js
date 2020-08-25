$(document).ready(function(){

    //alert('validate');
   
    $("#add_course_form_fronted").validate({
      rules: {
            venue_id: {
                required: true
            },
            course_id: {
                required: true
            }
        },
        messages: {
            venue_id: "Please Select Location.",
            course_id: "Please Select Course."
        }
    });





    
        
})

function check_student_by_type_for_dropdown(ele) {

    var id_tag = ele.id;
      //alert(id_tag);
    if (id_tag == 'student_type_1') {
            
        $('#corporate').show();
    }else{
        $('#corporate').hide();
    }
    
    // $('.Select2Corporate').select2({
    //     placeholder: "Select a Client Company",
    //     allowClear: true,
    //     ajax: {
    //         url: base_url+"general/json_get_company_list/",
    //         dataType: 'json',
    //         delay: 250,
    //         processResults: function (data) {
    //             return {
    //                 results: $.map(data, function(obj) {
    //                       return { id: obj.id, text: obj.company_name};
    //                 })
    //             };
    //         }
    //     }
    // });
    
    // $('.Select2Student').select2({
    //     placeholder: "Select a Student",
    //     allowClear: true,
    //     ajax: {
    //         url: base_url+"general/GetIndividualStudentList/",
    //         dataType: 'json',
    //         delay: 250,
    //         processResults: function (data) {
                 
    //             return {

    //                 results: $.map(data, function(obj) {
    //                       return { id: obj.id, text: obj.nric+ ' - ('+ obj.name + ')'};
    //                 })
    //             };
    //         }
    //     }
    // });
}







