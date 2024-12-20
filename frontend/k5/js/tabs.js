/*jshint esversion: 8 */
let Tabs = function () { return {
    Add: function(setup) {
        let _tabNav = document.getElementById(setup.ApiKey+'_tab_link_container');
        let _tabContent = document.getElementById(setup.ApiKey+'_tab_content_container');
        let domTabBase = setup.ApiKey+'_'+setup.TabKey;
        let targetLinkContainer = domTabBase+'_tab_link_container';

        let tabCheck = document.getElementById('basetab_navitem_'+tabId);
        if(!tabCheck) {
            _tabNav.appendChild(Tabs.tplNav(domTabBase,setup.Title));
            _tabContent.appendChild(Tabs.tplContent(domTabBase,setup.Body));
            $('#'+targetLinkContainer+' li:last-child a:first')[0].click();
        } else {
            tabCheck.innerHTML = setup.Body;
            $('#'+domTabBase+'_nav_item').click();
        }

    },
    tplNav: function (domTabBase,title) {
        $(".basetab-navlink").removeClass('active');
        let tDomId = 'basetab_pill_'+tabId;
        let pDomId = 'basetab_pane_'+tabId;

        return Tpl.Node('li',false,{'class':'nav-item','id':domTabBase+'_nav_item','role':'presentation'},false,[
            Tpl.Node('a',false,{'class':'nav-link active','href':'#'+domTabBase+'_tab','id':domTabBase+'_trigger','role':'tab','aria-controls':domTabBase+'_tab','aria-selected':'true','data-bs-toggle':'pill'}
                ,{},[
                    Tpl.Node('span',title+' &nbsp'),
                    Tpl.Node('button',false,{'type':'button','title':'Kapat','class':'btn-close close basetab-pane-close'},{'domtabbase':domTabBase}),
                ])
        ]);


    },
    tplContent: function (domTabBase,content) {
        $(".k5-tab-content").removeClass('fade active show');//.removeClass('fade active show').removeClass('fade active show');
        return Tpl.Node('div',content,{'class':'tab-pane k5-tab-content fade active show','id':domTabBase+'_tab','role':'tabpanel','aria-labelledby':domTabBase+'_trigger'});
    }
};
}();

$(document).off('click','.basetab-pane-close').on('click','.basetab-pane-close',function (evt){
    let domTabBase = $(this).data('domtabbase')
    let targetTabNavItem = domTabBase+'_nav_item';
    let targetTabPane = domTabBase+'_tab';
    let targetLinkContainer = domTabBase+'_tab_link_container';
    $('#'+targetTabNavItem).remove();
    $('#'+targetTabPane).remove();
    $('#'+targetLinkContainer+' li:last-child a:first')[0].click();
});

