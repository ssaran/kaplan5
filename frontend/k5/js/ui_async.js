/*jshint esversion: 8 */

const Ui = (function () {
    return {
        async process(response, callBack = null) {
            for (let cssIndex in response) {
                if (!response.hasOwnProperty(cssIndex)) {
                    continue;
                }

                let _r = response[cssIndex];
                if (typeof _r.Type === 'undefined') {
                    console.info("RESPONSE ELEMENT " + cssIndex + " UNDEFINED", _r);
                    return false;
                }

                switch (_r.Type) {
                    case "css": await Ui.processCss(_r); break;
                    case "data":
                        try {
                            _r.Content = JSON.parse(_r.Content);
                        } catch (e) {
                            console.error("json parse error in ui data", e);
                            continue;
                        }
                        response[cssIndex] = _r;
                        break;
                }
            }

            for (let index in response) {
                if (!response.hasOwnProperty(index)) {
                    continue;
                }

                let _r = response[index];
                if (typeof _r.Type === 'undefined') {
                    console.info("RESPONSE ELEMENT " + index + " UNDEFINED", _r);
                    return false;
                }

                switch (_r.Type) {
                    case "html": await Ui.processHtml(_r); break;
                    case "katmer": await Ui.processKatmer(_r); break;
                    case "modal":
                    case "modal5":
                        await Ui.processModal5(_r);
                        break;
                    case "tabs": await Ui.processTab(_r); break;
                    case "tab_title": await Ui.processTabTitle(_r); break;
                }
            }

            for (let jsIndex in response) {
                if (!response.hasOwnProperty(jsIndex)) {
                    continue;
                }

                let _r = response[jsIndex];
                if (typeof _r.Type === 'undefined') {
                    console.info("RESPONSE ELEMENT " + jsIndex + " UNDEFINED", _r);
                    return false;
                }

                switch (_r.Type) {
                    case "js": await Ui.processJs(_r); break;
                    case "js_lib": await Ui.loadJsLib(_r); break;
                    case "js_module": await Ui.loadJsModule(_r); break;
                }
            }

            if (callBack && typeof callBack === "function") {
                callBack(response);
            }
        },

        async processHtml(_r) {
            if (!_r.hasOwnProperty("Mode") || _r.Mode === false) {
                console.info("Process HTML undefined", _r);
                return false;
            }

            let _dest = document.getElementById(_r.DomID) || document.getElementById(_r.DomDestination) || document.getElementById('layout_content');

            switch (_r.Mode) {
                case 'content-add':
                    _dest.innerHTML = `<div id="${_r.DomID}">${_r.Content}</div>`;
                    break;
                case 'content-append':
                    _dest.innerHTML += `<div id="${_r.DomID}">${_r.Content}</div>`;
                    break;
                case 'content-prepend':
                    let child = document.createElement("div");
                    child.id = _r.DomID;
                    child.innerHTML = _r.Content;
                    _dest.insertBefore(child, _dest.firstChild);
                    break;
                case 'content-replace':
                    _dest.innerHTML = _r.Content;
                    break;
                case 'content-new':
                    let oElement = document.createElement(_r.newElementType);
                    oElement.id = _r.DomID;
                    oElement.className = _r.className;
                    oElement.defer = true;
                    oElement.innerHTML = _r.Content;
                    document.getElementById(_r.parentDomId).appendChild(oElement);
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
                    console.error("Wrong modal request");
                    break;
            }
        },

        async processJs(_r) {
            try {
                if (!_r.hasOwnProperty("Mode") || _r.Mode === false) {
                    _r.Mode = "add";
                }

                switch (_r.Mode) {
                    case "add":
                        if (document.getElementById(_r.DomID)) {
                            document.getElementById(_r.DomID).remove();
                        }
                        document.body.appendChild(Ui.newContentScript(_r.Content, "js-cover", _r.DomID));
                        break;
                    case "load":
                        if (document.getElementById(_r.DomID)) {
                            if (_r.hasOwnProperty('Refresh') && _r.Refresh === true) {
                                document.getElementById(_r.DomID).remove();
                            } else {
                                return null;
                            }
                        }
                        document.body.appendChild(Ui.newScript(_r.Content, "js-cover", _r.DomID));
                        break;
                    case "lib":
                        await Ui.loadScript(_r.Content, _r.DomID, false, _r.Refresh);
                        break;
                    case "remove":
                        document.getElementById(_r.DomID).remove();
                        break;
                    case "cleanAll":
                        let paras = document.getElementsByClassName('js-cover');
                        while (paras[0]) {
                            paras[0].parentNode.removeChild(paras[0]);
                        }
                        break;
                }
            } catch (e) {
                console.error(e);
                return false;
            }
        },

        async loadJsLib(_r) {
            try {
                await Ui.loadScript(_r.Content, _r.DomID, false, _r.Refresh);
            } catch (e) {
                console.error(e);
                return false;
            }
        },

        async loadJsModule(_r) {
            try {
                await Ui.loadScript(_r.Content, _r.DomID, true, _r.Refresh);
            } catch (e) {
                console.error(e);
                return false;
            }
        },

        async processCss(_r) {
            if (document.getElementById(_r.DomID)) {
                if (_r.hasOwnProperty('Refresh') && _r.Refresh === true) {
                    document.getElementById(_r.DomID).remove();
                } else {
                    return false;
                }
            }
            document.head.appendChild(Ui.newStyle(_r.Content, "css-load", _r.DomID));
        },

        async processModal5(_r) {
            Modal5.Get(_r.Modal_DomID, _r.Modal_Title, _r.Modal_Body, _r.Modal_Footer, _r.Modal_Size, _r.Modal_Close, _r.Config);
        },

        async processTab(_r) {
            if (!_r.hasOwnProperty("Mode") || _r.Mode === false) {
                console.warn("Process HTML undefined", _r);
                return false;
            }
            Tabs.Add(_r.TabId, _r.Title, _r.Content);
        },

        async processTabTitle(_r) {
            let tabPill = document.getElementById('basetab_pill_' + _r.DomID);
            if (tabPill) {
                tabPill.innerHTML = _r.Content;
            }
        },

        async processKatmer(obj) {
            let _dest = document.getElementById(obj.DomDestination) || document.getElementById('layout_content');
            if (_dest) {
                _dest.innerHTML = obj.Content;
            }
        },

        newScript: function (src, className = 'js-lib', DomID) {
            const _el = document.createElement("script");
            _el.language = "javascript";
            _el.src = src;
            if (DomID) {
                _el.id = DomID;
            }
            _el.className = className;
            return _el;
        },

        newContentScript: function (content, className = 'js-lib', DomID) {
            const _el = document.createElement("script");
            _el.language = "javascript";
            _el.text = content;
            if (DomID) {
                _el.id = DomID;
            }
            _el.className = className;
            return _el;
        },

        newStyle: function (src, className = 'css-load', DomID) {
            const _el = document.createElement("link");
            _el.rel = "stylesheet";
            _el.type = "text/css";
            _el.href = src;
            if (DomID) {
                _el.id = DomID;
            }
            _el.className = className;
            return _el;
        },

        async loadScript(src, DomID, isModule = false, refresh = false) {
            if (document.getElementById(DomID)) {
                if (refresh) {
                    document.getElementById(DomID).remove();
                } else {
                    return;
                }
            }

            const _ldr = new ScriptLoader({ src: src, global: DomID, is_module: isModule });
            await _ldr.load();
        },

        async xhrCallFromDomElement(domId) {
            let _elm = document.getElementById(domId);
            if (!_elm) {
                console.error("Dom element not found: ", domId);
                return false;
            }
            if (!XHref.isConfirmed(_elm)) {
                return false;
            }

            let _req = XHref.initRequest(_elm);
            _req.type = "GET";

            for (let i in _elm.dataset) {
                if (i === 'params') {
                    try {
                        let _params = JSON.parse(_elm.dataset.params);
                        for (let p in _params) {
                            if (_params.hasOwnProperty(p)) {
                                _req.fields[p] = _params[p];
                            }
                        }
                    } catch (e) {
                        console.info("JSON Parse error", e, _elm.dataset);
                    }
                } else if (i === 'datatable') {
                    _req.callback = async function (resp) {
                        let _conf = JSON.parse(_elm.dataset.datatable);
                        let _dtConf = { data: resp.data };

                        if (!_dtConf.hasOwnProperty('columns') && _conf.hasOwnProperty('columns')) {
                            _dtConf.columns = _conf.columns;
                        }

                        if (_conf.hasOwnProperty('buttons')) {
                            _dtConf.buttons = [];
                            _conf.buttons.forEach(_b => {
                                switch (_b.type) {
                                    case "new":
                                        _dtConf.buttons.push({
                                            text: '<i class="bi-plus-circle"></i>',
                                            action: function (e, dt, node, config) {
                                                Ui.xhrCallFromDomElement(_b.call_element_id);
                                            }
                                        });
                                        break;
                                }
                            });
                        }

                        $('#' + _conf.target_element_id).DataTable(_dtConf);
                    }
                }
            }
            await XHref.xhrCall(_req);
        }
    };
})();

class ScriptLoader {
    constructor({ src, global, is_module = false }) {
        this.src = src;
        this.global = global;
        this.isModule = is_module;
    }

    load() {
        return new Promise((resolve, reject) => {
            const script = document.createElement('script');
            script.src = this.src;
            script.async = true;
            if (this.isModule) {
                script.type = "module";
            }
            script.onload = () => resolve(this.global);
            script.onerror = () => reject(new Error(`Failed to load script: ${this.src}`));
            document.body.appendChild(script);
        });
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
