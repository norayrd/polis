var deleteAction = {
    _url: '',
    _callBack: function () {},
    init: function (url, callback) {

        this._callBack = callback;

        this._url = url;
        this.initDeletePopup();
        this.initQuickDeleteAction();
        this.initAllDeleteAction();
    },
    initQuickDeleteAction: function () {
        var self = this;
        var selectedArrayId = {};

        $('.f_user-archive-btn').unbind('click').on('click', function () {
            var userId = $(this).attr("data-user-id");
            selectedArrayId[0] = userId;
            var _params = {};
            var inflencersIdJSON = JSON.stringify(selectedArrayId);
            _params.param = inflencersIdJSON;
            AjaxRequest._call(self._url, _params, "POST", function (result) {
                self._callBack.call(this, result, inflencersIdJSON);
                self.initLoadedInfluencer(1);
            });
        });
    },
    initAllDeleteAction: function () {
        $("#select_all").on('click', function () {
            $("#influencer-list-table").find(".select_line").prop("checked", $(this).prop("checked"));
        });

        $('#cancelBtn').on('click', function () {
            $('.f_delete-user-popup').addClass("is_hidden");
        });

        $(document).on('click', function (event) {
            if ($(event.target).closest(".f_delete--user-container").length < 1 && $(event.target).closest(".f_all-users-archive-btn").length < 1) {
                $(".f_delete-user-popup").addClass("is_hidden");
            }
        });
    },
    initDeletePopup: function () {
        var selectedLines = '';
        var selectedArrayId = {};
        var inflencersIdJSON = '';
        $(".f_all-users-archive-btn").unbind('click').on('click', function () {
            selectedLines = $("#influencer-list-table").find(".select_line:checked");
            selectedLines.each(function (index) {
                selectedArrayId[index] = selectedLines[index].value;
            });
            if (selectedLines.length > 0) {
                $('.f_delete-user-popup').removeClass('is_hidden');
                inflencersIdJSON = JSON.stringify(selectedArrayId);
                this.initDeletePopupBox(inflencersIdJSON, selectedLines.length);
            }
        }.bind(this));
    },
    initDeletePopupBox: function (inflencersIdJSON, selectedArrayLength) {
        $('.f_delete-ok').unbind('click').on('click', function () {
            var _params = {};
            _params.param = inflencersIdJSON;
            AjaxRequest._call(this._url, _params, "POST", function (response) {
                this._callBack.call(this, response, inflencersIdJSON);
                this.initLoadedInfluencer(selectedArrayLength);
            }.bind(this));
            $('.f_delete-user-popup').addClass("is_hidden");
        }.bind(this));
    },
    initLoadedInfluencer: function (deletedCount) {
        var loadedItemsCount = parseInt($("#loadedItemsCount").html());
        var totalItems = parseInt($("#totalItems").html());

        var offset = loadedItemsCount - deletedCount;
        totalItems -= deletedCount;
        $("#totalItems").html(totalItems);

        if (totalItems < loadedItemsCount) {
            loadedItemsCount = totalItems;
            $("#loadedItemsCount").html(loadedItemsCount);
        }
        $("#select_all").attr('checked', false);
        if (totalItems == 0) {
            $("#loaded-influencers-info").addClass("is_hidden");
        }

        var pageUrl = $("#pageUrl").val();
        var btnLoadMore = $("#loadMoreBtn");
        influencerBaseList.loadMoreBtn(btnLoadMore, pageUrl, offset, deletedCount);
    }
};