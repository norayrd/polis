$(function () {
    CampaignManagement.init();
});

var CampaignManagement = {
    pageName: 'influencer_list',
    init: function () {
        this.initDeleteButtons("#keyword_buttons-block");
        this.addKeywords();

        this.initDeleteButtons("#negative_keyword_buttons-block");
        this.addNegativeKeywords();

        this.initDeleteButtons("#language_buttons-block");
        this.addLanguages();

        this.initDeleteButtons("#location_buttons-block");
        this.addLocations();

        this.initCampaignAddInfluencersKeyboardAction();
        this.initCampaignAddInfluencers();
        this.initCampaignRemoveInfluencers();
        this.initCSVUpload();
        this.initCSVUploadInfo();

    },
    initDeleteButtons: function (block_name) {
        $(block_name + " .fa-times-circle-o").unbind('click').click(function () {
            var btnClass = '';
            var command = '';
            var param = [];
            if ($(this).hasClass('f_keyword-cros')) {
                btnClass = '.f_keyword-btn';
                command = 'keywords';
            } else if ($(this).hasClass('f_negative-keyword-cros')) {
                btnClass = '.f_negative-keyword-btn';
                command = 'negative-keywords';
            } else if ($(this).hasClass('f_language-cros')) {
                btnClass = '.f_language-btn';
                command = 'languages';
            } else if ($(this).hasClass('f_location-cros')) {
                btnClass = '.f_location-btn';
                command = 'locations';
            }

            $(this).parent().remove();

            if (btnClass !== '') {
                jQuery(btnClass).each(function () {
                    param.push($(this).val());
                });
            }

            if (command !== '') {
                CampaignManagement.sendCommand(command, param);
            }

        });
    },
    sendCommand: function (command, param) {
        $.ajax({
            type: "POST",
            url: window.location.pathname + "/" + command,
            data: "param=" + JSON.stringify(param)
        });
    },
    addKeywords: function () {
        var me = this;
        $("#keyword").keydown(function (e) {

            var keyword = $(this).val().trim();
            var keywords = [];
            var lowerKeywords = [];

            if ((e.which == 13) && (keyword.trim() !== '')) {
                $(".f_keyword-btn").each(function () {
                    keywords.push($(this).val());
                    lowerKeywords.push($(this).val().trim().toLowerCase());
                });

                if (lowerKeywords.indexOf(keyword.toLowerCase()) == -1) {
                    keywords.push(keyword.trim());
                    CampaignManagement.sendCommand('keywords', keywords);

                    var html = "<label title='" + keyword + "'><input class='btn btn-success keyword-btn f_keyword-btn' type='button' name='' value='" + keyword + "'/><i class='fa fa-times-circle-o f_keyword-cros'></i></label>";
                    $(".keywords-block .buttons-block").append(html);
                    me.initDeleteButtons("#keyword_buttons-block");
                }
                $(this).val('');
            }
        });
    },
    addNegativeKeywords: function () {
        var me = this;
        $("#negative-keyword").keydown(function (e) {

            var keyword = $(this).val().trim();
            var keywords = [];
            var lowerKeywords = [];

            if ((e.which == 13) && (keyword.trim() !== '')) {
                $(".f_negative-keyword-btn").each(function () {
                    keywords.push($(this).val());
                    lowerKeywords.push($(this).val().trim().toLowerCase());
                });

                if (lowerKeywords.indexOf(keyword.toLowerCase()) == -1) {
                    keywords.push(keyword.trim());
                    me.sendCommand('negative-keywords', keywords);

                    var html = "<label title='" + keyword + "'><input class='btn btn-success negative-keyword-btn f_negative-keyword-btn' type='button' name='' value='" + keyword + "'/><i class='fa fa-times-circle-o f_negative-keyword-cros'></i></label>";
                    $(".negative-keywords-block .buttons-block").append(html);
                    me.initDeleteButtons("#negative_keyword_buttons-block");
                }
                $(this).val('');
            }
        });
    },
    addLanguages: function () {
        var me = this;
        $("#language").keydown(function (e) {

            var language = $(this).val();
            var languages = [];

            if ((e.which == 13) && (language.trim() !== '')) {
                $(".f_language-btn").each(function () {
                    languages.push($(this).val());
                });

                if (languages.indexOf(language) == -1) {

                    languages.push(language);
                    CampaignManagement.sendCommand('languages', languages);

                    var html = "<label title='" + language + "'><input class='btn btn-success language-btn f_language-btn' type='button' name='' value='" + language + "'/><i class='fa fa-times-circle-o'></i></label>";
                    $(".languages-block .buttons-block").append(html);
                    me.initDeleteButtons("#language_buttons-block");
                }
                $(this).val('');
            }
        });
    },
    addLocations: function () {
        var me = this;
        $("#location").keydown(function (e) {

            var location = $(this).val();
            var locations = [];

            if ((e.which == 13) && (location.trim() !== '')) {
                $(".f_location-btn").each(function () {
                    locations.push($(this).val());
                });

                if (locations.indexOf(location) == -1) {

                    locations.push(location);
                    CampaignManagement.sendCommand('locations', locations);

                    var html = "<label title='" + location + "'><input class='btn btn-success location-btn f_location-btn' type='button' name='' value='" + location + "'/><i class='fa fa-times-circle-o'></i></label>";
                    $(".locations-block .buttons-block").append(html);
                    me.initDeleteButtons("#location_buttons-block");
                }
                $(this).val('');
            }

        });
    },
    sendCommand2: function (command, param, container) {
        $.ajax({
            type: "POST",
            url: window.location.pathname + "/" + command,
            data: "param=" + JSON.stringify(param),
            success: function (response) {
                container.html(response);
                this.callAfterLoad();
            }.bind(this)
        });
    },
    callAfterLoad: function () {
        this.initCampaignAddInfluencers();
        this.initCampaignRemoveInfluencers();
        this.initCampaignAddInfluencersKeyboardAction();

    },
    initCSVUpload: function () {
        var self = this;
        var file = $('#file_ignore_list');
        var xhr = new XMLHttpRequest();
        var form = new FormData();
        file.change(function () {
            var upload_file = file[0].files[0];
            var fileType = upload_file.type;
            var selectedFormat = $("#csvDefaulFormat").find('input:checked').val();
            self.checkCSVValiadtion(xhr, form, upload_file, fileType, file, selectedFormat);
        });
    },
    checkCSVValiadtion: function (xhr, form, upload_file, fileType, file, selectedFormat) {
        var url = '';
        if (selectedFormat == "comma") {
            url = 'campaign-management-upload-file/upload_ignore_list_comma';
        } else {
            url = 'campaign-management-upload-file/upload_ignore_list_semi_colons';
        }
        if (file.val() != '' && (fileType == 'application/vnd.ms-excel' || fileType == 'text/csv') && upload_file.size != 0) {

            form.append("file_ignore_list", upload_file);
            xhr.open("post", url + "?r=" + Math.random(), false);   // "r=+Math.random()" - to avoid caching by browser
            xhr.send(form);

            this.getCSVUploadResult();
        } else {
            $(".f_scv-error").removeClass("is_hidden");
            if (upload_file.size == 0) {
                $(".f_scv-error p").html("The CSV file is empty!");
            }
        }
        file.val("");
        $(document).on('click', function (event) {
            if ($(event.target).closest(".f_scv-popup-container").length < 1 || $(event.target).closest(".f_ok-btn")) {
                $(".f_scv-error, .f_scv-success").addClass("is_hidden");
            }
        });
    },
    getCSVUploadResult: function (uploadDate) {
        var _url = "/campaign-management/ignore_list_info";
        AjaxRequest._call(_url, '', "POST", function (response) {
            if (response.code == 0) {
                $(".f_scv-success").removeClass("is_hidden");
                $("#csvLastUploadDate").html(response.result.updatedDateTime);
                $("#csvLastUploadDate").parent().removeClass("is_hidden");
            }
            if (response.code != 0 && response.result.message != "") {
                $(".f_scv-error").removeClass("is_hidden");
                $(".f_scv-error p").html(response.result.message);
            }
        });
    },
    initCSVUploadInfo: function () {
        $("#ignoreListPopupBtn").on('click', function () {
            $("#ignoreListPopup").toggleClass("is_hidden");
        });
        $(document).on('click', function (event) {
            if ($(event.target).closest("#ignoreListPopup").length < 1 && $(event.target).closest("#ignoreListPopupBtn").length < 1) {
                $("#ignoreListPopup").addClass("is_hidden");
            }
        });
    },
    initCampaignAddAction: function (self, actionName, container) {
        var fieldBox = self.closest(".f_input-field-box");
        var inputField = fieldBox.find(".f_input-field");
        var param = inputField.val();
        if (param.trim() != '') {
            inputField.removeClass("is_fill");
            fieldBox.addClass("is_active");
            this.sendCommand2(actionName, param, container);
        } else {
            inputField.addClass("is_fill");
        }

    },
    initCampaignAddInfluencers: function () {
        $(".f_benchmark_submit-btn").unbind('click').on('click', function () {
            var self = $(".f_benchmark_submit-btn");
            var container = $('#benchmark-content');
            this.initCampaignAddAction(self, 'benchmark', container);
        }.bind(this));

        $(".f_relevant_small_submit-btn").unbind('click').on('click', function () {
            var self = $(".f_relevant_small_submit-btn");
            var container = $('#relevant-small-content');
            this.initCampaignAddAction(self, 'relevant_small', container);
        }.bind(this));

        $(".f_relevant_middle_submit-btn").unbind('click').on('click', function () {
            var self = $(".f_relevant_middle_submit-btn");
            var container = $('#relevant-middle-content');
            this.initCampaignAddAction(self, 'relevant_middle', container);
        }.bind(this));

        $(".f_relevant_big_submit-btn").unbind('click').on('click', function () {
            var self = $(".f_relevant_big_submit-btn");
            var container = $('#relevant-big-content');
            this.initCampaignAddAction(self, 'relevant_big', container);
        }.bind(this));
    },
    initCampaignAddInfluencersKeyboardAction: function () {

        $(".f_benchmark_name").unbind('keydown').keydown(function (e) {
            if (e.which == 13) {
                $('.f_benchmark_submit-btn').click();
            }
        });
        $(".f_relevant_small_name").unbind('keydown').keydown(function (e) {
            if (e.which == 13) {
                $('.f_relevant_small_submit-btn').click();
            }
        });
        $(".f_relevant_middle_name").unbind('keydown').keydown(function (e) {
            if (e.which == 13) {
                $('.f_relevant_middle_submit-btn').click();
            }
        });
        $(".f_relevant_big_name").unbind('keydown').keydown(function (e) {
            if (e.which == 13) {
                $('.f_relevant_big_submit-btn').click();
            }
        });
    },
    initCampaignRemoveInfluencers: function () {

        $(".f_benchmark_del-btn").unbind('click').on('click', function () {
            var container = $("#benchmark-content");
            this.initCampaignRemoveAction('benchmark_delete', 'delete', container);
        }.bind(this));
        $(".f_relevant_small_del-btn").unbind('click').on('click', function () {
            var container = $("#relevant-small-content");
            this.initCampaignRemoveAction('relevant_small_delete', 'delete', container);
        }.bind(this));
        $(".f_relevant_middle_del-btn").unbind('click').on('click', function () {
            var container = $("#relevant-middle-content");
            this.initCampaignRemoveAction('relevant_middle_delete', 'delete', container);
        }.bind(this));
        $(".f_relevant_big_del-btn").unbind('click').on('click', function () {
            var container = $("#relevant-big-content");
            this.initCampaignRemoveAction('relevant_big_delete', 'delete', container);
        }.bind(this));

    },
    initCampaignRemoveAction: function (fieldName, actionName, container) {
        $('.f_delete-user-popup').removeClass('is_hidden');
        $('.f_delete-ok').unbind('click').on('click', function () {
            this.sendCommand2(fieldName, actionName, container);
            $('.f_delete-user-popup').addClass('is_hidden');
        }.bind(this));

        $("#cancelBtn").unbind('click').on('click', function () {
            $('.f_delete-user-popup').addClass('is_hidden');
        });

        $(document).unbind('click').on('click', function (event) {
            if ($(event.target).closest(".f_delete--user-container").length < 1 && $(event.target).closest(".f_remove-btn").length < 1) {
                $(".f_delete-user-popup").addClass("is_hidden");
            }
        });
    }
};