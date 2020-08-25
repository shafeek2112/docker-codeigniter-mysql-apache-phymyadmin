$(document).ready(function(){
    //select2///
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};

    $('input').attr('autocomplete','off');
    $('select').attr('autocomplete','off');
    $('radio').attr('autocomplete','off');
    $('textarea').attr('autocomplete','off');
    $('textarea').attr('rows','3');


    $('.datepicker').datepicker({
        autoclose: true,
        format : 'yyyy-mm-dd',
    })
    
    $('.ir_date').datepicker({
        autoclose: true,
        format : 'yyyy-mm-dd',
    })
    
    
    
    $('.month').datepicker({
        autoclose: true,
        viewMode: 'months',
        format : 'yyyy-mm',
    })

    $('.timepicker').timepicker({
        showMeridian: false, 
        showInputs:true, 
        showSeconds:false, 
        minuteStep:5
    })
    $('.assessment_timepicker').timepicker({
        showMeridian: true, 
        showInputs:true, 
        showSeconds:false, 
        minuteStep:5
    })
    $('.schedule_timepicker').timepicker({
        showMeridian: true, 
        showInputs:true, 
        showSeconds:false, 
        minuteStep:5
    })
    
    $(".course").select2({
      placeholder: "Select a Course",
      allowClear: true
    });

    $(".venue").select2({
      placeholder: "Select a Venue",
      allowClear: true
    });

    $('.Select2UserRole').select2({
        placeholder: "Select a role",
        allowClear: true,
        ajax: {
            type:'GET',
            url: CI.base_url+"general/getUserRole/",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.user_roll_id, text: obj.user_roll_name};
                    })
                };
            },
            cache: true
        }
    })


    $('.Select2loginData').select2({
        placeholder: "Select a Name",
        allowClear: true,
        ajax: {
            type:'POST',
            url: CI.base_url+"general/GetloginData/",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    type_id: $('#login_type').val(),
                    
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.user_id, text: obj.name};
                    })
                };
            },
            cache: true
        }
    })
    $('#id_type').change(function(){
        if($('#id_type').val() == 'NRIC')
        {
            $('#work_experience').show();
            $('.tg_div').show();
        }else
        {
            $('#work_experience').show();
            $('.tg_div').show();
        }
    });
    $(document).on('change','.show_age',function(){
        $.ajax({
            type: "GET",
            url: CI.base_url+"general/GetAgeByDOB",
            data: { 
                dob : $(this).val(),
            },
            async: false,
            success: function(data) {   
                $('#age').val(data);
            }
        });
    })
    $(".Select2").select2({
        placeholder: "Please Select",
        allowClear: true,
    })
    
    $('.Select2Company').select2({
        placeholder: "Select a Organization",
        allowClear: true,
        ajax: {
            url: CI.base_url+"general/GetCompanyList/",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.company_name};
                    })
                };
            },
            cache: true
        }
    }).on('change', function() { 
        $('.Select2CompanyCourse option').remove();
        $('.Select2CompanyVenue option').remove();
        // $('.Select2CourseLanguage option').remove();
        $('.Select2CourseSchedule option').remove();
        $('.register_course_time').val('');
    });

    $('.Select2CourseAward').select2({
        placeholder: "Select a Name of Award",
        allowClear: true,
        ajax: {
            url: base_url+"general/get_name_of_award/",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.award_name};
                    })
                };
            }
        }
    });
	
	
	$('.Select2ProgramCoordinator').select2({
        placeholder: "Select Program Coordinator",
        allowClear: true,
        ajax: {
            url: base_url+"general/get_programcordinator/",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.name};
                    })
                };
            }
        }
    });
$(".short_module_list").select2({
  placeholder: 'Select  Short/Module course',
  allowClear : true,
  ajax: {
    url: base_url + "general/get_short_module_ajax",
    dataType: 'json',
    delay: 250,
	data: function (params) {
      return {
          q: params.term,
          company_id: $('#company_id').val(),
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
});
    $('.Select2Courses').select2({
        placeholder: "Select a Course",
        allowClear: true,
        ajax: {
            url: base_url+"general/GetCourse/",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.course_title};
                    })
                };
            }
        }
    });
    $('.Select2AllCourses').select2({
        placeholder: "Select a Course",
        allowClear: true,
        ajax: {
            url: base_url+"general/GetAllCourse/",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.course_title};
                    })
                };
            }
        }
    }).on('change', function(data) {
        $('.Select2CourseSchedule option').remove();
    });
    $('.Select2ShortCourse').select2({
        placeholder: "Select a Short Course",
        allowClear: true,
        ajax: {
            url: base_url+"general/GetShortCourse/",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.course_title};
                    })
                };
            }
        }
    })


    $('.Select2Insideroom').select2({
        placeholder: "Select a Inside Room",
        allowClear: true,
        ajax: {
            url: base_url+"general/GetInsideRoom/",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                   venue_id : $('#venue_id').val(),
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.room_no};
                    })
                };
            }
        }
    })


    $('.Select2Course').select2({
        placeholder: "Select a Course",
        allowClear: true,
        ajax: {
            url: base_url+"general/GetCourse/",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.course_title};
                    })
                };
            }
        }
    }).on('change', function(data) {
        $('.Select2CourseLanguage option').remove();
        //$('.Select2StudentCourseLanguage option').remove();
        $('.Select2StudentCourseVenue option').remove();
        var course_id = $(this).val();
        var i = $(this).attr('data-id');
        var v = $(this).val();
        $('#no_' + i + ' td .quotation_course_dec').empty();
        $.ajax({
            url: base_url+"general/getcoursedes/"+course_id,
            success: function(result){
                var result = JSON.parse(result);
                 $('#no_' + i + ' td .quotation_course_dec').html(result.replace(/\"/g, "").replace(/\n"/g, "<br>"));
        }});
    });
    
    $('.Select2CompanyCourse').select2({
        placeholder: "Select a Short course",
        allowClear: true,
        ajax: {
            url: base_url+"general/GetCompanyCourseList/",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    company_id: $('#company_id').val(),
                    register : $('#register_id').val(),
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.course_title};
                    })
                };
            },
            cache: true
        }
    }).on('change',function(){
        
        // $('.Select2CourseLanguage option').remove();
        $('.Select2CompanyVenue option').remove();
        $('.register_course_time').val('');
    })
    $('.Select2CompanyShortCourse').select2({
        placeholder: "Select a Short course",
        allowClear: true,
        ajax: {
            url: base_url+"general/GetCompanyShortCourseList/",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    company_id: $('#company_id').val(),
                    register : $('#register_id').val(),
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.course_title};
                    })
                };
            },
            cache: true
        }
    }).on('change',function(){
        $('.Select2CourseLanguage option').remove();
        $('.Select2CourseSchedule option').remove();
        $('.register_course_time').val('');
    })
    /**/
    $('.Select2CompanyModuleCourse').select2({
        placeholder: "Select a Module course",
        allowClear: true,
        ajax: {
            url: base_url+"general/GetCompanyModuleCourseList/",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    company_id: $('#company_id').val(),
                    register : $('#register_id').val(),
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.course_title};
                    })
                };
            },
            cache: true
        }
    }).on('change',function(){
        $('.Select2CourseLanguage option').remove();
        $('.Select2CourseSchedule option').remove();
        $('.register_course_time').val('');
    })
    /**/

    $('.Select2CompanyCadetPlusCourse').select2({
        placeholder: "Select a Cadet Plus course",
        allowClear: true,
        ajax: {
            url: base_url+"general/GetCompanyCadetPlusCourseList/",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    company_id: $('#company_id').val(),
                    register : $('#register_id').val(),
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.course_title};
                    })
                };
            },
            cache: true
        }
    }).on('change',function(){
        $('.Select2CourseLanguage option').remove();
        $('.Select2CourseSchedule option').remove();
        $('.register_course_time').val('');
    })


    $('.Select2CompanyCadetPlusCourseIntakeno').select2({
        placeholder: "Select a Cadet Plus Intake No",
        allowClear: true,
        ajax: {
            url: base_url+"general/GetCompanyCadetPlusCourseIntakeList/",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    company_id: $('#company_id').val(),
                    course_id: $('#course_title').val(),
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.intake_no};
                    })
                };
            },
            cache: true
        }
    })

    $('.Select2CompanySeminarCourseIntakeno').select2({
        placeholder: "Select a Seminar Intake No",
        allowClear: true,
        ajax: {
            url: base_url+"general/GetCompanySeminarCourseIntakeList/",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    company_id: $('#company_id').val(),
                    course_id: $('#course_title').val(),
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.intake_no};
                    })
                };
            },
            cache: true
        }
    })
    
    $('.Select2CompanySeminarCourse').select2({
        placeholder: "Select a Seminar course",
        allowClear: true,
        ajax: {
            url: base_url+"general/GetCompanySeminarCourseList/",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    company_id: $('#company_id').val(),
                    register : $('#register_id').val(),
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.course_name};
                    })
                };
            },
            cache: true
        }
    }).on('change',function(){
        $('.Select2CourseLanguage option').remove();
        $('.Select2CourseSchedule option').remove();
        $('.register_course_time').val('');
    })


    $('.Select2CompanyLongCourse').select2({
        placeholder: "Select a Long Term course",
        allowClear: true,
        ajax: {
            url: base_url+"general/GetCompanyLongCourseList/",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    company_id: $('#company_id').val(),
                    register : $('#register_id').val(),
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.course_title};
                    })
                };
            },
            cache: true
        }
    }).on('change',function(){
        $('.Select2CourseLanguage option').remove();
        $('.Select2CourseSchedule option').remove();
        $('.register_course_time').val('');
    })

    $('.Select2CompanyVenue').select2({
        placeholder: "Select a venue",
        allowClear: true,
        ajax: {
            url: CI.base_url+"general/GetCompanyVenueList/",
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
                          return { id: obj.id, text: obj.area};
                    })
                };
            },
            cache: true
        }
    }).on('change',function(){
        $('.Select2Room option').remove();
        $('.Select2CourseSchedule option').remove();
        $('.register_course_time').val('');
    })

    $('.Select2CourseScheduleStatus').select2({
        placeholder: "Please Select",
        allowClear: true,
        ajax: {
            url: CI.base_url+"general/GetCourseScheduleStatus/",
            dataType: 'json',
            delay: 250,
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


    $('.Select2CadetCourseScheduleStatus').select2({
        placeholder: "Please Select Status",
        allowClear: true,
        ajax: {
            url: CI.base_url+"general/GetCadetCourseScheduleStatus/",
            dataType: 'json',
            delay: 250,
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

    $('.Select2Evaluation').select2({
        placeholder: "Select an Evaluation",
        allowClear: true,
        ajax: {
            url: CI.base_url+"general/GetEvaluationList/",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.question};
                    })
                };
            },
            cache: true
        }
    })

    $('.Select2EvaluationForm').select2({
        placeholder: "Select an Evaluation Form",
        allowClear: true,
        ajax: {
            url: CI.base_url+"general/GetEvaluationFormList/",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.form_name};
                    })
                };
            },
            cache: true
        }
    })

    $('.Select2EvaluationStatus').select2({
        placeholder: "Please Select a Status",
        allowClear: true,
        ajax: {
            url: CI.base_url+"general/GetEvaluationStatus/",
            dataType: 'json',
            delay: 250,
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


    $('.Select2ShortCourseTrainer').select2({
        placeholder: "Select a trainer",
        allowClear: true,
        ajax: {
            url: CI.base_url+"general/GetShortCourseTrainerList/",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    company_id: $('#company_id').val(),
                    course_id:  $('#course_id').val(),
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


    $('.Select2CadetPlusCourseTrainer').select2({
        placeholder: "Select a trainer",
        allowClear: true,
        ajax: {
            url: CI.base_url+"general/GetCadetPlusCourseTrainerList/",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    company_id: $('#company_id').val(),
                    course_id:  $('#course_id').val(),
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

    $('.Select2SeminarCourseTrainer').select2({
        placeholder: "Select a trainer",
        allowClear: true,
        ajax: {
            url: CI.base_url+"general/GetSeminarCourseTrainerList/",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    company_id: $('#company_id').val(),
                    course_id:  $('#course_id').val(),
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

	
	$('.CheckBundleCourse').on('change',function(){
		var value = $(".CheckBundleCourse option:selected").val();
		var bundle_promote = value.search(",");
		
		if (bundle_promote >= 1) {
			var arr = value.split(',');
			$('.normal_course').hide();
			$('.bundle_course').show();
			$('#CompanyCourse1').val(arr[0]);
			$('#CompanyCourse2').val(arr[1]);
			$('#bundle_promotion_id').val(arr[2]);
		} else {
			$('.normal_course').show();
			$('.bundle_course').hide();
			$('#CompanyCourse1').val(0);
			$('#CompanyCourse2').val(0);
			$('#bundle_promotion_id').val(0);
		}
		
	})
    $('.title3').hide();
    $('#evaluation_type').on('change',function(){
        var evaluation_type = $("#evaluation_type option:selected").val();
        
        if (evaluation_type == 'option2') {
            $('.title3').show();
        } else {
            $('.title3').hide();
        }
        
    })
    $('.Select2CompanyCourse2').select2({
        placeholder: "Select a course",
        allowClear: true,
        ajax: {
            url: base_url+"general/GetCompanyCourseList/",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    company_id: $('#company_id').val(),
                    register : $('#register_id').val(),
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.course_title};
                    })
                };
            },
            cache: true
        }
    }).on('change',function(){
        $('.Select2CourseLanguage option').remove();
        $('.Select2CourseSchedule option').remove();
        $('.register_course_time').val('');
    })
    
	$('.Select2CourseLanguage').select2({
        placeholder: "Select a Language",
        allowClear: true,
        ajax: {
            url: base_url+"general/GetCourseLanguage/",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    course_id: $('.Select2CompanyCourse').val()
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.language_id, text: obj.language};
                    })
                };
            }
        }
    }).on('change',function(){
        $('.Select2CourseSchedule option').remove();
        $('.register_course_time').val('');
    })
	
	$('.Select2CourseSchedule').select2({
        placeholder: "Select a Schedule",
        allowClear: true,
        ajax: {
            url: base_url+"general/json_get_class_date_by_course_language_venue_GET/",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    course_id: $('#course_id').val(),
                    language_id: $('#language_id').val(),
                    venue_id: $('#venue_id').val(),
                    student_id: $('#student_id').val(),
                    check_day : $('#check_day').val(),  /// today  date check //
                    check_student : $('#check_student').val(),  /// course student check //
                    register: $('#register').val(),
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.date};
                    })
                };
            }
        }
    }).on('change',function(){
        $('.register_course_time').val('');
        $('.Select2PracticalSchedule option').remove();
        $.ajax({
            type: "POST",
            url: CI.base_url+"general/get_course_schedule_timing",
            data: { 
                schedule_id : $(this).val(),
            },
            success: function(data) {
                $('.register_course_time').val(data);
            }
        })        
    })
	
    $('.Select2Room').select2({
        placeholder: "Select a Room No",
        allowClear: true,
        ajax: {
            url: CI.base_url+"general/GetVenueRoomList/",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    company_id: $('#company_id').val(),
                    venue_id: $('.venue_id').val()
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.room_no};
                    })
                };
            },
            cache: true
        }
    })

    $('.Select2Assessor').select2({
        placeholder: "Select an assessor",
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
    $('.Select2Assessment').select2({
        placeholder: "Select an assessor",
        allowClear: true,
        ajax: {
            url: CI.base_url+"general/getAssessmentByCourse/",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    course_id: $('#course_id').val()
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
	
	$('.Select2Race').select2({
        placeholder: "Select a Race",
        allowClear: true,
        ajax: {
            url: base_url+"general/GetRaceList/",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.name};
                    })
                };
            }
        }
    });
	
	$('.Select2Hqualification').select2({
        placeholder: "Select a Highest Qualification",
        allowClear: true,
        ajax: {
            url: base_url+"general/GetHighestQualificationList/",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.name};
                    })
                };
            }
        }
    });
	
	$('.Select2Salaryrange').select2({
        placeholder: "Select a Salary Range",
        allowClear: true,
        ajax: {
            url: base_url+"general/GetSalaryRangeList/",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.name};
                    })
                };
            }
        }
    });
	
	 $('.Select2Designation').select2({
        placeholder: "Select a Designation",
        allowClear: true,
        ajax: {
            url: base_url+"general/GetDesignationlist/",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.name};
                    })
                };
            }
        }
    });
	
	$('.Select2Nationality').select2({
        placeholder: "Select a Nationality",
        allowClear: true,
        ajax: {
            url: base_url+"general/GetNationalitylist/",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.nationality};
                    })
                };
            }
        }
    });
	
});
// $(document).on('change','.CourseAssessment',function(){
//     var course_id = $(this).val();
//     $.ajax({
//         type: "POST",
//         url: CI.base_url+"course_management/get_course_by_id_jason",
//         data: { 
//             course_id : course_id,
//         },
//         success: function(data) {
//             var result = jQuery.parseJSON(data);
//             //console.log(result);
//             if(result.written_test == 'Y')
//             {
//                 $('#writing_assessment').show();
//             }
//             else
//             {
//                 $('#writing_assessment').hide();
//             }
//             if(result.practical_test == 'Y')
//             {
//                 $('#practical_assessment').show();
//             }
//             else
//             {
//                 $('#practical_assessment').hide();
//             }
//             if(result.oral_test == 'Y')
//             {
//                 $('#oral_assessment').show();
//             }
//             else
//             {
//                 $('#oral_assessment').hide();
//             }
//             if(result.presentation == 'Y')
//             {
//                 $('#presentation_assessment').show();
//             }
//             else
//             {
//                 $('#presentation_assessment').hide();
//             }
//             if(result.quiz == 'Y')
//             {
//                 $('#quiz_assessment').show();
//             }
//             else
//             {
//                 $('#quiz_assessment').hide();
//             }
//             if(result.report == 'Y')
//             {
//                 $('#report_assessment').show();
//             }
//             else
//             {
//                 $('#report_assessment').hide();
//             }
//         }
//     });
    
// })

$(document).on('change','.Select2CompanyShortCourse',function(){
    var course_id = $(this).val();
    $.ajax({
        type: "POST",
        url: CI.base_url+"course_management/GetCoursedays",
        data: { 
            course_id : course_id,
        },
        success: function(data) {
            $( "#training_master_div_parent .date_slot.rowdata" ).each(function() {
                
              $( this ).remove();
            });
            var result = jQuery.parseJSON(data);
            $('.total_days').val(result.total_days);
            $('#student_limit').val(result.max_class_size);
            var day_count = result.total_days;
            var length = $('.date_slot').length;
            var total_click = day_count-length+1;            
            var i;
            for (i=0; i<total_click; i++) {

                $( ".class_add" ).trigger( "click" );
            }
            $('.timepicker_am').val(result.am_start_time);
            $('.am_end_time').val(result.am_end_time);
            $('.timepicker_pm').val(result.pm_start_time);
            $('.pm_end_time').val(result.pm_end_time);
            $('.WritingstartTime').val(result.written_start_time);
            $('.WritingendTime').val(result.written_end_time);
            $('.PracticalstartTime').val(result.practical_start_time);
            $('.PracticalendTime').val(result.practical_end_time);
            $('.OralstartTime').val(result.oral_start_time);
            $('.OralendTime').val(result.oral_end_time);
            $('.PresentationstartTime').val(result.pre_start_time);
            $('.PresentationendTime').val(result.pre_end_time);
            $('.QuizstartTime').val(result.quiz_start_time);
            $('.QuizendTime').val(result.quiz_end_time);
            $('.ReportstartTime').val(result.report_start_time);
            $('.ReportendTime').val(result.report_end_time);
        }
    });
    
})
function confirm_delete(url, id) {
   
    $("#delete").attr("href", url + '/' + id);
    $("#delete_imageModal").modal();
}
$(document).ready(function(){
                  
 $("#citizen_detail_1").hide();
 $("#salary_detail").hide();

    if($("#full_part_time").val() == 'full_time') {
        $("#salary_detail").show();
    }

    $('input[type=radio][name=citizen]').change(function() {

        if (this.value == '3')
        {
             $("#citizen_detail_1").show();
        }
        else
        {
             $("#citizen_detail_1").hide();
        }
   
    });

    if($('input[name=citizen]:checked').val() == 3)
        {
             $("#citizen_detail_1").show();
        }
        else
        {
             $("#citizen_detail_1").hide();
        }
    $(document).on('change','#full_part_time',function(){
        if (this.value == 'full_time')
        {
             $("#salary_detail").show();
        }
        else
        {
             $("#salary_detail").hide();
        }
   
    });    
   
});

function change_input(elm){
    if (elm.value == 'type1')
    {
        $(elm).closest('.date_slot').find('.category_type1').css("display","block");
        $(elm).closest('.date_slot').find('.category_type3').css("display","none");
        $(elm).closest('.date_slot').find('.category_type3').css("display","none");
        $(elm).closest('.rowdata_category').find('#cat_type').val('type1');
        var no = $(elm).closest('.rowdata_category').find('#row_count').val();
        $(elm).closest('.date_slot').find('.evaluation').attr('name','evaluation_detail['+no+'][evaluation_id][1][]');
        
    }else if (elm.value == 'type3')
    {
        $(elm).closest('.rowdata_category').find('#cat_type').val('type3');
        $(elm).closest('.date_slot').find('.category_type1').css("display","none");
        $(elm).closest('.date_slot').find('.category_type3').css("display","block");
        var no = $(elm).closest('.rowdata_category').find('#row_count').val();
        $(elm).closest('.date_slot').find('.info_title').attr('name','evaluation_detail['+no+'][title][1][]');
    } else {
        $(elm).closest('.rowdata_category').find('#cat_type').val('type2');
        $(elm).closest('.date_slot').find('.category_type1').css("display","none");
        $(elm).closest('.date_slot').find('.category_type3').css("display","none");
    }
    // });
}

//############# Add Schedule JS Function
$(document).ready(function(){
    $('.SimpleDataTable').dataTable({
        "paging":   false,
        "info":     false,
        "ordering" : false,
    });
})

var temp_row_id = $('#training_day_count').val();
    temp_row_id = parseInt(temp_row_id);

$(document).on('click','#add_recurring_schedule',function(){
    var from_date = $('#recurring #from_date').val();
    var to_date = $('#recurring #to_date').val();
    var searchDays = $("#recurring input:checkbox:checked").map(function(){
                        return $(this).val();
                    }).get();
    var validate = 'true';
    $('.course_date_error').text('This field is required.');
    $('#recurring *').filter('.requiredvalue').each(function(){
        if(this.value == '' || this.value == 0)
        {
            $('.'+this.id+'_error').show();
            validate = 'false';
        }
        else
        {
            $('.'+this.id+'_error').hide();
        }
    });

    // #### validation for day checkbox
    var checked = 0;
    $('#recurring input[type=checkbox]').each(function(){
        if(this.checked)
        {
            checked = 1;
        }
    })
    if(checked == 0)
    {
        $('.day_check_error').show();
        validate = 'false';
    }
    else
    {
        $('.day_check_error').hide();
    }
    
    var am_start_time = $('#recurring #recuring_am_start_time').val();
    var am_end_time = $('#recurring #recuring_am_end_time').val();
    var pm_start_time = $('#recurring #recuring_pm_start_time').val();
    var pm_end_time = $('#recurring #recuring_pm_end_time').val();
    var trainer_id = $('#recurring #recuring_trainer').val();
    var trainer_name = $('#recurring #recuring_trainer option:selected').text();
    var asst_trainer_id = $('#recurring #recuring_asst_trainer').val();
    var asst_trainer_name = $('#recurring recuring_asst_trainer option:selected').text();
    var room_id = $('#recurring #recurring_room_id').val();
    var room = $('#recurring #recurring_room_id option:selected').text();

    if(validate == 'true')
    {
        var courseDateArray = [];
        $('.course_date').each(function(){
            courseDateArray.push($(this).val());
        });
        $('#training_schedule tbody tr.odd').remove();
        $.ajax({
            type: "GET",
            url: CI.base_url+"general/get_recurring_date/",
            data: { 
                from_date : from_date,
                to_date : to_date,
                searchDays : searchDays,
                courseDateArray : courseDateArray,
            },
            success: function(data) {
                var result = jQuery.parseJSON(data);
                
                //#### Here is to check Room Resource Validation
                result.forEach(course_date => {
                    var validation_start_time = am_start_time;
                    var validation_end_time   = pm_end_time;
                    if(am_start_time == '' || am_start_time == '12:00 AM')
                    {
                        validation_start_time = pm_start_time;
                    }
                    if(pm_end_time == '' || pm_end_time == '12:00 AM')
                    {
                        validation_end_time = am_end_time;
                    }
                    validation = check_venue_resources_validation(room_id,course_date,validation_start_time,validation_end_time,'sc','recurring_room_id_error',0);
                    
                });

                result.forEach(course_date => {
                    if(validation == 'true')
                    {
                        temp_row_id +=1;
                        append_class_date(temp_row_id,course_date,am_start_time,am_end_time,pm_start_time,pm_end_time,trainer_id,trainer_name,asst_trainer_id,asst_trainer_name,room_id,room);
                    }
                });
            }
        });
    }
    
})


$(document).on('click','#add_cadet_plus_recurring_schedule',function(){
    var from_date = $('#recurring #from_date').val();
    var to_date = $('#recurring #to_date').val();
    var searchDays = $("#recurring input:checkbox:checked").map(function(){
                        return $(this).val();
                    }).get();
    var validate = 'true';
    $('.course_date_error').text('This field is required.');
    $('#recurring *').filter('.requiredvalue').each(function(){
        if(this.value == '' || this.value == 0)
        {
            $('.'+this.id+'_error').show();
            validate = 'false';
        }
        else
        {
            $('.'+this.id+'_error').hide();
        }
    });

    // #### validation for day checkbox
    var checked = 0;
    $('#recurring input[type=checkbox]').each(function(){
        if(this.checked)
        {
            checked = 1;
        }
    })
    if(checked == 0)
    {
        $('.day_check_error').show();
        validate = 'false';
    }
    else
    {
        $('.day_check_error').hide();
    }
    
    var am_start_time = $('#recurring #recuring_am_start_time').val();
    var am_end_time = $('#recurring #recuring_am_end_time').val();
    var pm_start_time = $('#recurring #recuring_pm_start_time').val();
    var pm_end_time = $('#recurring #recuring_pm_end_time').val();
    var trainer_id = $('#recurring #recuring_trainer').val();
    var trainer_name = $('#recurring #recuring_trainer option:selected').text();
    var asst_trainer_id = $('#recurring #recuring_asst_trainer').val();
    var asst_trainer_name = $('#recurring #recuring_asst_trainer option:selected').text();
    var evaluation_from_id = $('#recurring #recurring_evaluation_from').val();
    var evaluation_from = $('#recurring #recurring_evaluation_from option:selected').text();

    if(validate == 'true')
    {
        var courseDateArray = [];
        $('.course_date').each(function(){
            courseDateArray.push($(this).val());
        });
        $('#training_schedule tbody tr.odd').remove();
        $.ajax({
            type: "GET",
            url: CI.base_url+"general/get_recurring_date/",
            data: { 
                from_date : from_date,
                to_date : to_date,
                searchDays : searchDays,
                courseDateArray : courseDateArray,
            },
            success: function(data) {
                var result = jQuery.parseJSON(data);
                result.forEach(course_date => {
                    temp_row_id +=1;
                    append_cadet_plus_class_date(temp_row_id,course_date,am_start_time,am_end_time,pm_start_time,pm_end_time,trainer_id,trainer_name,asst_trainer_id,asst_trainer_name,evaluation_from_id,evaluation_from);
                });
            }
        });
    }
    
})

/*$(document).on('click','#add_seminar_recurring_schedule',function(){
    var from_date = $('#recurring #from_date').val();
    var to_date = $('#recurring #to_date').val();
    var searchDays = $("#recurring input:checkbox:checked").map(function(){
                        return $(this).val();
                    }).get();
    var validate = 'true';
    $('.course_date_error').text('This field is required.');
    $('#recurring *').filter('.requiredvalue').each(function(){
        if(this.value == '' || this.value == 0)
        {
            $('.'+this.id+'_error').show();
            validate = 'false';
        }
        else
        {
            $('.'+this.id+'_error').hide();
        }
    });

    // #### validation for day checkbox
    var checked = 0;
    $('#recurring input[type=checkbox]').each(function(){
        if(this.checked)
        {
            checked = 1;
        }
    })
    if(checked == 0)
    {
        $('.day_check_error').show();
        validate = 'false';
    }
    else
    {
        $('.day_check_error').hide();
    }
    
    var am_start_time = $('#recurring #recuring_am_start_time').val();
    alert(am_start_time);
    var am_end_time = $('#recurring #recuring_am_end_time').val();
    alert(am_end_time);
    var pm_start_time = $('#recurring #recuring_pm_start_time').val();
    var pm_end_time = $('#recurring #recuring_pm_end_time').val();
    var trainer_id = $('#recurring #recuring_trainer').val();
    var trainer_name = $('#recurring #recuring_trainer option:selected').text();
    var asst_trainer_id = $('#recurring #recuring_asst_trainer').val();
    var asst_trainer_name = $('#recurring recuring_asst_trainer option:selected').text();
    var room_id = $('#recurring #recurring_room_id').val();
    var room = $('#recurring #recurring_room_id option:selected').text();
    
    if(validate == 'true')
    {
        var courseDateArray = [];
        $('.course_date').each(function(){
            courseDateArray.push($(this).val());
        });
        $('#training_schedule tbody tr.odd').remove();
        $.ajax({
            type: "GET",
            url: CI.base_url+"general/get_recurring_date/",
            data: { 
                from_date : from_date,
                to_date : to_date,
                searchDays : searchDays,
                courseDateArray : courseDateArray,
            },
            success: function(data) {
                var result = jQuery.parseJSON(data);
                result.forEach(course_date => {
                    temp_row_id +=1;
                    append_seminar_class_date(temp_row_id,course_date,am_start_time,am_end_time,pm_start_time,pm_end_time,trainer_id,trainer_name,asst_trainer_id,asst_trainer_name,room_id,room,trainer_rate,asst_trainer_rate,evaluation_id,evaluation);
                });
            }
        });
    }
    
})*/

$(document).on('click','#add_single_schedule',function(){
    var validate = 'true';
    $('.course_date_error').text('This field is required.');
    $('#single *').filter('.requiredvalue').each(function(){
        if(this.value == '' || this.value == 0)
        {
            $('.'+this.id+'_error').show();
            validate = 'false';
        }
        else
        {
            $('.'+this.id+'_error').hide();
        }
    });

    var edit_mode = $('#single #temp_row_id').val();
    var course_date = $('#single #course_date').val();
    var am_start_time = $('#single #single_am_start_time').val();
    var am_end_time = $('#single #single_am_end_time').val();
    var pm_start_time = $('#single #single_pm_start_time').val();
    var pm_end_time = $('#single #single_pm_end_time').val();
    var trainer_id = $('#single #single_trainer').val();
    var trainer_name = $('#single #single_trainer option:selected').text();
    var asst_trainer_id = $('#single #single_asst_trainer').val();
    var asst_trainer_name = $('#single #single_asst_trainer option:selected').text();
    var room_id = $('#single #single_room_id').val();
    var room = $('#single #single_room_id option:selected').text();

   
    if(edit_mode > 0)
    {
        $('.course_date').each(function(){
            if($(this).val() == course_date && edit_mode != $(this).attr('data-row') )
            {
                $('.course_date_error').text('Duplicate Date');
                $('.course_date_error').show();
                validate = false;
            }
        });
        if(validate == 'true')
        {   
            //#### Here is to check Room Resource Validation
            var validation_start_time = am_start_time;
            var validation_end_time   = pm_end_time;
            var schedule_id           = $('#schedule_id').val();
            if(am_start_time == '' || am_start_time == '12:00 AM')
            {
                validation_start_time = pm_start_time;
            }
            if(pm_end_time == '' || pm_end_time == '12:00 AM')
            {
                validation_end_time = am_end_time;
            }
            validation = check_venue_resources_validation(room_id,course_date,validation_start_time,validation_end_time,'sc','single_room_id_error',schedule_id);
            if(validation == 'true')
            {
                update_class_date(edit_mode,course_date,am_start_time,am_end_time,pm_start_time,pm_end_time,trainer_id,trainer_name,asst_trainer_id,asst_trainer_name,room_id,room);
            }
        }
        
    }
    else
    {

        $('.course_date').each(function(){
            if($(this).val() == course_date)
            {
                $('.course_date_error').text('Duplicate Date');
                $('.course_date_error').show();
                validate = false;
            }
        });
        if(validate == 'true')
        {
            //#### Here is to check Room Resource Validation
            var validation_start_time = am_start_time;
            var validation_end_time   = pm_end_time;
            if(am_start_time == '' || am_start_time == '12:00 AM')
            {
                validation_start_time = pm_start_time;
            }
            if(pm_end_time == '' || pm_end_time == '12:00 AM')
            {
                validation_end_time = am_end_time;
            }
            validation = check_venue_resources_validation(room_id,course_date,validation_start_time,validation_end_time,'sc','single_room_id_error',0);
            if(validation == 'true')
            {
                $('#training_schedule tbody tr.emptyrow').remove();
                temp_row_id +=1;
                append_class_date(temp_row_id,course_date,am_start_time,am_end_time,pm_start_time,pm_end_time,trainer_id,trainer_name,asst_trainer_id,asst_trainer_name,room_id,room);
            }
            
        }
    }
})

$(document).on('click','#add_seminar_schedule',function(){
    var validate = 'true';
    $('.course_date_error').text('This field is required.');
    $('#single *').filter('.requiredvalue').each(function(){
        if(this.value == '' || this.value == 0)
        {
            $('.'+this.id+'_error').show();
            validate = 'false';
        }
        else
        {
            $('.'+this.id+'_error').hide();
        }
    });

    var edit_mode = $('#single #temp_row_id').val();
    var course_date = $('#single #course_date').val();
    var am_start_time = $('#single #single_am_start_time').val();
    var am_end_time = $('#single #single_am_end_time').val();
    var pm_start_time = $('#single #single_pm_start_time').val();
    var pm_end_time = $('#single #single_pm_end_time').val();
    var trainer_id = $('#single #single_trainer').val();
    var trainer_name = $('#single #single_trainer option:selected').text();
    var asst_trainer_id = $('#single #single_asst_trainer').val();
    var asst_trainer_name = $('#single #single_asst_trainer option:selected').text();
    var trainer_rate = $('#single #single_trainer_rate').val();
    var asst_trainer_rate = $('#single #single_asst_trainer_rate').val();
    var evaluation_id = $('#single #single_evaluation_id').val();
    var evaluation = $('#single #single_evaluation_id option:selected').text();
    
    if(edit_mode > 0)
    {
        $('.course_date').each(function(){
            if($(this).val() == course_date && edit_mode != $(this).attr('data-row') )
            {
                $('.course_date_error').text('Duplicate Date');
                $('.course_date_error').show();
                validate = false;
            }
        });
        if(validate == 'true')
        {
            update_seminar_class_date(edit_mode,course_date,am_start_time,am_end_time,pm_start_time,pm_end_time,trainer_id,trainer_name,asst_trainer_id,asst_trainer_name,room_id,room,trainer_rate,asst_trainer_rate,evaluation_id,evaluation);
        }
        
    }
    else
    {
        $('.course_date').each(function(){
            if($(this).val() == course_date)
            {
                $('.course_date_error').text('Duplicate Date');
                $('.course_date_error').show();
                validate = false;
            }
        });
        if(validate == 'true')
        {
            $('#training_schedule tbody tr.emptyrow').remove();
            temp_row_id +=1;
            append_seminar_class_date(temp_row_id,course_date,am_start_time,am_end_time,pm_start_time,pm_end_time,trainer_id,trainer_name,asst_trainer_id,asst_trainer_name,trainer_rate,asst_trainer_rate,evaluation_id,evaluation)
        }
    }
})

$(document).on('click','#add_cadet_plus_course_schedule',function(){
    var validate = 'true';
    $('.course_date_error').text('This field is required.');
    $('#single *').filter('.requiredvalue').each(function(){
        if(this.value == '' || this.value == 0)
        {
            $('.'+this.id+'_error').show();
            validate = 'false';
        }
        else
        {
            $('.'+this.id+'_error').hide();
        }
    });

    var edit_mode = $('#single #temp_row_id').val();
    var course_date = $('#single #course_date').val();
    var am_start_time = $('#single #single_am_start_time').val();
    var am_end_time = $('#single #single_am_end_time').val();
    var pm_start_time = $('#single #single_pm_start_time').val();
    var pm_end_time = $('#single #single_pm_end_time').val();
    var trainer_id = $('#single #single_trainer').val();
    var trainer_name = $('#single #single_trainer option:selected').text();
    var asst_trainer_id = $('#single #single_asst_trainer').val();
    var asst_trainer_name = $('#single #single_asst_trainer option:selected').text();
    var evaluation_from_id = $('#single #single_evaluation_from').val();
    var evaluation_from = $('#single #single_evaluation_from option:selected').text();

   
    if(edit_mode > 0)
    {
        $('.course_date').each(function(){
            if($(this).val() == course_date && edit_mode != $(this).attr('data-row') )
            {
                $('.course_date_error').text('Duplicate Date');
                $('.course_date_error').show();
                validate = false;
            }
        });
        if(validate == 'true')
        {
            update_cadet_plus_class_date(edit_mode,course_date,am_start_time,am_end_time,pm_start_time,pm_end_time,trainer_id,trainer_name,asst_trainer_id,asst_trainer_name,evaluation_from_id,evaluation_from);
        }
        
    }
    else
    {

        $('.course_date').each(function(){
            if($(this).val() == course_date)
            {
                $('.course_date_error').text('Duplicate Date');
                $('.course_date_error').show();
                validate = false;
            }
        });
        if(validate == 'true')
        {
            $('#training_schedule tbody tr.emptyrow').remove();
            temp_row_id +=1;
            append_cadet_plus_class_date(temp_row_id,course_date,am_start_time,am_end_time,pm_start_time,pm_end_time,trainer_id,trainer_name,asst_trainer_id,asst_trainer_name,evaluation_from_id,evaluation_from);
        }
    }
})


$(document).on('click','.remove_cadet_plus_schedule_row',function(){
    var temp_row_id =  $(this).attr('data-id');
    var data_delete = $(this).attr('data-delete');
    if(data_delete != '' && data_delete == 'Yes')
    {
        var data_id = $(this).attr('table-id')
        $.ajax({
            type: "GET",
            url: CI.base_url+"course_management/change_schedule_detail_status/",
            data: { 
                table : 'cadet_plus_course_schedule_detail',
                id : data_id,
                status : 'I',
            },
            success: function(data) {
                $('#training_schedule tbody tr#temp_row_'+temp_row_id).remove();
                reset_cadet_plus_schedule_serial_no();
            }
        });
    }
    else
    {
        $('#training_schedule tbody tr#temp_row_'+temp_row_id).remove();
        reset_cadet_plus_schedule_serial_no();
    }
})

$(document).on('click','.remove_schedule_row',function(){
    var temp_row_id =  $(this).attr('data-id');
    var data_delete = $(this).attr('data-delete');
    if(data_delete != '' && data_delete == 'Yes')
    {
        var data_id = $(this).attr('table-id')
        $.ajax({
            type: "GET",
            url: CI.base_url+"course_management/change_schedule_detail_status/",
            data: { 
                table : 'course_schedule_detail',
                id : data_id,
                status : 'I',
                usage_type : 'sc',
            },
            success: function(data) {
                $('#training_schedule tbody tr#temp_row_'+temp_row_id).remove();
                reset_schedule_serial_no();
            }
        });
    }
    else
    {
        $('#training_schedule tbody tr#temp_row_'+temp_row_id).remove();
        reset_schedule_serial_no();
    }
})

$(document).on('click','.remove_seminar_schedule_row',function(){
    var temp_row_id =  $(this).attr('data-id');
    var data_delete = $(this).attr('data-delete');
    if(data_delete != '' && data_delete == 'Yes')
    {
        var data_id = $(this).attr('table-id')
        $.ajax({
            type: "GET",
            url: CI.base_url+"seminar_course_management/change_schedule_detail_status/",
            data: { 
                table : 'seminar_course_schedule_detail',
                id : data_id,
                status : 'I',
            },
            success: function(data) {
                $('#training_schedule tbody tr#temp_row_'+temp_row_id).remove();
                reset_seminar_schedule_serial_no();
            }
        });
    }
    else
    {
        $('#training_schedule tbody tr#temp_row_'+temp_row_id).remove();
        reset_seminar_schedule_serial_no();
    }
})

$(document).on('click','.edit_schedule_row',function(){
    $('#single_tab').trigger('click');
    var temp_row_id =  $(this).attr('data-id');
    $('#single *').filter('.requiredvalue').each(function(){
        $('#single input.requiredvalue').val('');
        $('#single select.requiredvalue option').remove('');
    });
    $('#single #single_asst_trainer option').remove('');

    var course_date     = $('#training_schedule tr#temp_row_'+temp_row_id+' .course_date').val();
    var am_start_time   = $('#training_schedule tr#temp_row_'+temp_row_id+' .am_start_time').val();
    var am_end_time     = $('#training_schedule tr#temp_row_'+temp_row_id+' .am_end_time').val();
    var pm_start_time   = $('#training_schedule tr#temp_row_'+temp_row_id+' .pm_start_time').val();
    var pm_end_time     = $('#training_schedule tr#temp_row_'+temp_row_id+' .pm_end_time').val();
    var tutor_id        = $('#training_schedule tr#temp_row_'+temp_row_id+' .trainer').val();
    var tutor_name      = $('#training_schedule tr#temp_row_'+temp_row_id+' .trainer_name').text();
    var asst_tutor_id   = $('#training_schedule tr#temp_row_'+temp_row_id+' .trainer_2').val();
    var asst_tutor_name = $('#training_schedule tr#temp_row_'+temp_row_id+' .asst_trainer_name').text();
    var room_id         = $('#training_schedule tr#temp_row_'+temp_row_id+' .row_room_id').val();
    var room            = $('#training_schedule tr#temp_row_'+temp_row_id+' .room').text();

    $('#single #temp_row_id').val(temp_row_id);
    $('#single #course_date').val(course_date);
    $('#single #single_am_start_time').val(am_start_time);
    $('#single #single_am_end_time').val(am_end_time);
    $('#single #single_pm_start_time').val(pm_start_time);
    $('#single #single_pm_end_time').val(pm_end_time);
    $('#single #single_trainer').append('<option value="'+tutor_id+'">'+tutor_name+'</option>');
    if(asst_tutor_id > 0 || asst_tutor_id != '')
    {
        $('#single #single_asst_trainer').append('<option value="'+asst_tutor_id+'">'+asst_tutor_name+'</option>');
    }
    else
    {
        $('#single #single_asst_trainer').append('<option value=""></option>');
    }
    $('#single #single_room_id').append('<option value="'+room_id+'">'+room+'</option>');

    $('#single #add_single_schedule span').text('Update');
   

})

$(document).on('click','.edit_seminar_schedule_row',function(){
    $('#single_tab').trigger('click');
    var temp_row_id =  $(this).attr('data-id');
    $('#single *').filter('.requiredvalue').each(function(){
        $('#single input.requiredvalue').val('');
        $('#single select.requiredvalue option').remove('');
    });
    $('#single #single_asst_trainer option').remove('');
    $('#single #single_evaluation_id option').remove('');

    var course_date     = $('#training_schedule tr#temp_row_'+temp_row_id+' .course_date').val();
    var am_start_time   = $('#training_schedule tr#temp_row_'+temp_row_id+' .am_start_time').val();
    var am_end_time     = $('#training_schedule tr#temp_row_'+temp_row_id+' .am_end_time').val();
    var pm_start_time   = $('#training_schedule tr#temp_row_'+temp_row_id+' .pm_start_time').val();
    var pm_end_time     = $('#training_schedule tr#temp_row_'+temp_row_id+' .pm_end_time').val();
    var tutor_id        = $('#training_schedule tr#temp_row_'+temp_row_id+' .trainer').val();
    var tutor_name      = $('#training_schedule tr#temp_row_'+temp_row_id+' .trainer_name').text();
    var asst_tutor_id   = $('#training_schedule tr#temp_row_'+temp_row_id+' .trainer_2').val();
    var asst_tutor_name = $('#training_schedule tr#temp_row_'+temp_row_id+' .asst_trainer_name').text();
    var room_id         = $('#training_schedule tr#temp_row_'+temp_row_id+' .row_room_id').val();
    var room            = $('#training_schedule tr#temp_row_'+temp_row_id+' .room').text();
    var trainer_rate    = $('#training_schedule tr#temp_row_'+temp_row_id+' .row_trainer_rate').val();
    var asst_trainer_rate = $('#training_schedule tr#temp_row_'+temp_row_id+' .row_asst_trainer_rate').val();
    var evaluation_id   = $('#training_schedule tr#temp_row_'+temp_row_id+' .row_evaluation_id').val();
    var evaluation      = $('#training_schedule tr#temp_row_'+temp_row_id+' .evaluation').text();

    $('#single #temp_row_id').val(temp_row_id);
    $('#single #course_date').val(course_date);
    $('#single #single_am_start_time').val(am_start_time);
    $('#single #single_am_end_time').val(am_end_time);
    $('#single #single_pm_start_time').val(pm_start_time);
    $('#single #single_pm_end_time').val(pm_end_time);
    $('#single #single_trainer_rate').val(trainer_rate);
    $('#single #single_asst_trainer_rate').val(asst_trainer_rate);
    $('#single #single_trainer').append('<option value="'+tutor_id+'">'+tutor_name+'</option>');
    if(asst_tutor_id > 0 || asst_tutor_id != '')
    {
        $('#single #single_asst_trainer').append('<option value="'+asst_tutor_id+'">'+asst_tutor_name+'</option>');
    }
    else
    {
        $('#single #single_asst_trainer').append('<option value=""></option>');
    }
    
    $('#single #single_evaluation_id').append('<option value="'+evaluation_id+'">'+evaluation+'</option>');

    $('#single #add_single_schedule span').text('Update');
   

})

$(document).on('click','.edit_cadet_plus_schedule_row',function(){
    $('#single_tab').trigger('click');
    var temp_row_id =  $(this).attr('data-id');
    $('#single *').filter('.requiredvalue').each(function(){
        $('#single input.requiredvalue').val('');
        $('#single select.requiredvalue option').remove('');
    });
    $('#single #single_asst_trainer option').remove('');

    var course_date     = $('#training_schedule tr#temp_row_'+temp_row_id+' .course_date').val();
    var am_start_time   = $('#training_schedule tr#temp_row_'+temp_row_id+' .am_start_time').val();
    var am_end_time     = $('#training_schedule tr#temp_row_'+temp_row_id+' .am_end_time').val();
    var pm_start_time   = $('#training_schedule tr#temp_row_'+temp_row_id+' .pm_start_time').val();
    var pm_end_time     = $('#training_schedule tr#temp_row_'+temp_row_id+' .pm_end_time').val();
    var tutor_id        = $('#training_schedule tr#temp_row_'+temp_row_id+' .trainer').val();
    var tutor_name      = $('#training_schedule tr#temp_row_'+temp_row_id+' .trainer_name').text();
    var asst_tutor_id   = $('#training_schedule tr#temp_row_'+temp_row_id+' .trainer_2').val();
    var asst_tutor_name = $('#training_schedule tr#temp_row_'+temp_row_id+' .asst_trainer_name').text();
    var evaluation_from_id         = $('#training_schedule tr#temp_row_'+temp_row_id+' .row_evaluation_from_id').val();
    var evaluation_from            = $('#training_schedule tr#temp_row_'+temp_row_id+' .evaluation_from').text();
    
    $('#single #temp_row_id').val(temp_row_id);
    $('#single #course_date').val(course_date);
    $('#single #single_am_start_time').val(am_start_time);
    $('#single #single_am_end_time').val(am_end_time);
    $('#single #single_pm_start_time').val(pm_start_time);
    $('#single #single_pm_end_time').val(pm_end_time);
    $('#single #single_trainer').append('<option value="'+tutor_id+'">'+tutor_name+'</option>');
    if(asst_tutor_id > 0 || asst_tutor_id != '')
    {
        $('#single #single_asst_trainer').append('<option value="'+asst_tutor_id+'">'+asst_tutor_name+'</option>');
    }
    else
    {
        $('#single #single_asst_trainer').append('<option value=""></option>');
    }
    $('#single #single_evaluation_from').append('<option value="'+evaluation_from_id+'">'+evaluation_from+'</option>');

    $('#single #add_single_schedule span').text('Update');
   

})

//#### this function is to append tr to table.
function append_class_date(temp_row_id,course_date,am_start_time,am_end_time,pm_start_time,pm_end_time,trainer_id,trainer_name,asst_trainer_id,asst_trainer_name,room_id,room)
{
    
    var am_timing = '';
    if(am_start_time != '12:00 AM')
    {
        am_timing = am_start_time+ ' To ' + am_end_time;
    }
    var pm_timing = '';
    if(pm_start_time != '12:00 AM')
    {
        pm_timing = pm_start_time+ ' To ' + pm_end_time;
    }


    var new_tr ='<tr id="temp_row_'+temp_row_id+'">';
    new_tr +=       '<td class="row_no">'+temp_row_id+'</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[traning_day_id][]" value="">';
    new_tr +=           '<div class="dropdown">';
    new_tr +=               '<button aria-expanded="false" aria-haspopup="true" class="btn btn-info" data-toggle="dropdown" type="button"><i class="fa fa-sort-amount-desc"></i></button>';
    new_tr +=               '<ul role="menu" class="dropdown-menu profile-dropdown">';
    new_tr +=                   '<li><a href="javascript:void(0)" class="edit_schedule_row" data-id="'+temp_row_id+'"  ><i class="fa fa-gear"></i>Edit</a></li>';
    new_tr +=                   '<li><a href="javascript:void(0)" class="remove_schedule_row" data-id="'+temp_row_id+'" ><i class="fa fa-gear"></i>Delete</a></li>';
    new_tr +=               '</ul>';
    new_tr +=           '</div">';
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[course_date][]" data-row="'+temp_row_id+'" class="course_date" value="'+course_date+'">'+'<span class="course_date_row">'+course_date+'</span>';
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[am_start_time][]" class="am_start_time" value="'+am_start_time+'">';
    new_tr +=           '<input type="hidden" name="course_detail[am_end_time][]" class="am_end_time"  value="'+am_end_time+'">' +'<span class="am_timing_row">'+am_timing+'</span>' ;
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[pm_start_time][]" class="pm_start_time" value="'+pm_start_time+'">';
    new_tr +=           '<input type="hidden" name="course_detail[pm_end_time][]" class="pm_end_time" value="'+pm_end_time+'">' +'<span class="pm_timing_row">'+pm_timing+'</span>' ;
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[trainer][]" class="trainer" value="'+ trainer_id+'">' + '<span class="trainer_name">'+trainer_name+'</span>';
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[trainer_2][]" class="trainer_2" value="'+asst_trainer_id+'">'+'<span class="asst_trainer_name">'+asst_trainer_name+'</span>';
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[room_id][]" class="row_room_id" value="'+ room_id+'">'+'<span class="room">'+room+'</span>';
    new_tr +=       '</td>';
    new_tr +=   '</tr>';
                
    $('#training_schedule tbody').append(new_tr);
    reset_schedule_serial_no();
}

function append_cadet_plus_class_date(temp_row_id,course_date,am_start_time,am_end_time,pm_start_time,pm_end_time,trainer_id,trainer_name,asst_trainer_id,asst_trainer_name,evaluation_from_id,evaluation_from)
{
    // alert(asst_trainer_id);
    // alert(asst_trainer_name);
    var am_timing = '';
    if(am_start_time != '12:00 AM')
    {
        am_timing = am_start_time+ ' To ' + am_end_time;
    }
    var pm_timing = '';
    if(pm_start_time != '12:00 AM')
    {
        pm_timing = pm_start_time+ ' To ' + pm_end_time;
    }


    var new_tr ='<tr id="temp_row_'+temp_row_id+'">';
    new_tr +=       '<td class="row_no">'+temp_row_id+'</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[traning_day_id][]" value="">';
    new_tr +=           '<div class="dropdown">';
    new_tr +=               '<button aria-expanded="false" aria-haspopup="true" class="btn btn-info" data-toggle="dropdown" type="button"><i class="fa fa-sort-amount-desc"></i></button>';
    new_tr +=               '<ul role="menu" class="dropdown-menu profile-dropdown">';
    new_tr +=                   '<li><a href="javascript:void(0)" class="edit_schedule_row" data-id="'+temp_row_id+'"  ><i class="fa fa-gear"></i>Edit</a></li>';
    new_tr +=                   '<li><a href="javascript:void(0)" class="remove_schedule_row" data-id="'+temp_row_id+'" ><i class="fa fa-gear"></i>Delete</a></li>';
    new_tr +=               '</ul>';
    new_tr +=           '</div">';
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[course_date][]" data-row="'+temp_row_id+'" class="course_date" value="'+course_date+'">'+'<span class="course_date_row">'+course_date+'</span>';
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[am_start_time][]" class="am_start_time" value="'+am_start_time+'">';
    new_tr +=           '<input type="hidden" name="course_detail[am_end_time][]" class="am_end_time"  value="'+am_end_time+'">' +'<span class="am_timing_row">'+am_timing+'</span>' ;
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[pm_start_time][]" class="pm_start_time" value="'+pm_start_time+'">';
    new_tr +=           '<input type="hidden" name="course_detail[pm_end_time][]" class="pm_end_time" value="'+pm_end_time+'">' +'<span class="pm_timing_row">'+pm_timing+'</span>' ;
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[trainer][]" class="trainer" value="'+ trainer_id+'">' + '<span class="trainer_name">'+trainer_name+'</span>';
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[trainer_2][]" class="trainer_2" value="'+asst_trainer_id+'">'+'<span class="asst_trainer_name">'+asst_trainer_name+'</span>';
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[evaluation_from_id][]" class="row_evaluation_from_id" value="'+ evaluation_from_id+'">'+'<span class="evaluation_from">'+evaluation_from+'</span>';
    new_tr +=       '</td>';
    new_tr +=   '</tr>';
                
    $('#training_schedule tbody').append(new_tr);
    reset_cadet_plus_schedule_serial_no();
}

function update_class_date(temp_row_id,course_date,am_start_time,am_end_time,pm_start_time,pm_end_time,trainer_id,trainer_name,asst_trainer_id,asst_trainer_name,room_id,room)
{
    var am_timing = '';
    if(am_start_time != '12:00 AM')
    {
        am_timing = am_start_time+ ' To ' + am_end_time;
    }
    var pm_timing = '';
    if(pm_start_time != '12:00 AM')
    {
        pm_timing = pm_start_time+ ' To ' + pm_end_time;
    }

    $('#training_schedule tr#temp_row_'+temp_row_id+' .course_date').val(course_date);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .course_date_row').text(course_date);

    $('#training_schedule tr#temp_row_'+temp_row_id+' .am_start_time').val(am_start_time);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .am_end_time').val(am_end_time);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .am_timing_row').text(am_timing);

    $('#training_schedule tr#temp_row_'+temp_row_id+' .pm_start_time').val(pm_start_time);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .pm_end_time').val(pm_end_time);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .pm_timing_row').text(pm_timing);

    $('#training_schedule tr#temp_row_'+temp_row_id+' .trainer').val(trainer_id);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .trainer_name').text(trainer_name);

    $('#training_schedule tr#temp_row_'+temp_row_id+' .trainer_2').val(asst_trainer_id);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .asst_trainer_name').text(asst_trainer_name);

    $('#training_schedule tr#temp_row_'+temp_row_id+' .row_room_id').val(room_id);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .room').text(room);

    $('#single *').filter('.requiredvalue').each(function(){
        $('#single input.requiredvalue').val('');
        $('#single select.requiredvalue option').remove('');
    });
    $('#single #single_asst_trainer option').remove('');
    $('#single #temp_row_id').val('');

    $('#single #add_single_schedule span').text('Add');
}

function update_cadet_plus_class_date(temp_row_id,course_date,am_start_time,am_end_time,pm_start_time,pm_end_time,trainer_id,trainer_name,asst_trainer_id,asst_trainer_name,evaluation_from_id,evaluation_from)
{
    var am_timing = '';
    if(am_start_time != '12:00 AM')
    {
        am_timing = am_start_time+ ' To ' + am_end_time;
    }
    var pm_timing = '';
    if(pm_start_time != '12:00 AM')
    {
        pm_timing = pm_start_time+ ' To ' + pm_end_time;
    }

    $('#training_schedule tr#temp_row_'+temp_row_id+' .course_date').val(course_date);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .course_date_row').text(course_date);

    $('#training_schedule tr#temp_row_'+temp_row_id+' .am_start_time').val(am_start_time);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .am_end_time').val(am_end_time);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .am_timing_row').text(am_timing);

    $('#training_schedule tr#temp_row_'+temp_row_id+' .pm_start_time').val(pm_start_time);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .pm_end_time').val(pm_end_time);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .pm_timing_row').text(pm_timing);

    $('#training_schedule tr#temp_row_'+temp_row_id+' .trainer').val(trainer_id);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .trainer_name').text(trainer_name);

    $('#training_schedule tr#temp_row_'+temp_row_id+' .trainer_2').val(asst_trainer_id);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .asst_trainer_name').text(asst_trainer_name);

    $('#training_schedule tr#temp_row_'+temp_row_id+' .row_evaluation_from_id').val(evaluation_from_id);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .evaluation_from').text(evaluation_from);

    $('#single *').filter('.requiredvalue').each(function(){
        $('#single input.requiredvalue').val('');
        $('#single select.requiredvalue option').remove('');
    });
    $('#single #single_asst_trainer option').remove('');
    $('#single #temp_row_id').val('');

    $('#single #add_single_schedule span').text('Add');
}

function update_seminar_class_date(temp_row_id,course_date,am_start_time,am_end_time,pm_start_time,pm_end_time,trainer_id,trainer_name,asst_trainer_id,asst_trainer_name,trainer_rate,asst_trainer_rate,evaluation_id,evaluation)
{
    var am_timing = '';
    if(am_start_time != '12:00 AM')
    {
        am_timing = am_start_time+ ' To ' + am_end_time;
    }
    var pm_timing = '';
    if(pm_start_time != '12:00 AM')
    {
        pm_timing = pm_start_time+ ' To ' + pm_end_time;
    }

    $('#training_schedule tr#temp_row_'+temp_row_id+' .course_date').val(course_date);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .course_date_row').text(course_date);

    $('#training_schedule tr#temp_row_'+temp_row_id+' .am_start_time').val(am_start_time);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .am_end_time').val(am_end_time);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .am_timing_row').text(am_timing);

    $('#training_schedule tr#temp_row_'+temp_row_id+' .pm_start_time').val(pm_start_time);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .pm_end_time').val(pm_end_time);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .pm_timing_row').text(pm_timing);

    $('#training_schedule tr#temp_row_'+temp_row_id+' .trainer').val(trainer_id);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .trainer_name').text(trainer_name);

    $('#training_schedule tr#temp_row_'+temp_row_id+' .trainer_2').val(asst_trainer_id);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .asst_trainer_name').text(asst_trainer_name);

    $('#training_schedule tr#temp_row_'+temp_row_id+' .row_trainer_rate').val(trainer_rate);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .trainer_rate').text(trainer_rate);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .row_asst_trainer_rate').val(asst_trainer_rate);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .asst_trainer_rate').text(asst_trainer_rate);

    $('#training_schedule tr#temp_row_'+temp_row_id+' .row_evaluation_id').val(evaluation_id);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .evaluation').text(evaluation);

    $('#single *').filter('.requiredvalue').each(function(){
        $('#single input.requiredvalue').val('');
        $('#single select.requiredvalue option').remove('');
    });
    $('#single #single_asst_trainer option').remove('');
    $('#single #temp_row_id').val('');

    $('#single #add_single_schedule span').text('Add');
}

function append_seminar_class_date(temp_row_id,course_date,am_start_time,am_end_time,pm_start_time,pm_end_time,trainer_id,trainer_name,asst_trainer_id,asst_trainer_name,trainer_rate,asst_trainer_rate,evaluation_id,evaluation)
{
    
    var am_timing = '';
    if(am_start_time != '12:00 AM')
    {
        am_timing = am_start_time+ ' To ' + am_end_time;
    }
    var pm_timing = '';
    if(pm_start_time != '12:00 AM')
    {
        pm_timing = pm_start_time+ ' To ' + pm_end_time;
    }


    var new_tr ='<tr id="temp_row_'+temp_row_id+'">';
    new_tr +=       '<td class="row_no">'+temp_row_id+'</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[traning_day_id][]" value="">';
    new_tr +=           '<div class="dropdown">';
    new_tr +=               '<button aria-expanded="false" aria-haspopup="true" class="btn btn-info" data-toggle="dropdown" type="button"><i class="fa fa-sort-amount-desc"></i></button>';
    new_tr +=               '<ul role="menu" class="dropdown-menu profile-dropdown">';
    new_tr +=                   '<li><a href="javascript:void(0)" class="edit_schedule_row" data-id="'+temp_row_id+'"  ><i class="fa fa-gear"></i>Edit</a></li>';
    new_tr +=                   '<li><a href="javascript:void(0)" class="remove_schedule_row" data-id="'+temp_row_id+'" ><i class="fa fa-gear"></i>Delete</a></li>';
    new_tr +=               '</ul>';
    new_tr +=           '</div">';
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[course_date][]" data-row="'+temp_row_id+'" class="course_date" value="'+course_date+'">'+'<span class="course_date_row">'+course_date+'</span>';
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[am_start_time][]" class="am_start_time" value="'+am_start_time+'">';
    new_tr +=           '<input type="hidden" name="course_detail[am_end_time][]" class="am_end_time"  value="'+am_end_time+'">' +'<span class="am_timing_row">'+am_timing+'</span>' ;
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[pm_start_time][]" class="pm_start_time" value="'+pm_start_time+'">';
    new_tr +=           '<input type="hidden" name="course_detail[pm_end_time][]" class="pm_end_time" value="'+pm_end_time+'">' +'<span class="pm_timing_row">'+pm_timing+'</span>' ;
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[trainer][]" class="trainer" value="'+ trainer_id+'">' + '<span class="trainer_name">'+trainer_name+'</span>';
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[trainer_2][]" class="trainer_2" value="'+asst_trainer_id+'">'+'<span class="asst_trainer_name">'+asst_trainer_name+'</span>';
    new_tr +=       '</td>';
    
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[trainer_rate][]" data-row="'+trainer_rate+'" class="row_trainer_rate" value="'+trainer_rate+'">'+'<span class="trainer_rate">'+trainer_rate+'</span>';
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[asst_trainer_rate][]" data-row="'+asst_trainer_rate+'" class="row_asst_trainer_rate" value="'+asst_trainer_rate+'">'+'<span class="asst_trainer_rate">'+asst_trainer_rate+'</span>';
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[evaluation_id][]" data-row="'+evaluation_id+'" class="row_evaluation_id" value="'+evaluation_id+'">'+'<span class="evaluation">'+evaluation+'</span>';
    new_tr +=       '</td>';
    new_tr +=   '</tr>';
                
    $('#training_schedule tbody').append(new_tr);
    reset_seminar_schedule_serial_no();
}

function reset_schedule_serial_no(){
    var div_no = 1;
    $('#training_schedule .row_no').each(function(){
        $(this).text(div_no);
        div_no ++;
    });
}

function reset_seminar_schedule_serial_no(){
    var div_no = 1;
    $('#training_schedule .row_no').each(function(){
        $(this).text(div_no);
        div_no ++;
    });
}

function reset_cadet_plus_schedule_serial_no(){
    var div_no = 1;
    $('#training_schedule .row_no').each(function(){
        $(this).text(div_no);
        div_no ++;
    });
}

var assessment_temp_id = $('#assessment_day_count').val();
    assessment_temp_id = parseInt(assessment_temp_id);
$(document).on('click','#add_assessment',function(){
    var validate = 'true';
    $('#assessment *').filter('.requiredvalue').each(function(){
        if(this.value == '' || this.value == 0)
        {
            $('.'+this.id+'_error').show();
            validate = 'false';
        }
        else
        {
            $('.'+this.id+'_error').hide();
        }
    });

    var edit_mode               = $('#assessment #assessment_temp_id').val();
    var assessment_type_id      = $('#assessment #assessment_type').val();
    var assessment_type         = $('#assessment #assessment_type option:selected').text();
    var need_attendance         = 'No';
    var assessment_date         = $('#assessment #assessment_date').val(); 
    var assessment_start_time   = $('#assessment #assessment_start_time').val(); 
    var assessment_end_time     = $('#assessment #assessment_end_time').val(); 
    var assessor_id             = $('#assessment #assessor').val();
    var assessor_name           = $('#assessment #assessor option:selected').text();
    var room_id                 = $('#assessment #assessment_room_id').val();
    var room                    = $('#assessment #assessment_room_id option:selected').text();
    if($('#assessment #need_attendance').is(":checked"))
    {
        need_attendance = 'Yes';
    }

    if(validate == 'true')
    {
        $('#assessment_table tbody tr.odd').remove();

        if(edit_mode > 0 )
        {
            var validation_start_time = assessment_start_time;
            var validation_end_time   = assessment_end_time;
            var schedule_id = $('#schedule_id').val();
            validation = check_venue_resources_validation(room_id,assessment_date,validation_start_time,validation_end_time,'sca','assessment_room_id_error',schedule_id);
            if(validation == 'true')
            {
                update_assessment_data(edit_mode,
                                        assessment_type_id,
                                        assessment_type,
                                        need_attendance,
                                        assessment_date,
                                        assessment_start_time,
                                        assessment_end_time,
                                        assessor_id,
                                        assessor_name,
                                        room_id,
                                        room);
            }                            
        }
        else
        {
            //#### Here is to check Room Resource Validation
            var validation_start_time = assessment_start_time;
            var validation_end_time   = assessment_end_time;
            validation = check_venue_resources_validation(room_id,assessment_date,validation_start_time,validation_end_time,'sca','assessment_room_id_error',0);
            if(validation == 'true')
            {
                assessment_temp_id += 1;
                append_assessment_data(assessment_temp_id,
                                        assessment_type_id,
                                        assessment_type,
                                        need_attendance,
                                        assessment_date,
                                        assessment_start_time,
                                        assessment_end_time,
                                        assessor_id,
                                        assessor_name,
                                        room_id,
                                        room);
            }
            
        }
        
    }
})

$(document).on('click','#add_cadet_plus_assessment',function(){
    var validate = 'true';
    $('#assessment *').filter('.requiredvalue').each(function(){
        if(this.value == '' || this.value == 0)
        {
            $('.'+this.id+'_error').show();
            validate = 'false';
        }
        else
        {
            $('.'+this.id+'_error').hide();
        }
    });

    var edit_mode               = $('#assessment #assessment_temp_id').val();
    var assessment_type_id      = $('#assessment #assessment_type').val();
    var assessment_type         = $('#assessment #assessment_type option:selected').text();
    var need_attendance         = 'No';
    var assessment_date         = $('#assessment #assessment_date').val(); 
    var assessment_start_time   = $('#assessment #assessment_start_time').val(); 
    var assessment_end_time     = $('#assessment #assessment_end_time').val(); 
    var assessor_id             = $('#assessment #assessor').val();
    var assessor_name           = $('#assessment #assessor option:selected').text();
    var evaluation_from_id      = $('#assessment #assessment_evaluation_from').val();
    var evaluation_from         = $('#assessment #assessment_evaluation_from option:selected').text();
    if($('#assessment #need_attendance').is(":checked"))
    {
        need_attendance = 'Yes';
    }

    if(validate == 'true')
    {
        $('#assessment_table tbody tr.odd').remove();

        if(edit_mode > 0 )
        {
            update_cadet_plus_assessment_data(edit_mode,
                                    assessment_type_id,
                                    assessment_type,
                                    need_attendance,
                                    assessment_date,
                                    assessment_start_time,
                                    assessment_end_time,
                                    assessor_id,
                                    assessor_name,
                                    evaluation_from_id,
                                    evaluation_from);
        }
        else
        {
            assessment_temp_id += 1;
            append_cadet_plus_assessment_data(assessment_temp_id,
                                    assessment_type_id,
                                    assessment_type,
                                    need_attendance,
                                    assessment_date,
                                    assessment_start_time,
                                    assessment_end_time,
                                    assessor_id,
                                    assessor_name,
                                    evaluation_from_id,
                                    evaluation_from);
        }
        
    }
})  

function append_assessment_data(assessment_temp_id,assessment_type_id,assessment_type,need_attendance,assessment_date,assessment_start_time,assessment_end_time,assessor_id,assessor_name,room_id,room)
{
    var new_tr ='<tr id="temp_row_'+assessment_temp_id+'">';
    new_tr +=       '<td class="row_no">'+assessment_temp_id+'</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="assessment_detail[assessment_detail_id][]" value="">';
    new_tr +=           '<div class="dropdown">';
    new_tr +=               '<button aria-expanded="false" aria-haspopup="true" class="btn btn-info" data-toggle="dropdown" type="button"><i class="fa fa-sort-amount-desc"></i></button>';
    new_tr +=               '<ul role="menu" class="dropdown-menu profile-dropdown">';
    new_tr +=                   '<li><a href="javascript:void(0)" class="edit_assessment_row" data-id="'+assessment_temp_id+'"  ><i class="fa fa-gear"></i>Edit</a></li>';
    new_tr +=                   '<li><a href="javascript:void(0)" class="remove_assessment_row" data-id="'+assessment_temp_id+'" ><i class="fa fa-gear"></i>Delete</a></li>';
    new_tr +=               '</ul>';
    new_tr +=           '</div">';
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="assessment_detail[assessment_type][]" data-row="'+assessment_temp_id+'" class="assessment_type" value="'+assessment_type_id+'">'+'<span class="assessment_type_row">'+assessment_type+'</span>';
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="assessment_detail[need_attendance][]" class="need_attendance" value="'+need_attendance+'">';
    new_tr +=           '<span class="row_attendance">'+need_attendance+'</span>'
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="assessment_detail[assessment_date][]" class="assessment_date"  value="'+assessment_date+'">' +'<span class="assessment_date_row">'+assessment_date+'</span>' ;
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="assessment_detail[assessment_start_time][]" class="assessment_start_time" value="'+assessment_start_time+'">' +'<span class="assessment_start_time_row">'+assessment_start_time+'</span>' ;
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="assessment_detail[assessment_end_time][]" class="assessment_end_time" value="'+assessment_end_time+'">' +'<span class="assessment_end_time_row">'+assessment_end_time+'</span>' ;
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="assessment_detail[assessor_id][]" class="assessor_id" value="'+ assessor_id+'">' + '<span class="assessor_name">'+assessor_name+'</span>';
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="assessment_detail[assessment_room_id][]" class="room_id" value="'+ room_id+'">'+'<span class="room">'+room+'</span>';
    new_tr +=       '</td>';
    new_tr +=   '</tr>';
                
    $('#assessment_table tbody').append(new_tr);
    reset_assessment_serial_no();
}

function append_cadet_plus_assessment_data(assessment_temp_id,assessment_type_id,assessment_type,need_attendance,assessment_date,assessment_start_time,assessment_end_time,assessor_id,assessor_name,evaluation_from_id,evaluation_from)
{
    var new_tr ='<tr id="temp_row_'+assessment_temp_id+'">';
    new_tr +=       '<td class="row_no">'+assessment_temp_id+'</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="assessment_detail[assessment_detail_id][]" value="">';
    new_tr +=           '<div class="dropdown">';
    new_tr +=               '<button aria-expanded="false" aria-haspopup="true" class="btn btn-info" data-toggle="dropdown" type="button"><i class="fa fa-sort-amount-desc"></i></button>';
    new_tr +=               '<ul role="menu" class="dropdown-menu profile-dropdown">';
    new_tr +=                   '<li><a href="javascript:void(0)" class="edit_assessment_row" data-id="'+assessment_temp_id+'"  ><i class="fa fa-gear"></i>Edit</a></li>';
    new_tr +=                   '<li><a href="javascript:void(0)" class="remove_assessment_row" data-id="'+assessment_temp_id+'" ><i class="fa fa-gear"></i>Delete</a></li>';
    new_tr +=               '</ul>';
    new_tr +=           '</div">';
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="assessment_detail[assessment_type][]" data-row="'+assessment_temp_id+'" class="assessment_type" value="'+assessment_type_id+'">'+'<span class="assessment_type_row">'+assessment_type+'</span>';
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="assessment_detail[need_attendance][]" class="need_attendance" value="'+need_attendance+'">';
    new_tr +=           '<span class="row_attendance">'+need_attendance+'</span>'
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="assessment_detail[assessment_date][]" class="assessment_date"  value="'+assessment_date+'">' +'<span class="assessment_date_row">'+assessment_date+'</span>' ;
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="assessment_detail[assessment_start_time][]" class="assessment_start_time" value="'+assessment_start_time+'">' +'<span class="assessment_start_time_row">'+assessment_start_time+'</span>' ;
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="assessment_detail[assessment_end_time][]" class="assessment_end_time" value="'+assessment_end_time+'">' +'<span class="assessment_end_time_row">'+assessment_end_time+'</span>' ;
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="assessment_detail[assessor_id][]" class="assessor_id" value="'+ assessor_id+'">' + '<span class="assessor_name">'+assessor_name+'</span>';
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="assessment_detail[assessment_evaluation_from][]" class="evaluation_from_id" value="'+ evaluation_from_id+'">'+'<span class="evaluation_from">'+evaluation_from+'</span>';
    new_tr +=       '</td>';
    new_tr +=   '</tr>';
                
    $('#assessment_table tbody').append(new_tr);
    reset_cadet_plus_assessment_serial_no();
}


$(document).on('click','.remove_assessment_row',function(){
    var assessment_temp_id =  $(this).attr('data-id');
    var data_delete = $(this).attr('data-delete');
    if(data_delete != '' && data_delete == 'Yes')
    {
        var data_id = $(this).attr('table-id')
        $.ajax({
            type: "GET",
            url: CI.base_url+"course_management/change_schedule_detail_status/",
            data: { 
                table : 'course_schedule_assessment',
                id : data_id,
                status : 'I',
                usage_type   : 'sca',
            },
            success: function(data) {
                $('#assessment_table tbody tr#temp_row_'+assessment_temp_id).remove();
                reset_assessment_serial_no();
            }
        });
    }
    else
    {
        $('#assessment_table tbody tr#temp_row_'+assessment_temp_id).remove();
        reset_assessment_serial_no();
    }
    
})


$(document).on('click','.remove_cadet_plus_assessment_row',function(){
    var assessment_temp_id =  $(this).attr('data-id');
    var data_delete = $(this).attr('data-delete');
    if(data_delete != '' && data_delete == 'Yes')
    {
        var data_id = $(this).attr('table-id')
        $.ajax({
            type: "GET",
            url: CI.base_url+"cadet_plus_course_management/change_schedule_detail_status/",
            data: { 
                table : 'cadet_plus_course_schedule_assessment  ',
                id : data_id,
                status : 'I',
            },
            success: function(data) {
                $('#assessment_table tbody tr#temp_row_'+assessment_temp_id).remove();
                reset_cadet_plus_assessment_serial_no();
            }
        });
    }
    else
    {
        $('#assessment_table tbody tr#temp_row_'+assessment_temp_id).remove();
        reset_cadet_plus_assessment_serial_no();
    }
    
})

$(document).on('click','.edit_assessment_row',function(){
    $('#assessment_tab').trigger('click');
    var assessment_temp_id =  $(this).attr('data-id');
    $('#assessment *').filter('.requiredvalue').each(function(){
        $('#assessment input.requiredvalue').val('');
        $('#assessment select.requiredvalue option').remove('');
    });
    $('#assessment #assessment_room_id option').remove('');

    var assessment_type_id      = $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessment_type').val();
    var assessment_type         = $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessment_type_row').text();
    var assessment_date         = $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessment_date').val();
    var need_attendance         = $('#assessment_table tr#temp_row_'+assessment_temp_id+' .need_attendance').val();
    var assessment_start_time   = $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessment_start_time').val();
    var assessment_end_time     = $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessment_end_time').val();
    var assessor_id             = $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessor_id').val();
    var assessor_name           = $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessor_name').text();
    var room_id                 = $('#assessment_table tr#temp_row_'+assessment_temp_id+' .room_id').val();
    var room                    = $('#assessment_table tr#temp_row_'+assessment_temp_id+' .room').text();

    $('#assessment #assessment_temp_id').val(assessment_temp_id);
    $('#assessment #assessment_type').append('<option value="'+assessment_type_id+'">'+assessment_type+'</option>');
    $('#assessment #assessment_date').val(assessment_date);
    $('#assessment #assessment_start_time').val(assessment_start_time);
    $('#assessment #assessment_end_time').val(assessment_end_time);
    $('#assessment #assessor').append('<option value="'+assessor_id+'">'+assessor_name+'</option>');
    if(need_attendance == 'Yes')
    {
        $('#assessment #need_attendance').prop( "checked", true );
    }
    else
    {
        $('#assessment #need_attendance').prop( "checked", false );
    }
    if(room_id > 0 || room_id != '')
    {
        $('#assessment #assessment_room_id').append('<option value="'+room_id+'">'+room+'</option>');
    }
    else
    {
        $('#assessment #assessment_room_id').append('<option value=""></option>');
    }

    $('#assessment #add_assessment span').text('Update');
})

$(document).on('click','.edit_cadet_plus_assessment_row',function(){
    $('#assessment_tab').trigger('click');
    var assessment_temp_id =  $(this).attr('data-id');
    $('#assessment *').filter('.requiredvalue').each(function(){
        $('#assessment input.requiredvalue').val('');
        $('#assessment select.requiredvalue option').remove('');
    });
    $('#assessment #assessment_evaluation_from option').remove('');

    var assessment_type_id      = $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessment_type').val();
    var assessment_type         = $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessment_type_row').text();
    var assessment_date         = $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessment_date').val();
    var need_attendance         = $('#assessment_table tr#temp_row_'+assessment_temp_id+' .need_attendance').val();
    var assessment_start_time   = $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessment_start_time').val();
    var assessment_end_time     = $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessment_end_time').val();
    var assessor_id             = $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessor_id').val();
    var assessor_name           = $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessor_name').text();
    var evaluation_from_id      = $('#assessment_table tr#temp_row_'+assessment_temp_id+' .evaluation_from_id').val();
    var evaluation_from         = $('#assessment_table tr#temp_row_'+assessment_temp_id+' .evaluation_from').text();
    // alert(evaluation_from_id);
    // alert(evaluation_from);
    $('#assessment #assessment_temp_id').val(assessment_temp_id);
    $('#assessment #assessment_type').append('<option value="'+assessment_type_id+'">'+assessment_type+'</option>');
    $('#assessment #assessment_date').val(assessment_date);
    $('#assessment #assessment_start_time').val(assessment_start_time);
    $('#assessment #assessment_end_time').val(assessment_end_time);
    $('#assessment #assessor').append('<option value="'+assessor_id+'">'+assessor_name+'</option>');
    if(need_attendance == 'Yes')
    {
        $('#assessment #need_attendance').prop( "checked", true );
    }
    else
    {
        $('#assessment #need_attendance').prop( "checked", false );
    }
    if(evaluation_from_id > 0 || evaluation_from != '')
    {
        $('#assessment #assessment_evaluation_from').append('<option value="'+evaluation_from_id+'">'+evaluation_from+'</option>');
    }
    else
    {
        $('#assessment #assessment_evaluation_from').append('<option value=""></option>');
    }

    $('#assessment #add_assessment span').text('Update');
})


function update_assessment_data(assessment_temp_id,assessment_type_id,assessment_type,need_attendance,assessment_date,assessment_start_time,assessment_end_time,assessor_id,assessor_name,room_id,room)
{

    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessment_type').val(assessment_type_id);
    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessment_type_row').text(assessment_type);

    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .row_attendance').text(need_attendance);
    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .need_attendance').val(need_attendance);

    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessment_date').val(assessment_date);
    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessment_date_row').text(assessment_date);

    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessment_start_time').val(assessment_start_time);
    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessment_start_time_row').text(assessment_start_time);

    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessment_end_time').val(assessment_end_time);
    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessment_end_time_row').text(assessment_end_time);

    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessor_id').val(assessor_id);
    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessor_name').text(assessor_name);

    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .room_id').val(room_id);
    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .room').text(room);

    $('#assessment *').filter('.requiredvalue').each(function(){
        $('#assessment input.requiredvalue').val('');
        $('#assessment select.requiredvalue option').remove('');
    });
    $('#assessment #need_attendance').prop( "checked", false );
    $('#assessment #assessment_room_id option').remove('');
    $('#assessment #assessment_temp_id').val('');

    $('#assessment #add_assessment span').text('Add');
}

function update_cadet_plus_assessment_data(assessment_temp_id,assessment_type_id,assessment_type,need_attendance,assessment_date,assessment_start_time,assessment_end_time,assessor_id,assessor_name,evaluation_from_id,evaluation_from)
{

    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessment_type').val(assessment_type_id);
    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessment_type_row').text(assessment_type);

    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .row_attendance').text(need_attendance);
    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .need_attendance').val(need_attendance);

    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessment_date').val(assessment_date);
    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessment_date_row').text(assessment_date);

    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessment_start_time').val(assessment_start_time);
    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessment_start_time_row').text(assessment_start_time);

    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessment_end_time').val(assessment_end_time);
    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessment_end_time_row').text(assessment_end_time);

    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessor_id').val(assessor_id);
    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .assessor_name').text(assessor_name);

    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .evaluation_from_id').val(evaluation_from_id);
    $('#assessment_table tr#temp_row_'+assessment_temp_id+' .evaluation_from').text(evaluation_from);

    $('#assessment *').filter('.requiredvalue').each(function(){
        $('#assessment input.requiredvalue').val('');
        $('#assessment select.requiredvalue option').remove('');
    });
    $('#assessment #need_attendance').prop( "checked", false );
    $('#assessment #assessment_evaluation_from option').remove('');
    $('#assessment #assessment_temp_id').val('');

    $('#assessment #add_assessment span').text('Add');
}

function reset_assessment_serial_no(){
    var div_no = 1;
    $('#assessment_table .row_no').each(function(){
        $(this).text(div_no);
        div_no ++;
    });
}
    $('.lead_timepicker').timepicker({
        showMeridian: true, 
        showInputs:true, 
        showSeconds:false, 
        minuteStep:5
    })
    
function reset_cadet_plus_assessment_serial_no(){
    var div_no = 1;
    $('#assessment_table .row_no').each(function(){
        $(this).text(div_no);
        div_no ++;
    });
}
$(document).on('click','.module_remove_assessment_row',function(){
    var assessment_temp_id =  $(this).attr('data-id');
    var data_delete = $(this).attr('data-delete');
    if(data_delete != '' && data_delete == 'Yes')
    {
        var data_id = $(this).attr('table-id')
        $.ajax({
            type: "GET",
            url: CI.base_url+"module_course_management/change_schedule_detail_status/",
            data: { 
                table : 'module_course_schedule_assessment',
                id : data_id,
                status : 'I',
                usage_type   : 'msa',
            },
            success: function(data) {
                $('#assessment_table tbody tr#temp_row_'+assessment_temp_id).remove();
                reset_assessment_serial_no();
            }
        });
    }
    else
    {
        $('#assessment_table tbody tr#temp_row_'+assessment_temp_id).remove();
        reset_assessment_serial_no();
    }
    
})
$(document).on('click','.module_remove_schedule_row',function(){
    var temp_row_id =  $(this).attr('data-id');
    var data_delete = $(this).attr('data-delete');
    if(data_delete != '' && data_delete == 'Yes')
    {
        var data_id = $(this).attr('table-id')
        $.ajax({
            type: "GET",
            url: CI.base_url+"module_course_management/change_schedule_detail_status/",
            data: { 
                table : 'module_course_schedule_detail',
                id : data_id,
                status : 'I',
            },
            success: function(data) {
                $('#training_schedule tbody tr#temp_row_'+temp_row_id).remove();
                reset_schedule_serial_no();
            }
        });
    }
    else
    {
        $('#training_schedule tbody tr#temp_row_'+temp_row_id).remove();
        reset_schedule_serial_no();
    }
})
$(document).on('click','#module_add_single_schedule',function(){
    var validate = 'true';
    $('.course_date_error').text('This field is required.');
    $('#single *').filter('.requiredvalue').each(function(){
        if(this.value == '' || this.value == 0)
        {
            $('.'+this.id+'_error').show();
            validate = 'false';
        }
        else
        {
            $('.'+this.id+'_error').hide();
        }
    });

    var edit_mode = $('#single #temp_row_id').val();
    var course_date = $('#single #course_date').val();
    var am_start_time = $('#single #single_am_start_time').val();
    var am_end_time = $('#single #single_am_end_time').val();
    var pm_start_time = $('#single #single_pm_start_time').val();
    var pm_end_time = $('#single #single_pm_end_time').val();
    var trainer_id = $('#single #single_trainer').val();
    var trainer_name = $('#single #single_trainer option:selected').text();
    var asst_trainer_id = $('#single #single_asst_trainer').val();
    var asst_trainer_name = $('#single #single_asst_trainer option:selected').text();
    var room_id = $('#single #single_room_id').val();
    var room = $('#single #single_room_id option:selected').text();
    var am_room_id = $('#single #single_am_room_id').val();
    var am_room = $('#single #single_am_room_id option:selected').text();
    var pm_room_id = $('#single #single_pm_room_id').val();
    var pm_room = $('#single #single_pm_room_id option:selected').text();
    var trainer_rate = $('#single #single_trainer_rate').val();
    var trainer_rate_2 = $('#single #single_trainer_rate_2').val();
   
    if(edit_mode > 0)
    {
        $('.course_date').each(function(){
            if($(this).val() == course_date && edit_mode != $(this).attr('data-row') )
            {
                $('.course_date_error').text('Duplicate Date');
                $('.course_date_error').show();
                validate = false;
            }
        });
        if(validate == 'true')
        {   
            //#### Here is to check Room Resource Validation
            var validation_start_time = am_start_time;
            var validation_end_time   = pm_end_time;
            var schedule_id           = $('#schedule_id').val();
            if(am_start_time == '' || am_start_time == '12:00 AM')
            {
                validation_start_time = pm_start_time;
            }
            if(pm_end_time == '' || pm_end_time == '12:00 AM')
            {
                validation_end_time = am_end_time;
            }
            validation = check_venue_resources_validation(room_id,course_date,validation_start_time,validation_end_time,'ms','single_room_id_error',schedule_id);
            if(validate == 'true')
            {   
                module_update_class_date(edit_mode,course_date,am_start_time,am_end_time,pm_start_time,pm_end_time,trainer_id,trainer_name,asst_trainer_id,asst_trainer_name,room_id,room,am_room_id,am_room,pm_room_id,pm_room,trainer_rate,trainer_rate_2);
            }
        }
        
    }
    else
    {

        $('.course_date').each(function(){
            if($(this).val() == course_date)
            {
                $('.course_date_error').text('Duplicate Date');
                $('.course_date_error').show();
                validate = false;
            }
        });
		var validation_start_time = am_start_time;
		var validation_end_time   = pm_end_time;
		if(am_start_time == '' || am_start_time == '12:00 AM')
		{
			validation_start_time = pm_start_time;
		}
		if(pm_end_time == '' || pm_end_time == '12:00 AM')
		{
			validation_end_time = am_end_time;
		}
		validation = check_venue_resources_validation(room_id,course_date,validation_start_time,validation_end_time,'ms','single_room_id_error',0);
        if(validate == 'true')
        {
            $('#training_schedule tbody tr.emptyrow').remove();
            temp_row_id +=1;
            module_append_class_date(temp_row_id,course_date,am_start_time,am_end_time,pm_start_time,pm_end_time,trainer_id,trainer_name,asst_trainer_id,asst_trainer_name,room_id,room,am_room_id,am_room,pm_room_id,pm_room,trainer_rate,trainer_rate_2);
        }
    }
})
function module_update_class_date(temp_row_id,course_date,am_start_time,am_end_time,pm_start_time,pm_end_time,trainer_id,trainer_name,asst_trainer_id,asst_trainer_name,room_id,room,am_room_id,am_room,pm_room_id,pm_room,trainer_rate,trainer_rate_2)
{
    var am_timing = '';
    if(am_start_time != '12:00 AM')
    {
        am_timing = am_start_time+ ' To ' + am_end_time;
    }
    var pm_timing = '';
    if(pm_start_time != '12:00 AM')
    {
        pm_timing = pm_start_time+ ' To ' + pm_end_time;
    }

    $('#training_schedule tr#temp_row_'+temp_row_id+' .course_date').val(course_date);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .course_date_row').text(course_date);

    $('#training_schedule tr#temp_row_'+temp_row_id+' .am_start_time').val(am_start_time);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .am_end_time').val(am_end_time);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .am_timing_row').text(am_timing);

    $('#training_schedule tr#temp_row_'+temp_row_id+' .pm_start_time').val(pm_start_time);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .pm_end_time').val(pm_end_time);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .pm_timing_row').text(pm_timing);

    $('#training_schedule tr#temp_row_'+temp_row_id+' .trainer').val(trainer_id);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .trainer_name').text(trainer_name);

    $('#training_schedule tr#temp_row_'+temp_row_id+' .trainer_2').val(asst_trainer_id);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .asst_trainer_name').text(asst_trainer_name);

    /*$('#training_schedule tr#temp_row_'+temp_row_id+' .row_room_id').val(room_id);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .room').text(room);*/

    $('#training_schedule tr#temp_row_'+temp_row_id+' .row_am_room_id').val(am_room_id);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .am_room_row').text(am_room);

    $('#training_schedule tr#temp_row_'+temp_row_id+' .row_pm_room_id').val(pm_room_id);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .pm_room_row').text(pm_room);
    
    $('#training_schedule tr#temp_row_'+temp_row_id+' .row_trainer_rate').val(trainer_rate);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .trainer_rate_row').text(trainer_rate);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .row_trainer_rate_2').val(trainer_rate_2);
    $('#training_schedule tr#temp_row_'+temp_row_id+' .trainer_rate_2_row').text(trainer_rate_2);

    $('#single *').filter('.requiredvalue').each(function(){
        $('#single input.requiredvalue').val('');
        $('#single select.requiredvalue option').remove('');
    });
    $('#single #single_asst_trainer option').remove('');
    $('#single #temp_row_id').val('');

    $('#single #module_add_single_schedule span').text('Add');
}
function module_append_class_date(temp_row_id,course_date,am_start_time,am_end_time,pm_start_time,pm_end_time,trainer_id,trainer_name,asst_trainer_id,asst_trainer_name,room_id,room,am_room_id,am_room,pm_room_id,pm_room,trainer_rate,trainer_rate_2)
{
    
    var am_timing = '';
    if(am_start_time != '12:00 AM')
    {
        am_timing = am_start_time+ ' To ' + am_end_time;
    }
    var pm_timing = '';
    if(pm_start_time != '12:00 AM')
    {
        pm_timing = pm_start_time+ ' To ' + pm_end_time;
    }


    var new_tr ='<tr id="temp_row_'+temp_row_id+'">';
    new_tr +=       '<td class="row_no">'+temp_row_id+'</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[traning_day_id][]" value="">';
    new_tr +=           '<div class="dropdown">';
    new_tr +=               '<button aria-expanded="false" aria-haspopup="true" class="btn btn-info" data-toggle="dropdown" type="button"><i class="fa fa-sort-amount-desc"></i></button>';
    new_tr +=               '<ul role="menu" class="dropdown-menu profile-dropdown">';
    new_tr +=                   '<li><a href="javascript:void(0)" class="edit_module_schedule_row" data-id="'+temp_row_id+'"  ><i class="fa fa-gear"></i>Edit</a></li>';
    new_tr +=                   '<li><a href="javascript:void(0)" class="remove_schedule_row" data-id="'+temp_row_id+'" ><i class="fa fa-gear"></i>Delete</a></li>';
    new_tr +=               '</ul>';
    new_tr +=           '</div">';
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[course_date][]" data-row="'+temp_row_id+'" class="course_date" value="'+course_date+'">'+'<span class="course_date_row">'+course_date+'</span>';
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[am_start_time][]" class="am_start_time" value="'+am_start_time+'">';
    new_tr +=           '<input type="hidden" name="course_detail[am_end_time][]" class="am_end_time"  value="'+am_end_time+'">' +'<span class="am_timing_row">'+am_timing+'</span>' ;
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[pm_start_time][]" class="pm_start_time" value="'+pm_start_time+'">';
    new_tr +=           '<input type="hidden" name="course_detail[pm_end_time][]" class="pm_end_time" value="'+pm_end_time+'">' +'<span class="pm_timing_row">'+pm_timing+'</span>' ;
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[trainer][]" class="trainer" value="'+ trainer_id+'">' + '<span class="trainer_name">'+trainer_name+'</span>';
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[trainer_2][]" class="trainer_2" value="'+asst_trainer_id+'">'+'<span class="asst_trainer_name">'+asst_trainer_name+'</span>';
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[am_room_id][]" class="am_room_id" value="'+ am_room_id+'">'+'<span class="am_room_id">'+am_room+'</span>';
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[trainer_rate][]" class="trainer_rate" value="'+ trainer_rate+'">'+'<span class="trainer_rate">'+trainer_rate+'</span>';
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[pm_room_id][]" class="pm_room_id" value="'+ pm_room_id+'">'+'<span class="pm_room_id">'+pm_room+'</span>';
    new_tr +=       '</td>';
    new_tr +=       '<td>';
    new_tr +=           '<input type="hidden" name="course_detail[trainer_rate_2][]" class="trainer_rate_2" value="'+ trainer_rate_2+'">'+'<span class="trainer_rate_2">'+trainer_rate_2+'</span>';
    new_tr +=       '</td>';
    new_tr +=   '</tr>';
                
    $('#training_schedule tbody').append(new_tr);
    reset_schedule_serial_no();
}
$(document).on('click','#module_add_recurring_schedule',function(){
    var from_date = $('#recurring #from_date').val();
    var to_date = $('#recurring #to_date').val();
    var searchDays = $("#recurring input:checkbox:checked").map(function(){
                        return $(this).val();
                    }).get();
    var validate = 'true';
    $('.course_date_error').text('This field is required.');
    $('#recurring *').filter('.requiredvalue').each(function(){
        if(this.value == '' || this.value == 0)
        {
            $('.'+this.id+'_error').show();
            validate = 'false';
        }
        else
        {
            $('.'+this.id+'_error').hide();
        }
    });

    // #### validation for day checkbox
    var checked = 0;
    $('#recurring input[type=checkbox]').each(function(){
        if(this.checked)
        {
            checked = 1;
        }
    })
    if(checked == 0)
    {
        $('.day_check_error').show();
        validate = 'false';
    }
    else
    {
        $('.day_check_error').hide();
    }
    
    var am_start_time = $('#recurring #recuring_am_start_time').val();
    var am_end_time = $('#recurring #recuring_am_end_time').val();
    var pm_start_time = $('#recurring #recuring_pm_start_time').val();
    var pm_end_time = $('#recurring #recuring_pm_end_time').val();
    var trainer_id = $('#recurring #recuring_trainer').val();
    var trainer_name = $('#recurring #recuring_trainer option:selected').text();
    var asst_trainer_id = $('#recurring #recuring_asst_trainer').val();
    var asst_trainer_name = $('#recurring #recuring_asst_trainer option:selected').text();
    var room_id = $('#recurring #recurring_room_id').val();
    var room = $('#recurring #recurring_room_id option:selected').text();
    var am_room_id = $('#recurring #recurring_am_room_id').val();
    var am_room = $('#recurring #recurring_am_room_id option:selected').text();
    var pm_room_id = $('#recurring #recurring_pm_room_id').val();
    var pm_room = $('#recurring #recurring_pm_room_id option:selected').text();
    var trainer_rate = $('#recurring #recurring_trainer_rate').val();
    var trainer_rate_2 = $('#recurring #recurring_trainer_rate_2').val();

    if(validate == 'true')
    {
        var courseDateArray = [];
        $('.course_date').each(function(){
            courseDateArray.push($(this).val());
        });
        $('#training_schedule tbody tr.odd').remove();
        $.ajax({
            type: "GET",
            url: CI.base_url+"general/get_recurring_date/",
            data: { 
                from_date : from_date,
                to_date : to_date,
                searchDays : searchDays,
                courseDateArray : courseDateArray,
            },
            success: function(data) {
                var result = jQuery.parseJSON(data);
                result.forEach(course_date => {
                    temp_row_id +=1;
                    //module_append_class_date(temp_row_id,course_date,am_start_time,am_end_time,pm_start_time,pm_end_time,trainer_id,trainer_name,asst_trainer_id,asst_trainer_name,room_id,room);
                    module_append_class_date(temp_row_id,course_date,am_start_time,am_end_time,pm_start_time,pm_end_time,trainer_id,trainer_name,asst_trainer_id,asst_trainer_name,room_id,room,am_room_id,am_room,pm_room_id,pm_room,trainer_rate,trainer_rate_2);
                });
            }
        });
    }
    
})
$(document).on('click','.edit_module_schedule_row',function(){
    $('#single_tab').trigger('click');
    var temp_row_id =  $(this).attr('data-id');
    $('#single *').filter('.requiredvalue').each(function(){
        $('#single input.requiredvalue').val('');
        $('#single select.requiredvalue option').remove('');
    });
    $('#single #single_asst_trainer option').remove('');

    var course_date     = $('#training_schedule tr#temp_row_'+temp_row_id+' .course_date').val();
    var am_start_time   = $('#training_schedule tr#temp_row_'+temp_row_id+' .am_start_time').val();
    var am_end_time     = $('#training_schedule tr#temp_row_'+temp_row_id+' .am_end_time').val();
    var pm_start_time   = $('#training_schedule tr#temp_row_'+temp_row_id+' .pm_start_time').val();
    var pm_end_time     = $('#training_schedule tr#temp_row_'+temp_row_id+' .pm_end_time').val();
    var tutor_id        = $('#training_schedule tr#temp_row_'+temp_row_id+' .trainer').val();
    var tutor_name      = $('#training_schedule tr#temp_row_'+temp_row_id+' .trainer_name').text();
    var asst_tutor_id   = $('#training_schedule tr#temp_row_'+temp_row_id+' .trainer_2').val();
    var asst_tutor_name = $('#training_schedule tr#temp_row_'+temp_row_id+' .asst_trainer_name').text();
    var am_room_id      = $('#training_schedule tr#temp_row_'+temp_row_id+' .row_am_room_id').val();
    var pm_room_id      = $('#training_schedule tr#temp_row_'+temp_row_id+' .row_pm_room_id').val();
    var am_room         = $('#training_schedule tr#temp_row_'+temp_row_id+' .am_room_row').text();
    var pm_room         = $('#training_schedule tr#temp_row_'+temp_row_id+' .pm_room_row').text();
    var trainer_rate    = $('#training_schedule tr#temp_row_'+temp_row_id+' .row_trainer_rate').val();
    var trainer_rate_2  = $('#training_schedule tr#temp_row_'+temp_row_id+' .row_trainer_rate_2').val();

    $('#single #temp_row_id').val(temp_row_id);
    $('#single #course_date').val(course_date);
    $('#single #single_am_start_time').val(am_start_time);
    $('#single #single_am_end_time').val(am_end_time);
    $('#single #single_pm_start_time').val(pm_start_time);
    $('#single #single_pm_end_time').val(pm_end_time);
    $('#single #single_trainer').append('<option value="'+tutor_id+'">'+tutor_name+'</option>');
    if(asst_tutor_id > 0 || asst_tutor_id != '')
    {
        $('#single #single_asst_trainer').append('<option value="'+asst_tutor_id+'">'+asst_tutor_name+'</option>');
    }
    else
    {
        $('#single #single_asst_trainer').append('<option value=""></option>');
    }
    /*$('#single #single_room_id').append('<option value="'+room_id+'">'+room+'</option>');*/
    $('#single #single_am_room_id').append('<option value="'+am_room_id+'">'+am_room+'</option>');
    $('#single #single_pm_room_id').append('<option value="'+pm_room_id+'">'+pm_room+'</option>');
    $('#single #single_trainer_rate').val(trainer_rate);
    $('#single #single_trainer_rate_2').val(trainer_rate_2);
    $('#single #module_add_single_schedule span').text('Update');
   

})
//################### End Schedule Page.

function check_venue_resources_validation(room_id,course_date,validation_start_time,validation_end_time,type,error_class,data_id)
{
    var validation = 'true';
    $.ajax({
        type: "GET",
        url: CI.base_url+"general/check_venue_resources_validation/",
        async : false,
        data: { 
            room_id                 : room_id,
            course_date             : course_date,
            validation_start_time   : validation_start_time,
            validation_end_time     : validation_end_time,
            type                    : type,
            data_id                 : data_id,
        },
        success: function(data) {
            if(data != '')
            {
                $('.'+error_class).text(data);
                $('.'+error_class).show();

                validation = 'false';
            }
            else
            {
                $('.'+error_class).text('This field is required.');
                $('.'+error_class).hide();
            }
        }
    });

    return validation;
}

function check_student_by_type(ele) {
    var id_tag = ele.id;
    var type = $("#" + id_tag + " option:selected").val();
    
    if (type == 2) {
        $('#email_id_msg').hide();
        $(".company").prop('required', true);
        $('#corporate').fadeIn();
        $('#add_student_button').show();
        $('#password_div').fadeOut();
        var $csrf_token_id_value = $("#csrf_token_id").val();
        $.ajax({
            type : "POST",
            data : {
                    u_token:$csrf_token_id_value,
                    type : type,
                    company_id: $('#company_id').val(),
                },
            url : base_url + "general/json_get_company_list/",
            success : function(data) {
                var result = jQuery.parseJSON(data);
                $('.company').html('<option></option>');
                for ( i = 0; i < result.length; i++) {
                    $('.company').append($("<option value='" + result[i].id + "'>" + result[i].company_name + "</option>"));
                }
                
            }
        });
        $('.company').removeClass('select-8-wrapper select2-hidden-accessible');
        $('.company').select2();
    }else if (type == 3) {
        $('#email_id_msg').hide();
        $('#add_student_button').hide();
        $(".company").prop('required', true);
        $('#corporate').fadeIn();
        $('#password_div').fadeOut();
        var $csrf_token_id_value = $("#csrf_token_id").val();
        $.ajax({
            type : "POST",
            data : {
                    u_token:$csrf_token_id_value,
                    type : type,
                    agent_id: $('#agent_id').val(),
                    company_id: $('#company_id').val(),
            },
            url : base_url + "general/json_get_company_list",
            success : function(data) {
                var result = jQuery.parseJSON(data);
                $('.company').html('<option></option>');
                for ( i = 0; i < result.length; i++) {
                    $('.company').append($("<option value='" + result[i].id + "'>" + result[i].company_name + "</option>"));
                }

            }
        });
        $('.company').removeClass('select-8-wrapper select2-hidden-accessible');
        $('.company').select2();
        
    }else {
        $(".mobile_req").html('*');
        $(".company").prop('required', false);
        $('#corporate').fadeOut();
        $('#password_div').fadeIn();
        $('#company_detail').fadeOut();
        $('#company_detail1').fadeOut();
        $('#add_student_button').hide();
        $('#email_id_msg').show();
    }
} 

function get_company_detail() {

    var company_id = $('#corporate_id').val();
        
        $.ajax({
            type : "GET",
            data : {
                    company_id:company_id
                },
            url : base_url + "student_management/json_get_company_detail/",
            success : function(data) {
                var result = jQuery.parseJSON(data);

                $('#company_detail').show();
                $('#company_detail1').show();
                $('#company_address').text(result.address);
                $('#industry_type').text(result.address);
                $('#contact_name').text(result.contact_person);
                $('#company_email').text(result.email);
                $('#contact_no').text(result.contact_number);
                $('#billing_address').text(result.billing_address);
                
            }
        });
}

function check_discount(ele,base_url){
    var id_tag = ele.id;
    var schedule_id = $("#" + id_tag + " option:selected").val();
    var $csrf_token_id_value = $("#csrf_token_id").val();
    $.ajax({
        type : "POST",
        url : base_url + "general/check_discount/",
        data : {
            schedule_id : schedule_id,
            u_token: $csrf_token_id_value,
        },
        success : function(data) {
            var result = jQuery.parseJSON(data);
            var discount = result.discount;
            discount = parseFloat(discount);
            if(discount > 0)
            {
                $('#dis_div').removeClass('hide');
                $('#dis_input').val(discount.toFixed(2));
                
            }else
            {
                $('#dis_div').addClass('hide');
                $('#dis_input').val(0);
            }
        }
    });
}
$(document).ready(function(){
$('.Select2CourseTypeCourse').select2({
        placeholder: "Select a Module course",
        allowClear: true,
        ajax: {
            url: base_url+"general/GetCourseTypeCourseList/",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    company_id: $('#company_id').val(),
                    course_type: $('#course_type').val(),
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                          return { id: obj.id, text: obj.course_title};
                    })
                };
            },
            cache: true
        }
    }).on('change',function(){
        $('.Select2CourseLanguage option').remove();
        $('.Select2CourseSchedule option').remove();
        $('.register_course_time').val('');
    }) 
})
var assessment_temp_id = $('#assessment_day_count').val();
    assessment_temp_id = parseInt(assessment_temp_id);
$(document).on('click','#add_module_assessment',function(){
    var validate = 'true';
    $('#assessment *').filter('.requiredvalue').each(function(){
        if(this.value == '' || this.value == 0)
        {
            $('.'+this.id+'_error').show();
            validate = 'false';
        }
        else
        {
            $('.'+this.id+'_error').hide();
        }
    });

    var edit_mode               = $('#assessment #assessment_temp_id').val();
    var assessment_type_id      = $('#assessment #assessment_type').val();
    var assessment_type         = $('#assessment #assessment_type option:selected').text();
    var need_attendance         = 'No';
    var assessment_date         = $('#assessment #assessment_date').val(); 
    var assessment_start_time   = $('#assessment #assessment_start_time').val(); 
    var assessment_end_time     = $('#assessment #assessment_end_time').val(); 
    var assessor_id             = $('#assessment #assessor').val();
    var assessor_name           = $('#assessment #assessor option:selected').text();
    var room_id                 = $('#assessment #assessment_room_id').val();
    var room                    = $('#assessment #assessment_room_id option:selected').text();
    if($('#assessment #need_attendance').is(":checked"))
    {
        need_attendance = 'Yes';
    }

    if(validate == 'true')
    {
        $('#assessment_table tbody tr.odd').remove();

        if(edit_mode > 0 )
        {
            var validation_start_time = assessment_start_time;
            var validation_end_time   = assessment_end_time;
            var schedule_id = $('#schedule_id').val();
            validation = check_venue_resources_validation(room_id,assessment_date,validation_start_time,validation_end_time,'msa','assessment_room_id_error',schedule_id);
            if(validation == 'true')
            {
                update_assessment_data(edit_mode,
                                        assessment_type_id,
                                        assessment_type,
                                        need_attendance,
                                        assessment_date,
                                        assessment_start_time,
                                        assessment_end_time,
                                        assessor_id,
                                        assessor_name,
                                        room_id,
                                        room);
            }                            
        }
        else
        {
            //#### Here is to check Room Resource Validation
            var validation_start_time = assessment_start_time;
            var validation_end_time   = assessment_end_time;
            validation = check_venue_resources_validation(room_id,assessment_date,validation_start_time,validation_end_time,'msa','assessment_room_id_error',0);
            if(validation == 'true')
            {
                assessment_temp_id += 1;
                append_assessment_data(assessment_temp_id,
                                        assessment_type_id,
                                        assessment_type,
                                        need_attendance,
                                        assessment_date,
                                        assessment_start_time,
                                        assessment_end_time,
                                        assessor_id,
                                        assessor_name,
                                        room_id,
                                        room);
            }
            
        }
        
    }
})
