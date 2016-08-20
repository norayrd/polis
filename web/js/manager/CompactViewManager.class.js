/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


CompactViewManager = {
    init: function (idSelector, pageName, selectorType) {
        
        var selector =  this.getSelectorByType(idSelector, selectorType);
        
        $(selector).on('click', function () {

            CookieManager._getCookie(pageName + "_compactView");

            var cookie = CookieManager._getCookie(pageName + "_compactView");
            if (typeof cookie !== "undefined" && cookie == 0) {
                CookieManager._setCookie(pageName + "_compactView", 1, null, '.');
                return;
            }
            CookieManager._setCookie(pageName + "_compactView", 0, null, '.');

        });
    },
    getSelectorByType: function (selectorName, selectorType) {
        var selector = "";
        switch (selectorType) {
            case "class":
                selector = ".";
                break;
            case "id":
                selector = "#";
                break;
            default:
                selector = "#";
        }
        return selector + selectorName;
    }

};

