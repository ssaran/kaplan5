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
    populate : function (domId,_headerContent,_bodyContent,location) {
        let _offCanvas;
        let _domObject = document.getElementById(domId);
        if (_domObject) {
            $('#'+domId+'_offcanvas_header').html(_headerContent);
            $('#'+domId+'_offcanvas_body').html(_bodyContent);
            _offCanvas = bootstrap.Offcanvas.getInstance('#'+domId);
        } else {
            let _body = document.getElementsByTagName("BODY")[0];
            _body.appendChild(OffCanvas.tplOffcanvas(domId,_headerContent,_bodyContent,location));
            setTimeout(function (){
                _offCanvas = new bootstrap.Offcanvas('#'+domId);
            },500)
        }
        console.log("Dom",_domObject);
        console.log("off",_offCanvas);
        _offCanvas.show();
        $(document).off('click','#'+domId+'_btn_close_offcanvas').on('click','#'+domId+'_btn_close_offcanvas',function (){
            _offCanvas.hide();
        });
    },
    tplOffcanvas: function (domId,header,body,location) {
        return Tpl.Dom('div',{
            'class':'offcanvas offcanvas-'+location,
            'id':domId+'_offcanvas',
            'tabindex':'-1',
            'style':'display:none;'
            },
            [
                header,
                body
            ]);
    },
    tplBody: function (bodyContent,domId) {
        let body = Tpl.Dom('div',{'class':'offcanvas-body','id':domId+'_offcanvas_body'},[
            bodyContent
        ]);
        return body;
    },
    tplHeader: function (title,domId,close="right") {
        title = typeof title !== 'undefined' ? title : '&nbsp';

        let header = Tpl.Dom('div',{'class':'offcanvas-header','id':domId+'_offcanvas_header'},[
            Tpl.Dom('div',{'class':'offcanvas-title','id':domId+'_offcanvas_header_title'},title)
        ]);
        if(close) {
                let _c = Tpl.Dom('button',{'id':domId+"_btn_close_offcanvas",'class':'btn-close','aria-label':'Close','offcanvas':'modal','type':'button'});
                header.appendChild(_c);
        }
        return header;
    }
};
}();

