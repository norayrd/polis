$(function () {
    singleAnalysis.init();
});

var singleAnalysis = {
    _oldProgress: 0,
    _currentProgress: 0,
    init: function () {
        this.initSearchResult();
        this.initAnotheAnalyzeAction();
        this.hideLimitPopup();
    },
    initSearchResult: function () {
        var self = this;

        $("#singleSearchContainer").on('keydown', function (event) {
            if (event.which == 13) {
                event.preventDefault();
            }
        });
        $("#singleSearchContainer").on('input', function (ev) {
            var instagram_username = $(ev.target).val();
            if (this.timeOut) {
                clearTimeout(this.timeOut);
            }
            if (instagram_username.trim() !== '') {
                this.timeOut = setTimeout(function (instagram_username) {
                    self.getSearchResult(instagram_username);
                    $("#singleSearchContainer").siblings(".f_option-load").removeClass("is_hidden");
                }, 500, instagram_username);
            } else {
                $(".f_single-search-result").removeClass('is_active');
            }
        }.bind(this));

        $(document).on('click', function (event) {
            if ($(event.target).closest(".f_single-search-result").length < 1 && $(event.target).closest("#singleSearchContainer").length < 1)
            {
                $(".f_single-search-result").removeClass("is_active");
            }
        });
    },
    getSearchResult: function (instagram_username) {
        var self = this;
        if (instagram_username == $("#singleSearchContainer").val()) {
            $.ajax({
                type: "POST",
                url: location.origin + '/start-search',
                data: "instagram_username=" + instagram_username,
                success: function (msg) {
                    $("#singleSearchContainer").siblings(".f_option-load").addClass("is_hidden");
                    $(".f_single-search-result").addClass('is_active');
                    $(".f_single-search-result").html(msg);
                    $("#singleSearchContainer").unbind('keydown').keydown(function (event) {
                        if (event.which == 13) {
                            self.sendEnterAction(event);
                        }
                    });
                    $(".f_search-upload-influencer").click(function (event) {
                        self.setPopupPosition(event);
                        var currentOption = $(this);
                        self.sendAploadAction(currentOption);
                    });
                }
            });
        } else {
            $(".f_single-search-result").removeClass('is_active');
        }
    },
    sendAploadAction: function (currentOption) {
        $(".f_search-upload-influencer").addClass("is_disabled");
        currentOption.find(".fa").addClass('is_hidden');
        currentOption.find(".f_option-load").removeClass('is_hidden');
        var username = currentOption.parent().siblings('.f_name-cell').find('.f_search-user-name-full').val().trim();
        var usernameID = currentOption.parent().siblings('.f_name-cell').find('.f_search-user-id').val();
        this.sendSearchUpload(currentOption, username, usernameID);
    },
    sendEnterAction: function (event) {
        event.preventDefault();

        $(".f_search-upload-influencer").removeClass("is_disabled");
        $("#singleSearchContainer").siblings(".f_option-load").removeClass("is_hidden");
        $("#singleSearchLimitingPopup").addClass("is_hidden");

        var firstUser = $(".f_single-search-result .f_name-cell").first();
        var username = firstUser.find(".f_search-user-name-full").val();
        var usernameID = firstUser.find(".f_search-user-id").val();
        var currentOption = 'undefined';
        this.sendSearchUpload(currentOption, username, usernameID);
    },
    sendSearchUpload: function (currentOption, username, usernameID) {
        var self = this;
        $.ajax({
            type: "POST",
            url: 'start-upload',
            data: "username=" + username + "&usernameID=" + usernameID,
            success: function (msg) {
                var userInfluencerId = msg.userInfluencerId;
                if (msg.code > 0) {
                    self.showPopup(currentOption, msg);
                } else {
                    $("#singleSearchContainerForm").fadeOut(function () {
                        $("#singleAnalysisHeader").fadeOut('fast');
                        $("#startSingleAnalysisProcessContent").fadeIn();
                        self.addInfluencerStatusLoader(userInfluencerId);
                        self.influencerStatusLoaderRunnerAction(userInfluencerId);
                    });
                }
            }
        });
    },
    showPopup: function (currentOption, msg) {
        $("#singleSearchLimitingPopup").removeClass("is_hidden");
        $("#singleSearchLimitingPopup").html(msg.message);
        if (currentOption != "undefined") {
            currentOption.find(".fa").removeClass('is_hidden');
            currentOption.find(".f_option-load").addClass('is_hidden');
        } else {
            $("#singleSearchLimitingPopup").addClass("single-limit-popup");
            $("#singleSearchLimitingPopup").removeAttr('style');
            $("#singleSearchContainer").siblings(".f_option-load").addClass("is_hidden");
        }
        $(".f_search-upload-influencer").removeClass("is_disabled");
    },
    setPopupPosition: function (event) {
        // var top = event.clientY - $("#singleSearchContainerForm").offset().top + $(document).scrollTop() + 35;
        var top = $(event.target).position().top + 35;
        var left = event.currentTarget.offsetLeft - 10;
        var styles = {
            top: top + 'px',
            left: left + 'px'
        };
        $("#singleSearchLimitingPopup").css(styles);
        $(document).on('click', function (ev) {
            if ($(ev.target).closest("#singleSearchLimitingPopup").length < 1) {
                $("#singleSearchLimitingPopup").addClass("is_hidden");
            }
        });
    },
    addInfluencerStatusLoader: function (userInfluencerId) {
        var self = this;
        $("#startSingleAnalysisProcess").circleProgress({
            value: 0,
            size: 1000,
            animation: {
                duration: 500
            },
            thickness: 10,
            fill: {
                gradient: ['#3D93E6', '#3D93E6']
            }
        });

        var reloadInterval = setInterval(function () {
            self.influencerStatusLoaderRunAction(reloadInterval, userInfluencerId);
        }, 3000);

    },
    influencerStatusLoaderRunAction: function (reloadInterval, userInfluencerId) {
        var self = this;
        $.ajax({
            type: "POST",
            url: "/start-progress",
            context: this,
            data: "userInfluencerId=" + userInfluencerId
        }).done(function (data) {
            var influencers = data; //$.parseJSON(data);
            var influencer = influencers[influencers.length - 1];
            var oneWorkerFinished = true;
            var currentProgress = influencer.progress / 100;
            var animationStartValue = 0;
            var elem = $("#startSingleAnalysisProcess");
            self._currentProgress = influencer.progress;

            if (self._currentProgress == 100) {
                window.clearInterval(reloadInterval);
            }
        });
    },
    influencerStatusLoaderRunnerAction: function (userInfluencerId) {
        var self = this;
        var elem = $("#startSingleAnalysisProcess");

        if (self._oldProgress < 100) {
            if (self._oldProgress < self._currentProgress) {
                self._oldProgress++;
                elem.circleProgress({
                    value: self._oldProgress / 100,
                    animationStartValue: (self._oldProgress - 1) / 100,
                    size: 1000,
                    animation: {
                        duration: 500
                    },
                    thickness: 10
                }).on('circle-animation-progress', function (event) {
                    $(this).find('.process-progress').html(parseInt(self._oldProgress) + '%');
                    self.changeResultText(self._oldProgress);
                });
            }
            setTimeout(function () {
                self.influencerStatusLoaderRunnerAction(userInfluencerId);
            }, 500);
        } else {
            this.influencerStatusLoaderStopAction(userInfluencerId);
        }
    },
    influencerStatusLoaderStopAction: function (userInfluencerId) {
        setTimeout(function () {
            $("#startSingleAnalysis").fadeOut("slow", function () {
                $.ajax({
                    type: "POST",
                    url: "/start-result",
                    context: this,
                    data: "userInfluencerId=" + userInfluencerId,
                }).done(function (data) {
                    $("#startSingleAnalysisProcess .process-progress").html("0%");
                    $('#analyzedInfluencerContainer').html(data);
                    $("#singleAnalysisHeader").fadeIn();
                    $("#singleAnalysisInfo").fadeIn();
                });
            });
        }, 2000);
    },
    changeResultText: function (progress) {
        if (progress > 1 && progress <= 30) {
            $("#startSingleAnalysisProcessText").html("Getting posts from the influencer account");
        } else if (progress > 30 && progress <= 40) {
            $("#startSingleAnalysisProcessText").html("Analyzing comments and likes");
        } else if (progress > 40 && progress <= 60) {
            $("#startSingleAnalysisProcessText").html("Getting audience accounts of the influencer");
        } else if (progress > 60 && progress <= 80) {
            $("#startSingleAnalysisProcessText").html("Getting audience account bios");
        } else if (progress > 80 && progress <= 95) {
            $("#startSingleAnalysisProcessText").html("Getting audience posts");
        } else if (progress > 95) {
            $("#startSingleAnalysisProcessText").html("Making final calculations... thanks for your patience!!! Drumroll please!");
        }
    },
    initAnotheAnalyzeAction: function () {
        $("#anotherAnalyzeBtn").on('click', function () {
            location.reload();
//            $("#singleAnalysisInfo").fadeOut(function () {
//                $("#startSingleAnalysisProcessContent").fadeOut(function () {
//                    $("#startSingleAnalysis").fadeIn();
//                    $("#singleSearchContainerForm").fadeIn();
//                });
//            });
        });
    },
    hideLimitPopup: function () {
        $(document).on('click', function (ev) {
            if ($(ev.target).closest("#singleSearchLimitingPopup").length < 1) {
                $("#singleSearchLimitingPopup").addClass("is_hidden");
            }
        });
    }
};