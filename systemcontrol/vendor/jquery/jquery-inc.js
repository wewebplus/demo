// JavaScript Document
if(jQuery && !jQuery.fn.live) {
    jQuery.fn.live = function(evt, func) {
        $('body').on(evt, this.selector, func);
    }
}
