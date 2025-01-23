"use strict";
/*jshint esversion: 6 */

(function() {
    window.k5.form = {
        reset: function(idForm) {
            if(!$('#'+idForm).length) { console.error('Form not found ',idForm); return false; }
            $('#'+idForm).data('submitted',2);
        },
        submitForm: function (oForm,formID) {
            if(k5.state.hasOwnProperty(formID)) {
                if(k5.state.hasOwnProperty(formID) && k5.state[formID] === "destroy") {
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

            if(!k5.form.hasUnvalidated(formID)) { return false; }

            if(!$('#'+formID)[0].checkValidity()) {
                $('#'+formID).find(':submit').click();
            } else {
                let _formData = this.getFormData(formID);

                let _req = k5.xhr.initRequest(oForm);
                _req.url = oForm.action;
                _req.type = oForm.method;
                for(let p in _formData) {
                    if(_formData.hasOwnProperty(p)) {
                        _req.fields[p] = _formData[p];
                    }
                }

                k5.xhr.call(_req.url,_req.type,_req.fields,_req.options);
            }
        },
        getFormData: function (formDomID) {
            let data = $('#'+formDomID).serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});
            return data;
        },
        createFromData: function(data) {
            let FD = new FormData();
            for(name in data) {
                FD.append(name, data[name]);
            }
            return FD;
        },
        setState: function (formId,elementId,state) {
            if(!k5.state.hasOwnProperty(formId)) {
                k5.state[formId] = {};
            }
            if(k5.state[formId] === 'destroy') {
                return;
            }

            if(state === "destroy") {
                if(k5.state[formId].hasOwnProperty(elementId)) {
                    delete k5.state[formId][elementId];
                }
            } else {
                k5.state[formId][elementId] = state;
            }
        },
        setFate: function (formId,fate) {
            if(fate === "destroy") {
                k5.state[formId] = "destroy";
                return;
            }

            let toDelete = true;
            if(k5.state.hasOwnProperty(formId)) {
                for(var prop in k5.state[formId]) {
                    (k5.state[formId].hasOwnProperty(prop)) ? toDelete = false : '';
                }
            }
            if(toDelete){ delete k5.state[formId]; }
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
            _req.history = (_elm.dataset.hasOwnProperty('reqhistory')) ? _elm.dataset.reqhistory : null;
            _req.callback = (_elm.dataset.hasOwnProperty('backhandler')) ? window[_elm.dataset.backhandler]() : null;
            return _req;
        },
        isUnique: function (_elm,formID) {
            let elements = _elm.elements;
            let ret = true;
            for (let i = 0, element; element = elements[i++];) {
                if(element.classList.contains("xhr-unique")) {
                    var _req = XHref.fieldUnique(element);
                    if(_req !== false) {
                        _req.data['form_id'] = formID;
                        Main.SetFormState(_req.data['form_id'],_req.data['form_element_id'],"wait");
                        k5.xhr.call(_req.url,_req.type,_req.data,2,_req.callback);
                        ret = false;
                    }
                }
            }
            return ret;
        },
        getUnvalidated: function (domId) {
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
        setUnvalidated: function (domId,uv) {
            document.getElementById(domId).dataset.unvalidated = JSON.stringify(uv);
        },
        hasUnvalidated: function (formID) {
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
})();

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


