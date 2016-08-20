$(function () {
    forgotPassword.init();
});

var forgotPassword = {
    init: function () {
        this.initEmailValidationAction();
        this.initPasswordValidationAction();
        this.onSuccessMessage();
    },
    initEmailValidationAction: function () {
        var falidateField = $("#email");
        $("#submit_form").on('click', function (ev) {
            ev.preventDefault();
            if (this.checkEmailValidaion(falidateField)) {
                $("#forgot_password_form").trigger("submit");
            }
        }.bind(this));
        this.initEmailValidation(falidateField);
    },
    initEmailValidation: function (selector) {
        selector.on('focus', function () {
            selector.removeClass("is_fill");
        }.bind(this));
        selector.on('focusout', function () {
            if (!this.checkEmailValidaion(selector)) {
                selector.addClass("is_fill");
            }
        }.bind(this));
    },
    checkEmailValidaion: function (selector) {
        var regExp = /^([A-Za-z0-9_\-\.\+])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        if (regExp.test(selector.val())) {
            selector.removeClass("is_fill");
            selector.addClass("is_success");
            return true;
        } else {
            selector.addClass("is_fill");
            selector.removeClass("is_success");
            return false;
        }
    },
    initPasswordValidationAction: function () {
        this.initPasswordValidation();
        $("#submit_form").on('click', function (ev) {
            ev.preventDefault();
            var newPassword = $("#newPassword");
            var confirmPassword = $("#confirmPassword");
            if (this.checkPasswordDoubleValiadtion(newPassword, confirmPassword)) {
                $("#forgot_password_form").trigger("submit");
            }

        }.bind(this));
    },
    initPasswordValidation: function () {
        var newPassword = $("#newPassword");
        var confirmPassword = $("#confirmPassword");
        newPassword.removeClass("is_fill");
        confirmPassword.removeClass("is_fill");

        newPassword.on('focusout', function () {
            this.checkPasswordValiadtion(newPassword);
        }.bind(this));
        confirmPassword.on('focusout', function () {
            this.checkPasswordValiadtion(confirmPassword);
        }.bind(this));

    },
    checkPasswordValiadtion: function (selector) {
        var selectorValue = selector.val().trim();
        if (selectorValue.length < 7) {
            selector.addClass("is_fill");
            selector.removeClass("is_success");
        } else {
            selector.removeClass("is_fill");
            selector.addClass("is_success");
        }
    },
    checkPasswordDoubleValiadtion: function (newPassword, confirmPassword) {
        var firstPassword = newPassword.val().trim();
        var secondPassword = confirmPassword.val().trim();
        if (firstPassword.length >= 7 && secondPassword.length >= 7 && firstPassword == secondPassword) {
            return true;
        } else {
            confirmPassword.removeClass("is_success");
            confirmPassword.addClass("is_fill");
            if (firstPassword.length < 7) {
                newPassword.removeClass("is_success");
                newPassword.addClass("is_fill");
            }
            return false;
        }
    },
    onSuccessMessage: function () {
        if ($('.f_alert-success').length > 0) {
            setTimeout(function () {
                document.location.href = '/login';
            }, 3000);
        }
    }
};