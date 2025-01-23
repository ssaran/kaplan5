"use strict";
/*jshint esversion: 6 */

(function() {
    window.k5.tpl.tabs = function () { return {
        add: function(setup) {
            console.log("Tabset",setup);
            console.log("_tabNav",setup.Employer+'_lobby_main_tab_link_container');
            console.log("_tabContent",setup.Employer+'_lobby_main_tab_content_container');
            let _tabNav = document.getElementById(setup.Employer+'_app_lobby_tab_link_container');
            let _tabContent = document.getElementById(setup.Employer+'_app_lobby_tab_content_container');
            let domTabBase = setup.ApiPrefix+'_'+setup.TabKey;
            let domFirstTabTrigger = setup.Employer+'_app_lobby_main_tab_trigger';
            let domFirstTab = setup.Employer+'_app_lobby_main_tab';
            console.log("first",domFirstTabTrigger)
            console.log("last",domTabBase+'trigger')

            $(document).off('click','#'+domFirstTabTrigger).on('click','#'+domFirstTabTrigger,function (){
                console.log("clicked",this);
                $('#'+domTabBase+'trigger').click();
            })

            let tabCheck = document.getElementById(domTabBase+'_nav_item');
            if(!tabCheck) {
                _tabNav.appendChild(Tabs.tplNav(domTabBase,setup.Title));
                _tabContent.appendChild(Tabs.tplContent(domTabBase,setup.Body));
            } else {
                _tabContent.innerHTML = setup.Body;
            }

            $('.k5-tab-nav').first().find('a:first').tab("show");
            setTimeout(function () {
                $('.k5-tab-nav').first().find('a:last').tab("show");
            },200);

            //$('#'+domFirstTabTrigger).click();
            /*setTimeout(function () {
                $('#'+domTabBase+'trigger').click();

            },300);*/
            /*bootstrap.Tab.getOrCreateInstance(document.querySelector('#'+domFirstTab)).show();
            bootstrap.Tab.getOrCreateInstance(domTabBase+'_tab').show();*/
        },
        tplNav: function (domTabBase,title) {
            $(".k5-tab-nav-link").removeClass('active');

            return k5.tpl.Node('li',false,{'class':'nav-item k5-tab-nav-item','id':domTabBase+'_nav_item','role':'presentation'},false,[
                k5.tpl.Node('a',false,{'class':'nav-link k5-tab-nav-link active','href':'#'+domTabBase+'_tab','id':domTabBase+'_trigger','role':'tab','aria-controls':domTabBase+'_tab','aria-selected':'true','data-bs-toggle':'pill'}
                    ,{},[
                        k5.tpl.Node('span',title+' &nbsp'),
                        k5.tpl.Node('button',false,{'type':'button','title':'Kapat','class':'btn-close close basetab-pane-close'},{'domtabbase':domTabBase}),
                    ])
            ]);


        },
        tplContent: function (domTabBase,content) {
            $(".k5-tab-content").removeClass('fade active show');//.removeClass('fade active show').removeClass('fade active show');
            return Tpl.Node('div',content,{'class':'tab-pane k5-tab-content fade active show','id':domTabBase+'_tab','role':'tabpanel','aria-labelledby':domTabBase+'_trigger'});
        }
    };
    }();
})();


