/*jshint esversion: 8 */

const Ui = function () { return {
    process:function(response,callBack=null) {
        for(let index in response) {
            if(!response.hasOwnProperty(index)) {
                continue;
            }

            let _r = response[index];
            if(typeof _r.Type === 'undefined') {
                console.info("RESPONSE ELEMENT "+index+" UNDEFINED",_r);
                return false;
            }

            switch(_r.Type) {
                case "html": Ui.processHtml(_r); break;
                case "js": Ui.processJs(_r); break;
                case "js_lib": Ui.loadJsLib(_r); break;
                case "css": Ui.processCss(_r); break;
                case "modal":
                case "modal5":
                    Ui.processModal5(_r);
                    break;
                case "tabs": Ui.processTab(_r); break;
                case "tab_title": Ui.processTabTitle(_r); break;
                case "data":
                    var obj = JSON.parse(_r.Content);
                    if (obj instanceof SyntaxError) {
                        console.error("json parse error in ui data",obj);
                        continue;
                    } else {
                        _r.Content = obj;
                    }
                    response[index] = _r;
                    break;
            }
        }

        if(callBack !== null) {
            if (typeof callBack === "function") {
                callBack(response);
            }
        }
    },
    processHtml:function(_r) {
        if(!_r.hasOwnProperty("Mode") || _r.Mode === false) {
            console.info("Process HTML undefined",_r);
            return false;
        }

        switch(_r.Mode) {
            case 'content-add':
            case 'content-append':
            case 'content-prepend':
            case 'content-replace':
                let _dest = document.getElementById(_r.DomID);
                if (_dest){
                    document.getElementById(_r.DomID).innerHTML = _r.Content;
                } else {
                    _dest = document.getElementById(_r.DomDestination);
                    if(!_dest) {
                        _dest = document.getElementById('layout_content');
                    }

                    switch(_r.Mode) {
                        case 'content-add':
                            _dest.innerHTML = "<div id=\""+_r.DomID+"\">"+_r.Content+"</div>";
                            break;
                        case 'content-append':
                            _dest.innerHTML += "<div id=\""+_r.DomID+"\">"+_r.Content+"</div>";
                            break;
                        case 'content-prepend':
                            let parent = _dest;
                            let child = document.createElement("div");
                            child.setAttribute('id',_r.DomID);
                            child.innerHTML = _r.Content;
                            parent.insertBefore(child, parent.firstChild);
                            break;
                        case 'content-replace':
                            _dest.innerHTML = _r.Content;
                            break;
                    }
                }
                break;
            case 'content-new':
                let oElement = document.createElement(_r.newElementType);
                oElement.id = _r.DomID;
                oElement.className = _r.className;
                oElement.defer = true;
                oElement.innerHTML = _r.Content;
                document.getElementById(_r.parentDomId).item(0).appendChild(oElement);
                break;
            case 'remove':
                document.getElementById(_r.DomID).remove();
                break;
            case 'layout-clean':
                document.getElementById(_r.K5Destination).innerHTML = '';
                break;
            case 'bypass':
                break;
            case 'modal':
                if(typeof _r.Modal === 'undefined') {
                    return false;
                }
                if (document.getElementById(_r.Modal.DomID)){
                    document.getElementById(_r.Modal.DomID+' .modal-body').innerHTML = _r.Modal.Body;
                    document.getElementById(_r.Modal.DomID+' .modal-footer').innerHTML = _r.Modal.Footer;
                } else {
                    Modal.Get(_r.Modal.DomID,_r.Modal.Title,_r.Modal.Body,_r.Modal.Footer,_r.Modal.Size);
                }
                break;
        }
        if(glb.env.is_tabbed === 1) {
            //$('#basetab_list li:first-child a:first')[0].click();
        }
    },
    processJs:function(_r) {
        try {
            if(!_r.hasOwnProperty("Mode") || _r.Mode === false) {
                _r.Mode = "add";
            }
            //Util.RemoveElementsByClass("js-cover");

            switch(_r.Mode) {
                case "add":
                    if (document.getElementById(_r.DomID)){
                        document.getElementById(_r.DomID).remove();
                    }
                    document.getElementsByTagName('body').item(0).appendChild(this.newContentScript(_r.Content,"js-cover",_r.DomID));
                    break;
                case "load":
                    if (document.getElementById(_r.DomID)){
                        if(_r.hasOwnProperty('Refresh') && _r.Refresh === true) {
                            document.getElementById(_r.DomID).remove();
                        } else {
                            return null;
                        }
                    }
                    document.getElementsByTagName('body').item(0).appendChild(this.newScript(_r.Content,"js-cover",_r.DomID));
                    break;
                case "lib":
                    if (document.getElementById(_r.DomID)){
                        if(_r.hasOwnProperty('Refresh') && _r.Refresh === true) {
                            document.getElementById(_r.DomID).remove();
                        } else {
                            return null;
                        }
                    }
                    (async() => {
                        const _ldr = new ScriptLoader({src: _r.Content,global:_r.DomID});
                        const _to = await _ldr.load();
                    })();
                    break;
                case "remove":
                    document.getElementById(_r.DomID).remove();
                    break;
                case "cleanAll":
                    let paras = document.getElementsByClassName('js-cover');
                    while(paras[0]) {
                        paras[0].parentNode.removeChild(paras[0]);
                    }
                    break;
            }
        } catch (e) {
            console.error(e);
            return false;
        }
    },
    loadJsLib:function(_r) {
        try {
            if (document.getElementById(_r.DomID) !== null){
                if(_r.hasOwnProperty('Refresh') && _r.Refresh === true) {
                    document.getElementById(_r.DomID).remove();
                } else {
                    return null;
                }
            }
            (async() => {
                const _ldr = new ScriptLoader({src: _r.Content,global:_r.DomID});
                const _to = await _ldr.load();
            })();
        } catch (e) {
            console.error(e);
            return false;
        }
    },
    processCss:function(_r) {
        if (document.getElementById(_r.DomID)){
            if(_r.hasOwnProperty('Refresh') && _r.Refresh === true) {
                document.getElementById(_r.DomID).remove();
            } else {
                return false;
            }
        }
        document.getElementsByTagName('head').item(0).appendChild(this.newStyle(_r.Content,"css-load",_r.DomID));
    },
    processModal:function(_r) {
        let _state = "new";
        let _destModal = document.getElementById(_r.DomID);
        if(_destModal) {
            let _dest = document.getElementById(_r.DomID+"_body");
            if(_dest) {
                _state = "update";
            } else {
                _state = "new";
            }
        }
        if(_state === "new") {
            Modal.Get(_r.Modal_DomID,_r.Modal_Title,_r.Modal_Body,_r.Modal_Footer,_r.Modal_Size,_r.Modal_Width,_r.Modal_Sidebar);
        } else {
            let _modalBody = document.getElementById(_r.DomID+"_body");
            if(_modalBody) {
                _modalBody.innerHTML = _r.Modal_Body;
            }
            let _modalTitle = document.getElementById(_r.DomID+"_title");
            if(_modalTitle) {
                _modalTitle.innerHTML = _r.Modal_Title;
            }
            let _modalFooter = document.getElementById(_r.DomID+"_footer");
            if(_modalFooter) {
                _modalFooter.innerHTML = _r.Modal_Footer;
            }
        }
    },
    processModal5:function(_r) {
        if(_r.hasOwnProperty('Modal_Callback')) {
            if(_r.Modal_Callback === '') {
                _r.Modal_Callback = null;
            }
            if(!_r.hasOwnProperty('Modal_Close') || _r.Modal_Close === '') {
                _r.Modal_Close = 'right';
            }
        }
        Modal5.Get(_r.Modal_DomID,_r.Modal_Title,_r.Modal_Body,_r.Modal_Footer,_r.Modal_Size,_r.Modal_Close,_r.Modal_Callback);
    },
    processTab:function(_r) {
        if(!_r.hasOwnProperty("Mode") || _r.Mode === false) {
            console.info("Process HTML undefined",_r);
            return false;
        }
        Tabs.Add(_r.TabId,_r.Title,_r.Content);
    },
    processTabTitle:function(_r) {
        let tabPill = document.getElementById('basetab_pill_'+_r.DomID);
        if(typeof tabPill !== 'undefined' && tabPill !== null ) {
            tabPill.innerHTML = _r.Content;
        }
    },
    newScript: function(src,className,DomID) {
        var _el = document.createElement("script");
        _el.language = "javascript";
        _el.src = src;
        className = (typeof className === undefined) ? 'js-lib' : className;

        if(typeof DomID !== undefined) {
            _el.id = DomID;
        }

        _el.className = className;
        return _el;
    },
    newContentScript: function(content,className,DomID) {
        var _el = document.createElement("script");
        _el.language = "javascript";
        _el.text = content;
        if(typeof className === undefined) {
            className = "js-lib";
        }

        if(typeof DomID !== undefined) {
            _el.id = DomID;
        }

        _el.className = className;
        return _el;
    },
    newStyle: function(src,className,DomID) {
        var _el = document.createElement("link");
        _el.rel = "stylesheet";
        _el.type = "text/css";
        _el.href = src;

        if(typeof className === undefined) {
            className = "css-load";
        }

        if(typeof DomID !== undefined) {
            _el.id = DomID;
        }

        _el.className = className;
        return _el;
    },
    xhrCallFromDomElement: function (domId) {
        let _elm = document.getElementById(domId);
        if(!_elm) {
            console.error("Dom element not found : ",domId);
            return false;
        }
        if(!XHref.isConfirmed(_elm)) { return false; }

        let _req = XHref.initRequest(_elm);
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
            } else if(i === 'type') {
                _req.type = _elm.dataset.type;
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
        console.log("xhr req",_req);
        Main.xjCall(_req.url,_req.type,_req.fields,_req.options);
    }
};
}();

class ScriptLoader {
    constructor (options) {
        const { src, global, protocol = document.location.protocol } = options
        this.src = src
        this.global = global
        this.protocol = protocol
        this.isLoaded = false
    }

    loadScript () {
        return new Promise((resolve, reject) => {
            // Create script element and set attributes
            const script = document.createElement('script');
            script.type = 'text/javascript';
            script.async = true;
            //script.src = `${this.protocol}//${this.src}`;
            script.src = `${this.src}`;
            script.setAttribute("id", this.global);

            // Append the script to the DOM
            const el = document.getElementsByTagName('script')[0];
            el.parentNode.insertBefore(script, el);

            // Resolve the promise once the script is loaded
            script.addEventListener('load', () => {
                this.isLoaded = true;
                resolve(script);
            })

            // Catch any errors while loading the script
            script.addEventListener('error', () => {
                reject(new Error(`${this.src} failed to load.`));
            });
        });
    }

    load () {
        return new Promise(async (resolve, reject) => {
            if (!this.isLoaded) {
                try {
                    await this.loadScript()
                    resolve(window[this.global])
                } catch (e) {
                    reject(e)
                }
            } else {
                resolve(window[this.global])
            }
        })
    }
}

var UiDataTable = function () { return {
    GetRowButton: function(buttonConfig,row,meta) {
        var isXhref = false;
        var _label = '';
        var _classList = '';
        var _dataset = {};
        var _dSet = '';
        if(buttonConfig.hasOwnProperty('classList')) {
            _classList = buttonConfig.classList.join(' ');
            if(buttonConfig.classList.indexOf('xhref') !== -1) {
                isXhref = true;
            }
        }
        var _href = (buttonConfig.hasOwnProperty('href')) ? buttonConfig.href : 'javascript:;';
        var _title = (buttonConfig.hasOwnProperty('title')) ? 'title="'+buttonConfig.title+'"' : '';
        var _question = (buttonConfig.hasOwnProperty('question')) ? 'data-question="'+buttonConfig.question+'"' : '';
        var _type = (buttonConfig.hasOwnProperty('type')) ? 'data-type="'+buttonConfig.type+'"' : '';
        _label+= (buttonConfig.hasOwnProperty('icon')) ? '<i class="fa '+buttonConfig.icon+'"></i>' : '';
        _label+= (buttonConfig.hasOwnProperty('label')) ? buttonConfig.label : '';
        if(buttonConfig.hasOwnProperty('dataset')) {
            for (var d in buttonConfig.dataset) {
                _dataset[d] = buttonConfig.dataset[d];
            }
        }

        if(buttonConfig.hasOwnProperty('rowData')) {
            for (var rowKey in buttonConfig.rowData) {
                var dataKey = buttonConfig.rowData[rowKey];
                if(row.hasOwnProperty(rowKey)) {
                    _dataset[dataKey] = row[rowKey];
                }
            }
        }

        if(isXhref === true) {
            _dSet = "data-append='"+JSON.stringify(_dataset)+"'";
        } else {
            for (var d in _dataset) {
                _dSet+= 'data-'+d+'="'+_dataset[d]+'"';
            }
        }

        var _a = '<a href="'+_href+'" '+_title+' class="btn btn-xs '+_classList+'" '+_dSet+' '+_question+' '+_type+'>'+_label+'</a>';
        return _a;
    },
};
}();

/**
 * Stopwatch object used for call timers
 *
 * @param {dom element} elem
 * @param {[object]} options
 */
var Stopwatch = function ( elem, options)  {
    // private functions
    function createTimer () {
        return document.createElement ( 'span');
    }

    var timer = createTimer (),
        offset,
        clock,
        interval;

    // default options
    options = options || {};
    options.delay = options.delay || 1000;
    options.startTime = options.startTime || Date.now ();

    // append elements
    elem.appendChild ( timer);

    function start () {
        if ( ! interval) {
            offset = options.startTime;
            interval = setInterval ( update, options.delay);
        }
    }

    function stop () {
        if ( interval) {
            clearInterval ( interval);
            interval = null;
        }
    }

    function reset () {
        clock = 0;
        render ();
    }

    function update () {
        clock += delta ();
        render ();
    }

    function render () {
        timer.innerHTML = moment ( clock).format ( 'mm:ss');
    }

    function delta () {
        var now = Date.now (),
            d = now - offset;

        offset = now;
        return d;
    }

    // initialize
    reset ();

    // public API
    this.start = start;
    this.stop  = stop;
};