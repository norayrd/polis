$(function () {
    SignUp.init();
});

var SignUp = {
    init: function () {

        this.init_submit_btn_click();

    },

    init_submit_btn_click: function (event) {

        $("#btn_submit").on('click', function () {

            notValide=false;

            pUserName = $("#inputUserName").val();
            pLastName = $("#inputUserLastname").val();
            pEmail = $("#inputUsernameEmail").val();
            pPassword = $("#inputPassword").val();
            pPasswordRetype = $("#inputRetypePassword").val();
            
            $(".control-group.error").each(function(){
                notValide=true;
            })
            
            return !notValide;

        });

    },
    
};