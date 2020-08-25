

    $(document).on('click', '.add_question', function() {

        $('li.question_add').show();
    	var que =  $("li.question_add").clone().removeClass('question_add').addClass('question_new').appendTo(".que_div");
    	 $('.question_add').hide();
        $('.que_div .select2-container').each(function() {
             $(this).prev().removeClass('select2-wrapper').removeClass('select2-hidden-accessible');
            $(this).remove();
        });

        $('select[name="course_id[]"]').each(function() {
            console.log($(this));
            $(this).select2();
        });

    });

    $(document).on('click', '.add_question_q', function() {
        $('li.question_add').show();
    	var que =  $("li.question_add").clone().removeClass('question_add').addClass('question_new').appendTo(".que_div");
    	$('.question_add').hide();
        $('.que_div .select2-container').each(function() {
       
            $(this).prev().removeClass('select2-wrapper').removeClass('select2-hidden-accessible');
            $(this).remove();
        });
        $('select[name="course_id[]"]').each(function() {
            console.log($(this));
            $(this).select2();
        });  
    });



    $(document).on('click', 'span.subtract_question', function() {  
        $option_detele = $(this).closest('div.row').find('div.question_addd');

            var id = $(this).attr('id');
            
            dt_question(id);

            $(this).closest('div.question_addd').remove();
   
    });



    $(document).on('click', 'span.subtract_question_div', function() { 
         var $option_detele = $(this).closest('div.que_div').find('li.delete_que');
         console.log($option_detele);
        	if($option_detele.length == 1)
        	{
        		// alert('gfgfdgfdg');
        		$(this).closest('li.delete_que').hide();
        	}else
        	{
        		 $(this).closest('li.delete_que').remove();
        	}
    });




    $(document).on('click', '.add_option', function() {

        var que =  $("div.main_layout_1").clone().removeClass('main_layout_1').addClass('option_layout_1 option_detele my_new_latout_1').css("display","").appendTo("#layout_1_fields");  

    });

    $(document).on('click', '.add_option_layout_3', function() {

        var que =  $("div.main_layout_3").clone().removeClass('main_layout_3').addClass('option_layout_3 option_detele my_new_latout_3').css("display","").appendTo("#layout_3_fields");  

    });

    $(document).on('click', 'span.subtract_option', function() {  
        $option_detele = $(this).closest('#layout_1_fields').find('div.option_detele');
        console.log($option_detele);
            if($option_detele.length == 1)
        	{
        		$(this).closest('div.option_detele').hide();
        	}else
        	{
        		 $(this).closest('div.option_detele ').remove();
        	}
    });

    $(document).on('click', '.add_option_layout_2', function() {
    			var que =  $("div.main_news").clone().removeClass('main_news').addClass('option_layout_2 option_detele my_newadd').css("display","").appendTo("#layout_2_fields");		
    });

    $(document).on('click', '.add_option_layout_4_1', function() {
                var que =  $("div.main_layout_4_1").clone().removeClass('main_layout_4_1').addClass('option_layout_2 option_detele my_newadd').css("display","").appendTo("div.layout_4_secation_1");      
    });

    $(document).on('click', '.add_option_layout_4_2', function() {
                var que =  $("div.main_layout_4_2").clone().removeClass('main_layout_4_2').addClass('option_layout_2 option_detele my_newadd').css("display","").appendTo("div.layout_4_secation_2");      
    });

    $(document).on('click', '.add_option_layout_4_3', function() {
                var que =  $("div.main_layout_4_3").clone().removeClass('main_layout_4_3').addClass('option_layout_2 option_detele my_newadd').css("display","").appendTo("div.layout_4_secation_3");      
    });

    $(document).on('click', 'span.subtract_option_layput_2_r', function() {  
        $option_detele = $(this).closest('#layout_2_fields').find('div.option_layout_2_main');
        console.log($option_detele);
           var id = $(this).attr('id');

           dt_delete("assessment_option","id",id);
            $(this).closest('div.option_layout_2_main').remove();
    });

    $(document).on('click', 'span.subtract_option_layput_2', function() {  
        $option_detele = $(this).closest('#layout_2_fields').find('div.option_detele');
        console.log($option_detele);
       		if($option_detele.length == 1)
        	{
        		
        		$(this).closest('div.option_detele').hide();
        	}else
        	{
        		 $(this).closest('div.option_detele ').remove();
        	}
    });

    

    $(document).on('click', '.add_option_r', function() {
        $(this).closest('div.option_layout_1').clone().insertAfter($(this).closest('div.option_layout_1'));
    });

    $(document).on('click', 'span.subtract_option_r', function() {  
        $option_detele = $(this).closest('div.layout_1_fields').find('div.option_layout_11');
       
            var id = $(this).attr('id');
            dt_delete("assessment_option","id",id);
            $(this).closest('div.option_layout_11').remove();
    });


    $(document).on('click', 'span.subtract_option_layput_div', function() {  
        $option_detele = $(this).closest('div.layout_3_fields').find('div.option_layout_3');
       
            var id = $(this).attr('id');
           // dt_delete("assessment_option","id",id);
            $(this).closest('div.option_layout_3').remove();
    });

