"use strict";

function Configurator() {
    this._api = '';
    this._module = '';
    this._elements = {};
    this._values = {};
    this._accountCompanyId = '';
    this._containerDomId = '';
}


Configurator.prototype.Setup = function(api,module,elements,values,accountCompanyId) {
    this._api = api;
    this._module = module;
    this._elements = elements;
    this._values = values;
    this._accountCompanyId = accountCompanyId;
};


Configurator.prototype.Generate = function(containerDomId) {
    let par = document.getElementById(containerDomId);
    for (var key in this._elements) {
        if(this._elements.hasOwnProperty(key)) {
            let value = null;
            let obj = this._elements[key];

            if(this._values.hasOwnProperty(key)) {
                value = this._values[key];
            }
            let form = this.CreateFormElement(obj,value);
            par.appendChild(form);
        }
    }
};


Configurator.prototype.CreateFormElement = function (el,value) {

    console.log('el',el,'value',value);
    let formElement = document.createElement('span');
    let formAppend = document.createElement('span');

    let registered = this.GetValue(value);
    let nameForm = this._api+'_config_form_'+el.Name;
    formAppend = Tpl.Node('div',false,{'class':'input-group-append'},{},[
        Tpl.Node('button',false,{'class':'btn btn-primary btn-block config-form-submit'},{'nameform':nameForm},[
            Tpl.Node('i',false,{'class':'fa fa-save'})
        ])
    ]);

    if (el.hasOwnProperty('Options') && el.Options !== null && Array.isArray(el.Options)) {
        formElement = Tpl.Node('select',false,{'class':'form-control','name':'value'});
        let ops = [];
        for (let i = 0, l = el.Options.length; i < l; i++) {
            let obj = el.Options[i];
            let attr = { 'value':obj.key,'class':'form-control config-form-input'};

            if(obj.key === registered) {
                attr = { 'value':obj.key,'selected':'selected','class':'form-control config-form-input'};
            }
            formElement.appendChild(Tpl.Node('option',obj.text,attr));
        }
    } else {
        switch (el.Type) {
            case "string":
                formElement = Tpl.Node('input',false,{'class':'form-control config-form-input','name':'value','type':'text','value':registered});
                break;
            case "text":
                formElement = Tpl.Node('textarea',registered,{'class':'form-control config-form-input','name':'value','rows':'10'});
                break;
            case "integer":
                formElement = Tpl.Node('input',false,{'class':'form-control config-form-input','name':'value','type':'number','value':registered});
                break;
            case "decimal":
                formElement = Tpl.Node('input',false,{'class':'form-control config-form-input','name':'value','type':'number','step':'0.01','value':registered});
                break;
            case "date_time":
                formElement = Tpl.Node('input',false,{'class':'form-control config-form-input','name':'value','type':'date','value':registered});
                break;
        }
    }

    let val = {};
    val.id = 'new';
    val.config_group = el.Type;
    val.config_key = el.new;


    if(typeof value !== "undefined" && value !== null && value !== false) {
        if(value.hasOwnProperty("id")) {
            val.id = value.id;
        }
        if(value.hasOwnProperty("config_group")) {
            val.config_group = value.config_group;
        }
        if(value.hasOwnProperty("config_key")) {
            val.config_key = value.config_key;
        }
    }


    let item = Tpl.Node('form',false,{'class':'','id': this._api+'_config_form_'+el.Name,'onsubmit':'return false;'},{},
            [
            Tpl.Node('div',false,{'class':'row'},{},
                [
                    Tpl.Node('div',"&nbsp;",{'class':'col-md-1',}),
                    Tpl.Node('div',false,{'class':'col-md-11',},{},[
                        Tpl.Node('div',el.Label,{'class':'row',},{},[
                        ])
                    ]),
                ]),
                Tpl.Node('div',false,{'class':'row'},{},
                    [
                        Tpl.Node('div',false,{'class':'col-md-1',},{},[
                            formAppend
                        ]),
                        Tpl.Node('div',false,{'class':'col-md-11',},{},[
                            Tpl.Node('div',false,{'class':'input-group mb-2',},{},[
                                formElement
                            ]),
                        ])
                    ]),
                Tpl.Node('input',false,{'type':'hidden','name':'company_account_id','value':this._accountCompanyId}),
                Tpl.Node('input',false,{'type':'hidden','name':'id','value':val.id}),
                Tpl.Node('input',false,{'type':'hidden','name':'config_group','value':val.config_group}),
                Tpl.Node('input',false,{'type':'hidden','name':'type','value':el.Type}),
                Tpl.Node('input',false,{'type':'hidden','name':'name','value':el.Name}),
                Tpl.Node('input',false,{'type':'hidden','name':'config_key','value':val.config_key}),
        ]);

    return item;
};

Configurator.prototype.GetValue = function (value) {
    if (typeof value === 'undefined' || value === null) {
        return '';
    }

    if(!value.hasOwnProperty('type')) {
        return '';
    }

    switch (value.type) {
        case "string":
            return value.value_string;
            break;
        case "text":
            return value.value_text;
            break;
        case "integer":
            return value.value_integer;
            break;
        case "decimal":
            return value.value_decimal;
            break;
        case "date_time":
            return value.value_date_time;
            break;
    }

    return '';
};