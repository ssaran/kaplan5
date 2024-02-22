"use strict";
/*jshint esversion: 6 */

const glb = {};
glb.ParseCallback = function (obj,path) {
    let path_ = path.split(".");
    if(path_[0] !== "glb") {
        return false;
    }
    for (var i=0, path=path.split('.'), len=path.length; i<len; i++){
        obj = obj[path[i]];
    };
    return obj;
};

glb.env = {};
glb.env.isInIFrame = (window.location !== window.parent.location);
glb.env.protocol = ("https:" === document.location.protocol) ? "https://" : "http://";
glb.env.referrer = document.referrer;
glb.env.loc = document.location;
glb.env.iOS = (!!navigator.userAgent.match(/(iPad|iPhone|iPod)/g));
glb.env.ua = navigator.userAgent.toLowerCase();
glb.env.isAndroid = glb.env.ua.indexOf("android") > -1; //&& ua.indexOf("mobile");
glb.env.isIEMobile = false;
glb.env.bsv = 4;
glb.env.xHeaders = {};
if(navigator.userAgent.match(/iemobile/i)) {
    glb.env.isIEMobile = true;
}
glb.env.isMobile = false;
glb.env.lastScrollTop = 0;
glb.sound = {};
glb.sound.notify = {};
//glb.sound.notify.message =  new Audio('/static/audio/notification_message.mp3');
glb.state = {};
glb.util = {};
glb.CBacks = {};
glb.Lang = [];
glb.Handson = {};
glb.Ncn = {};
glb.Ncn.Behalf = {};
glb.Ncn.Account = {};
glb.Ncn.Ulak = {};
glb.Ncn.Vici = {};
glb.Ncn.Report = {};
glb.Ncn.Hcc = {};
glb.Ncn.Hysana = {};
glb.Tunca = {};
glb.Modules = {};
glb.Events = {};
glb.Multitabs = '';



window.mobilecheck = function() {
    var check = false;
    (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
    return check;
};

if(glb.env.iOS === true || glb.env.isAndroid === true || glb.env.isIEMobile === true) {
    glb.env.isMobile = true;
}
glb.date = {};
glb.date.obj = new Date();
glb.date.obj.toLocaleString("tr-TR", {timeZone: "Europe/Istanbul"});

/** Landing */
history.scrollRestoration = 'manual';
history.pushState({'call':'landing', 'url':window.location.href, 'data':{}, 'type':'GET', 'options':{},'requestHistory':null, 'callback':null, 'dataType':null, 'scrollToTop':null,}, '', window.location.href);

var Main = function () { return {
    _urlChangeCallbacks : {},
    BufferBlocked : {},
    getWhp: function(wHeight,percent) {
        return Math.round((wHeight / 100) * percent);
    },
    getWwp: function(wWidth,percent) {
        return Math.round((wWidth / 100) * percent);
    },
    toTop: function() {
        $('html, body').animate({scrollTop: 0}, 700);
    },
    resetForm: function(idForm) {
        if(!$("#"+idForm).length) { console.error("Form not found ",idForm); return false; }
        $("#"+idForm).data("submitted",2);
    },
    deferredAjax: function(requests,callbackDone) {
        const def = $.Deferred();
        $.when.apply($,requests).done(function () {
            def.resolve(arguments);
        })
            .fail(function() {
                    console.info(arguments);
                    def.reject(arguments);
                }
            );
        return def.promise();
    },
    xjCall: function(url,type,fields,options){
        if(typeof url === "undefined") {
            console.error("xjCall undefined url",url,type,fields,options);
            return;
        }
        $(".xhr-remove").remove();
        let _rHeaders = Util.CloneObj(glb.env.xHeaders);
        if(glb.env.hasOwnProperty('tmpHeaders') && glb.env.tmpHeaders !== null) {
            _rHeaders = Util.CloneObj(glb.env.tmpHeaders);
            glb.env.tmpHeaders = null;
        }
        if(options.hasOwnProperty('headers')) {
            Object.assign(_rHeaders, options.headers);
        }

        $.ajax({
            headers: _rHeaders, type: type, method: type, url: url, dataType: 'text', data: fields
        }).done(function(_resp) {
            if(!_resp) {
                console.error("Empty Ajax Request");
                return false;
            }
            let resp = Util.ParseJSON(_resp);
            if(typeof resp !== "object") {
                Util.JSAlert(resp,"Hatalı Cevap");
                return false;
            }
            observeUrlChange();
            if(options.hasOwnProperty('requestHistory') && options.requestHistory !== null) {
                let __data = JSON.stringify(fields);
                let _yada = {'call':'xjCall', 'url':url, 'data':__data, 'type':type, 'options': options, 'dataType':'json'};
                history.pushState(_yada, '', url);
                if(Main.hasOwnProperty('_urlChangeCallbacks')) {
                    for (let key in Main._urlChangeCallbacks) {
                        let _cbFunc = Main._urlChangeCallbacks[key];
                        if(typeof _cbFunc === "function") {
                            _cbFunc({'url':url, 'type':type, 'fields':fields, 'options':options});
                        }
                    }
                }
            }
            if(resp[Object.keys(resp)[0]] !== null && resp[Object.keys(resp)[0]].hasOwnProperty('DomID') && resp[Object.keys(resp)[0]].hasOwnProperty('Type') ) {
                Ui.process(resp,options);
            } else {
                if (options.hasOwnProperty('callback') && typeof options.callback === "function") {
                    options.callback(resp);
                } else {
                    console.info("xjCall Callback",typeof options.callback,options.callback);
                }
            }
        })
        .fail(function(resp) {
            if(!resp.hasOwnProperty('status')) {
                Modal5.Error("Tanımlanmamış hata mesajı.","Hatalı Cevap");
                return false;
            }
            switch (resp.status) {
                case 400: Modal5.Error("Sistemimize yaptığınız istekte bir sorun var.","400 Hatalı istek.");break;
                case 401: Modal5.Error("Sistemimize yaptığınız istek için gecerli erişim yetkiniz yok.","401 Yetkisiz erişim.");break;
                case 402: Modal5.Error("Sistemimize yaptığınız istek için gecerli erişim yetkiniz yok.","402 Yetkisiz erişim!!!.");break;
                case 403: Modal5.Error("","403 Girilmez");break;
                case 404: Modal5.Error("Erişmek istediğiniz sayfa bulunamadı","404 Sayfa yok");break;
                case 405: Modal5.Error("İstek metodu uygunsuz.","405");break;
                case 406: Modal5.Error("Yapılan istek kabul edilebilir değil.","406");break;
                case 407: Modal5.Error("Bu kaynağa erişmek için vekil üzerinden yetkilendirilmelisiniz.","407 Yetkisiz vekil erişimi");break;
                case 408: Modal5.Error("Sunucu vaktinde cevap vermiyor.","408 Zaman aşımı");break;
                case 409: case 410: case 411: case 412: Modal5.Error(resp.status+" hatası",""+resp.status);break;
                case 413: Modal5.Error("Yüklenmeye çalışan veri, sunucunun kabul edebileceğinden fazla.","413 Çok büyük paket",);break;
                case 414: Modal5.Error("İstek yapılan adres bilgisi çok uzun.","414 Çok uzun adres");break;
                case 415: case 416: case 417: case 418: case 421: case 422: case 423: Modal5.Error(resp.status+" hatası",""+resp.status);break;
                case 424: case 425:  Modal5.Error(resp.status+" hatası",""+resp.status);break;
                case 426: Modal5.Error("Sunucu bu bağlantıyı devam ettirmek için güncelleme yapıyor.","426 Güncelleme şart");break;
                case 429: Modal5.Error("Sunucu çok kısa süre içinde yapılan çok fazla isteği yerine getirmeyi kabul etmiyor.","429 Çok Fazla İstek");break;
                case 431: Modal5.Error("","431 İstek başlıkları çok büyük");break;
                case 451: Modal5.Error("Yasal zorunlulukar nedeni ile sunucu bu isteğe yanıt vermiyor","451");break;

                case 500: Modal5.Error("Amanın !, sunucuda bir şeyler bozuldu.","500");break;
                case 501: Modal5.Error("Hayır !, bu isteğe cevap verebilecek bir uygulama yok.","501");break;
                case 502: Modal5.Error("Nizamiye de sorun var...","502");break;
                case 503: Modal5.Error("Necefli marşapa","503 Hizmet verilemiyor");break;
                case 504: Modal5.Error("Nizamiye yoğun.","504 ");break;
                case 505: Modal5.Error("Bu istek sürümü desteklenmiyor. Çok eski bir cihazdan erişmeye çalışıyor olabilirsiniz.","505 ");break;
                case 506: Modal5.Error("Sunucu ayar hatası.","506 ");break;
                case 507: case 508: case 510: case 511: Modal5.Error(resp.status+" hatası",""+resp.status);break;


            }
            console.error("xjCall Fail");
            console.info("resp",resp);
            let _sResp = JSON.stringify(resp);
        })
        .always(function() {
            setTimeout(function () { $(".alert-dismissible").hide(); $('.navbar-ajax-indicator').css('color', 'black');},50);
            if(options.hasOwnProperty('scrollToTop') && options.scrollToTop !== null) {
                window.scrollTo({
                    top: 0,
                    left: 0,
                    behavior: "instant",
                });
            }
            if(glb.CBacks.hasOwnProperty('xjCall')) {
                glb.CBacks.xjCall();
            }
            if(window.hasOwnProperty('ga')) {
                ga('send', {
                    hitType: 'xjhref',
                    eventCategory: 'pageview',
                    eventAction: 'xjload'

                });
            }
        });
    },
    submitForm: function (oForm,formID) {
        if(glb.state.hasOwnProperty(formID)) {
            if(glb.state.hasOwnProperty(formID) && glb.state[formID] === "destroy") {
                Main.SetFormFate(formID,"delete");
                return false;
            }
            setTimeout(function () {
                console.info("form state wait",formID);
                Main.SetFormFate(formID,'delete');
                Main.submitForm(oForm,formID);
            },50);
            return false;
        }

        if(!XHref.formHasUnvalidated(formID)) { return false; }

        if(!$('#'+formID)[0].checkValidity()) {
            $('#'+formID).find(':submit').click();
        } else {
            let _formData = Util.GetFormData(formID);

            let _req = XHref.initRequest(oForm);
            _req.url = oForm.action;
            _req.type = oForm.method;
            for(let p in _formData) {
                if(_formData.hasOwnProperty(p)) {
                    _req.fields[p] = _formData[p];
                }
            }

            Main.xjCall(_req.url,_req.type,_req.fields,_req.options);
        }
    },
    SetFormState: function (formId,elementId,state) {
        if(!glb.state.hasOwnProperty(formId)) {
            glb.state[formId] = {};
        }
        if(glb.state[formId] === 'destroy') {
            return;
        }

        if(state === "destroy") {
            if(glb.state[formId].hasOwnProperty(elementId)) {
                delete glb.state[formId][elementId];
            }
        } else {
            glb.state[formId][elementId] = state;
        }
    },
    SetFormFate: function (formId,fate) {
        if(fate === "destroy") {
            glb.state[formId] = "destroy";
            return;
        }

        let toDelete = true;
        if(glb.state.hasOwnProperty(formId)) {
            for(var prop in glb.state[formId]) {
                (glb.state[formId].hasOwnProperty(prop)) ? toDelete = false : '';
            }
        }
        if(toDelete){ delete glb.state[formId]; }
    },
    ParsePayload: function (resp) {
        if(!resp) {
            console.error("empty response");
            console.log(resp,"------------------------------------");
            return false;
        }
        if(!resp.hasOwnProperty('state')) {
            console.error("Response mismatch");
            console.log(resp,"------------------------------------");
            return false;
        }
        if(!resp.hasOwnProperty('payload')) {
            console.error("Response has no payload");
            console.log(resp,"------------------------------------");
            return false;
        }
        return resp;
    },
    getIfSrc: async function (url,iframeId) {
        let headers = {};
        headers['tamga'] = glb.env.xHeaders['tamga'];
        headers['employer'] = glb.env.xHeaders['employer'];
        headers['bsv'] = glb.env.xHeaders['bsv'];
        headers['is_iframe'] = 1;

        const res = await fetch(url, {
            method: 'GET',
            headers: headers
        });
        const blob = await res.blob();
        const urlObject = URL.createObjectURL(blob);
        document.getElementById(iframeId).setAttribute("src", urlObject);
    }
};
}();

const XHref = function () { return {
    isConfirmed: function(_elm) {
        if(!_elm.dataset.hasOwnProperty("question")) { // no question so it auto confirmed
            return true;
        }
        if(window.confirm(_elm.dataset.question)){
            return true;
        }
        return false;
    },
    initRequest : function (_elm) {
        let _req = {};
        _req.fields = {};
        _req.options = {};
        _req.options.headers = {};

        if(_elm.dataset.hasOwnProperty("domdestination")) { _req.options.headers['Dom-Destination'] = _elm.dataset.domdestination; }
        if(_elm.dataset.hasOwnProperty("isdata")) { _req.options.headers['Is-Data'] = _elm.dataset.isdata; }
        if(_elm.dataset.hasOwnProperty("iscommon")) { _req.options.headers['Is-Common'] = _elm.dataset.iscommon; }
        if(_elm.dataset.hasOwnProperty("ismodal")) { _req.options.headers['Is-Modal'] = _elm.dataset.ismodal; }
        if(_elm.dataset.hasOwnProperty("actualtabid")) { _req.options.headers['Actual-Tab-Id'] = _elm.dataset.actualtabid; }
        if(_elm.dataset.hasOwnProperty("iscomponent")) { _req.options.headers['Is-Component'] = _elm.dataset.iscomponent; }
        if(_elm.dataset.hasOwnProperty("employer")) { _req.options.headers['Employer'] = _elm.dataset.employer; }

        if(_elm.dataset.hasOwnProperty('append')) {
            let _params = JSON.parse(_elm.dataset.append);
            for (const key in _params) {
                if (_params.hasOwnProperty(key)) {
                    _req.fields[key] = _params[key];
                }
            }
            if(_req.fields.hasOwnProperty('Is-Modal')) {
                _req.options.headers['Is-Modal'] = _req.fields['Is-Modal'];
                delete(_req.fields['Is-Modal']);
            }
            if(_req.fields.hasOwnProperty('Dom-Destination')) {
                _req.options.headers['Dom-Destination'] = _req.fields['Dom-Destination'];
                delete(_req.fields['Dom-Destination']);
            }
            if(_req.fields.hasOwnProperty('Is-Common')) {
                _req.options.headers['Is-Common'] = _req.fields['Is-Common'];
                delete(_req.fields['Is-Common']);
            }
            if(_req.fields.hasOwnProperty('Is-Data')) {
                _req.options.headers['Is-Data'] = _req.fields['Is-Data'];
                delete(_req.fields['Is-Data']);
            }
            if(_req.fields.hasOwnProperty('Actual-Tab-Id')) {
                _req.options.headers['Actual-Tab-Id'] = _req.fields['Actual-Tab-Id'];
                delete(_req.fields['Actual-Tab-Id']);
            }
            if(_req.fields.hasOwnProperty('Is-Component')) {
                _req.options.headers['Is-Component'] = _req.fields['Is-Component'];
                delete(_req.fields['Is-Component']);
            }
            if(_req.fields.hasOwnProperty('Employer')) {
                _req.options.headers['Employer'] = _req.fields['Employer'];
                delete(_req.fields['Employer']);
            }
        }

        _req.url = (_elm.tagName === 'A') ? _elm.href : _elm.dataset.href;
        _req.url = (_elm.dataset.hasOwnProperty('url')) ? _elm.dataset.url : _req.url; // Override for tabs etc
        _req.type = (_elm.dataset.hasOwnProperty('type')) ? _elm.dataset.type : "GET";

        if(_elm.dataset.hasOwnProperty('scrolltotop')) {
            _req.options.scrollToTop = 'yes';
        } else {
            _req.options.scrollToTop = null;
        }

        _req.options.callback = null;

        if(_elm.dataset.hasOwnProperty('backhandler')) {
            if(window.hasOwnProperty(_elm.dataset.backhandler)) {
                _req.options.callback = window[_elm.dataset.backhandler]();
            }  else {
                console.error("Callback not found ",_elm.dataset.backhandler);
            }
        }
        return _req;
    },
    appendData: function(_elm,_data) {
        if(!_elm.dataset.hasOwnProperty("append")) {
            return _data;
        }
        let _params = JSON.parse(_elm.dataset.append);
        for(var p in _params) {
            _data[p] = _params[p];
        }
        return _data;
    },
    fieldUnique: function (_elm,formId) {
        let _minLength = (_elm.minLength.hasOwnProperty("minlength")) ? _elm.minLength.hasOwnProperty("minlength") : 3;
        let _maxLength = (_elm.maxLength.hasOwnProperty("maxlength")) ? _elm.maxLength.hasOwnProperty("maxlength") : 30;
        if(_elm.value.length < _minLength) {
            return false;
        }

        if(_elm.value.length > _maxLength) {
            Util.JSNotify("Value too long","error");
            return false;
        }

        if(_elm.dataset.question) {
            let _check = false;
            if(confirm(_elm.dataset.question)) { _check = true; }
            if(!_check) { return false;}
        }

        let _req = {};
        _req.url = _elm.dataset.href;
        _req.data = XHref.appendData(_elm,{});
        _req.data[_elm.name] = _elm.value;
        _req.data['form_element_id'] = _elm.id;

        _req.type = (_elm.dataset.hasOwnProperty('type')) ? _elm.dataset.type : "POST";
        _req.history = (_elm.dataset.hasOwnProperty('nohistory')) ? _elm.dataset.nohistory : 2;
        _req.callback = (_elm.dataset.hasOwnProperty('backhandler')) ? window[_elm.dataset.backhandler]() : null;
        return _req;
    },
    formCheckUnique: function (_elm,formID) {
        let elements = _elm.elements;
        let ret = true;
        for (let i = 0, element; element = elements[i++];) {
            if(element.classList.contains("xhr-unique")) {
                var _req = XHref.fieldUnique(element);
                if(_req !== false) {
                    _req.data['form_id'] = formID;
                    Main.SetFormState(_req.data['form_id'],_req.data['form_element_id'],"wait");
                    Main.xjCall(_req.url,_req.type,_req.data,2,_req.callback);
                    ret = false;
                }
            }
        }
        return ret;
    },
    formGetUnvalidated: function (domId) {
        let _r = {};
        let _i = 0;
        let _elm = document.getElementById(domId);
        if(_elm.dataset.hasOwnProperty("unvalidated")) {
            let _uv = Util.ParseJSON(_elm.dataset.unvalidated);
            for(var p in _uv) {
                if(_uv.hasOwnProperty(p)) {
                    var _c = _uv[p];
                    if(_c !== null &&  _c !== "null" && _c.length > 0) {
                        _r[p] = _c;
                        _i++;
                    }
                }
            }
        }
        return _r;
    },
    formSetUnvalidated: function (domId,uv) {
        document.getElementById(domId).dataset.unvalidated = JSON.stringify(uv);
    },
    formHasUnvalidated: function (formID) {
        let oForm = document.getElementById(formID);
        if (oForm.dataset.hasOwnProperty("unvalidated")) {
            let _message = '';
            let _uv = XHref.formGetUnvalidated(formID);
            for (var msg in _uv) {
                _message = (_uv.hasOwnProperty(msg)) ? _message+_uv[msg]+"<br>" : _message+'';
            }

            if(_message.length > 0) {
                Util.JSAlert(formID+"_unvalidate_alert","HATA",_message);
                return false;
            }
        }
        return true;
    }
};
}();


$(document).off("submit",".xhr-form");
$(document).on("submit", ".xhr-form", function (ev) {
    ev.preventDefault();
    let formID = $(this).attr("id");
    let oForm = document.getElementById(formID);

    if(oForm.dataset.hasOwnProperty("single") && oForm.dataset.single === 1) {
        if (oForm.dataset.hasOwnProperty("submitted") && oForm.dataset.submitted === 1) {
            Util.JSAlert("Bu form birden fazla aynı gönderime kapalıdır. Lütfen formu yenileyin.","","warning");
            return false;
        } else {
            oForm.dataset.submitted = 1;
        }
    }
    XHref.formCheckUnique(oForm,formID);
    Main.submitForm(oForm,formID);
    return false;
});

$(window).scroll(function() {
    ( $(window).scrollTop() > 300 ) ? $('a.back-to-top').fadeIn('slow') : $('a.back-to-top').fadeOut('slow');
});

$(document).ajaxStart(function() {
    /*
    var over = '<div id="ajaxoverlay"><img id="loading" src="http://bit.ly/pMtW1K"></div>';
    $(over).appendTo('body');*/
});

$(document).ajaxStop(function() {
    //$('#ajaxoverlay').remove();
});

Array.from(document.getElementsByClassName("back-to-top")).forEach(function(_elm) {
    _elm.addEventListener("click", function(ev){
        ev.preventDefault();
        Main.toTop();
    });
});


glb.util.AvailableHeight = function() {
    let aHeight = Util.getAvailableHeight("top_nav_bar");
    let rem  = parseInt(getComputedStyle(document.documentElement).fontSize);
    rem = rem * 2.5;
    aHeight = (aHeight - rem);
    return aHeight;
};

glb.util.OverlayIframeOpen = function(iframeID,iframeSrc,aHeight,callback=null) {
    //glb.util.MinimizeLayout();
    //let aHeight = glb.util.AvailableHeight();
    $("#layout_overlay").css({height:aHeight+'px',display:"block"});
    let iframeElm = Tpl.Node('iframe',false,{
        id:iframeID,
        'src':iframeSrc,
        'class':'p-0',
        'frameBorder':'0',
        'width':'100%',
        'height':'100%'
    });

    /*var overlay = document.getElementById('layout_overlay');
    overlay.innerHTML = "";*/
    $('#layout_overlay').html('');

    if (typeof callback === "function") {
        $('#layout_overlay').append(iframeElm).promise().done(function () {
            callback();
        });
    } else {
        $('#layout_overlay').append(iframeElm);
    }
    return;
};

glb.util.OverlayIframeClose = function () {
    let overlay = document.getElementById('layout_overlay');
    if(overlay) {
        overlay.innerHTML = "";
        overlay.style.display = "none";
        glb.util.RestoreLayout();
    }
};

window.addEventListener('popstate', function(popStateEvent) {
    if(popStateEvent.state !== null && popStateEvent.state.hasOwnProperty('call')) {
        switch (popStateEvent.state.call) {
            case "xjCall":
                if(popStateEvent.state.options.hasOwnProperty('requestHistory')) {
                    delete(popStateEvent.state.options['requestHistory']);
                }
                let _fields = JSON.parse(popStateEvent.state.data);
                Main.xjCall(popStateEvent.state.url,popStateEvent.state.type,_fields,popStateEvent.state.options);
                break;
            case "landing":
                window.location.href = popStateEvent.state.url;
                break;
            case null:
                console.info("Case NUll");
                break;
        }
    } else {
        console.info("Return to index",popStateEvent);
    }
});

const observeUrlChange = () => {
    let oldHref = document.location.href;
    const body = document.querySelector("body");
    const observer = new MutationObserver(mutations => {
        if (oldHref !== document.location.href) {
            oldHref = document.location.href;
            window.dispatchEvent(new Event('locationchange'));
        }
    });
    observer.observe(body, { childList: true, subtree: true });
};

window.onload = observeUrlChange;
