jQuery(function () {
    bootstrapInputFile();
    setTimeout(function () {
        jQuery(".f_success-message").fadeOut();
    }, 6000);

    jQuery("#influencer_form_submit").click(function () {
        result_ok = true;

        requireds = jQuery("#influencer_form input.required").each(function (index) {

            if (jQuery(this).val() == "") {

                if (jQuery(this).hasClass("f_select-btn")) {
                    jQuery(this).parents(".f_input-group").find(".btn-file").addClass("btn-danger");
                    result_ok = false;
                } else {
                    jQuery(this).addClass("is_fill");
                }
                result_ok = false;
            } else {
                if (jQuery(this).hasClass("f_select-btn")) {
                    jQuery(this).parents(".f_input-group").find(".btn-file").removeClass("btn-danger");
                } else {
                    jQuery(this).removeClass("is_fill");
                }
            }
        });

        if (result_ok) {
            $("body").addClass("has--overlay");
            $(".import-data-pop-up").addClass("hide");
        } else {
            jQuery("#error_message").css("visibility", "visible");
            setTimeout(function () {
                jQuery("#error_message").css("visibility", "hidden");
            }, 6000);
        }
        
        return result_ok;
    });

    jQuery("#influencer_form_submit_upload").click(function () {
        result_ok = true;
        
        requireds = jQuery("#influencer_form_upload input.required").each(function (index) {
            
            if (jQuery(this).val() == "") {
                jQuery(this).addClass("is_fill");
                result_ok = false;
            } else {
                jQuery(this).removeClass("is_fill");
            }
        });

        if (result_ok) {
            $("body").addClass("has--overlay");
            $(".upload-data-pop-up").addClass("hide");
        } else {
            jQuery("#error_message").css("visibility", "visible");
            setTimeout(function () {
                jQuery("#error_message").css("visibility", "hidden");
            }, 6000);
        }
        
        return result_ok;
    });

    jQuery("#influencer_btn_delete").click(function () {

        selectedLines = jQuery("#influencer_table_form input.select_line[type=checkbox]:checked");

        return ((selectedLines.length > 0) && confirm("Delete selected influencers info?"));
    });

    jQuery(".select_line").click(function () {

        if (jQuery(".select_line:checked").length > 0) {
            jQuery("#influencer_btn_delete").removeAttr("disabled");
        } else {
            jQuery("#influencer_btn_delete").attr("disabled", "disabled");
        }

    });

    jQuery("#select_all").click(function () {

        jQuery("#influencer_table_form input.select_line").prop("checked", jQuery("#select_all").prop('checked'));

        if (jQuery(".select_line:checked").length > 0) {
            jQuery("#influencer_btn_delete").removeAttr("disabled");
        } else {
            jQuery("#influencer_btn_delete").attr("disabled", "disabled");
        }

    });


    jQuery("#influencer_btn_import").click(function () {

        jQuery(".import-data-pop-up").removeClass("hide");
    });

    jQuery(".close-button").click(function () {

        jQuery(".import-data-pop-up").addClass("hide");
    });

    jQuery(".overlay").click(function () {

        jQuery(".import-data-pop-up").addClass("hide");
    });
    
     jQuery("#influencer_btn_upload").click(function () {

        jQuery(".upload-data-pop-up").removeClass("hide");
    });

    jQuery(".close-button").click(function () {

        jQuery(".upload-data-pop-up").addClass("hide");
    });

    jQuery(".overlay").click(function () {

        jQuery(".upload-data-pop-up").addClass("hide");
    });
    
    jQuery(window).scroll(function () {
        if (jQuery(window).scrollTop() > jQuery(".f_table-striped").offset().top) {
            jQuery('.table_header').addClass('stuck');
            jQuery(".f_table-striped").addClass("is_struck");
        } else {
            jQuery('.table_header').removeClass('stuck');
            jQuery(".f_table-striped").removeClass("is_struck");
        }

    });

});

var bootstrapInputFile = function () {
    $(document).on('change', '.btn-file :file', function () {
        var input = $(this),
                numFiles = input.get(0).files ? input.get(0).files.length : 1,
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    $(document).ready(function () {
        $('.btn-file :file').on('fileselect', function (event, numFiles, label) {

            var input = $(this).parents('.input-group').find(':text'),
                    log = numFiles > 1 ? numFiles + ' files selected' : label;

            if (input.length) {
                input.val(log);
            } else {
                if (log)
                    alert(log);
            }

        });
    });
};