jQuery(function () {

    jQuery("#submit_form").click(function() {
        result_ok = true;

        var reg = /^([A-Za-z0-9_\-\.\+])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        username = jQuery("#username");
        if ( reg.test(username.val()) == false ) {
            username.addClass("is_fill");
            username.removeClass("is_success");
            result_ok = false;
        } else {
            username.removeClass("is_fill");
            username.addClass("is_success");
        }
            
        password = jQuery("#password");
        if ( password.val().length < 7 ) {
            password.addClass("is_fill");
            password.removeClass("is_succes");
            result_ok = false;
        } else {
            password.removeClass("is_fill");
            password.addClass("is_succes");
        }

        return result_ok;
    });
    
    jQuery("#username").blur(function() {
        var reg = /^([A-Za-z0-9_\-\.\+])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        username = jQuery("#username");
        
        var usernamestr = username.val();
        var apostr = new RegExp("[\x22\x27]+","g");
        username.val(usernamestr.replace(apostr,''));
        
        if ( reg.test(username.val()) == false ) {
            username.addClass("is_fill");
            username.removeClass("is_success");
        } else {
            username.removeClass("is_fill");
            username.addClass("is_success");
        }
    });
    
    jQuery("#password").blur(function() {
        password = jQuery("#password");
        if ( password.val().length < 7 ) {
            password.addClass("is_fill");
            password.removeClass("is_success");
        } else {
            password.removeClass("is_fill");
            password.addClass("is_success");
        }
    });

});