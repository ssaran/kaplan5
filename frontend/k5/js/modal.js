let Modal = function () { return {
    GetCallBack: function(modalID,title,body,footer,modalSize,modalWidth,sidebar=null,modalBodyP='',callback=null) {
        modalSize = typeof modalSize !== 'undefined' ? modalSize : 'medium';
        modalWidth = typeof modalWidth !== 'undefined' ? modalWidth : '';
        if(glb.env.isMobile === true) {
            modalSize = 'full';
            modalWidth = '';
        }
        if(sidebar === 'error') {
            modalSize = 'modal-dialog-centered';
        }
        let _modalSelector = "#"+modalID;
        if(document.body != null){
            if(callback !== null) {
                document.body.appendChild(Modal.generate(modalID,title,body,footer,modalSize,modalWidth,sidebar,modalBodyP));
                $(_modalSelector).modal({show: true});
                $(_modalSelector).on('hidden.bs.modal', function () {
                    $(this).data('bs.modal', null);
                    $(_modalSelector).remove();
                });
            } else {
                document.body.appendChild(Modal.generate(modalID,title,body,footer,modalSize,modalWidth,sidebar,modalBodyP));
                $(_modalSelector).modal({show: true});
                $(_modalSelector).on('hidden.bs.modal', callback);
            }

        }
    },
    Get: function(modalID,title,body,footer,modalSize,modalWidth,sidebar=null,modalBodyP='') {
        modalSize = typeof modalSize !== 'undefined' ? modalSize : 'medium';
        modalWidth = typeof modalWidth !== 'undefined' ? modalWidth : '';
        if(glb.env.isMobile === true) {
            modalSize = 'full';
            modalWidth = '';
        }
        if(sidebar === 'error') {
            modalSize = 'modal-dialog-centered';
        }
        let _modalSelector = "#"+modalID;
        if(document.body != null){
            document.body.appendChild(Modal.generate(modalID,title,body,footer,modalSize,modalWidth,sidebar,modalBodyP));
            $(_modalSelector).modal({show: true});
            $(_modalSelector).on('hidden.bs.modal', function () {
                $(this).data('bs.modal', null);
                $(_modalSelector).remove();
            });
        }
    },
    generate: function(modalID,title,body,footer,modalSize,modalWidth,sidebar=null,modalBodyP='') {
        lry = title = typeof title !== 'undefined' ? title : false;
        footer = typeof footer !== 'undefined' ? footer : false;
        modalSize = typeof modalSize !== 'undefined' ? modalSize: 'medium';
        modalWidth = typeof modalWidth !== 'undefined' ? modalWidth : '';
        modalClass = '';
        if(modalSize === 'full') {
            modalClass = 'modal-fullscreen';
        }

        _header = '';
        if(title) {
            _header = Modal.tplHeader(title,modalID);
        }

        _body = Modal.tplBody(body,modalID,modalBodyP);
        _footer = '';
        if(footer) {
            _footer = Modal.tplFooter(footer,modalID);
        }

        return Modal.tplModal(
            modalID,
            Modal.tplDialog(Modal.tplContent(_header,_body,_footer), modalSize, modalWidth,sidebar),
            modalClass
        );
    },
    tpl: function (title,content,footer) {
        let html = '';
        html += '<div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
        html += '   <div class="modal-dialog" role="document">';
        html += '       <div class="modal-content">';
        html += '           <div class="modal-header">';
        html += '               <div class="modal-title" id="exampleModalLabel">'+title+'</div>';
        html += '               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        html += '           </div>';
        html += '           <div class="modal-body">';
        html += '           '+content+'';
        html += '           </div>';
        html += '           <div class="modal-footer">';
        html += '           '+footer+'';
        html += '           </div>';
        html += '       </div>';
        html += '   </div>';
        html += '</div>';
        return html;
    },
    tplModal: function (modalID,dialog,modalClass='') {
        return Tpl.Node('div',false,{'class':'modal fade '+modalClass,'id':modalID,'role':'dialog','tabindex':'-1','aria-labelledby':modalID+'-Label','aria-hidden':'true'},false,[dialog]);
    },
    tplDialog: function (content,modalSize,modalWidth,sidebar=null) {
        modalSize = typeof modalSize !== 'undefined' ? modalSize: 'medium';
        var modalClass = '';
        var sidebarClass = (sidebar !== null && sidebar !== 'error') ? 'modal-dialog-slideout' : '';
        switch (modalSize) {
            case "small": modalClass = 'modal-sm'; break;
            case "medium": modalClass = 'modal-md'; break;
            case "large": modalClass = 'modal-lg'; break;
            case "full": modalClass = 'modal-fullscreen'; break;
        }
        if(sidebar === 'error') {
            modalClass = '';
        }
        if(modalWidth === null) {
            modalWidth = '';
        }
        return Tpl.Node('div',false,{'class':'modal-dialog '+sidebarClass+' '+modalClass+' '+modalWidth,'role':'document'},false,[content]);
    },
    tplContent: function (header,body,footer) {
        content = Tpl.Node('div',false,{'class':'modal-content'});
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

        header = Tpl.Node('div',false,{'class':'modal-header pl-3 pr-3 pt-1 pb-1'},false,[
            Tpl.Node('div',title,{'class':'modal-title','id':modalID+'_title'})
        ])
        if(close) {
            _c = Tpl.Node('button',false,{'id':modalID+"_btn_close",'class':'close','aria-label':'Kapat'},{'dismiss':'modal'},[
                Tpl.Node('span','&times;',{'aria-hidden':'true'})
            ]);
            header.appendChild(_c);
        }
        return header;
    },
    tplBody: function (body,modalID,modalBodyP='') {
        return Tpl.Node('div',body,{'class':'modal-body '+modalBodyP,'id':modalID+'_body'});
    },
    tplFooter: function (footer,modalID) {
        return Tpl.Node('div',footer,{'class':'modal-footer','id':modalID+'_footer'});
    },
    tplHede: function () {
        return "Hede";
    }
};
}();

