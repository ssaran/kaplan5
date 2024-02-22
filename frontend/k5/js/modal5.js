/*jshint esversion: 8 */

let Modal5 = function () { return {
    Success: function (message,title=null,size='small') {
        Modal5.Alert(message,'success',title,size)
    },
    Info: function (message,title=null,size='small') {
        Modal5.Alert(message,'info',title,size)
    },
    Error: function (message,title=null,size='small') {
        Modal5.Alert(message,'error',title,size)
    },
    Alert: function (message,type='info',title=null,size="small") {
        var _type = ''
        switch (type){
            case 'error':
                _type = '<div class="modal-status bg-danger"></div><div class="modal-body text-center py-4"><span class="badge bg-red text-red-fg"><i class="fas fa-exclamation-triangle fa-2x"></i></span><br><br>';
                break;
            case 'success':
                _type = '<div class="modal-status bg-success"></div><div class="modal-body text-center py-4"><span class="badge bg-success text-success-fg"><i class="fas fa-check-circle fa-2x"></i></span><br><br>';
                break;
            case 'info':
            default:
                _type = '<div class="modal-status bg-info"></div><div class="modal-body text-center py-4"><span class="badge bg-info text-info-fg"><i class="fas fa-info-circle fa-2x"></i></span><br><br>';
                break;
        }
        let mBody = '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>'+_type+'<h3>'+title+'</h3><div class="text-secondary">'+message+'</div></div>';
        let mTitle = (title === null) ? '' : title;
        Modal5.Get("alert_"+Util.GenerateId(10),mTitle,mBody,'',size,null)
    },
    Get: function(modalID,title,body,footer,modalSize='medium',close="right",isIFrame=false,removeBackdrop=null) {
        if(document.body === null) { return; }
        modalSize = (glb.env.isMobile === true) ? 'full' : modalSize;

        let _header = '';
        if(title !== null) {
            if(title && title !== '') {
                _header = Modal5.tplHeader(title,modalID,close);
            }
        } else {
            _header = null;
        }


        let _body = Modal5.tplBody(body,modalID,isIFrame);
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
            modalSize = typeof modalSize !== 'undefined' ? modalSize: 'medium';
            let _content = document.getElementById("layout_content");
            _content.appendChild(Modal5.tplModal(modalID, Modal5.tplDialog(modalID,_modalContent, modalSize),removeBackdrop));
            let _modal = new bootstrap.Modal('#'+modalID);
            _modal.show();

            $(document).off('click','#'+modalID+'_btn_close').on('click','#'+modalID+'_btn_close',function (){
                _modal.hide();
            });
        }
    },
    tplModal: function (modalID,dialog,removeBackdrop=null) {
        let _modalAttribs = {'class':'modal fade show', 'id':modalID,'role':'dialog', 'tabindex':'-1', 'aria-labelledby':modalID+'-Label', 'style':'display:none;'}
        if(removeBackdrop !== null) {
            _modalAttribs['data-bs-backdrop'] = 'false';
        }
        return Tpl.Node('div',false,_modalAttribs,false,[dialog]);
    },
    tplDialog: function (modalID,content,modalSize) {
        modalSize = typeof modalSize !== 'undefined' ? modalSize: 'medium';
        let modalClass = '';
        switch (modalSize) {
            case "small": modalClass = 'modal-sm modal-dialog-centered'; break;
            case "medium": modalClass = 'modal-md modal-dialog-centered'; break;
            case "large": modalClass = 'modal-lg modal-dialog-centered'; break;
            case "full": modalClass = 'modal-fullscreen modal-dialog-centered'; break;
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
    tplHeader: function (title,modalID,close="right") {
        title = typeof title !== 'undefined' ? title : '&nbsp';

        let header = Tpl.Node('div',false,{'class':'modal-header pl-3 pr-3 pt-1 pb-1'},false,[
            Tpl.Node('div',title,{'class':'modal-title w-100 d-print-none','id':modalID+'_title'})
        ])
        let _c = '';

        if(close) {
            if(close === 'left') {
                _c = Tpl.Node('button','<i class="far fa-chevron-left"></i>',{'id':modalID+"_btn_close",'class':'btn btn-link','aria-label':'Close','data-bs-dismiss':'modal','type':'button'});
                header.prepend(_c);
            } else {
                _c = Tpl.Node('button',false,{'id':modalID+"_btn_close",'class':'btn-close','aria-label':'Close','data-bs-dismiss':'modal','type':'button'});
                header.appendChild(_c);
            }

        }
        return header;
    },
    tplBody: function (body,modalID,isIframe=false) {
        let _gut = (isIframe === false) ? 'p-1 p-md-3' : 'p-0 m-0'
        return Tpl.Node('div',body,{'class':'modal-body '+_gut,'id':modalID+'_body'});
    },
    tplFooter: function (footer,modalID) {
        return Tpl.Node('div',footer,{'class':'modal-footer','id':modalID+'_footer'});
    }
};
}();

