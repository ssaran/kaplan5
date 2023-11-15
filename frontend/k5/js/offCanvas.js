/*jshint esversion: 8 */

let OffCanvas = function () { return {
    Generate: function(domId,title,body,location="start",close="right") {
        let _headerContent;
        if(title !== null) {
            if(title && title !== '') {
                _headerContent = OffCanvas.tplHeader(title,domId,close);
            }
        } else {
            _headerContent = null;
        }
        OffCanvas.populate(domId,_headerContent,OffCanvas.tplBody(body,domId));
    },
    populate : function (domId,_headerContent,_bodyContent) {
        let _offCanvas;
        let _domObject = document.getElementById(domId);
        if (_domObject) {
            $('#'+domId+'_offcanvas_header').html(_headerContent);
            $('#'+domId+'_offcanvas_body').html(_bodyContent);

            _offCanvas = bootstrap.Offcanvas.getInstance('#'+domId);
        } else {
            let _layoutContent = document.getElementById("layout_content");
            _layoutContent.appendChild(OffCanvas.tplOffcanvas(domId,_headerContent,_bodyContent ));
            _offCanvas = new bootstrap.Offcanvas('#'+domId);
        }
        _offCanvas.show();
        $(document).off('click','#'+domId+'_btn_close_offcanvas').on('click','#'+domId+'_btn_close_offcanvas',function (){
            _offCanvas.hide();
        });
    },
    tplOffcanvas: function (modalID,dialog) {
        return Tpl.Node('div',false,{
            'class':'modal fade show ',
            'id':modalID,'role':'dialog',
            'tabindex':'-1',
            'aria-labelledby':modalID+'-Label',
            'style':'display:none;',
            'data-bs-backdrop':'false'
        },false,[dialog]);
    },
    tplBody: function (bodyContent,domID) {
        let body = Tpl.Dom('div',{'class':'offcanvas-body','id':domID+'_offcanvas_body'});
        body.appendChild(bodyContent);
        return body;
    },
    tplHeader: function (title,domId,close="right") {
        title = typeof title !== 'undefined' ? title : '&nbsp';

        let header = Tpl.Dom('div',{'class':'offcanvas-header','id':domID+'_offcanvas_header'});
        let headerTitle = Tpl.Dom('div',{'class':'offcanvas-title','id':domID+'_offcanvas_header_title'});
        headerTitle.innerHTML = title;
        header.appendChild(headerTitle);

        if(close) {
            let _c = Tpl.Dom('button',{'id':domId+"_btn_close_offcanvas",'class':'btn-close','aria-label':'Close','offcanvas':'modal','type':'button'});
            header.appendChild(_c);
        }
        return header;
    }
};
}();

