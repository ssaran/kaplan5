/*jshint esversion: 8 */

let Dialog = function () { return {
    GetModal: function(modalID,title,body,footer,modalSize='medium',close="right",callback=null) {
        if(document.body === null) {
            return;
        }

        if(glb.env.isMobile === true) {
            modalSize = 'full';
        }

        let _header = '';
        if(title !== null) {
            if(title && title !== '') {
                _header = Dialog.modalHeader(title,modalID,close);
            }
        } else {
            _header = null;
        }

        let _body = Dialog.modalBody(body,modalID);
        let _footer = '';
        if(footer && footer !== '') {
            _footer = Dialog.modalFooter(footer,modalID);
        }

        let _domModal = document.getElementById(modalID);
        let _modalContent = Dialog.modalContent(_header,_body,_footer);

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
            _content.appendChild(Dialog.modal(modalID, Dialog.modalDialog(modalID,_modalContent, modalSize)));
            let _modal = new bootstrap.Modal('#'+modalID);
            _modal.show();

            $(document).off('click','#'+modalID+'_btn_close').on('click','#'+modalID+'_btn_close',function (){
                _modal.hide();
            });
        }
    },
    modal: function (modalID,dialog) {
        return Tpl.Dom('div',{
            'class':'modal fade show ',
            'id':modalID,'role':'dialog',
            'tabindex':'-1',
            'aria-labelledby':modalID+'-Label',
            'style':'display:none;',
            'data-bs-backdrop':'false'
            },
            [
                dialog
            ]
        );
    },
    modalDialog: function (modalID,content,modalSize) {
        modalSize = typeof modalSize !== 'undefined' ? modalSize: 'medium';
        let modalClass = '';
        switch (modalSize) {
            case "small": modalClass = 'modal-sm modal-dialog-centered'; break;
            case "medium": modalClass = 'modal-md modal-dialog-centered'; break;
            case "large": modalClass = 'modal-lg modal-dialog-centered'; break;
            case "full": modalClass = 'modal-fullscreen modal-dialog-centered'; break;
        }
        return Tpl.Dom('div',{
            'class':'modal-dialog '+modalClass+' ',
            'role':'document',
            'id':modalID+'_modal_dialog'
        },[
            content
        ]);
    },
    modalContent: function (header,body,footer) {
        let content = Tpl.Dom('div',{'class':'modal-content'});
        if(header) {
            content.appendChild(header);
        }
        content.appendChild(body);
        if(footer) {
            content.appendChild(footer);
        }
        return content;
    },
    modalHeader: function (title,modalID,close="right") {
        title = typeof title !== 'undefined' ? title : '&nbsp';

        let header = Tpl.Dom('div',{'class':'modal-header pl-3 pr-3 pt-1 pb-1'},[
            Tpl.Dom('div',{'class':'modal-title w-100','id':modalID+'_title'},title)
        ])
        let _c = '';

        if(close) {
            if(close === 'left') {
                _c = Tpl.Dom('button',{'id':modalID+"_btn_close",'class':'btn btn-link','aria-label':'Close','data-bs-dismiss':'modal','type':'button'},'<i class="far fa-chevron-left"></i>');
                header.prepend(_c);
            } else {
                _c = Tpl.Dom('button',{'id':modalID+"_btn_close",'class':'btn-close','aria-label':'Close','data-bs-dismiss':'modal','type':'button'});
                header.appendChild(_c);
            }

        }
        return header;
    },
    modalBody: function (body,modalID) {
        return Tpl.Dom('div',{'class':'modal-body p-1 p-md-3','id':modalID+'_body'},body);
    },
    modalFooter: function (footer,modalID) {
        return Tpl.Node('div',{'class':'modal-footer','id':modalID+'_footer'},footer);
    },
    GetToast: function(message,options) {
        let defaultOptions = {
            title: "",
            subtitle: "",
            position: "bottom-right",
            type: "success",
            timeout: 3000
        };
        options = { ...defaultOptions, ...options };

        let _Title = (options.title !== '') ? Tpl.Dom('strong',{'class':'rounded me-2'},options.title) : '';
        let _subTitle = (options.subtitle !== '') ? Tpl.Dom('small',{},options.subtitle) : '';

        let _Toast = Tpl.Dom("div",{"class":"toast","role":"alert","aria-live":"assertive","aria-atomic":"true"},[
            Tpl.Dom("div",{"class":"toast-header"},[
                Tpl.Dom('img',{'src':'...','class':'rounded me-2','alt':'...'}),
                _Title,
                _subTitle,
                Tpl.Dom('button',{'tyoe':'button','class':'btn-close','data-bs-dismiss':'toast','aria-label':'Close'}),
            ]),
            Tpl.Dom('div',{'class':'toast-body'},message)
        ]);

        let _toastCover = document.getElementById('bs5_toast_container');
        _toastCover.appendChild(_toastCover);
    },
};
}();

