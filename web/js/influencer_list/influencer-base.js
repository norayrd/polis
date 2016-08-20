/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {
    influencerBaseList.init();

});

var influencerBaseList = {
    init: function () {

        //this.initUserArchivePopup();
        this.initInfluencerImportPopup();
        this.initInfluencerUploadPopup();
        this.swicthCompactView();
        this.accordionEffect();
        this.hideLimitPopup();
        this.privateAccountPopup();
        this.initTableFixedHeader();
        this.initTableFixedHeaderEvent();
        this.updateUserData();

    },
//    initUserArchivePopup: function () {
//        $(".f_user-archive-btn").unbind("click");
//        $(".f_user-archive-btn").on('click', function () {
//            if (!$(this).closest(".f_user-archive").hasClass("is_active")) {
//                $(".f_user-archive").removeClass("is_active");
//            }
//            $(this).closest(".f_user-archive").toggleClass("is_active");
//
//        });
//
//        $(document).on('click', function (event) {
//            if ($(event.target).closest(".f_user-archive").length < 1) {
//                $(".f_user-archive").removeClass("is_active");
//            }
//        });
//    },
    initInfluencerImportPopup: function () {

        var impotInfluencerContent = $(".f_import-influencer");
        $("#influencer_btn_import").on('click', function () {
            impotInfluencerContent.toggleClass("hide");
        });
        $("body").on('click', function (event) {
            if ($(event.target).closest("#influencer_btn_import").length < 1 && $(event.target).closest(".f_import-influencer").length < 1) {
                impotInfluencerContent.addClass("hide");
            }
        });
    },
    initInfluencerUploadPopup: function () {

        var uploadInfluencerContent = $(".f_upload-influencer");
        $("#influencer_btn_upload").on('click', function () {
            uploadInfluencerContent.toggleClass("hide");
        });
        $("body").on('click', function (event) {
            if ($(event.target).closest("#influencer_btn_upload").length < 1 && $(event.target).closest(".f_upload-influencer").length < 1) {
                uploadInfluencerContent.addClass("hide");
            }
        });
    },
    swicthCompactView: function () {
        $("#full-screen-table").on('click', function () {
            $(this).closest(".f_setting-block").toggleClass("compact-view");
            $(this).closest(".f_setting-block").siblings(".f_table-striped").toggleClass("compact-view");
        });
    },
    hideLimitPopup: function () {
        $(document).on('click', function (ev) {
            if ($(ev.target).closest(".f_limiting-popup").length < 1) {
                $(".f_limiting-popup").addClass("is_hidden");
            }
        });
    },
    accordionEffect: function () {
        $(".f_influencer-name").unbind('click');
        $(".f_influencer-name").on('click', function () {
            var currentContent = $(this).closest(".f_influencer-block");
            if (currentContent.hasClass("is_active")) {
                currentContent.removeClass("is_active");
            } else {
                $(".f_influencer-block").removeClass("is_active");
                currentContent.addClass("is_active");
            }
        });
        $(window).unbind('click').on('click', function (event) {
            if ($(event.target).closest(".f_influencer-block").length < 1) {
                $(".f_influencer-block").removeClass("is_active");
            }
        });
    },
    privateAccountPopup: function () {
        $(".f_private-account-popup .f_ok-btn").on('click', function () {
            $(".f_private-account-popup").addClass("is_hidden");
        });
        $(document).on('click', function (ev) {
            if ($(ev.target).closest("f_private-popup-container").length < 1) {
                $(".f_private-account-popup").addClass("is_hidden");
            }
        });
        if (!$(".f_private-account-popup").hasClass("is_hidden")) {
            ErrorMessageManager.init(".f_private-account-popup");
        }
    },
    initTableFixedHeader: function () {
        $(window).scroll(function () {
            this.initTableFixedHeaderEvent();
        }.bind(this));

        $('body').on({
            'touchmove': function () {
                this.initTableFixedHeaderEvent();
            }.bind(this)
        });
    },
    initTableFixedHeaderEvent: function () {
        var scrollTop = $(window).scrollTop() + $(".f_header-inner").innerHeight();
        if (scrollTop > $(".f_table-striped").offset().top) {
            $(".f_table-striped").addClass("has_fixed-content");
        } else {
            $(".f_table-striped").removeClass("has_fixed-content");
        }
    },
    sortPageBy: function (sender, sort) {
        var me = this;

        if (typeof InfluencerList !== "undefined") {
            pageName = InfluencerList.pageName;
        } else if (typeof InfluencerRecommended !== "undefined") {
            pageName = InfluencerRecommended.pageName;
        } else {
            pageName = 'base_';
        }

        var cookieSortBy = CookieManager._getCookie(pageName + "_sort_by");
        var cookieSortDirectionDesc = (CookieManager._getCookie(pageName + "_sort_direction_desc") == 'true');

        if (sort == cookieSortBy) {
            cookieSortDirectionDesc = !cookieSortDirectionDesc;
        } else {
            cookieSortBy = sort;
            cookieSortDirectionDesc = false;
        }

        CookieManager._setCookie(pageName + "_sort_by", cookieSortBy, null, '.');
        CookieManager._setCookie(pageName + "_sort_direction_desc", cookieSortDirectionDesc, null, '.');

        document.location.href = document.location.href;
        return true;
    },
    loadMoreBtn: function (sender, pageName, offset, pageSize) {
        if (typeof pageSize == "undefined") {
            pageSize = -1;
        }
        var me = this;
        $(sender).parent().remove();
        //offset = $('#loadedItemsCount').html();
        $.ajax({
            type: "POST",
            url: pageName,
            data: "offset=" + offset + "&pagesize=" + pageSize,
            success: function (content) {
                $(".f_influencers-content").append(content);
                //var totalItems = $(content).filter('.f_totalItems').val();
                var loadedItemsCount = $('#loadedItemsCountInput').val();

                $('#loadedItemsCount').html(loadedItemsCount);
                //$('#totalItems').html(totalItems);

                if (pageName == '/influencers-recommended') {
                    InfluencerRecommended.init();
                }
                if (pageName == '/influencers-list') {
                    InfluencerList.init();
                }
                influencerBaseList.init();
            }
        });
    },
    updateUserData: function() {
        $('.f_user-avatar').unbind('error');
        $('.f_user-avatar').on('error', function () {
            pageName = '/update-instagram-user';
            var userAvatar = $(this);
            instagramUserId = userAvatar.closest('.f_influencer-block').find('.f_instagram-user-id').val();
            AjaxRequest._call(pageName,"instagramUserId=" + instagramUserId,"POST",function (content) {
                if (content.code == 0) {
                    $(userAvatar).unbind('error');
                    userAvatar.attr('src',content.result.profilePicture);
                }
            });
        });
    }
};