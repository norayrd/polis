$(function () {
    notifyProgress.init();
});
var notifyProgress = {
    _url: "/notify-info",
    init: function () {
        this.initNotifyInfo();
    },
    initNotifyInfo: function () {
        var self = this;
        AjaxRequest._call(this._url, '', "POST", function (responseJSON) {
            self.initJSON(responseJSON);
        });
    },
    initNotifyInfoProgress: function () {
        var self = this;
        setTimeout(function () {
            AjaxRequest._call(this._url, '', "POST", function (responseJSON) {
                self.initJSON(responseJSON);
            });
        }.bind(this), 30000);
    },
    initJSON: function (responseJSON) {
        
        if (responseJSON.code == 401) {
            location.reload();
            return;
        }
//        try {
//            JSON.parse(responseJSON);
//                
//        } catch (e) {
//            if ($(responseJSON).filter('#loginpage').length>0) {
//                location.reload();
//            }
//        }

        if (responseJSON.code == 1) {
            this.initReAuthorize(responseJSON);
        } else {
            var response = responseJSON.result;
            if (typeof response === "undefined") {
                return;
            }
            if (typeof response !== "undefined") {
                var limitPercent = response.instagramRateLimit.rateLimitPercent;
                var remainingCount = response.instagramRateLimit.rateLimit;
                $("#notity-progress").css('width', limitPercent + '%');
                $("#progressCountRemaining").html(remainingCount);
                this.setProgressColor(limitPercent);
                this.initNotifyInfoProgress();
            }
        }
    },
    setProgressColor: function (limitPercent) {
        if (limitPercent < 40) {
            $("#notity-progress").addClass("progress-bar-danger");
        } else if (limitPercent >= 40 && limitPercent <= 75) {
            $("#notity-progress").removeClass("progress-bar-danger");
            $("#notity-progress").addClass("progress-bar-success");
        } else if ((limitPercent > 75)) {
            $("#notity-progress").removeClass("progress-bar-success");
            $("#notity-progress").addClass("progress-bar-info");
        }
    },
    initReAuthorize: function (responseJSON) {
        var authorizeUrl = responseJSON.result.instagramLoginUrl;
        $("#reAuthorize").removeClass("is_hidden");
        $("#reAuthorizeBtn").attr('href', authorizeUrl);
        var previousUrl = window.location.href;
        CookieManager._setCookie("previous_url", previousUrl, null, '.');
        return;
    }
};