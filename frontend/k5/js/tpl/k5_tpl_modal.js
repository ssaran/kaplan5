"use strict";
/*jshint esversion: 6 */

(function() {
    window.k5.tpl.modal = function () { return {
        success: function (message,title=null,size='small') {
            this.alert(message,'success',title,size)
        },
        info: function (message,title=null,size='small') {
            this.alert(message,'info',title,size)
        },
        error: function (message,title=null,size='small') {
            this.alert(message,'error',title,size)
        },
        alert: function (message,type='info',title=null,size="small") {
            var _type = ''
            switch (type){
                case 'error':
                    _type = '<div class="modal-status bg-danger"></div><div class="modal-body text-center py-4"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/></svg></span><br><br>';
                    break;
                case 'success':
                    _type = '<div class="modal-status bg-success"></div><div class="modal-body text-center py-4"><span class="badge bg-success text-success-fg"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg></span><br><br>';
                    break;
                case 'info':
                default:
                    _type = '<div class="modal-status bg-info"></div><div class="modal-body text-center py-4"><span class="badge bg-info text-info-fg"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16"><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2"/></svg></span><br><br>';
                    break;
            }
            let mBody = '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>'+_type+'<h3>'+title+'</h3><div class="text-secondary">'+message+'</div></div>';
            let mTitle = (title === null) ? '' : title;
            this.get("alert_"+k5.util.generateId(10),mTitle,mBody,'',size,null)
        },
        get: function(modalID,title,body,footer,modalSize='medium',close="right",config=null) {
            if(document.body === null) { return; }
            if(modalSize !== 'hcc') {
                modalSize = (k5.env.isMobile === true) ? 'full' : modalSize;
            }

            let _header = '';
            if(title !== null) {
                if(title && title !== '') {
                    _header = this.tplHeader(title,modalID,close);
                }
            } else {
                _header = null;
            }
            if(config === null) {
                config = {
                    'IsIframe':false,
                    'RemoveBackdrop':false,
                    'HasHistory':false,
                    'JsCallbacks':null,
                }
            }

            let _body = this.tplBody(body,modalID,config.IsIframe);
            let _footer = '';
            if(footer && footer !== '') {
                _footer = this.tplFooter(footer,modalID);
            }

            let _domModal = document.getElementById(modalID);
            let _modalContent = this.tplContent(_header,_body,_footer);

            if (_domModal) {
                $('#'+modalID+'_modal_dialog').html(_modalContent);
                let _modal = bootstrap.Modal.getInstance('#'+modalID);
                _modal.show();
                $(document).off('click','#'+modalID+'_btn_close').on('click','#'+modalID+'_btn_close',function (){
                    //_modal.hide();
                    document.getElementById(modalID).remove();
                });
            } else {
                modalSize = typeof modalSize !== 'undefined' ? modalSize: 'medium';
                let _content = document.getElementById("layout_content");
                _content.appendChild(this.tplModal(modalID, this.tplDialog(modalID,_modalContent, modalSize),config.RemoveBackdrop));
                let _modal = new bootstrap.Modal('#'+modalID);
                _modal.show();


                $(document).off('click','#'+modalID+'_btn_close').on('click','#'+modalID+'_btn_close',function (){
                    document.getElementById(modalID).addEventListener('hidden.bs.modal', function () {
                        document.getElementById(modalID).remove();
                    });
                });
                if(config.JsCallbacks !== null) {
                    const eventTypes = ['show', 'shown', 'hide', 'hidden'];
                    eventTypes.forEach(eventType => {
                        if (config.JsCallbacks[eventType]) {
                            document.getElementById(modalID).addEventListener(`${eventType}.bs.modal`, function () {
                                this.jsAddCallbacks(config.JsCallbacks[eventType],modalID);
                            });
                        }
                    });
                }
            }
        },
        tplModal: function (modalID,dialog,removeBackdrop=false) {
            let _modalAttribs = {'class':'modal fade show', 'id':modalID,'role':'dialog', 'tabindex':'-1', 'aria-labelledby':modalID, 'style':'display:none;','aria-hidden':true}
            if(removeBackdrop) {
                _modalAttribs['data-bs-backdrop'] = 'false';
            }
            return k5.tpl.Node('div',false,_modalAttribs,false,[dialog]);
        },
        tplDialog: function (modalID,content,modalSize) {
            modalSize = typeof modalSize !== 'undefined' ? modalSize: 'medium';
            let modalClass = '';
            switch (modalSize) {
                case "hcc": modalClass = 'modal-hcc modal-dialog-centered'; break;
                case "small": modalClass = 'modal-sm modal-dialog-centered'; break;
                case "medium": modalClass = 'modal-md modal-dialog-centered'; break;
                case "large": modalClass = 'modal-lg modal-dialog-centered'; break;
                case "full": modalClass = 'modal-fullscreen modal-dialog-centered'; break;
            }

            return k5.tpl.Node('div',false,{
                'class':'modal-dialog '+modalClass+' ',
                'role':'document',
                'id':modalID+'_modal_dialog'
            },false,[content]);
        },
        tplContent: function (header,body,footer) {
            let content = k5.tpl.Node('div',false,{'class':'modal-content'});
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

            let header = k5.tpl.Node('div',false,{'class':'modal-header pl-3 pr-3 pt-1 pb-1'},false,[
                k5.tpl.Node('div',title,{'class':'modal-title w-100 d-print-none','id':modalID+'_title'})
            ])
            let _c = '';

            if(close) {
                if(close === 'left') {
                    _c = k5.tpl.Node('button','<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/></svg>',{'id':modalID+"_btn_close",'class':'btn btn-link','aria-label':'Close','data-bs-dismiss':'modal','type':'button'});
                    header.prepend(_c);
                } else {
                    _c = k5.tpl.Node('button',false,{'id':modalID+"_btn_close",'class':'btn-close','aria-label':'Close','data-bs-dismiss':'modal','type':'button'});
                    header.appendChild(_c);
                }

            }
            return header;
        },
        tplBody: function (body,modalID,isIframe=false) {
            let _gut = (isIframe === false) ? 'p-1 p-md-3' : 'p-0 m-0'
            return k5.tpl.Node('div',body,{'class':'modal-body '+_gut,'id':modalID+'_body'});
        },
        tplFooter: function (footer,modalID) {
            return k5.tpl.Node('div',footer,{'class':'modal-footer','id':modalID+'_footer'});
        },
        jsAddCallbacks: async function (callbacks = {},modalID) {
            let _cb = [];
            for (const [key, value] of Object.entries(callbacks)) {
                _cb.push(k5.dom.processJs(value))
            }
            await Promise.all(_cb);
        }
    };
    }();
})();


