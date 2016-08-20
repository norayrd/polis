/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {
    InfluencerHeader.init();
});

var InfluencerHeader = {
    init: function () {
        this.headerMenuPopup();
    },
    
    headerMenuPopup: function () {
        var menuContent = $(".f_header-menu-content");

        $(".f_header-menu-btn").on('click', function () {
            if (menuContent.hasClass("is_active")) {
                menuContent.removeClass("is_active");
            } else {
                menuContent.addClass("is_active");
            }
        });

        $("body").on('click', function (event) {
            if ($(event.target).parents('.f_header-menu-btn-content').length < 1) {
                menuContent.removeClass("is_active");
            }
        });
    }
};