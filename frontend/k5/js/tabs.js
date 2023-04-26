/*jshint esversion: 8 */
let Tabs = function () { return {
    Add: function(tabId,title,body,callback=null) {
        let is_main = (tabId === 'main');
        let tabList = document.getElementById('basetab_list');
        let tabContent = document.getElementById('basetab_content');
        if(is_main) {
            let tabPill = document.getElementById('basetab_pill_main');
            tabPill.innerHTML = title;
            let tabPane = document.getElementById('layout_content');
            tabPane.innerHTML = body;
            $('#basetab_list li:first-child a:first')[0].click();
        } else {
            let tabCheck = document.getElementById('basetab_navitem_'+tabId);
            if(!tabCheck) {
                tabList.appendChild(Tabs.tplPill(tabId,title));
                tabContent.appendChild(Tabs.tplPane(tabId,body));
                $('#basetab_list li:last-child a:first')[0].click();
            }
        }
    },
    Modal2Tab: function (_r) {
        let _title = _r.Modal_Title;
        let _subHeader = '';
        if(_r.hasOwnProperty('Modal_Callback') && _r.Modal_Callback !== null && _r.Modal_Callback.length > 0 && _r.Modal_Callback.charAt(0) === ':') {
            _title = _r.Modal_Callback.substring(1);
            _subHeader = _r.Modal_Title;
        }
        Tabs.Add(_r.Modal_DomID,_title,_subHeader+"<br>"+_r.Modal_Body+"<br>"+_r.Modal_Footer);
    },
    tplPill: function (tabId,title) {
        $(".basetab-navlink").removeClass('active');
        let tDomId = 'basetab_pill_'+tabId;
        let pDomId = 'basetab_pane_'+tabId;
        if(glb.env.bsv === 4) {
            return Tpl.Node('li',false,{'class':'nav-item','id':'basetab_navitem_'+tabId},false,[
                Tpl.Node('a',false,{'class':'nav-link basetab-navlink active','href':'#'+pDomId,'id':tDomId,'role':'tab','aria-controls':pDomId,'aria-selected':"true"}
                    ,{'toggle':'pill'},[
                        Tpl.Node('span',title+' &nbsp'),
                        Tpl.Node('button','<i class="fas fa-window-close"></i>',{'type':'button','title':'Kapat','class':'close basetab-pane-close'},{'tabid':tabId}),
                    ])
            ]);
        } else {
            return Tpl.Node('li',false,{'class':'nav-item','id':'basetab_navitem_'+tabId,'role':'presentation'},false,[
                Tpl.Node('a',false,{'class':'nav-link basetab-navlink active','href':'#'+pDomId,'id':tDomId,'role':'tab','aria-controls':pDomId,'aria-selected':'true','data-bs-toggle':'pill'}
                    ,{},[
                        Tpl.Node('span',title+' &nbsp'),
                        Tpl.Node('button',false,{'type':'button','title':'Kapat','class':'btn-close close basetab-pane-close'},{'tabid':tabId}),
                    ])
            ]);
        }

    },
    tplPane: function (tabId,content) {
        $(".basetab-tabpane").removeClass('fade active show');//.removeClass('fade active show').removeClass('fade active show');
        return Tpl.Node('div',content,{'class':'tab-pane basetab-tabpane fade active show','id':'basetab_pane_'+tabId,'role':'tabpanel','aria-labelledby':'basetab_pill_'+tabId});
    }
};
}();

$(document).off('click','.basetab-pane-close').on('click','.basetab-pane-close',function (evt){
    let targetTabNavItem = 'basetab_navitem_'+$(this).data('tabid');
    let targetTabPane = 'basetab_pane_'+$(this).data('tabid');
    $('#'+targetTabNavItem).remove();
    $('#'+targetTabPane).remove();
    $('#basetab_list li:last-child a:first')[0].click();
});

