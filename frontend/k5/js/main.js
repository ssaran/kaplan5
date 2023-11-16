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
glb.sound = {};
glb.sound.notify = {};
//glb.sound.notify.message =  new Audio('/static/audio/notification_message.mp3');
glb.state = {};
glb.util = {};
glb.Backs = {};
glb.Lang = [];
glb.Handson = {};
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

glb.Ncn = {};
glb.Ncn.Behalf = {};
glb.Ncn.Account = {};
glb.Ncn.Ulak = {};
glb.Ncn.Vici = {};
glb.Ncn.Report = {};
glb.Ncn.Hcc = {};
glb.Ncn.Hysana = {};
glb.Tunca = {};
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

//--- Put Landing State
history.pushState({call:'landing',url:window.location.href,data:{},type:'GET',requestHistory:null,callback:null,dataType:null}, null, window.location.href);

var Main = function () { return {
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
    xhrCall: function(url,type,dataType,data,urlHistory="2",callBack=null){
        if(typeof url === "undefined") {
            console.error("xhr url",url,type,dataType,data,urlHistory,callBack);
            return;
        }

        $(".xhr-remove").remove();

        let _rHeaders = Util.CloneObj(glb.env.xHeaders);
        if(glb.env.hasOwnProperty('tmpHeaders') && glb.env.tmpHeaders !== null) {
            _rHeaders = Util.CloneObj(glb.env.tmpHeaders);
            glb.env.tmpHeaders = null;
        }

        $.ajax({
            headers: _rHeaders,
            type: type, method: type, url: url, dataType: 'json', data: data,
        })
        .done(function(resp) {
            if(!resp) {
                console.error("Empty Ajax Request"); return false;
            }
            if(typeof resp !== "object") {
                Util.JSAlert("response_error","Hatalı Cevap");
                console.log(resp);
                return false;
            }
            if(resp[Object.keys(resp)[0]] !== null && resp[Object.keys(resp)[0]].hasOwnProperty('DomID') && resp[Object.keys(resp)[0]].hasOwnProperty('Type') ) {
                Ui.process(resp,callBack);
            } else {
                if (typeof callBack === "function") {
                    callBack(resp);
                    return;
                } else {
                    console.info("xhrCall_callback",typeof callBack,callBack);
                }
            }
        })
        .fail(function(resp) {
            console.log("xhrcall Fail",url,type,dataType, data,"response",resp);
            let _resp = JSON.stringify(resp);
            Util.JSAlert("response_error","Hatalı Cevap","<pre>"+_resp+"</pre>",false,'full');
        })
        .always(function() {
            setTimeout(function () { $(".alert-dismissible").hide(); $('.navbar-ajax-indicator').css('color', 'black');},50);
        });
    },
    ajax: function(url,data,type='post') {
        let _rHeaders = Util.CloneObj(glb.env.xHeaders);
        if(glb.env.hasOwnProperty('tmpHeaders') && glb.env.tmpHeaders !== null) {
            _rHeaders = Util.CloneObj(glb.env.tmpHeaders);
            glb.env.tmpHeaders = null;
        }
        return $.ajax({
            headers: _rHeaders,
            statusCode : {
                403: function() { window.alert("Forbidden \n"+url); },
                404: function() { window.alert("Requested url not found \n"+url); },
            },
            type: type, method: type, url: url, dataType: 'json', data: data,
            beforeSend: function () { }
        });
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
    xCall: function(url,type,data,requestHistory=null,callBack=null){
        if(typeof url === "undefined") {
            console.error("xhr url",url,type,data,requestHistory,callBack);
            return;
        }

        $(".xhr-remove").remove();

        let _rHeaders = Util.CloneObj(glb.env.xHeaders);
        if(glb.env.hasOwnProperty('tmpHeaders') && glb.env.tmpHeaders !== null) {
            _rHeaders = Util.CloneObj(glb.env.tmpHeaders);
            glb.env.tmpHeaders = null;
        }

        $.ajax({
            headers: _rHeaders,
            type: type, method: type, url: url, dataType: 'json', data: data,
        }).done(function(resp) {
            if(!resp) {
                console.error("Empty Ajax Request");
                return false;
            }
            if(typeof resp !== "object") {
                Util.JSAlert("response_error","Hatalı Cevap");
                console.log(resp);
                return false;
            }
            if(requestHistory !== null) {
                history.pushState(
                    {
                        'call':'xCall',
                        'url':url,
                        'data':data,
                        'type':type,
                        'requestHistory':requestHistory,
                        'callback':callBack,
                        'dataType':'json'
                    },
                    '',
                    url
                );
            }
            if(resp[Object.keys(resp)[0]] !== null && resp[Object.keys(resp)[0]].hasOwnProperty('DomID') && resp[Object.keys(resp)[0]].hasOwnProperty('Type') ) {
                Ui.process(resp,callBack);
            } else {
                if (typeof callBack === "function") {
                    callBack(resp);
                } else {
                    console.info("xhrCall_callback",typeof callBack,callBack);
                }
            }
        })
        .fail(function(resp) {
            console.log("xhrcall Fail",url,type,dataType, data,"response",resp);
            let _resp = JSON.stringify(resp);
            Util.JSAlert("response_error","Hatalı Cevap","<pre>"+_resp+"</pre>",false,'full');
        })
        .always(function() {
            setTimeout(function () { $(".alert-dismissible").hide(); $('.navbar-ajax-indicator').css('color', 'black');},50);
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
            let _req = {};
            _req.url = oForm.action;
            _req.data = XHref.appendData(oForm,Util.GetFormData(formID));
            _req.type = oForm.method;
            if (oForm.dataset.hasOwnProperty("issuerprefix")) { _req.data['issuer_prefix'] = oForm.dataset.issuerprefix; }
            _req.callback = (oForm.dataset.hasOwnProperty("backhandler")) ? oForm.dataset.backhandler : null;
            Main.xhrCall(_req.url,_req.type,'json',_req.data,2,_req.callback);
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
        if(resp.state === 'failure') {
            console.error("Response_Failure");
            console.log(resp,"------------------------------------");
            let _txt = resp.message.join("<br>\n");
            Util.JSAlert("Response_Payload_Failure",false,_txt);
            return false;
        }
        if(resp.state !== 'success') {
            console.error("Response_not_success");
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
        console.log("getIfSrc",url,iframeId);
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

let XHref = function () { return {
    isConfirmed: function(_elm) {
        if(!_elm.dataset.hasOwnProperty("question")) { // no question so it auto confirmed
            return true;
        }
        if(window.confirm(_elm.dataset.question)){
            return true;
        }
        return false;
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
                    Main.xhrCall(_req.url,_req.type,'json',_req.data,2,_req.callback);
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

$(document).off('click','.xhref').on('click','.xhref', function(ev) {
    try {
        ev.preventDefault();
        glb.util.OverlayIframeClose();
        let _elm = ev.currentTarget;
        if(_elm.dataset.collapse) { document.querySelector('.navbar-toggle').click(); }
        if(!XHref.isConfirmed(_elm)) { return false; }

        let _req = {};
        _req.data = XHref.appendData(_elm,{});
        if(_elm.dataset.hasOwnProperty("issuerprefix")) { _req.data.issuer_prefix = _elm.dataset.issuerprefix; }
        if(_elm.dataset.hasOwnProperty("recordpid")) { _req.data.record_pid = _elm.dataset.recordpid; }
        if(_elm.dataset.hasOwnProperty("domdestination")) { _req.data.dom_destination = _elm.dataset.domdestination; }

        _req.url = (_elm.tagName === 'BUTTON') ? _elm.dataset.href : _elm.href;
        _req.url = (_elm.dataset.hasOwnProperty('url')) ? _elm.dataset.url : _req.url; // Override for tabs etc
        _req.type = (_elm.dataset.hasOwnProperty('type')) ? _elm.dataset.type : "GET";
        _req.history = (_elm.dataset.hasOwnProperty('nohistory')) ? null : 'yes';
        _req.callback = (_elm.dataset.hasOwnProperty('backhandler')) ? window[_elm.dataset.backhandler]() : null;

        if(_elm.dataset.hasOwnProperty('is_data')) {
            glb.env.tmpHeaders = Util.CloneObj(glb.env.xHeaders,1,'is_data');
        }

        Main.xCall(_req.url,_req.type,_req.data,_req.history,_req.callback);
    } catch (e) {
        console.error("Xhref Error",e);
    }

});

$(document).off("submit",".xhr-form");
$(document).on("submit", ".xhr-form", function (ev) {
    ev.preventDefault();
    let formID = $(this).attr("id");
    let oForm = document.getElementById(formID);

    if(oForm.dataset.hasOwnProperty("single") && oForm.dataset.single === 1) {
        if (oForm.dataset.hasOwnProperty("submitted") && oForm.dataset.submitted === 1) {
            Util.JSAlert(formID+"_submit_alert","","Bu form birden fazla aynı gönderime kapalıdır. Lütfen formu yenileyin.");
            return false;
        } else {
            oForm.dataset.submitted = 1;
        }
    }
    if(oForm.dataset.hasOwnProperty('is_data')) {
        glb.env.tmpHeaders = Util.CloneObj(glb.env.xHeaders,1,'is_data');
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

glb.util.MinimizeLayout = function() {
    $("#layout_subHeader").hide();
    $("#layout_content").hide();
    $("#layout_footer").hide();
};

glb.util.RestoreLayout = function() {
    $("#layout_subHeader").show();
    $("#layout_content").show();
    $("#layout_footer").show();
};

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

glb.util.ToggleSidebar = function () {
    var triggers = document.getElementsByClassName('sidebar-trigger');
    if(document.body.classList.contains('sidebar-collapse')) {
        document.body.classList.remove('sidebar-collapse');
        document.body.classList.remove('sidebar-closed');
        document.body.classList.add('sidebar-open');
        for (var i = 0; i < triggers.length; i++) {
            triggers[i].classList.remove('fa-arrow-to-right');
            triggers[i].classList.add('fa-arrow-to-left');
        }
    } else {
        document.body.classList.add('sidebar-collapse');
        document.body.classList.add('sidebar-closed');
        document.body.classList.remove('sidebar-open');
        for (var i = 0; i < triggers.length; i++) {
            triggers[i].classList.remove('fa-arrow-to-left');
            triggers[i].classList.add('fa-arrow-to-right');
        }
    }
};

window.addEventListener('popstate', function(e) {
    if(history.state != null && history.state.hasOwnProperty('call')) {
        switch (history.state.call) {
            case "ajaxCall":
                Main.xhrCall(history.state.url,history.state.type,'json',history.state.data,history.state.data.callback);
                break;
            case "xhrCall":
                Main.xhrCall(history.state.url,history.state.type,'json',history.state.data,"2",history.state.callback);
                break;
            case "xCall":
                Main.xCall(history.state.url,history.state.type,history.state.data,history.state.requestHistory,history.state.callback);
                break;
            case "landing":
                Util.loadUrl(history.state.url);
                break;
            case null:
                console.info("Case NUll");
                break;
        }
    } else {
        console.info("Return to index",e);
    }
});

