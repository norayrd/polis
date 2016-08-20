CookieManager = {
    _setCookie: function (name, value, exdays, domain) {
        if (domain) {
            var domain = window.location.hostname;
            if (domain.indexOf("www.") === 0) {
                domain = domain.substr(domain.indexOf(".") + 1);
            }
        } else {
            var domain = window.location.hostname;
        }
        var exdate = new Date();
        exdate.setDate(exdate.getDate() + exdays);
        var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString()) + "; path=/; domain=" + domain;
        document.cookie = name + "=" + c_value;
    },
    _getCookie: function (name) {
        var i, x, y, ARRcookies = document.cookie.split(";");
        for (i = 0; i < ARRcookies.length; i++) {
            x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
            y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
            x = x.replace(/^\s+|\s+$/g, "");
            if (x == name) {
                return unescape(y);
            }
        }
    },
    _deleteCookie: function (name,domain) {
        if (this._getCookie(name))
            this._setCookie (name, '', -30000 ,domain);
    }
};