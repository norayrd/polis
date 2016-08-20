ErrorMessageManager  = {
    _timeout: 3000,
    selector: '',
    init: function (selector, delay) {
       
        if (typeof selector === 'undefined') {
            return;
        }
        this.selector = selector;
        if (typeof delay !== 'undefined') {
            this._timeout = delay;
        }
        this.removeMessage();
    },
    removeMessage: function () {
         
        setTimeout(function () {
            jQuery(this.selector).addClass("is_hidden");
        }.bind(this), this._timeout);
    }
};