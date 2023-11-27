/*jshint esversion: 8 */

let Toast = function () { return {
    Generate: function(domId,title,body,location="start") {
        let _headerContent, _bodyContent;
        _headerContent = (title !== null && title !== '') ? Toast.tplHeader(title,domId,close) : null;
        _bodyContent = (body !== null && body !== '') ? Toast.tplBody(body,domId) : null;

        return Toast.populate(domId,_headerContent,_bodyContent);
    },
    populate : function (domId,_headerContent,_bodyContent,location) {
        return Tpl.Dom('div',{'class':'toast','role':'alert','aria-live':'assertive','aria-atomic':'true'},[
            _headerContent,
            _bodyContent
        ]);
    },
    tplBody: function (bodyContent) {
        let body = Tpl.Dom('div',{'class':'toast-body'},[
            bodyContent
        ]);
        return body;
    },
    tplHeader: function (title) {
        title = typeof title !== 'undefined' ? title : '&nbsp';

        let header = Tpl.Dom('div',{'class':'toast-header'},[
            Tpl.Dom('strong',{'class':'me-auto'},title),
            Tpl.Dom('small',{'class':'text-muted'},"hede"),
            Tpl.Dom('button ',{'class':'btn-close','data-bs-dismiss':'close','aria-label':'Close','type':'button'}),
        ]);
        return header;
    }
};
}();

