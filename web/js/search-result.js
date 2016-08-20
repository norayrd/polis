/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {
    searchResult.init();
});

var searchResult = {
    init: function () {
        this.initSearchResult();
        this.searchPopup();
    },
    searchPopup: function () {
        $(".f_search-box-open").on('click', function (event) {
            $(".f_search-container").fadeToggle().focus();
        });

        $(".f_search-field-box").on('click', function () {
            $(".f_search-container").fadeIn().focus();
        });

        $(document).on('click', function (event) {
            if ($(event.target).closest(".f_search-box-open").length < 1 && $(event.target).closest(".f_search-field-box").length < 1) {
                $(".f_search-container").fadeOut();
            }
        });

    },
    initSearchResult: function () {
        var self = this;
        $("#searchContainer").on('input', function (ev) {
            var instagram_username = $(ev.target).val();
            if (this.timeOut) {
                clearTimeout(this.timeOut);
            }
            if (instagram_username !== '') {
                this.timeOut = setTimeout(function (instagram_username) {
                    if (instagram_username == $("#searchContainer").val()) {
                        $.ajax({
                            type: "POST",
                            url: location.origin + '/instagram-search',
                            data: "instagram_username=" + instagram_username,
                            success: function (msg) {

                                $(".f_search-result").removeClass('is_hidden');
                                $(".f_search-result").html(msg);
                                $(".f_search-upload-influencer").click(function (event) {
                                    self.setPopupPosition(event);
                                    var currentOption = $(this);
                                    currentOption.find(".fa").addClass('is_hidden');
                                    currentOption.find(".f_option-load").removeClass('is_hidden');
                                    username = currentOption.parent().siblings('.f_name-cell').find('.f_search-user-name-full').val().trim();
                                    $.ajax({
                                        type: "POST",
                                        url: 'influencers-upload',
                                        data: "username=" + username + "&influencer_form_submit_upload=1",
                                        success: function (msg) {
                                            if (msg.code == 0) {
                                                /*var userInfluencerId=msg.userInfluencerId;
                                                $.ajax({
                                                    type: "POST",
                                                    url: 'influencers-list',
                                                    data: "userInfluencerId=" + msg.userInfluencerId,
                                                    success: function (content) {
                                                        $("#table_row_influencer_"+userInfluencerId).remove();
                                                        $(".f_influencers-content").prepend(content);
                                                        $(".f_search-result").addClass('is_hidden');
                                                    }
                                                });
                                                */
                                                location.reload();
                                            } else if (msg.code >= 10) {
                                                $("#searchLimitingPopup").removeClass("is_hidden");
                                                $("#searchLimitingPopup").html(msg.message);

                                                currentOption.find(".fa").removeClass('is_hidden');
                                                currentOption.find(".f_option-load").addClass('is_hidden');
                                            } else {
                                                $(".f_private-account-popup").removeClass("is_hidden");
                                                $(".f_private-account-popup p").html(msg.message);
//                                                (msg.message);
                                            }
                                        }
                                    });
                                });
                            }
                        });
                    } else {
                        $(".f_search-result").addClass('is_hidden');
                    }
                }, 500, instagram_username);
            } else {

                $(".f_search-result").addClass('is_hidden');
            }
        }.bind(this));
        $("#searchContainer").click(function () {
            $(this).keyup();
        });

        $(document).on('click', function (event) {
            if ($(event.target).closest(".f_search-result").length < 1)
            {
                $(".f_search-result").addClass("is_hidden");
            }
        });
    },
    setPopupPosition: function (event) {
        //var top = event.clientY - $("#resultBoxContainer").offset().top + $(document).scrollTop() + 35;
        var top = $(event.target).position().top + 35;
        var left = event.currentTarget.offsetLeft - 10;
        var styles = {
            top: top + 'px',
            left: left + 'px'
        };
        $("#searchLimitingPopup").css(styles);
        $(document).on('click', function (ev) {
            if ($(ev.target).closest("#searchLimitingPopup").length < 1) {
                $("#searchLimitingPopup").addClass("is_hidden");
            }
        });
    }
};