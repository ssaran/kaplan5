/*jshint esversion: 8 */

let Modal5 = function () { return {
    Get: function(modalID,title,body,footer,modalSize='medium',callback=null) {
        if(document.body === null) {
            return;
        }

        if(glb.env.isMobile === true) {
            modalSize = 'full';
        }

        let _header = '';
        if(title && title !== '') {
            _header = Modal5.tplHeader(title,modalID);
        }

        let _body = Modal5.tplBody(body,modalID);
        let _footer = '';
        if(footer && footer !== '') {
            _footer = Modal5.tplFooter(footer,modalID);
        }

        let _domModal = document.getElementById(modalID);
        let _modalContent = Modal5.tplContent(_header,_body,_footer);

        if (_domModal) {
            $('#'+modalID+'_modal_dialog').html(_modalContent);
            let _modal = bootstrap.Modal.getInstance('#'+modalID);
            _modal.show();
            $(document).off('click','#'+modalID+'_btn_close').on('click','#'+modalID+'_btn_close',function (){
                _modal.hide();
            });
        } else {
            title = typeof title !== 'undefined' ? title : false;
            footer = typeof footer !== 'undefined' ? footer : false;
            modalSize = typeof modalSize !== 'undefined' ? modalSize: 'medium';

            let modalClass = '';
            if(modalSize === 'full') {
                modalClass = 'modal-fullscreen';
            }

            //document.body.appendChild(Modal5.tplModal(modalID, Modal5.tplDialog(modalID,_modalContent, modalSize), modalClass));
            let _content = document.getElementById("layout_content");
            _content.appendChild(Modal5.tplModal(modalID, Modal5.tplDialog(modalID,_modalContent, modalSize), modalClass));
            let _modal = new bootstrap.Modal('#'+modalID);
            _modal.show();

            $(document).off('click','#'+modalID+'_btn_close').on('click','#'+modalID+'_btn_close',function (){
                _modal.hide();
            });
        }
    },
    tplModal: function (modalID,dialog,modalClass='') {
        return Tpl.Node('div',false,{
            'class':'modal fade show '+modalClass,
            'id':modalID,'role':'dialog',
            'tabindex':'-1',
            'aria-labelledby':modalID+'-Label',
            'style':'display:none;',
            'data-bs-backdrop':'false'
            },false,[dialog]);
    },
    tplDialog: function (modalID,content,modalSize) {
        modalSize = typeof modalSize !== 'undefined' ? modalSize: 'medium';
        let modalClass = '';
        switch (modalSize) {
            case "small": modalClass = 'modal-sm modal-dialog-centered'; break;
            case "medium": modalClass = 'modal-md modal-dialog-centered'; break;
            case "large": modalClass = 'modal-lg modal-dialog-centered'; break;
            case "full": modalClass = 'modal-full-width modal-dialog-centered'; break;
        }
        return Tpl.Node('div',false,{
            'class':'modal-dialog '+modalClass+' ',
            'role':'document',
            'id':modalID+'_modal_dialog'
        },false,[content]);
    },
    tplContent: function (header,body,footer) {
        let content = Tpl.Node('div',false,{'class':'modal-content'});
        if(header) {
            content.appendChild(header);
        }
        content.appendChild(body);
        if(footer) {
            content.appendChild(footer);
        }
        return content;
    },
    tplHeader: function (title,modalID,close) {
        title = typeof title !== 'undefined' ? title : '&nbsp';
        close = typeof close !== 'undefined' ? close : true;

        let header = Tpl.Node('div',false,{'class':'modal-header pl-3 pr-3 pt-1 pb-1'},false,[
            Tpl.Node('div',title,{'class':'modal-title','id':modalID+'_title'})
        ])
        let _c = '';

        if(close) {
            _c = Tpl.Node('button',false,{'id':modalID+"_btn_close",'class':'btn-close','aria-label':'Close','data-bs-dismiss':'modal','type':'button'});
            header.appendChild(_c);
        }
        return header;
    },
    tplBody: function (body,modalID) {
        return Tpl.Node('div',body,{'class':'modal-body','id':modalID+'_body'});
    },
    tplFooter: function (footer,modalID) {
        return Tpl.Node('div',footer,{'class':'modal-footer','id':modalID+'_footer'});
    }

};
}();

