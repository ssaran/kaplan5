/*jshint esversion: 6 */

function HandsonTableHelper() {
    return {
        HOT: {},
        Paginator : {},
        config: {},
        settings: {},
        fieldOptions : '',
        colHeaders: [],
        columns: [],
        dbFields: [],
        dropdownOptions: [],
        filters: {},
        headerFocus: null,
        find : '',
        page : 1,
        Data : {},
        Hooks : {},
        FetchData: function() {
            if(this.config.Routes.Load === "noload") {
                console.info("Load NoLoad");
                return false;
            }

            $('.navbar-ajax-indicator').addClass('fa-spin');
            let data = {};
            data.fields = JSON.stringify(this.dropdownOptions);
            data = this._appendParams(data);

            if(glb.env.hasOwnProperty('is_tabbed') && glb.env.is_tabbed !== null && glb.env.is_tabbed === 1) {
                glb.env.tmpHeaders = Util.CloneObj(glb.env.xHeaders);
                glb.env.tmpHeaders['employer'] = this.config.Employer;
            }
            let _options = {
                'nohistory':'yes'
            }
            if(this.config.hasOwnProperty('callback') && this.config.callback.hasOwnProperty('Load') && typeof this.config.callback.Load === "function") {
                _options['callback'] = this.config.callback.Load;
            }
            Main.xjCall(this.config.Routes.Load, 'post',  data, _options);
        },
        InitHtml: function() {
            this.config.dropdownClass = Util.slugify(this.config.DomElements.HotObject);
            this._renderFields();
            this._setupTable();
            let _content = '';
            if(this.config.hasOwnProperty('Components')) {
                _content = this._parseComponents(this.config.Components,_content);
            }

            _content = this._getContent(_content);

            if(this.config.hasOwnProperty('DomElements') &&  this.config.DomElements.hasOwnProperty('Destination')) {
                $("#"+this.config.DomElements.Destination).html(_content).promise().done(this._afterInitDone());
            }

            let that = this;

            $(document).off('change','.hot-header-select').on( 'change','.hot-header-select', function( event ) {
                that.filters[$(this).data('db_field')] = $(this).val();
                that.Search(null,1,1);
            });

            $(document).off('keyup','.hot-header-input').on( 'keyup','.hot-header-input', function( event ) {
                that.filters[$(this).data('db_field')] = $(this).val();
                that.Search(null,1,1);
                that.headerFocus = $(this).attr('id');
            });
        },
        LoadData:function(resp) {
            this.HOT.loadData(resp.data.data);
            $('.navbar-ajax-indicator').removeClass('fa-spin');
            if(this.config.hasOwnProperty('Components') && this.config.Components.hasOwnProperty('Paginator')) {
                this.Paginator.params = resp.data;
                this.Paginator.params.data.data = [];
                this.Paginator.Render();
            }
            this.HOT.refreshDimensions();
        },
        _afterInitDone:function() {
            let hotElement = document.getElementById(this.config.DomElements.HotSelector);
            if(hotElement === null) {
                console.info(this.config.DomElements);
                alert("Hot element not found");
                return false;
            }
            hotElement.innerHTML = '';

            this.HOT = new Handsontable(hotElement, this.settings);
            this.HOT.updateSettings(this.Hooks);
            this.FetchData();
        },
        _renderFields: function() {
            this.dropdownOptions = [];
            this.colHeaders = [];
            this.columns = [];
            this.dbFields = [];
            let fieldOptions = [];
            let _fields = this.config.Fields;
            let _f = '';
            let _add = true;
            for(const k in _fields) {
                if (!_fields.hasOwnProperty(k)) {
                    continue;
                }

                _f = _fields[k];

                _add = true;
                if(_f.IsSelectable === true) {
                    if (_f.IsVisible === true) {
                        fieldOptions.push('<a href="#" class="dropdown-item small '+this.config.dropdownClass+'" data-value="'+_f.Config.data+'"  data-colhead="'+_f.Label+'" tabIndex="-1"><input type="checkbox" checked class="hot-selected-fields" data-dbfield="'+_f.Config.data+'" data-colhead="'+_f.Label+'" />&nbsp'+_f.Label+'</a>');
                    } else {
                        _add = false;
                        fieldOptions.push('<a href="#" class="dropdown-item small '+this.config.dropdownClass+'" data-value="'+_f.Config.data+'"  data-colhead="'+_f.Label+'" tabIndex="-1"><input type="checkbox" data-dbfield="'+_f.Config.data+'" data-colhead="'+_f.Label+'"/>&nbsp'+_f.Label+'</a>');
                    }
                }

                if(_add === true) {
                    this.colHeaders.push(_f.Label);
                    this.columns.push(_f.Config);
                    this.dbFields.push(_f.Config.data);
                    this.dropdownOptions.push(_f.Config.data);
                }
            }
            this.fieldOptions = fieldOptions.join("\n");
        },
        _setupTable: function() {
            this.settings.stretchH = "all";
            this.settings.rowHeaders = false;
            this.settings.columnSorting = false;
            this.settings.tableClassName = ['table', 'table-hover', 'table-striped'];
            this.settings.persistentState = true;
            this.settings.fillHandle =  false;
            this.settings.data =  [];
            this.settings.licenseKey =  "non-commercial-and-evaluation";

            let that = this;

            this.settings.afterGetColHeader = function (col, TH) {
                let _config = this.getSettings().columns[col];
                let header = TH.querySelectorAll('.colHeader')[0];
                let _lbl = '';
                switch(_config.head.type) {
                    case "textVertical":
                        _lbl = header.innerHTML;
                        header.innerHTML = '<div class="hsVerticalHead">' + _lbl + '</div>';
                        break;
                    case "textVerticalB":
                        _lbl = header.innerHTML;
                        header.innerHTML = '<div class="hsVerticalHead"><strong>' + _lbl + '</strong></div>';
                        break;
                    case "textVerticalC":
                        _lbl = header.innerHTML;
                        header.innerHTML = '<div class="hsVerticalHeadC"><strong>' + _lbl + '</strong></div>';
                        break;
                    case "text":
                        break;
                    case "find2":
                        let input = document.createElement('input');
                        input.className = 'hot-header-filter hot-header-input';
                        input.setAttribute('data-db_field', _config.data);
                        input.placeholder = _config.head.label;
                        if(that.filters.hasOwnProperty(_config.data)) {
                            input.value = that.filters[_config.data];
                        }
                        input.id = that.config.DomElements.HotSelector+'_filter_'+_config.data;

                        header.innerHTML = "";
                        header.appendChild(input);
                        break;

                    case "select2":
                        let select = document.createElement('select');
                        select.className = 'hot-header-filter hot-header-select select2';
                        select.placeholder = _config.head.label;
                        select.setAttribute('data-db_field', _config.data);
                        select.style = 'width:100%;';
                        select.id = that.config.DomElements.HotSelector+'_filter_'+_config.data;

                        let option = document.createElement("option");
                        option.text = _config.head.label;
                        option.value = "";
                        select.appendChild(option);
                        let _selected = null;
                        if(that.filters.hasOwnProperty(_config.data)) {
                            _selected = that.filters[_config.data];
                        }
                        for (let i = 0; i<=_config.source.length; i++){
                            let opt = document.createElement('option');
                            opt.value = _config.source[i];
                            opt.text = _config.source[i];
                            if(_selected !== null && opt.value === _selected) {
                                opt.selected = true;
                            }
                            select.appendChild(opt);
                        }

                        header.innerHTML = "";
                        header.appendChild(select);
                        break;
                }
            };
            this.settings.beforeOnCellMouseDown = function (event, coords) {
                if (coords.row === -1 && event.realTarget.nodeName === 'INPUT') {
                    event.stopImmediatePropagation();
                    this.deselectCell();
                }
                if (coords.row === -1 && event.realTarget.nodeName === 'SELECT') {
                    event.stopImmediatePropagation();
                    this.deselectCell();
                }
            };

            /*
            this.settings.afterRender = function (change, source) {
                $('.select2').select2();
                var _el = document.getElementById(that.headerFocus)
                if(_el) {
                    _el.focus();
                }
            }*/

            Handsontable.renderers.registerRenderer('defaultActionRenderer', this.RendererDefaultAction);
            Handsontable.renderers.registerRenderer('TextDbField', this.RendererTextDbField);
            Handsontable.renderers.registerRenderer('NumericDbField', this.RendererNumericDbField);
            Handsontable.renderers.registerRenderer('DropdownDbField', this.RendererDropdownDbField);
            Handsontable.renderers.registerRenderer('DateDbField', this.RendererDateDbField);
            Handsontable.renderers.registerRenderer('AutocompleteDbField', this.RendererAutocompleteDbField);


            this.settings.colHeaders = this.colHeaders;
            this.settings.columns = this.columns;

            this.settings.startCols = this.colHeaders.length;
        },
        _parseComponents: function(components,content) {
            for(const k in components) {
                if (!components.hasOwnProperty(k)) {
                    continue;
                }
                let _c = components[k];
                if(k === 'Navbar') {
                    content+= this._getNavbar(_c);
                    this._setupNavbar();
                }
                if(k === 'Paginator') {
                    this._setupPaginator();
                }
            }
            return content;
        },

        _setupPaginator: function() {
            let that = this;

            this.Paginator = new PaginatorHelper();
            this.Paginator.config.DomDestination = this.config.DomElements.Paginator;
            this.Paginator.config.DomPaginatorLink = this.config.DomElements.PaginatorLink;


            $(document).off( 'click', '.pagination a.'+this.config.DomElements.PaginatorLink);
            $(document).on( 'click',  '.pagination a.'+this.config.DomElements.PaginatorLink, function( event ) {
                let _page = $(this).data('page');
                that.page = _page;
                that.Search(that.find,_page,1);
            });
        },

        _getNavbar: function(_navbarSetup) {
            let that = this;

            let _navbarLabel = '';
            if(_navbarSetup.hasOwnProperty('Label')) {
                _navbarLabel = _navbarSetup.Label;
            }
            let _searchForm = '';
            if(_navbarSetup.hasOwnProperty('SearchForm') && _navbarSetup.SearchForm !== null) {
                _searchForm =
                    '                <form class="form-inline my-2 my-lg-0" method="post" onsubmit="return false;">\n' +
                    '                        <input type="text" class="form-control mr-sm-2" name="find" id="'+_navbarSetup.SearchForm.domId+'" placeholder="Ara">\n' +
                    '                </form>\n';
                $(document).off('keyup','#'+_navbarSetup.SearchForm.domId).on('keyup','#'+_navbarSetup.SearchForm.domId, function(e) {
                    e.preventDefault();
                    let find = $(this).val();
                    that.find = find;
                    that.Search(find,that.page,0);
                });
            }

            let _buttons = {};
            if(_navbarSetup.hasOwnProperty('Buttons') && _navbarSetup.Buttons !== null) {
                for (const key in _navbarSetup.Buttons) {
                    if (_navbarSetup.Buttons.hasOwnProperty(key)) {
                        let config = _navbarSetup.Buttons[key];
                        let _data = '';
                        let _append = {};

                        if(config.hasOwnProperty('Data') && config.Data !== null ) {
                            for(const key in config.Data) {
                                _data+= ' data-'+key+'="'+config.Data[key]+'" ';
                            }
                        }

                        if(config.hasOwnProperty('Append') && config.Append !== null ) {
                            for(const a in config.Append) {
                                _append[a]= config.Append[a];
                            }
                        }

                        let btnAppend = JSON.stringify(_append);
                        _buttons[key] = '<button type="button" class="'+config.Class+'" data-url="'+config.Uri+'" data-type="post"  data-nohistory="yes" data-scrolltotop="yes" title="'+config.Title+'" data-append='+btnAppend+' '+_data+' ><i class="'+config.Icon+'" aria-hidden="true"></i> &nbsp; '+config.Label+'</button>';
                    }
                }
            }

            if(_navbarSetup.hasOwnProperty('DefaultButtons') && _navbarSetup.DefaultButtons !== null) {
                for (const key in _navbarSetup.DefaultButtons) {
                    if (_navbarSetup.DefaultButtons.hasOwnProperty(key)) {
                        if(key === 'dropdown') {
                            _buttons['dropdown'] = ''+
                                '      <div class="btn-group" role="group">\n' +
                                '         <button id="hot_bar_field_dropdown" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\n' +
                                '            <i class="fa fa-eye" aria-hidden="true"></i> &nbsp; Göster\n' +
                                '         </button>\n' +
                                '         <div class="dropdown-menu" aria-labelledby="hot_bar_field_dropdown">\n' +
                                ''+this.fieldOptions+'\n'+
                                '         </div>\n' +
                                '      </div>\n';
                        }
                        if(key === 'print') {
                            _buttons['print'] = '      <button type="button" class="btn btn-secondary button-print-data"><i class="fa fa-print" aria-hidden="true"></i> Yazdır</button>';
                        }
                        if(key === 'excel') {
                            _buttons['excel'] = '      <button type="button" class="btn btn-secondary button-xls-data"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>\n';
                        }
                    }
                }
            }

            let _buttonsHtml = '';
            for (const key in _buttons) {
                if (_buttons[key]) {
                    _buttonsHtml+=_buttons[key];
                }
            }

            let _btnGroup = '';
            if(_buttonsHtml.length > 2) {
                _btnGroup = ''+
                '<div class="navbar-nav mr-auto">'+
                '   <div class="btn-group" role="group" aria-label="HOT Navbar Button Group">\n' +
                '       '+_buttonsHtml+' \n'+
                '   </div>'+
                '</div>'
            }

            let _reloadUrl = 'javascript:void(0)';
            let _reloadClass = '';
            if(this.config.Routes.hasOwnProperty('Reload')) {
                _reloadUrl = this.config.Routes.Reload;
                _reloadClass = 'xjhref';
            }

            let _html =
                '<header class="navbar navbar-expand-md d-print-none">'+
                '    <div class="container-fluid">'+
                '        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">'+
                '           <a class="navbar-brand '+_reloadClass+'" href="'+_reloadUrl+'" data-nohistory="yes" data-type="post">' +
                '               <i class="fa fa-circle fa-fw navbar-ajax-indicator"></i>'+
                '               <span class="sr-only">Loading...</span> ' + _navbarLabel +
                '           </a>' +
                '        </h1>'+
                '                <ul class="navbar-nav">'+
                '                    <li class="nav-item">'+
                '                        <div class="btn-group flex-wrap btn-group-justified" role="toolbar" aria-label="App Navigation" data-toggle="buttons">'+
                '                            '+_btnGroup+' \n'+
                '                        </div>'+
                '                    </li>'+
                '                </ul>'+
                '                <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">'+
                '                   '+_searchForm+' \n'+
                '                </div>'+
                '    </div>'+
                '</header>';

            return _html;
        },
        _setupNavbar: function() {
            let that = this;
            $(document).off( 'click','.dropdown-menu a.'+this.config.dropdownClass);
            $(document).on( 'click','.dropdown-menu a.'+this.config.dropdownClass, function( event ) {
                let $target = $( event.currentTarget ),
                    val = $target.attr( 'data-value' ),
                    head = $target.attr( 'data-colhead' ),
                    $inp = $target.find( 'input' ),
                    idx;

                if(that.config.Fields[val].IsVisible === true) {
                    that.config.Fields[val].IsVisible = false;
                    setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
                } else {
                    that.config.Fields[val].IsVisible = true;
                    setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
                }
                $( event.target ).blur();
                //that.AfterInit();
                return false;
            });


            $(document).off( 'click', '.button-print-data').on( 'click',  '.button-print-data', function( event ) {
                that.Print();
                return false;
            });

            $(document).off( 'click', '.button-pdf-data').on( 'click',  '.button-pdf-data', function( event ) {
                that.Pdf();
                return false;
            });

            $(document).off( 'click', '.button-xls-data').on( 'click',  '.button-xls-data', function( event ) {
                that.Xls(event);
                return false;
            });
        },
        _getContent: function(content) {
            content+=
                '<div id="'+this.config.DomElements.HotSelector+'" class="handson-helper-container"></div>\n' +
                '<div class="'+this.config.DomElements.Paginator+'  text-right"></div>\n' +
                '<div id="'+this.config.DomElements.HotSelector+'_export_container" style="display: none;"></div>\n';
            return content;
        },
        _prepareHead: function(el) {
            let ret = '';
            switch (el.HeadConfig.type) {
                case "text":
                    ret = el.HeadConfig.label;
                    break;
                case "select2":
                    var _opts;
                    if(el.HeadConfig.data.source === 'config') {
                        _opts = Util.renderOptions(Util.array2opArray(el.Config.source),'');
                    }
                    ret = '<select class="form-control input-sm select2 select2-hidden-accessible" style="width: 100%;"><option value=""> '+el.HeadConfig.label+'</option>'+_opts+'</select>';
                    break;
                case "find2":
                    ret = '<input type="text" class="" placeholder="'+el.HeadConfig.label+'">';
                    break;
            }
            return ret;
        },
        _appendParams: function(data) {
            if(!this.config.hasOwnProperty('RequestAppend')) {
                return data;
            }
            for (const key in this.config.RequestAppend) {
                if (this.config.RequestAppend.hasOwnProperty(key)) {
                    data[key] = this.config.RequestAppend[key];
                }
            }
            return data;
        },
        Reload: function () {
            this.Search(this.find,this.page,1);
        },
        Print: function() {
            let data = {};
            data.print = 1;
            data.search = '';
            data.filter = JSON.stringify(this.filters);
            data.fields = JSON.stringify(this.dropdownOptions);
            data = this._appendParams(data);
            if(glb.env.hasOwnProperty('is_tabbed') && glb.env.is_tabbed !== null && glb.env.is_tabbed === 1) {
                glb.env.tmpHeaders = Util.CloneObj(glb.env.xHeaders);
                glb.env.tmpHeaders['employer'] = this.config.Employer;
            }

            Main.xjCall(this.config.Routes.Search, 'post',  data,{
                'nohistory':'yes',
                'callback': function (resp) {
                    Export.Print(resp.data);
                }
            });
        },
        Pdf: function() {
            let that = this;
            let data = {};
            data.print = 1;
            data.search = '';
            data.filter = JSON.stringify(this.filters);
            data.fields = JSON.stringify(this.dropdownOptions);
            data = this._appendParams(data);
            if(glb.env.hasOwnProperty('is_tabbed') && glb.env.is_tabbed !== null && glb.env.is_tabbed === 1) {
                glb.env.tmpHeaders = Util.CloneObj(glb.env.xHeaders);
                glb.env.tmpHeaders['employer'] = that.config.Employer;
            }
            Main.xjCall(this.config.Routes.Search, 'post',data,{
                'nohistory':'yes',
                'callback':function (resp) {
                    Export.Pdf(resp.data,that.config.ExportPrefix);
                }
            });
        },
        Xls: function(_e) {
            let that = this;
            let data = {};
            data.print = 1;
            data.search = '';
            data.filter = JSON.stringify(this.filters);
            data.fields = JSON.stringify(this.dropdownOptions);
            data = this._appendParams(data);
            if(glb.env.hasOwnProperty('is_tabbed') && glb.env.is_tabbed !== null && glb.env.is_tabbed === 1) {
                glb.env.tmpHeaders = Util.CloneObj(glb.env.xHeaders);
                glb.env.tmpHeaders['employer'] = that.config.Employer;
            }
            Main.xjCall(this.config.Routes.Search, 'post', data,{
                'nohistory':'yes',
                'callback':function (resp) {
                    $("#"+that.config.DomElements.HotSelector+"_export_container").html(resp.data).promise().done(that.DownloadXLSX(_e));
                }
            });
        },
        DownloadXLSX: function(_e) {
            let elt = document.getElementById(this.config.DomElements.HotSelector+"_search_result_table");
            let wb = XLSX.utils.table_to_book(elt, { sheet : this.config.ExportPrefix });
            let file = XLSX.writeFile(wb, this.config.ExportPrefix+'.xlsx');
            return file;
        },
        Csv: function() {
            var that = this;
            let data = {};
            data.print = 1;
            data.search = '';
            data.filter = JSON.stringify(this.filters);
            data.fields = JSON.stringify(this.dropdownOptions);
            data = this._appendParams(data);
            if(glb.env.hasOwnProperty('is_tabbed') && glb.env.is_tabbed !== null && glb.env.is_tabbed === 1) {
                glb.env.tmpHeaders = Util.CloneObj(glb.env.xHeaders);
                glb.env.tmpHeaders['employer'] = that.config.Employer;
            }
            Main.xjCall(this.config.Routes.Search, 'post',data,{
                'nohistory':'yes',
                'callback':function (resp) {
                    Export.Cvs(resp.data,that.config.ExportPrefix,that.config.DomElements.HotSelector);
                }
            });
        },
        Search: function (value,pageId,paginator) {
            let data = {};
            data.search = value;
            data.page = pageId;
            if(data.page < 1) {
                data.page = 1;
            }
            data.filter = JSON.stringify(this.filters);
            if(paginator > 0 || data.search.length >= 2) {
                data.fields = JSON.stringify(this.dropdownOptions);
                data = this._appendParams(data);
                if(glb.env.hasOwnProperty('is_tabbed') && glb.env.is_tabbed !== null && glb.env.is_tabbed === 1) {
                    glb.env.tmpHeaders = Util.CloneObj(glb.env.xHeaders);
                    glb.env.tmpHeaders['employer'] = this.config.Employer;
                }
                let _options = {
                    'nohistory':'yes'
                }
                if(this.config.hasOwnProperty('callback') && this.config.callback.hasOwnProperty('Load') && typeof this.config.callback.Search === "function") {
                    _options['callback'] = this.config.callback.Search;
                }
                Main.xjCall(this.config.Routes.Search, 'post', data,_options);
            }
        },
        RendererDefaultAction: function (instance, td, row, col, prop, value, cellProperties) {
            let _set = instance.getSettings();
            let _config = _set.columns[col];
            let _buttons = [];
            let rowData = instance.getSourceDataAtRow(row);
            if(_config.hasOwnProperty('renderer') && _config.renderer === 'defaultActionRenderer'
                && _config.hasOwnProperty('buttons'))
            {
                for(const k in _config.buttons){
                    if(!_config.buttons.hasOwnProperty(k)) {
                        continue;
                    }
                    if(value === null || value === false ) {
                        if(rowData.hasOwnProperty('id')) {
                            value = rowData.id;
                        }
                    }
                    _buttons.push(HandsonTableFunctions.RenderActionButton(row,_config.buttons[k],value));
                }
            }
            td.setAttribute('data-dbfield', _config.data);
            $(td).empty().append(_buttons.join("&nbsp;"));
        },

        RendererTextDbField: function (instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            let _config = instance.getSettings().columns[col];

            td.setAttribute('data-dbfield', _config.data);
        },
        RendererNumericDbField: function(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.NumericRenderer.apply(this, arguments);
            let _config = instance.getSettings().columns[col];
            td.setAttribute('data-dbfield', _config.data);
        },
        RendererDropdownDbField: function(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.DropdownRenderer.apply(this, arguments);
            let _config = instance.getSettings().columns[col];
            td.setAttribute('data-dbfield', _config.data);
        },
        RendererDateDbField: function(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.DateRenderer.apply(this, arguments);
            let _config = instance.getSettings().columns[col];
            td.setAttribute('data-dbfield', _config.data);
        },
        RendererAutocompleteDbField: function(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.AutocompleteRenderer.apply(this, arguments);
            let _config = instance.getSettings().columns[col];
            td.setAttribute('data-dbfield', _config.data);
        }
    };
};

var HandsonTableFunctions = function () {
    return {
        RenderActionButton: function(row,config,value) {
            let _data = '';
            let _append = {};
            if(config.hasOwnProperty('Data') && config.Data !== null ) {
                for(const key in config.Data) {
                    _data+= ' data-'+key+'="'+config.Data[key]+'" ';
                }
            }

            if(config.hasOwnProperty('Append') && config.Append !== null ) {
                for(const a in config.Append) {
                    _append[a]= config.Append[a];
                }
            }
            _append[config.IdKey] = value;
            let btnAppend = JSON.stringify(_append);
            return '<button type="button" class="'+config.Class+'" data-url="'+config.Uri+'" title="'+config.Title+'" data-append='+btnAppend+' '+_data+' ><i class="'+config.Icon+'" aria-hidden="true"></i></button>';
        },
        UpdateTown: function(change,source,that) {
            if (source === 'loadData') { return;}

            if(change[0][1] !== 'city_id' || source !== 'edit') {
                return;
            }

            var row = change[0][0];
            var col = change[0][1];
            var vOld = change[0][2];
            var vNew = change[0][3];

            var _col = that.HOT.propToCol('town_id');
            that.HOT.setDataAtCell(row, _col, null);
            that.HOT.setCellMeta(row,_col,'source','');
        },
        SetTownSource: function(change,source,that)  {
            var _colC = that.HOT.propToCol('city_id');
            var _colT = that.HOT.propToCol('town_id');
            var tableData = that.HOT.getData();
            var tot_rows = tableData.length;
            for(var row=0; row < tot_rows; ++row)  {
                var city = that.HOT.getDataAtCell(row, _colC);
                that.HOT.setCellMeta(row,_colT,'source','');
            }
        },
        CellUpdate: function(change,source,that) {
            // If you are looking for cell updater callback, check php side Load()
            if (source === 'loadData') { return;}
            $('.navbar-ajax-indicator').css('color', 'green');

            let rowData = that.HOT.getSourceDataAtRow(change[0][0]);

            let data = {};
            data.db_id =  Object.keys(rowData)[0];
            data.db_field = change[0][1];
            data.db_old = change[0][2];
            data.db_new = change[0][3];

            if(glb.env.hasOwnProperty('is_tabbed') && glb.env.is_tabbed !== null && glb.env.is_tabbed === 1) {
                glb.env.tmpHeaders = Util.CloneObj(glb.env.xHeaders);
                glb.env.tmpHeaders['employer'] = that.config.Employer;
            }
            Main.xjCall(that.config.Routes.CellUpdate, 'post', data,{'nohistory':'yes'});
        }
    }
}();


var i18n = {
    previousMonth	: 'Önceki Ay',
    nextMonth		: 'Sonraki Ay',
    months 			: ['Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos','Eylül',"Ekim","Kasım","Aralık"],
    weekdays		: [" pazar "," pazartesi "," salı "," çarşamba "," perşembe "," cuma "," cumartesi "],
    weekdaysShort	: ['Paz', 'Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt']
};
