"use strict";
/*jshint esversion: 6 */

(function() {
    window.k5.screen = {
        storeScroll: function () {
            k5.env.mainScroll = window.scrollY;
        },
        restoreScroll : function (erase=true) {
            let _r = k5.env.MainScroll;
            if(erase) {
                k5.env.MainScroll = 0;
            }
            return _r;
        },
        overlayIframeClose : function () {
            let overlay = document.getElementById('layout_overlay');
            if(overlay) {
                overlay.innerHTML = "";
                overlay.style.display = "none";
                glb.util.RestoreLayout();
            }
        },
        alert: function (content,title=null) {
            let _con = content;
            if(typeof content === "object") {
                _con = "<pre>"+JSON.stringify(content)+"</pre>";
            }
            k5.modal.get("JSAlert",title,_con,null,'medium','right')
        },
        notify: function (message,type='info',position='top-right',timer=5000) {
            this.toastr(message,type,position,timer);
        },
        toastr: function (message,type='success',position='top-right',timer=5000,onclick=null) {

            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-"+position,
                "preventDuplicates": true,
                "onclick": onclick,
                "showDuration": "400",
                "hideDuration": "1000",
                "timeOut": timer,
                "extendedTimeOut": timer,
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr.info(message);
        },
    };
})();


