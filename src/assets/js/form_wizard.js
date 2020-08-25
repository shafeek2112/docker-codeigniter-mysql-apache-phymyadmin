/* ============================================================
 * Form Wizard
 * Multistep form wizard using Bootstrap Wizard Plugin
 * For DEMO purposes only. Extract what you need.
 * ============================================================ */
(function($) {

    'use strict';

    $(document).ready(function() {
        var $validator1 = $("#add_profile_form").validate({
                        rules: {
                            passport_number: {
                                required: true,
                                remote: {
                                    url: CI.base_url+"profile/validate_passport_num",
                                    type: "post",
                                    data: {
                                      user_id: function() {
                                        return '0';
                                      }
                                    }
                                }
                            },
                            first_name:{                
                                required:true
                            },
                            last_name:{             
                                required:true
                            },
                            email:{             
                                required:true,
                                email: true
                            },
                            username:{              
                                required:true
                            }, 
							passport_expiry_date:{                
                                required:true
                            },
							medical_health:{                
                                required:true
                            },
							nationality:{                
                                required:true
                            },
							contact_number_1:{                
                                required:true
                            },	
                            password:{              
                                required:true
                            },
                            password_confirm: {
                                required:true,
                                equalTo: "#reg_password"
                            },
                            'photo[]': {
                                //required: true,
                                extension: "png|jpe?g|gif"
                            }
                        },
                        messages: {
                            passport_number: {
                                required: "Please enter a valid passport number",
                                remote: jQuery.validator.format("{0} is already exists")
                            },
                            first_name: "Please enter your first name",
                            last_name: "Please enter your last name",
                            passport_expiry_date: "Please enter passport expiry date",
                            medical_health: "Please enter health & medical",
                            nationality: "Please enter nationality",
							contact_number_1: "Please enter contact number",
                            email: "Please enter your email",
                            username: "Please enter username",
                            password: "Please enter password"
                        }
                    });
					
		var $validator = $("#add_profile_form_register").validate({
                        rules: {
                            passport_number: {
                                required: true,
                                remote: {
                                    url: CI.base_url+"auth/register/validate_passport_num",
                                    type: "post",
                                    data: {
                                      user_id: function() {
                                        return '0';
                                      }
                                    }
                                }
                            },
                            first_name:{                
                                required:true
                            },
                            last_name:{             
                                required:true
                            },
                            email:{             
                                required:true,
                                email: true
                            },
                            username:{              
                                required:true
                            },          
							passport_expiry_date:{                
                                required:true
                            },
							medical_health:{                
                                required:true
                            },	
							nationality:{                
                                required:true
                            },
							contact_number_1:{                
                                required:true
                            },
                            password:{              
                                required:true
                            },
                            password_confirm: {
                                required:true,
                                equalTo: "#reg_password"
                            },
                            'photo[]': {
                                //required: true,
                                extension: "png|jpe?g|gif"
                            }
                        },
                        messages: {
                            passport_number: {
                                required: "Please enter a valid passport number",
                                remote: jQuery.validator.format("{0} is already exists")
                            },
                            first_name: "Please enter your first name",
                            last_name: "Please enter your last name",
							passport_expiry_date: "Please enter passport expiry date",
                            medical_health: "Please enter health & medical",
							nationality: "Please enter nationality",
							contact_number_1: "Please enter contact number",
                            email: "Please enter your email",
                            username: "Please enter username",
                            password: "Please enter password"
                        }
                    });			

        $('#rootwizard').bootstrapWizard({
            onTabShow: function(tab, navigation, index) {
                var $total = navigation.find('li').length;
                var $current = index + 1;

                // If it's the last tab then hide the last button and show the finish instead
                if ($current >= $total) {
                    $('#rootwizard').find('.pager .next').hide();
                    $('#rootwizard').find('.pager .finish').show().removeClass('disabled hidden');
                } else {
                    $('#rootwizard').find('.pager .next').show();
                    $('#rootwizard').find('.pager .finish').hide();
                }

                var li = navigation.find('li.active');

                var btnNext = $('#rootwizard').find('.pager .next').find('button');
                var btnPrev = $('#rootwizard').find('.pager .previous').find('button');

                // remove fontAwesome icon classes
                function removeIcons(btn) {
                    btn.removeClass(function(index, css) {
                        return (css.match(/(^|\s)fa-\S+/g) || []).join(' ');
                    });
                }

                if ($current > 1 && $current < $total) {

                    var nextIcon = li.next().find('.fa');
                    var nextIconClass = "";

                    if(nextIcon.attr('class').match(/fa-[\w-]*/))
                     var nextIconClass = nextIcon.attr('class').match(/fa-[\w-]*/).join();

                    removeIcons(btnNext);
                    btnNext.addClass(nextIconClass + ' btn-animated from-left fa');

                    var prevIcon = li.prev().find('.fa');
                    var prevIconClass = prevIcon.attr('class').match(/fa-[\w-]*/).join();

                    removeIcons(btnPrev);
                    btnPrev.addClass(prevIconClass + ' btn-animated from-left fa');
                } else if ($current == 1) {
                    // remove classes needed for button animations from previous button
                    btnPrev.removeClass('btn-animated from-left fa');
                    removeIcons(btnPrev);
                } else {
                    // remove classes needed for button animations from next button
                    btnNext.removeClass('btn-animated from-left fa');
                    removeIcons(btnNext);
                }
            },
            onTabClick: function(tab, navigation, index) { return false;
                var $valid = $("#add_profile_form").valid();
                if(!$valid) {
                    $validator1.focusInvalid();
                    return false;
                }
            },
            onNext: function(tab, navigation, index) {
                //console.log("Showing next tab");
                
                var $valid = $("#add_profile_form").valid();
                if(!$valid) {
                    $validator1.focusInvalid();
                    return false;
                }
                
            },
            onPrevious: function(tab, navigation, index) {
                ///console.log("Showing previous tab");
            },
            onInit: function() {
                $('#rootwizard ul').removeClass('nav-pills');
            }
        });
		
		$('#rootwizard_register').bootstrapWizard({
            onTabShow: function(tab, navigation, index) {
                var $total = navigation.find('li').length;
                var $current = index + 1;

                // If it's the last tab then hide the last button and show the finish instead
                if ($current >= $total) {
                    $('#rootwizard_register').find('.pager .next').hide();
                    $('#rootwizard_register').find('.pager .finish').show().removeClass('disabled hidden');
                } else {
                    $('#rootwizard_register').find('.pager .next').show();
                    $('#rootwizard_register').find('.pager .finish').hide();
                }

                var li = navigation.find('li.active');

                var btnNext = $('#rootwizard_register').find('.pager .next').find('button');
                var btnPrev = $('#rootwizard_register').find('.pager .previous').find('button');

                // remove fontAwesome icon classes
                function removeIcons(btn) {
                    btn.removeClass(function(index, css) {
                        return (css.match(/(^|\s)fa-\S+/g) || []).join(' ');
                    });
                }

                if ($current > 1 && $current < $total) {

                    var nextIcon = li.next().find('.fa');
                    var nextIconClass = "";

                    if(nextIcon.attr('class').match(/fa-[\w-]*/))
                     var nextIconClass = nextIcon.attr('class').match(/fa-[\w-]*/).join();

                    removeIcons(btnNext);
                    btnNext.addClass(nextIconClass + ' btn-animated from-left fa');

                    var prevIcon = li.prev().find('.fa');
                    var prevIconClass = prevIcon.attr('class').match(/fa-[\w-]*/).join();

                    removeIcons(btnPrev);
                    btnPrev.addClass(prevIconClass + ' btn-animated from-left fa');
                } else if ($current == 1) {
                    // remove classes needed for button animations from previous button
                    btnPrev.removeClass('btn-animated from-left fa');
                    removeIcons(btnPrev);
                } else {
                    // remove classes needed for button animations from next button
                    btnNext.removeClass('btn-animated from-left fa');
                    removeIcons(btnNext);
                }
            },
            onTabClick: function(tab, navigation, index) { return false;
				var $valid = $("#add_profile_form_register").valid();
                if(!$valid) {
                    $validator.focusInvalid();
                    return false;
                }
            },
            onNext: function(tab, navigation, index) {
                //console.log("Showing next tab");
                var $valid = $("#add_profile_form_register").valid();
                if(!$valid) {
                    $validator.focusInvalid();
                    return false;
                }
                
            },
            onPrevious: function(tab, navigation, index) {
                ///console.log("Showing previous tab");
            },
            onInit: function() {
                $('#rootwizard_register ul').removeClass('nav-pills');
            }
        });

        $('.remove-item').click(function() {
            $(this).parents('tr').fadeOut(function() {
                $(this).remove();
            });
        });

    });

})(window.jQuery);