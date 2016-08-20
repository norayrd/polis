$(function () {
    InfluencerBatch.init();
});

var InfluencerBatch = {
    _oldWaitingstatus: {
        oldTime: 0,
        waitingStatus: 0
    },
    _oldwaitingTime: new Date(),
    _waitingStatusCount: false,
    _analyzedStatus: {
        _statusDone: 0,
        _statusWaiting: 0,
        _statusNotFound: 0
    },
    init: function () {
        this.initCSVUpload();
        this.initCSVInfoTooltip();
        this.initAddInfuencer();
        this.checkUserStatus();
        this.editInfluencerName();
        this.removeErrorMessage();
    },
    initCSVUpload: function () {
        var self = this;
        var file = $('#import_csv_list');
        var xhr = new XMLHttpRequest();
        var form = new FormData();
        file.change(function () {

            var upload_file = file[0].files[0];
            var fileType = upload_file.type;
            self.checkCSVValiadtion(xhr, form, upload_file, fileType, file);
        });
    },
    checkCSVValiadtion: function (xhr, form, upload_file, fileType, file, selectedFormat) {
        var url = '/influencers-batch/upload';

        if (file.val() != '' && (fileType == 'application/vnd.ms-excel' || fileType == 'text/csv') && upload_file.size != 0) {
            
            $(".f_import-csv-success").removeClass("is_hidden");
            form.append("import_csv_list", upload_file);
            xhr.open("post", url + "?r=" + Math.random(), false);   // "r=+Math.random()" - to avoid caching by browser
            xhr.send(form);
            document.location.reload();
        } else {
           
            $(".f_import-csv-error").removeClass("is_hidden");
            if (upload_file.size == 0) {
                $(".f_import-csv-error p").html("The CSV file is empty!");
            }
        }
        file.val("");
        $(document).on('click', function (event) {
            if ($(event.target).closest(".f_scv-popup-container").length < 1 || $(event.target).closest(".f_ok-btn")) {
                $(".f_import-csv-success, .f_import-csv-error").addClass("is_hidden");
            }
        });
    },
    initCSVInfoTooltip: function () {
        $(".f_additional-info-btn").on('click', function () {
            $(".f_additional-info").toggleClass("is_hidden");
        });
        $(document).on('click', function (event) {
            if ($(event.target).closest(".f_additional-info-btn").length < 1 && $(event.target).closest(".f_additional-info").length < 1) {
                $(".f_additional-info").addClass("is_hidden");
            }
        });
    },
    initAddInfuencer: function () {
        $(".f_user-add-btn").unbind('click').on('click', function () {
            var currentbtn = $(this);
            var userId = currentbtn.attr("data-user-id");
            currentbtn.addClass("is_hidden");
            currentbtn.find('.fa-plus').remove();
            currentbtn.siblings(".f_batch-loader").removeClass("is_hidden");
            $.ajax({
                type: "POST",
                url: '/influencers-batch/addToInfluencerList',
                data: "param=" + userId,
                success: function (response) {
                    if (response.code > 0) {
                        currentbtn.removeClass("is_hidden");
                        currentbtn.siblings(".f_batch-loader").addClass("is_hidden");
                        currentbtn.closest(".f_influencer-block").find(".f_limiting-popup").removeClass("is_hidden");
                        currentbtn.closest(".f_influencer-block").find(".f_limiting-popup").html(response.message);
                    } else {
                        currentbtn.siblings(".f_batch-loader").addClass("is_hidden");
                        currentbtn.siblings(".f_check-circle").removeClass("is_hidden");
                        setTimeout(function () {
                            currentbtn.removeClass("is_hidden");
                            currentbtn.html('<i class="fa fa-refresh"></i>');
                            currentbtn.siblings(".f_check-circle").addClass("is_hidden");
                        }, 1500);
//                        $("#table_row_instagram_user_info_" + userId).remove();
                    }

                }
            });
        });
    },
    editInfluencerName: function () {
        var self = this;
        $(".f_username-field").on('click', function () {
            var currentField = $(this);
            var oldValue = currentField.val();
            var batchId = currentField.attr("data-batch-id");
            currentField.addClass("is_active");
            currentField.attr('readOnly', false);

            currentField.unbind('keydown').keydown(function (e) {
                if (e.which == 13) {
                    currentField.unbind('keydown');
                    currentField.attr('readOnly', true);
                    currentField.removeClass("is_active");
                    var newValue = currentField.val();
                    self.checkFieldValues(currentField, oldValue, newValue, batchId);
                }
            });
            currentField.unbind('focusout').on('focusout', function () {
                currentField.unbind('keydown');
                currentField.attr('readOnly', true);
                currentField.removeClass("is_active");
                var newValue = currentField.val();
                self.checkFieldValues(currentField, oldValue, newValue, batchId);
            });
        });

    },
    checkFieldValues: function (currentField, oldValue, newValue, batchId) {
        if (oldValue != newValue) {
            currentField.closest(".f_influencer-block").attr("data-user-status", 0);
            currentField.closest(".f_influencer-block").find(".f_user-not-found").removeClass("is_hidden");
            //currentField.closest(".f_influencer-block").find(".f_user-add-btn").addClass("is_hidden");
            //currentField.closest(".f_influencer-block").find(".f_user-archive").html("<div class='batch-loader'></div>");
            this.changeInfluencer(batchId, newValue);
        }
    },
    changeInfluencer: function (batchId, newValue) {
        $.ajax({
            type: "POST",
            url: '/influencers-batch/rename/account',
            data: "userBatchId=" + batchId + "&newname=" + newValue,
            success: function (response) {
                var code = $(response).filter('.f_code').val();
                var message = $(response).filter('.f_message').val();
                $("#table_row_instagram_user_info_" + batchId).html($(response).children());
                this.initAfterLoad();
                if (code>0) {
                $("#table_row_instagram_user_info_" + batchId).find(".f_limiting-popup").removeClass("is_hidden");
                $("#table_row_instagram_user_info_" + batchId).find(".f_limiting-popup").html(message);
                }
            }.bind(this)
        });
    },
    checkUserStatus: function () {
        var self = this;
        setTimeout(function () {
            $.ajax({
                type: "POST",
                url: '/influencers-batch/status',
                data: "",
                success: function (resposnse) {
                    $(".f_influencer-block[data-user-status=0]").each(function (index) {
                        var userBatchId = $(this).attr("data-batch-id");
                        if (resposnse.result[userBatchId] != 0) {
                            $(this).attr("data-user-status", resposnse.result[userBatchId]);
                            self.changeUserStatus(userBatchId);
                        }
                    });

                    $.each(resposnse.result, function (index) {
                        if (resposnse.result[index] == 0) {
                            self._waitingStatusCount = true;
                        } else {
                            self._waitingStatusCount = false;
                        }
                        self.estimateTime(resposnse.result);
                    });
                    self.clearAnalyzedStatus();
                    $.each(resposnse.result, function (index) {
                        self.countAnalyzedStatus(resposnse.result[index]);
                    });
                    self.setAnalyzedStatus();
                    if (self._waitingStatusCount) {
                        self.checkUserStatus();
                        if (CookieManager._getCookie("KPI_Batch_remaining")) {
                            $("#estimateTime").html(CookieManager._getCookie("KPI_Batch_remaining"));
                        }
                    } else {
                        CookieManager._deleteCookie('KPI_Batch_remaining', '.');

                    }
                }
            });
        }.bind(this), 3000);
    },
    changeUserStatus: function (userBatchId) {
        $.ajax({
            type: "POST",
            url: '/influencers-batch',
            data: "userBatchId=" + userBatchId,
            success: function (resposnse) {
                $("#table_row_instagram_user_info_" + userBatchId).html($(resposnse).children());
                this.initAfterLoad();
            }.bind(this)
        });
    },
    estimateTime: function (resposnseResult) {
        var waiting = 0;
        $.each(resposnseResult, function (index) {
            if (resposnseResult[index] == 0) {
                waiting++;
            }
        });
        if (this._oldWaitingstatus.waitingStatus == 0) {
            this._oldWaitingstatus.waitingStatus = waiting;
            this._oldWaitingstatus.oldTime = new Date();

        } else if (this._oldWaitingstatus.waitingStatus > waiting) {
            var currentTime = new Date();
            var estimateTime = (currentTime - this._oldWaitingstatus.oldTime) * waiting / (this._oldWaitingstatus.waitingStatus - waiting);
            this._oldWaitingstatus.waitingStatus = waiting;
            this._oldWaitingstatus.oldTime = currentTime;
            this.setDateFormat(estimateTime);
        }
    },
    setDateFormat: function (estimateTime) {
        estimateTime /= 1000;
        var hour = Math.floor(estimateTime / 3600);
        estimateTime -= hour * 3600;
        var minute = Math.floor(estimateTime / 60);
        var second = Math.floor(estimateTime - minute * 60);
        if (hour > 0) {
            $("#estimateTime").html(hour + "h" + ":" + minute + "m" + ":" + second + "s");
        } else if (hour == 0 && minute == 0) {
            $("#estimateTime").html(second + "s");
        } else {
            $("#estimateTime").html(minute + "m" + ":" + second + "s");
        }
        var cookieValue = $("#estimateTime").html();
        CookieManager._setCookie("KPI_Batch_remaining", cookieValue, null, '.');
        if (estimateTime == 0) {
            CookieManager._deleteCookie('KPI_Batch_remaining', '.');
            document.location.reload();
        }
    },
    clearAnalyzedStatus: function () {
        this._analyzedStatus._statusWaiting = 0;
        this._analyzedStatus._statusDone = 0;
        this._analyzedStatus._statusNotFound = 0;
    },
    countAnalyzedStatus: function (status) {
        if (status == 0) {
            this._analyzedStatus._statusWaiting++;
        } else if (status == 1) {
            this._analyzedStatus._statusDone++;
        } else {
            this._analyzedStatus._statusNotFound++;
        }
    },
    setAnalyzedStatus: function () {
        $("#analyzedCount").html(this._analyzedStatus._statusDone);
        $("#analyzedLeftCount").html(this._analyzedStatus._statusWaiting);
        $("#notFoundCount").html(this._analyzedStatus._statusNotFound);
    },
    loadMoreBtn: function (sender, offset) {

        var me = this;
        $(sender).parent().addClass("hide");
        $.ajax({
            type: "POST",
            url: '/influencers-batch',
            data: "offset=" + offset,
            success: function (content) {

                $(".f_influencers-content").append(content);
                me.initAfterLoad();

            }
        });
    },
    removeErrorMessage: function () {
        var errorMessage = $("#batchUploadMessage");
        if(errorMessage.length > 0){
            ErrorMessageManager.init(errorMessage, 5000);
        }
    },
    initAfterLoad: function () {
        influencerBaseList.init();
        this.initAddInfuencer();
        this.editInfluencerName();
        this.updateUserData();
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