"use strict";
/*jshint esversion: 6 */

(function() {
    window.k5 = {
        env : {
            isInIFrame: (window.location !== window.parent.location),
            protocol: ('https:' === document.location.protocol) ? 'https://' : 'http://',
            xHeaders: {},
            userAgent: navigator.userAgent.toLowerCase(),
            lastScrollTop: 0,
            mainScroll: 0,
            modalScroll: 0,
            client: {
                is_ios:(!!navigator.userAgent.match(/(iPad|iPhone|iPod)/g)),
                is_android:/android/i.test(navigator.userAgent),
            },
            sound:{},
            state:{},
        },
        _urlChangeCallbacks : {},
        module : {},
        lang : {},
        getEnv: function() {
            return this.env;
        }
    };
})();

const observeUrlChange = () => {
    let oldHref = document.location.href;
    const body = document.querySelector('body');
    const observer = new MutationObserver(mutations => {
        if (oldHref !== document.location.href) {
            oldHref = document.location.href;
            window.dispatchEvent(new Event('locationchange'));
        }
    });
    observer.observe(body, { childList: true, subtree: true });
};

window.onload = observeUrlChange;

console.log(k5.getEnv());



