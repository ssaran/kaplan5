"use strict";
/*jshint esversion: 6 */

(function() {
    window.k5.xhr = {
        callbacks:{},
        _urlChangeCallbacks : {},
        call: function(url,type,fields,options,_scroll=-1){
            if(typeof url === "undefined") {
                console.error("xjCall undefined url",url,type,fields,options);
                return;
            }
            $(".xhr-remove").remove();
            let _rHeaders = k5.util.cloneObj(k5.env.xHeaders);
            if(k5.env.hasOwnProperty('tmpHeaders') && k5.env.tmpHeaders !== null) {
                _rHeaders = k5.util.CloneObj(k5.env.tmpHeaders);
                k5.env.tmpHeaders = null;
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
                let resp = k5.util.parseJSON(_resp);
                if(typeof resp !== "object") {
                    k5.util.JSAlert(resp,"Hatalı Cevap");
                    return false;
                }
                if (typeof gtag === 'function') {
                    gtag("event", "pageView",{ 'pagePath':url, 'requestType':'xhr'});
                }
                observeUrlChange();

                if(options.hasOwnProperty('scrollToTop') && options.scrollToTop !== null) {
                    setTimeout(function() {
                        window.scrollTo({top: 0, left: 0, behavior: "instant"});
                    }, 0);
                }

                if(options.hasOwnProperty('requestHistory') && options.requestHistory !== null) {
                    this.setHistory(url,type,fields,options);
                }

                console.log("xjresponse",resp);
                if(resp[Object.keys(resp)[0]] !== null && resp[Object.keys(resp)[0]].hasOwnProperty('DomID') && resp[Object.keys(resp)[0]].hasOwnProperty('Type') ) {
                    k5.dom.process(resp,options).then();
                } else {
                    if (options.hasOwnProperty('callback') && typeof options.callback === "function") {
                        options.callback(resp);
                    } else {
                        console.info("xjCall Callback",typeof options.callback,options.callback);
                    }
                }
            })
            .fail(function(resp) {
                if(_scroll > -1) {
                    k5.env.mainScroll = 0;
                }
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
                if(k5.xhr.callbacks.hasOwnProperty('xjCall')) {
                    k5.xhr.callbacks.xjCall();
                }
            });
        },
        deferred: function(requests,callbackDone) {
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
        setHistory: function (url,type,fields,options) {
            let __data = k5.util.getScrollPosition();
            __data['fields'] = JSON.stringify(fields);

            history.pushState({'call':'xjCall', 'url':url, 'data':__data, 'type':type, 'options': options, 'dataType':'json'}, '', url);
            if(k5.hasOwnProperty('_urlChangeCallbacks')) {
                for (let key in k5._urlChangeCallbacks) {
                    let _cbFunc = k5._urlChangeCallbacks[key];
                    if(typeof _cbFunc === "function") {
                        _cbFunc({'url':url, 'type':type, 'fields':fields, 'options':options});
                    }
                }
            }
        },
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
            if(_elm.dataset.hasOwnProperty("istab")) { _req.options.headers['Is-Tab'] = _elm.dataset.ismodal; }
            if(_elm.dataset.hasOwnProperty("actualtabid")) { _req.options.headers['Actual-Tab-Id'] = _elm.dataset.actualtabid; }
            if(_elm.dataset.hasOwnProperty("iscomponent")) { _req.options.headers['Is-Component'] = _elm.dataset.iscomponent; }
            if(_elm.dataset.hasOwnProperty("employer")) { _req.options.headers['Employer'] = _elm.dataset.employer; }
            if(_elm.dataset.hasOwnProperty("restoreScroll")) { _req.options.headers['Restore-Scroll'] = _elm.dataset.restoreScroll; }

            if(_elm.dataset.hasOwnProperty('append')) {
                let _params = k5.util.parseJSON(_elm.dataset.append);
                for (const key in _params) {
                    if (_params.hasOwnProperty(key)) {
                        _req.fields[key] = _params[key];
                    }
                }
                if(_req.fields.hasOwnProperty('Is-Modal')) {
                    _req.options.headers['Is-Modal'] = _req.fields['Is-Modal'];
                    delete(_req.fields['Is-Modal']);
                }
                if(_req.fields.hasOwnProperty('Is-Tab')) {
                    _req.options.headers['Is-Tab'] = _req.fields['Is-Tab'];
                    delete(_req.fields['Is-Tab']);
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

            if(_elm.dataset.hasOwnProperty('restorescroll')) {
                _req.options.restoreScroll = 'yes';
            } else {
                _req.options.restoreScroll = null;
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
            let _params = k5.util.parseJSON(_elm.dataset.append);
            for(var p in _params) {
                _data[p] = _params[p];
            }
            return _data;
        },
        isResponseValid: function (resp) {
            if(!resp.hasOwnProperty('state')) {
                console.error("Response mismatch",resp)
                return false;
            }
            if(resp.state === 'failure') {
                console.error("Response_Failure",resp.message)
                k5.util.JSAlert(resp.message.toString(),"Cevap hatası");
                return false;
            }
            if(resp.state !== 'success') {
                k5.util.JSAlert(resp.message.toString(),"Bilinmeyen cevap");
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
        callFromDomElement: function (domId) {
            let _elm = document.getElementById(domId);
            if(!_elm) {
                console.error("Dom element not found : ",domId);
                return false;
            }
            if(!this.isConfirmed(_elm)) { return false; }

            let _req = this.initRequest(_elm);
            _req.type = "GET";

            for(let i in _elm.dataset ) {
                if(i === 'params') {
                    try {
                        let _params = JSON.parse(_elm.dataset.params);
                        for (let p in _params) {
                            if(_params.hasOwnProperty(p)) {
                                _req.fields[p] = _params[p];
                            }
                        }
                    } catch (e) {
                        console.info("Json Parse error", e,_elm.dataset);
                    }
                } else if(i === 'datatable') {
                    _req.callback = function (resp) {
                        let _conf = JSON.parse(_elm.dataset.datatable);
                        let _dtConf = {};
                        _dtConf.data = resp.data;
                        if(!_dtConf.hasOwnProperty('columnDefs')) {
                            _dtConf.columnDefs = [];
                        }

                        if(_conf.hasOwnProperty('buttons')) {
                            _dtConf.columnDefs = [ {
                                "targets": 0,
                                "data": null,
                                render: function ( data, type, row, meta ) {
                                    var _btns = '';
                                    for (var b in _conf.buttons) {
                                        _btns+= UiDataTable.GetRowButton(_conf.buttons[b],row,meta);
                                    }
                                    return _btns;
                                }
                            } ];
                        }

                        if(_conf.hasOwnProperty('config')) {
                            for (var c in _conf.config) {
                                if(c !== "columnDefs") {
                                    _dtConf[c] = _conf.config[c];
                                } else {
                                    var _defConf = _conf.config[c];
                                    for (var dc in _defConf) {
                                        var _dc = _defConf[dc];
                                        if(_dc.hasOwnProperty("_render")) {
                                            _dc.render = function (data,type,row) {
                                                return  window[_dc._render](data,type,row);
                                            }
                                        }
                                        _dtConf.columnDefs.push(_dc);
                                    }
                                }
                            }
                        }
                        if ($.fn.DataTable.isDataTable('#'+domId)) {
                            $('#'+domId).DataTable().clear().destroy();
                        }
                        $('#'+domId).DataTable(_dtConf);
                    };
                }
            }
            this.call(_req.url,_req.type,_req.fields,_req.options);
        }
    };
})();


