jQuery(function () {
    
    //var reg = /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i;

    jQuery("#submit_form").click(function () {
        var result_ok = true;

        var reg = /^([A-Za-z0-9_\-\.\+])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        var email = jQuery("#email");
        if (reg.test(email.val()) == false) {
            email.addClass("is_fill");
            email.removeClass("is_success");
            result_ok = false;
        } else {
            email.removeClass("is_fill");
            email.addClass("is_success");
        }

        var password = jQuery("#password");
        if (password.val().length < 7) {
            password.addClass("is_fill");
            password.removeClass("is_success");
            result_ok = false;
        } else {
            password.removeClass("is_fill");
            password.addClass("is_success");
        }

        var repassword = jQuery("#retype_password");
        if ((repassword.val().length < 7)|| (password.val() != repassword.val())) {
            repassword.addClass("is_fill");
            repassword.removeClass("is_success");
            result_ok = false;
        } else {
            repassword.removeClass("is_fill");
            repassword.addClass("is_success");
        }
        
        return result_ok;
    });

    jQuery("#email").blur(function () {
        var reg = /^([A-Za-z0-9_\-\.\+])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        var email = jQuery("#email");
        
        var emailstr = email.val();
        var apostr = new RegExp("[\x22\x27]+","g");
        email.val(emailstr.replace(apostr,''));
        
        if (reg.test(email.val()) == false) {
            email.addClass("is_fill");
            email.removeClass("is_success");
        } else {
            email.removeClass("is_fill");
        }

                //url: 'http://influencer.naghashyan.com/check-email',
        if (!email.hasClass("is_fill")) {
            $.ajax({
                type: "POST",
                url: window.location.pathname+"/check-email",
                data: "email=" + email.val(),
                success: function (msg) {
                    var result = jQuery.parseJSON(msg);
                    if (result.result) {
                        //Email alredy is used!
                        email.addClass("is_fill");
                        email.removeClass("is_success");
                    } else {
                        email.addClass("is_success");
                    }
                } 
            });
        }

    });

    jQuery("#password").blur(function () {
        var password = jQuery("#password");
        if ( (password.val().length < 7) ) {
            password.addClass("is_fill");
            password.removeClass("is_success");
        } else {
            password.removeClass("is_fill");
            password.addClass("is_success");
        }
    });

    jQuery("#retype_password").blur(function () {
        var password = jQuery("#password");
        var repassword = jQuery("#retype_password");
        if ( (repassword.val().length < 7) || (password.val() != repassword.val()) ) {
            repassword.addClass("is_fill");
            repassword.removeClass("is_success");
        } else {
            repassword.removeClass("is_fill");
            repassword.addClass("is_success");
        }
    });

});