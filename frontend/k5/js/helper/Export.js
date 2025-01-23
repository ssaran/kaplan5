var Export = function () {
    return {
        BaseUrl: glb.env.loc.origin,
        Print: function(data) {

            var meta = document.createElement('meta');
            meta.charset = 'utf-8';
            var w = window.open();
            setTimeout(function () {
                $(w.document.head).append(meta);
                $(w.document.head).append(Ui.newStyle(glb.env.loc.origin+"/ext/datatables/datatables.min.css"));
                $(w.document.body).html(data);
            },1000)
        },
        Pdf: function(data,filename) {
            console.info("Export Pdf");
            console.info(data);
            var meta = document.createElement('meta');
            meta.charset = 'utf-8';
            var w = window.open();

            var specialElementHandlers = {
                '#editor': function(element, renderer){
                    return true;
                },
                '.controls': function(element, renderer){
                    return true;
                }
            };

            setTimeout(function () {
                $(w.document.head).append(meta);
                $(w.document.head).append(Ui.newStyle(glb.env.loc.origin+"/ext/datatables/datatables.min.css"));
                $(w.document.head).append(Ui.newScript(glb.env.loc.origin+"/ext/jsPDF/jspdf.min.js"));

                var doc = new jsPDF("l","mm","a4")
                doc.fromHTML(data, 15, 15, {});
                doc.autoPrint()
                doc.save(filename+'.pdf')

            },1000)
        },
        Xls: function (data,filename,domPrefix) {
            var w = window.open(glb.env.loc.origin+"/xlsx");
            var data = data;
            data = data+'<a id="'+filename+'-xlsx" onclick="DownloadXlsX(\''+filename+'\',\''+domPrefix+'\')" href="javascript:void(0);" class="btn btn-default xls-data"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a>\n';


            setTimeout(function () {
                $(w.document.body).html(data)
                  setTimeout(function () {
                      DownloadXlsX(filename,domPrefix);
                },200);
            },600)
        },
        Csv: function (data,filename,domPrefix) {

        }
    };
}();
