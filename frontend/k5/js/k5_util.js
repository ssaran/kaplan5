"use strict";
/*jshint esversion: 6 */

(function() {
    window.k5.util = {
        slugify: function (text) {
            text = this.convertToASCII(text);
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-')           // Replace spaces with -
                .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                .replace(/^-+/, '')             // Trim - from start of text
                .replace(/-+$/, '');            // Trim - from end of text
        },
        domIdfy: function (text) {
            text = this.convertToASCII(text);
            text = text.toString().toLowerCase()
                .replace(/\s+/g, '')           // Replace spaces with -
                .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                .replace(/\-\-+/g, '')         // Replace multiple - with single -
                .replace(/^-+/, '')             // Trim - from start of text
                .replace(/-+$/, '');            // Trim - from end of text
            text = text.replace(/-/g,"");
            return text;
        },
        generateUUID: function () {
            var d = new Date().getTime();//Timestamp
            var d2 = ((typeof performance !== 'undefined') && performance.now && (performance.now()*1000)) || 0;//Time in microseconds since page-load or 0 if unsupported
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                var r = Math.random() * 16;//random number between 0 and 16
                if(d > 0){//Use timestamp until depleted
                    r = (d + r)%16 | 0;
                    d = Math.floor(d/16);
                } else {//Use microseconds since page-load if supported
                    r = (d2 + r)%16 | 0;
                    d2 = Math.floor(d2/16);
                }
                return (c === 'x' ? r : (r & 0x3 | 0x8)).toString(16);
            });
        },
        isMainDomain: function (domain) {
            const parts = domain.split('.');
            // Check if there are exactly two segments, indicating it's a main domain
            return parts.length === 2 || (parts.length === 3 && parts[1].length <= 3);
        },
        isEmpty: function(obj) {
            for(let prop in obj) {
                if(obj.hasOwnProperty(prop)) {
                    return false;
                }
            }
            return JSON.stringify(obj) === JSON.stringify({});
        },
        isJson: function (str) {
            var _json;
            try {
                _json = JSON.parse(str);
            } catch (e) {
                return false;
            }
            return _json;
        },
        tr2Eng: function (str) {
            var charMap = {'Ç': 'C', 'Ö': 'O', 'Ş': 'S', 'İ': 'I', 'I': 'i', 'Ü': 'U', 'Ğ': 'G', 'ç': 'c', 'ö': 'o',
                'ş': 's', 'ı': 'i', 'ü': 'u', 'ğ': 'g'};

            let str_array = str.split('');

            for (var i = 0, len = str_array.length; i < len; i++) {
                str_array[i] = charMap[str_array[i]] || str_array[i];
            }

            str = str_array.join('');
            return str;
        },
        nl2br: function(str) {
            if (typeof str === 'undefined' || str === null) {
                return '';
            }
            var breakTag = '<br>';
            return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
        },
        secondsToHour: function(seconds) {
            let date = new Date(null);
            date.setSeconds(seconds);
            return date.toISOString().substr(11, 8);
        },
        sleep: function (milliseconds) {
            var start = new Date().getTime();
            for (var i = 0; i < 1e7; i++) {
                if ((new Date().getTime() - start) > milliseconds){
                    break;
                }
            }
        },
        convertToASCII: function(str) {
            str = str.replace(/\u00c2/g, 'A'); // Â
            str = str.replace(/\u00e2/g, 'a'); // â
            str = str.replace(/\u00fb/g, 'u'); // û
            str = str.replace(/\u00c7/g, 'C'); // Ç
            str = str.replace(/\u00e7/g, 'c'); // ç
            str = str.replace(/\u011e/g, 'G'); // Ğ
            str = str.replace(/\u011f/g, 'g'); // ğ
            str = str.replace(/\u0130/g, 'I'); // İ
            str = str.replace(/\u0131/g, 'i'); // ı
            str = str.replace(/\u015e/g, 'S'); // Ş
            str = str.replace(/\u015f/g, 's'); // ş
            str = str.replace(/\u00d6/g, 'O'); // Ö
            str = str.replace(/\u00f6/g, 'o'); // ö
            str = str.replace(/\u00dc/g, 'U'); // Ü
            str = str.replace(/\u00fc/g, 'u'); // ü
            return str;
        },
        toLower: function(str){
            return str.toLowerCase();
        },
        getUrl: function(url) {
            document.location.href = url;
        },
        renderOptions: function(d,sel) {
            var r = '';
            var s = d.length;
            var selected = '';
            for(var i = 0; i < s; i++) {
                e = d[i].split(":");
                if(e[1] != undefined) {
                    if(e[0] == sel) {
                        selected = 'selected'
                    } else {
                        selected = '';
                    }
                    r = r+' <option value="'+e[0]+'" '+selected+'>'+e[1]+'</option>';
                }
            }
            return r;
        },
        array2opArray: function(arr) {
            var arrayLength = arr.length;
            var r = [];
            for (var i = 0; i < arrayLength; i++) {
                var _str = arr[i]+":"+arr[i];
                r.push(_str);
            }
            return r;
        },
        closest: function(num, arr) {
            var curr = arr[0];
            var diff = Math.abs (num - curr);
            for (let val = 0; val < arr.length; val++) {
                var newdiff = Math.abs (num - arr[val]);
                if (newdiff < diff) {
                    diff = newdiff;
                    curr = arr[val];
                }
            }
            return curr;
        },
        loadUrl: function(url) {
            window.location.href = url;
        },
        openNewWindow: function(url) {
            window.open(url);
        },
        askConfirmLoad: function(ask,url){
            if(confirm(ask)){
                this.loadUrl(url);
            }
            return false;
        },
        getRandomInt: function(min, max) {
            return Math.floor(Math.random() * (max - min + 1) + min);
        },
        create2DArray: function(rows) {
            var arr = [];
            for (var i=0;i<rows;i++) {
                arr[i] = [];
            }
            return arr;
        },
        isInArray: function(value, array) {
            return array.indexOf(value) > -1;
        },
        resetSelect: function(idSelect)
        {
            var selectbox = document.getElementById(idSelect);
            var i;
            for(i = selectbox.options.length - 1 ; i >= 0 ; i--)
            {
                selectbox.remove(i);
            }
        },
        emptySelect: function(selectbox) {
            var i;
            for(i = selectbox.options.length - 1 ; i >= 0 ; i--)  {
                selectbox.remove(i);
            }
        },
        iframeAutoHeight: function(iframeID) {
            var _iFrame = document.getElementById(iFrameID);
            if(_iFrame) {
                _iFrame.height = "";
                _iFrame.height = _iFrame.contentWindow.document.body.scrollHeight + "px";
            }
        },
        generateId : function  (len) {
            var arr = new Uint8Array((len || 40) / 2)
            window.crypto.getRandomValues(arr)
            return Array.from(arr, this.dec2hex).join('')
        },
        dec2hex: function  (dec) {
            return dec.toString(16).padStart(2, "0")
        },
        getIssuerKey: function (issuerPrefix,key) {
            let el = document.getElementsByClassName('issuer');
            let _len = el.length;
            let issuerDomID = issuerPrefix+"_issuer";

            for (let i = 0; i < _len; i++) {
                let _is = el[i];
                if(_is.id !== 'undefined' && _is.id === issuerDomID) {
                    let _data = _is.dataset;
                    for(let _d in _data ) {
                        if(_d === key && _data.hasOwnProperty(_d)) {
                            return _data[_d];
                        }
                    }
                }
            }
            return false;
        },
        removeElementsByClass: function (className) {
            let elements = document.getElementsByClassName(className);
            while(elements.length > 0){
                elements[0].parentNode.removeChild(elements[0]);
            }
        },
        findElementByDataAndValue: function (dataKey,value) {
            return document.querySelectorAll("[data-"+dataKey+"='"+value+"']");
        },
        parseJSON: function (str) {
            try {
                return JSON.parse(str);
            } catch (e) {
                return str;
            }
        },
        vatFromTotal: function (total,ratio,round=true) {
            if(total === 0) { return; }
            if(ratio === 0) { return; }
            return (!round) ? total / (1 + (ratio / 100)) : Math.round(total / (1 + (ratio / 100))).toFixed(2);
        },
        twoWords: function (data) {
            if(data === null) { return data; }
            let name = this.ucFirst(data);
            return name.split(' ').slice(0,2).join(' ');
        },
        manyWords: function (data,amount) {
            if(data === null) { return data; }
            let name = this.ucFirst(data);
            return name.split(' ').slice(0,amount).join(' ');
        },
        ucFirst: function (data) {
            if(data === null) { return data; }

            return data
                .toString()
                .toLowerCase()
                .split(' ')
                .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                .join(' ');
        },
        printMoney: function(value,locale='tr-TR',currency='TRY') {
            const formatter = new Intl.NumberFormat(locale, {
                style: 'currency',
                currency: currency
            })

            return formatter.format(value);
        },
        formatPhoneNumber: function(phoneNumberString) {
            var cleaned = ('' + phoneNumberString).replace(/\D/g, '');
            var match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/);
            if (match) {
                return '(' + match[1] + ') ' + match[2] + '-' + match[3];
            }
            return null;
        },
        removeSelectOptions: function(selectElement) {
            var i, L = selectElement.options.length - 1;
            for(i = L; i >= 0; i--) {
                selectElement.remove(i);
            }
        },
        js2Str: function (obj) {
            return window.btoa(unescape(encodeURIComponent(JSON.stringify(obj))));
        },
        str2Js: function (encoded) {
            if(typeof encoded !== "undefined" && encoded.length > 0) {
                return JSON.parse(decodeURIComponent(escape(window.atob(encoded))));
            }
        },
        bootstrapDetectBreakpoint : function () {
            /**
             * Author and copyright: Stefan Haack (https://shaack.com)
             * Repository: https://github.com/shaack/bootstrap-detect-breakpoint
             * License: MIT, see file 'LICENSE'
             */
            // cache some values on first call
            if (!this.breakpointValues) {
                this.breakpointNames = ['xxl', 'xl', 'lg', 'md', 'sm', 'xs']
                this.breakpointValues = []
                const isPriorBS5 = !!window.getComputedStyle(document.documentElement).getPropertyValue('--breakpoint-sm')
                const prefix = isPriorBS5 ? "--breakpoint-" : "--bs-breakpoint-"
                for (const breakpointName of this.breakpointNames) {
                    const value = window.getComputedStyle(document.documentElement).getPropertyValue(prefix + breakpointName)
                    if(value) {
                        this.breakpointValues[breakpointName] = value
                    }
                }
            }
            let i = this.breakpointNames.length
            for (const breakpointName of this.breakpointNames) {
                i--
                if (window.matchMedia("(min-width: " + this.breakpointValues[breakpointName] + ")").matches) {
                    return {name: breakpointName, index: i}
                }
            }
            return null;
        },
        focusNextTabIndex : function (currentIndex,tabClass="tabable",lastTabIndex=10) {
            console.log("yada",currentIndex,tabClass,lastTabIndex);
            var curIndex = currentIndex;
            if(curIndex == lastTabIndex) { //if we are on the last tabindex, go back to the beginning
                curIndex = 0;
            }
            var tabbables = document.querySelectorAll("."+tabClass); //get all tabable elements
            for(var i=0; i<tabbables.length; i++) { //loop through each element
                if(tabbables[i].tabIndex == (curIndex+1)) { //check the tabindex to see if it's the element we want
                    tabbables[i].focus(); //if it's the one we want, focus it and exit the loop
                    break;
                }
            }
        },
        base64ToBlob : function (base64, mime,sError=false) {
            try {
                mime = mime || '';
                var sliceSize = 1024;
                var byteChars = window.atob(base64);
                var byteArrays = [];

                for (var offset = 0, len = byteChars.length; offset < len; offset += sliceSize) {
                    var slice = byteChars.slice(offset, offset + sliceSize);

                    var byteNumbers = new Array(slice.length);
                    for (var i = 0; i < slice.length; i++) {
                        byteNumbers[i] = slice.charCodeAt(i);
                    }

                    var byteArray = new Uint8Array(byteNumbers);

                    byteArrays.push(byteArray);
                }

                return new Blob(byteArrays, {type: mime});
            } catch (e) {
                console.log('blob error e');
                if(sError === true) {
                    alert('Web cam kayıt hatası, pencereyi kapatıp tekrar deneyin')
                }
                return null;
            }
        },
        getQueryStringValue : function (name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                results = regex.exec(location.search);
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        },
        escapeXmlTags : function (value) {
            if(value) {
                var escapedValue = value.replace(new RegExp('<', 'g'), '&lt');
                escapedValue = escapedValue.replace(new RegExp('>', 'g'), '&gt');
                return escapedValue;
            }
        },
        removeTrailingSlash : function (str) {
            return str.replace(/\/+$/, '');
        },
        isIOS: function () {
            return [
                    'iPad Simulator',
                    'iPhone Simulator',
                    'iPod Simulator',
                    'iPad',
                    'iPhone',
                    'iPod'
                ].includes(navigator.platform)
                // iPad on iOS 13 detection
                || (navigator.userAgent.includes("Mac") && "ontouchend" in document)
        },
        iOSversion : function () {
            let iOS = this.isIOS();
            if (iOS) { // <-- Use the one here above
                if (window.indexedDB) { return 'iOS8+'; }
                if (window.SpeechSynthesisUtterance) { return 'iOS7'; }
                if (window.webkitAudioContext) { return 'iOS6'; }
                if (window.matchMedia) { return 'iOS5'; }
                if (window.history && 'pushState' in window.history) { return 'iOS4'; }
                return 'iOS3-';
            }
            return 'iOS-';
        },
        getScrollPosition : function () {
            return {
                top: window.scrollY,
                left: window.scrollX
            };
        },
        cloneObj(obj,append=null,append_key=null) {
            let ret = {};
            let _strAp = '';
            for (const key in obj) {
                ret[key] = obj[key];
            }
            if(append !== null && append_key !== null && ret.hasOwnProperty(append_key)) {
                for (const k in append) {
                    _strAp = _strAp+"_"+append[k];
                }
                ret[append_key] = ret[append_key]+"__"+this.domIdfy(_strAp);
            }
            return ret;
        }
    };
})();


