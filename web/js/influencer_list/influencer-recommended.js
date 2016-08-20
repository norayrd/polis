$(function () {
    InfluencerRecommended.init();
});

var InfluencerRecommended = {
    pageName: 'influencer_recommended',
    init: function () {
        CompactViewManager.init("full-screen-table", this.pageName, "id");
        deleteAction.init('/influencers-recommended/addToIgnoreList', this.onDeleteInfluencerFromList);

        //$(".f_user-add-btn").click(this.addToInfluencersList.bind(this));

        this.initUserAddPopup();
        this.initUserAddPopupAction();
    },
    initUserAddPopup: function () {
        var self = this;
        $(".f_user-add-btn").unbind('click');
        $(".f_user-add-btn").on('click', function () {
            var userId = $(this).attr("data-user-id");
            $(".f_add-user-popup").removeClass("is_hidden");
            self.initUserAddPopupAction(userId);
        });

        $(".f_cancel-btn").on('click', function () {
            $(".f_add-user-popup").addClass("is_hidden");
        });
        $(document).on('click', function (event) {
            if ($(event.target).closest(".f_add-user-container").length < 1 && $(event.target).closest(".f_user-add-btn").length < 1) {
                $(".f_add-user-popup").addClass("is_hidden");
            }
        });
    },
    initUserAddPopupAction: function (userId) {
        $(".f_add-ok").unbind('click');
        $(".f_add-ok").on('click', function () {
            this.addToInfluencersList(userId);
            $("#table_row_instagram_user_info_" + userId).find(".f_user-archive-content").addClass("is_hidden");
            $("#table_row_instagram_user_info_" + userId).find(".f_loader-option").removeClass("is_hidden");
            $(".f_add-user-popup").addClass("is_hidden");
        }.bind(this));
    },
    onDeleteInfluencerFromList: function (responseJson, inflencersIdJSON) {
        var response = jQuery.parseJSON(responseJson);
        var responseID = jQuery.parseJSON(inflencersIdJSON);
        if (typeof responseID !== 'undefined') {
            $.each(responseID, function (index) {
                var rowId = responseID[index];
                $("#table_row_instagram_user_info_" + rowId).remove();
            });
        }
    },
    addToInfluencersList: function (instagramUserInfoId) {
        $.ajax({
            type: "POST",
            url: '/influencers-recommended/addToInfluencerList',
            data: "param=" + instagramUserInfoId,
            success: function (response) {
                var currentRow = $("#table_row_instagram_user_info_" + instagramUserInfoId);
                if (response.code > 0) {
                    currentRow.find(".f_loader-option").addClass("is_hidden");
                    currentRow.find(".f_user-archive-content").removeClass("is_hidden");
                    currentRow.find(".f_limiting-popup").removeClass("is_hidden");
                    currentRow.find(".f_limiting-popup").html(response.message);
                } else {
                    $("#table_row_instagram_user_info_" + instagramUserInfoId).remove();
                    deleteAction.initLoadedInfluencer(1);
                }
            }
        });
    }
};