var Util = function () {
    return {
        tr2Eng: function (str) {
            var charMap = {'Ç': 'C', 'Ö': 'O', 'Ş': 'S', 'İ': 'I', 'I': 'i', 'Ü': 'U', 'Ğ': 'G', 'ç': 'c', 'ö': 'o',
                'ş': 's', 'ı': 'i', 'ü': 'u', 'ğ': 'g'};

            str_array = str.split('');

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
        SecondsToHour: function(seconds) {
            let date = new Date(null);
            date.setSeconds(seconds);
            let timeString = date.toISOString().substr(11, 8);
            return timeString;
        },
        sleep: function (milliseconds) {
            var start = new Date().getTime();
            for (var i = 0; i < 1e7; i++) {
                if ((new Date().getTime() - start) > milliseconds){
                    break;
                }
            }
        },
        isCreditCard: function(CC) {
            if (CC.length != 16) {
                return (null);
            }

            if (CC.length > 19) {
                return (false);
            }

            sum = 0; mul = 1; l = CC.length;
            for (i = 0; i < l; i++) {
                digit = CC.substring(l-i-1,l-i);
                tproduct = parseInt(digit ,10)*mul;
                if (tproduct >= 10) {
                    sum += (tproduct % 10) + 1;
                } else {
                    sum += tproduct;
                }

                if (mul == 1) {
                    mul = mul + 1;
                } else {
                    mul = mul - 1;
                }
            }
            if ((sum % 10) == 0) {
                return (true);
            } else {
                return (false);
            }
        },
        iframeAutoHeight: function(ifrmId) {
            parent.document.getElementById(ifrmId).height = document['body'].offsetHeight;
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
        slugify: function (text) {
            text = Util.convertToASCII(text);
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-')           // Replace spaces with -
                .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                .replace(/^-+/, '')             // Trim - from start of text
                .replace(/-+$/, '');            // Trim - from end of text
        },
        domIdfy: function (text) {
            text = Util.convertToASCII(text);
            text = text.toString().toLowerCase()
                .replace(/\s+/g, '')           // Replace spaces with -
                .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                .replace(/\-\-+/g, '')         // Replace multiple - with single -
                .replace(/^-+/, '')             // Trim - from start of text
                .replace(/-+$/, '');            // Trim - from end of text
            text = text.replace(/-/g,"");
            return text;
        },
        emailFilter: function(str) {
            Util.convertToASCII(str);
            str = str.replace(/[^a-zA-Z0-9-_$.@]/g, '')
            return str;
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
        loadUrl: function(url) {
            window.location.href = url;
        },
        openNewWindow: function(url) {
            window.open(url);
        },
        askConfirmLoad: function(ask,url){
            if(confirm(ask)){
                Util.loadUrl(url);
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
        isJson: function (str) {
            var _json;
            try {
                _json = JSON.parse(str);
            } catch (e) {
                return false;
            }
            return _json;
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
        isEmpty: function(obj) {
            for(let prop in obj) {
                if(obj.hasOwnProperty(prop)) {
                    return false;
                }
            }
            return JSON.stringify(obj) === JSON.stringify({});
        },
        JSAlert: function (content,title=null) {
            let _con = content;
            console.log("jsAlert typeof content",typeof content);
            if(typeof content === "object") {
                _con = "<pre>"+JSON.stringify(content)+"</pre>";
            }
            Modal5.Get("JSAlert",title,_con,null,'medium','right')
        },
        JSNotify: function (message,type='info',position='top-right',timer=5000) {
            Util.JSToastr(message,type,position,timer);
        },
        JSToastr: function (message,type='success',position='top-right',timer=5000,onclick=null) {

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
            toastr[type](message);
        },
        TCVerify: function(tcNo) {
            tcNo = tcNo.toString();
            var isEleven = /^[0-9]{11}$/.test(tcNo);
            var totalX = 0;
            for (var i = 0; i < 10; i++) {
                totalX += Number(tcNo.substr(i, 1));
            }
            var isRuleX = totalX % 10 == tcNo.substr(10,1);
            var totalY1 = 0;
            var totalY2 = 0;
            for (var i = 0; i < 10; i+=2) {
                totalY1 += Number(tcNo.substr(i, 1));
            }
            for (var i = 1; i < 10; i+=2) {
                totalY2 += Number(tcNo.substr(i, 1));
            }
            var isRuleY = ((totalY1 * 7) - totalY2) % 10 == tcNo.substr(9,0);
            return isEleven && isRuleX && isRuleY;
        },
        IframeAutoHeight: function(iframeID) {
            var _iFrame = document.getElementById(iFrameID);
            if(_iFrame) {
                _iFrame.height = "";
                _iFrame.height = _iFrame.contentWindow.document.body.scrollHeight + "px";
            }
        },
        GenerateId : function  (len) {
            var arr = new Uint8Array((len || 40) / 2)
            window.crypto.getRandomValues(arr)
            return Array.from(arr, Util.Dec2hex).join('')
        },
        Dec2hex: function  (dec) {
            return dec.toString(16).padStart(2, "0")
        },
        GetFormData: function (formDomID) {
            let data = $('#'+formDomID).serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});
            return data;
        },
        CreateFromData: function(data) {
            let FD = new FormData();
            for(name in data) {
                FD.append(name, data[name]);
            }
            return FD;
        },
        GetIssuerKey: function (issuerPrefix,key) {
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
        RemoveElementsByClass: function (className) {
            let elements = document.getElementsByClassName(className);
            while(elements.length > 0){
                elements[0].parentNode.removeChild(elements[0]);
            }
        },
        FindElementByDataAndValue: function (dataKey,value) {
            return document.querySelectorAll("[data-"+dataKey+"='"+value+"']");
        },
        ParseJSON: function (str) {
            try {
                return JSON.parse(str);
            } catch (e) {
                return str;
            }
        },
        VatFromTotal: function (total,ratio,round=true) {
            if(total === 0) { return; }
            if(ratio === 0) { return; }
            return (!round) ? total / (1 + (ratio / 100)) : Math.round(total / (1 + (ratio / 100))).toFixed(2);
        },
        TwoWords: function (data) {
            if(data === null) { return data; }
            let name = Util.UcFirst(data);
            return name.split(' ').slice(0,2).join(' ');
        },
        ManyWords: function (data,amount) {
            if(data === null) { return data; }
            let name = Util.UcFirst(data);
            return name.split(' ').slice(0,amount).join(' ');
        },
        UcFirst: function (data) {
            if(data === null) { return data; }

            return data
                .toString()
                .toLowerCase()
                .split(' ')
                .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                .join(' ');
        },
        PrintMoney: function(value,locale='tr-TR',currency='TRY') {
            const formatter = new Intl.NumberFormat(locale, {
                style: 'currency',
                currency: currency
            })

            return formatter.format(value);
        },
        FormatPhoneNumber: function(phoneNumberString) {
            var cleaned = ('' + phoneNumberString).replace(/\D/g, '');
            var match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/);
            if (match) {
                return '(' + match[1] + ') ' + match[2] + '-' + match[3];
            }
            return null;
        },
        RemoveSelectOptions: function(selectElement) {
            var i, L = selectElement.options.length - 1;
            for(i = L; i >= 0; i--) {
                selectElement.remove(i);
            }
        },
        getDates: function (startDate, stopDate, days=1) {
            var dateArray = new Array();
            var currentDate = startDate;
            while (currentDate <= stopDate) {
                dateArray.push(new Date (currentDate));
                currentDate = currentDate.addDays(days);
            }
            return dateArray;
        },
        dump: function (arr, level) {
            var dumped_text = "";
            if (!level)
                level = 0;

            // The padding given at the beginning of the line.
            var level_padding = "";

            for (var j = 0; j < level + 1; j++)
                level_padding += "  ";

            if (typeof(arr) == 'object') { // Array/Hashes/Objects

                for (var item in arr) {

                    var value = arr[item];

                    if (typeof(value) == 'object') { // If it is an array,
                        dumped_text += level_padding + "'" + item + "' ...\n";
                        dumped_text += Util.dump(value, level + 1);
                    } else {
                        dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
                    }
                }
            } else { // Stings/Chars/Numbers etc.
                dumped_text = "===>" + arr + "<===(" + typeof(arr) + ")";
            }
            return dumped_text;
        },
        isDayOfWeek: function (strTime,dayOfWeek=0) {
            var dt = new Date(strTime);

            if(dt.getDay() === dayOfWeek)
            {
                return true;
            } else {
                return false;
            }
        },
        getDateOfWeek: function (w, y) {
            var d = (1 + (w - 1) * 7); // 1st of January + 7 days for each week
            return new Date(y, 0, d);
        },
        getMondayOfCurrentWeek: function (d) {
            var day = d.getDay();
            return new Date(d.getFullYear(), d.getMonth(), d.getDate() + (day == 0?-6:1)-day );
        },
        getSundayOfCurrentWeek: function (d) {
            var day = d.getDay();
            return new Date(d.getFullYear(), d.getMonth(), d.getDate() + (day == 0?0:7)-day );
        },
        getAvailableHeight: function (topBarId) {
                var top_nav_height = $("#"+topBarId).height();
                var window_height = $(window).height();

                var height_of_open_space = window_height - (top_nav_height);
                return height_of_open_space;
        },
        getWeekNumber: function (d) {
            // Copy date so don't modify original
            d = new Date(Date.UTC(d.getFullYear(), d.getMonth(), d.getDate()));
            // Set to nearest Thursday: current date + 4 - current day number
            // Make Sunday's day number 7
            d.setUTCDate(d.getUTCDate() + 4 - (d.getUTCDay()||7));
            // Get first day of year
            var yearStart = new Date(Date.UTC(d.getUTCFullYear(),0,1));
            // Calculate full weeks to nearest Thursday
            var weekNo = Math.ceil(( ( (d - yearStart) / 86400000) + 1)/7);
            // Return array of year and week number
            return [d.getUTCFullYear(), weekNo];
        },
        Js2Str: function (obj) {
            return window.btoa(unescape(encodeURIComponent(JSON.stringify(obj))));
        },
        Str2Js: function (encoded) {
            if(typeof encoded !== "undefined" && encoded.length > 0) {
                return JSON.parse(decodeURIComponent(escape(window.atob(encoded))));
            }
        },
        BootstrapDetectBreakpoint : function () {
            /**
             * Author and copyright: Stefan Haack (https://shaack.com)
             * Repository: https://github.com/shaack/bootstrap-detect-breakpoint
             * License: MIT, see file 'LICENSE'
             */
            // cache some values on first call
            if (!this.breakpointValues) {
                this.breakpointNames = ["xxl", "xl", "lg", "md", "sm", "xs"]
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
        FocusNextTabIndex : function (currentIndex,tabClass="tabable",lastTabIndex=10) {
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
        Base64ToBlob : function (base64, mime,sError=false) {
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
                console.log("blob error e");
                if(sError === true) {
                    alert("Web cam kayıt hatası, pencereyi kapatıp tekrar deneyin")
                }
                return null;
            }
        },
        GetQueryStringValue : function (name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                results = regex.exec(location.search);
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        },
        EscapeXmlTags : function (value) {
            if(value) {
                var escapedValue = value.replace(new RegExp('<', 'g'), '&lt');
                escapedValue = escapedValue.replace(new RegExp('>', 'g'), '&gt');
                return escapedValue;
            }
        },
        IsResponseValid: function (resp) {
            if(!resp.hasOwnProperty('state')) {
                console.error("Response mismatch",resp)
                return false;
            }
            if(resp.state === 'failure') {
                console.error("Response_Failure",resp.message)
                Util.JSAlert(resp.message.toString(),"Cevap hatası");
                return false;
            }
            if(resp.state !== 'success') {
                Util.JSAlert(resp.message.toString(),"Bilinmeyen cevap");
                return false;
            }
            if(!resp.hasOwnProperty('payload')) {
                console.error("Response has no payload",resp)
                return false;
            }
            if(resp['payload'].hasOwnProperty('xheaders')) {
                console.log("xheaders var");
                if(resp['payload']['xheaders'].hasOwnProperty('X-Requested-With')) {
                    glb.env.xHeaders['X-Requested-With'] = resp['payload']['xheaders']['X-Requested-With'];
                }
                if(resp['payload']['xheaders'].hasOwnProperty('tamga')) {
                    glb.env.xHeaders['tamga'] = resp['payload']['xheaders']['tamga'];
                }
                if(resp['payload']['xheaders'].hasOwnProperty('employer')) {
                    glb.env.xHeaders['employer'] = resp['payload']['xheaders']['employer'];
                }
                if(resp['payload']['xheaders'].hasOwnProperty('bsv')) {
                    glb.env.xHeaders['bsv'] = resp['payload']['xheaders']['bsv'];
                }
                delete(resp['payload']['xheaders']);
            }
            return resp;
        },
        removeTrailingSlash : function (str) {
            return str.replace(/\/+$/, '');
        },
        IsIOS: function () {
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
            let iOS = Util.IsIOS();
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
        DateGetYearStartAndEndUnixTimestamps : function (year) {
            // Create date objects for the start and end of the given year
            const firstDayOfYear = new Date(year, 0, 1); // January 1st
            const lastDayOfYear = new Date(year + 1, 0, 0); // December 31st (end of year)

            // Set times to the first minute of the start day (00:00:00) and last minute of the last day (23:59:59)
            const yearStart = new Date(year, 0, 1, 0, 0, 0);
            const yearEnd = new Date(year, 11, 31, 23, 59, 59);

            // Convert to Unix timestamps (seconds since epoch)
            const yearStartUnixTimestamp = Math.floor(yearStart.getTime() / 1000);
            const yearEndUnixTimestamp = Math.floor(yearEnd.getTime() / 1000);

            return {
                dateStart: yearStartUnixTimestamp,
                dateEnd: yearEndUnixTimestamp
            };
        },
        DateGetQuarterStartAndEndDates : function (now,manuplate=0) {
            var quarter = 0;
            if(manuplate !== 0) {
                quarter = Math.floor((now.getMonth() / 3))+manuplate;
            } else {
                quarter = Math.floor((now.getMonth() / 3));
            }

            const firstDay = new Date(now.getFullYear(), quarter * 3, 1);
            const lastDay = new Date(firstDay.getFullYear(), firstDay.getMonth() + 3, 0);

            const quarterStart = new Date(firstDay.getFullYear(), firstDay.getMonth(), firstDay.getDate(), 0, 0, 0);
            const quarterEnd = new Date(lastDay.getFullYear(), lastDay.getMonth(), lastDay.getDate(), 23, 59, 59);

            return {
                dateStart: Math.floor(quarterStart.getTime() / 1000),
                dateEnd: Math.floor(quarterEnd.getTime() / 1000)
            };
        },
        DateGetUnixTimestamps: function (dateInput) {
            const date = new Date(dateInput);

            // Set start of the day (hours, minutes, seconds, and milliseconds to 0)
            const startOfDay = new Date(date);
            startOfDay.setHours(0, 0, 0, 0);

            // Set end of the day (hours to 23, minutes to 59, seconds to 59, milliseconds to 999)
            const endOfDay = new Date(date);
            endOfDay.setHours(23, 59, 59, 999);

            return {
                dateStart: Math.floor(startOfDay.getTime() / 1000),
                dateEnd: Math.floor(endOfDay.getTime() / 1000)
            };
        },
        DateGetWeekStartAndEndTimestamps : function (weekInput) {
            if (!weekInput) {
                alert("Lütfen bir hafta belirtin");
                console.log("Please select a week.");
                return;
            }

            const [year, week] = weekInput.split('-W');
            const firstDayOfYear = new Date(Date.UTC(year, 0, 1));
            const daysOffset = (firstDayOfYear.getUTCDay() <= 4 ? 1 : 8) - firstDayOfYear.getUTCDay();
            const firstThursday = new Date(Date.UTC(year, 0, 1 + daysOffset));

            const weekStart = new Date(firstThursday);
            weekStart.setUTCDate(firstThursday.getUTCDate() - firstThursday.getUTCDay() + 1 + (week - 1) * 7);
            weekStart.setUTCHours(0, 0, 0, 0);

            const weekEnd = new Date(weekStart);
            weekEnd.setUTCDate(weekStart.getUTCDate() + 6);
            weekEnd.setUTCHours(23, 59, 59, 999);

            const startTimestamp = Math.floor(weekStart.getTime() / 1000);
            const endTimestamp = Math.floor(weekEnd.getTime() / 1000);

            return {
                dateStart: startTimestamp,
                dateEnd: endTimestamp
            };
        },
        DateGetMonthStartAndEndTimestamps : function (monthInput) {
            if (!monthInput) {
                alert("Lütfen bir ay belirtin");
                console.log("Please select a month.");
                return;
            }

            let startDate = new Date(monthInput);
            startDate.setDate(1);
            startDate.setHours(0, 0, 0, 0);

            // Create a Date object for the last day of the month
            let endDate = new Date(startDate);
            endDate.setMonth(endDate.getMonth() + 1);
            endDate.setDate(0);
            endDate.setHours(23, 59, 59, 999);

            // Convert to Unix timestamps
            let startTimestamp = Math.floor(startDate.getTime() / 1000);
            let endTimestamp = Math.floor(endDate.getTime() / 1000);

            return {
                dateStart: startTimestamp,
                dateEnd: endTimestamp
            };
        },
        DateFormatMonthDate : function (date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed
            return `${year}-${month}`;
        },
        DateGetWeekNumber : function (date) {
            const startOfYear = new Date(date.getFullYear(), 0, 0);
            const diff = (date - startOfYear) + ((startOfYear.getTimezoneOffset() - date.getTimezoneOffset()) * 60 * 1000);
            const oneWeek = 604800000; // milliseconds in a week
            var weekNumber = Math.floor(diff / oneWeek);
            if(manuplate !== 0) {
                weekNumber = weekNumber + manuplate;
            }
            return weekNumber;
        },
        CloneObj(obj,append=null,append_key=null) {
            let ret = {};
            let _strAp = '';
            for (const key in obj) {
                ret[key] = obj[key];
            }
            if(append !== null && append_key !== null && ret.hasOwnProperty(append_key)) {
                for (const k in append) {
                    _strAp = _strAp+"_"+append[k];
                }
                ret[append_key] = ret[append_key]+"__"+Util.domIdfy(_strAp);
            }
            return ret;
        },

    };
}();


function empty( val ) {

    // test results
    //---------------
    // []        true, empty array
    // {}        true, empty object
    // null      true
    // undefined true
    // ""        true, empty string
    // ''        true, empty string
    // 0         false, number
    // true      false, boolean
    // false     false, boolean
    // Date      false
    // function  false

    if (val === undefined) {
        return true;
    }

    if (typeof (val) == 'function' || typeof (val) == 'number' || typeof (val) == 'boolean' || Object.prototype.toString.call(val) === '[object Date]') {
        return false;
    }

    if (val == null || val.length === 0){
        return true;
    } // null or 0 length array


    if (typeof (val) == "object") {
        // empty object

        var r = true;

        for (var f in val)
            r = false;

        return r;
    }

    return false;
}

function isObject(val) {
    if (val === null) { return false;}
    return ( (typeof val === 'function') || (typeof val === 'object') );
}

Date.prototype.addDays = function(days) {
    var date = new Date(this.valueOf());
    date.setDate(date.getDate() + days);
    return date;
}

Date.prototype.yyyymmdd = function(separator='') {
    var mm = this.getMonth() + 1; // getMonth() is zero-based
    var dd = this.getDate();

    return [this.getFullYear(),
        (mm>9 ? '' : '0') + mm,
        (dd>9 ? '' : '0') + dd
    ].join(separator);
};


// See LICENSE for usage information

// The following lines allow the ping function to be loaded via commonjs, AMD,
// and script tags, directly into window globals.
// Thanks to https://github.com/umdjs/umd/blob/master/templates/returnExports.js
(function (root, factory) { if (typeof define === 'function' && define.amd) { define([], factory); } else if (typeof module === 'object' && module.exports) { module.exports = factory(); } else { root.ping = factory(); }
}(this, function () {

    /**
     * Creates and loads an image element by url.
     * @param  {String} url
     * @return {Promise} promise that resolves to an image element or
     *                   fails to an Error.
     */
    function request_image(url) {
        return new Promise(function(resolve, reject) {
            var img = new Image();
            img.onload = function() { resolve(img); };
            img.onerror = function() { reject(url); };
            img.src = url + '?random-no-cache=' + Math.floor((1 + Math.random()) * 0x10000).toString(16);
        });
    }

    /**
     * Pings a url.
     * @param  {String} url
     * @param  {Number} multiplier - optional, factor to adjust the ping by.  0.3 works well for HTTP servers.
     * @return {Promise} promise that resolves to a ping (ms, float).
     */
    function ping(url, multiplier) {
        return new Promise(function(resolve, reject) {
            var start = (new Date()).getTime();
            var response = function() {
                var delta = ((new Date()).getTime() - start);
                delta *= (multiplier || 1);
                resolve(delta);
            };
            request_image(url).then(response).catch(response);

            // Set a timeout for max-pings, 5s.
            setTimeout(function() { reject(Error('Timeout')); }, 5000);
        });
    }

    return ping;
}));


const isElementLoaded = async selector => {
    while ( document.querySelector(selector) === null) {
        await new Promise( resolve =>  requestAnimationFrame(resolve) )
    }
    return document.querySelector(selector);
};
