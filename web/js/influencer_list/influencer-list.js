$(function () {
    InfluencerList.init();
});

var InfluencerList = {
    pageName: 'influencer_list',
    init: function () {
        CompactViewManager.init("full-screen-table", this.pageName, "id");
        deleteAction.init('/influencers-list/delete', this.onDeleteInfluencerFromInfluencerList);
        this.initInfluencerFormUpload();
        this.initInfluencerForm();
        this.afterLoadMessageHide();
        this.initNoKeywordPopup();
        if ($(".f_progress").length > 0) {
            this.addInfluencerStatusLoader();
        }
    },
    addInfluencerStatusLoader: function () {

        $(".f_progress").circleProgress({
            value: 0,
            size: 80
        });

        var reloadInterval = setInterval(function () {
            $.ajax({
                url: "/influencers-list/workers",
                context: this
            }).done(function (data) {
                var influencers = $.parseJSON(data);

                var allWorkersFinished = true;
                var oneWorkerFinished = false;

                $.each(influencers, function (i, influencer) {
                    var progress = influencer.progress / 100;
                    var animationStartValue = 0;
                    var elem = $("#f_influencer-status_" + influencer.influencerId);

                    if (elem.length == 0) {
                        return;
                    }

                    if (influencer.progress < 100) {
                        allWorkersFinished = false;
                    } else {
                        oneWorkerFinished = true;
                    }

                    if (elem.attr("progress")) {
                        if (elem.attr("progress") == progress) {
                            return;
                        }

                        animationStartValue = elem.attr("progress");
                    }

                    elem.attr("progress", progress);

                    elem.circleProgress({
                        value: progress,
                        animationStartValue: animationStartValue,
                        size: 80
                    }).on('circle-animation-progress', function (event) {
                        $(this).find('strong').html(parseInt(100 * progress) + '<i>%</i>');
                    });

                });

                if (oneWorkerFinished) {
                    location.reload();
                }
                if (allWorkersFinished) {
                    window.clearInterval(reloadInterval);
                }
            });

        }, 3000);

    },
    onDeleteInfluencerFromInfluencerList: function (responseJson, inflencersIdJSON) {
        var response = jQuery.parseJSON(responseJson);
        var responseID = jQuery.parseJSON(inflencersIdJSON);
        if (response.result) {
            if (typeof responseID !== 'undefined') {
                $.each(responseID, function (index) {
                    var rowId = responseID[index];
                    $("#table_row_influencer_" + rowId).remove();
                });
            }
        }
    },
    afterLoadMessageHide: function () {
        window.onload = function () {
            ErrorMessageManager.init(".f_after-load");
        };
    },
    initInfluencerFormUpload: function () {
        var popupContent = $(".f_upload-influencer");
        $("#influencer_form_submit_upload").click(function () {
            var result_ok = true;

            jQuery("#influencer_form_upload .required").each(function (index, elem) {

                if (jQuery(elem).val() == "") {
                    jQuery(elem).addClass("is_fill");
                    result_ok = false;
                } else {
                    jQuery(elem).removeClass("is_fill");
                }
            });

            if (result_ok) {
                $(".f_upload-influencer").addClass("hide");
            } else {
                jQuery("#error_message").removeClass("is_hidden");
                ErrorMessageManager.init("#error_message");
                //popupContent.addClass("hide");
            }

            return result_ok;
        }.bind(this));
    },
    initInfluencerForm: function () {
        var popupContent = $(".f_import-influencer");

        $("#influencer_form_submit").click(function () {
            var result_ok = true;

            jQuery("#influencer_form input.required").each(function (index, elem) {

                if (jQuery(elem).val() == "") {

                    if (jQuery(elem).hasClass("f_select-btn")) {
                        jQuery(elem).parents(".f_input-group").find(".btn-file").addClass("btn-danger");
                    } else {
                        jQuery(elem).addClass("is_fill");
                    }
                    result_ok = false;
                } else {
                    if (jQuery(elem).hasClass("f_select-btn")) {
                        jQuery(elem).parents(".f_input-group").find(".btn-file").removeClass("btn-danger");
                    } else {
                        jQuery(elem).removeClass("is_fill");
                    }
                }
            });

            if (result_ok) {
                $(".f_import-influencer").addClass("hide");
            } else {
                jQuery("#error_message").removeClass("is_hidden");
                ErrorMessageManager.init("#error_message");
                //popupContent.addClass("hide");
            }

            return result_ok;
        }.bind(this));
    },
    initNoKeywordPopup: function () {
        $(".f_no-keyword-popup").on('click', function () {
            $(".f_no-keyword-content").addClass("is_hidden");
            $(this).siblings(".f_no-keyword-content").toggleClass("is_hidden");
        });

        $(document).on('click', function (event) {
            if ($(event.target).closest(".f_no-keyword-popup").length < 1 && $(event.target).closest(".f_no-keyword-content").length < 1) {
                $(".f_no-keyword-content").addClass("is_hidden");
            }
        });
    }

};