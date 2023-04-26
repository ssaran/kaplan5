function PaginatorHelper() {
    return {
        params : {},
        config : {},
        Render: function() {
            var _min = 1;
            var _max = 10;
            if(this.params.last_page > 10) {
                if(this.params.current_page > 5) {
                    _min = this.params.current_page - 4;
                    _max = this.params.current_page + 5;
                    if((this.params.last_page - this.params.current_page) <= 5) {
                        _min = this.params.last_page - 10;
                        _max = this.params.last_page;
                    }
                }
            } else {
                _max = this.params.last_page;
            }

            var _html = '<nav aria-label="Handson Paginator">\n'+
                '  <ul class="pagination pagination-sm justify-content-end">\n' ;

            if(this.params.current_page > 1) {
                _html+= '' +
                    '<li class="page-item"><a href="#" data-page="1" class="page-link '+this.config.DomPaginatorLink+'"> « </a></li>' +
                    '<li class="page-item"><a aria-label="Önceki" href="#" data-page="'+(this.params.current_page - 1)+'" class="page-link '+this.config.DomPaginatorLink+'">  Önceki </a></li>';
            } else {
                _html+= '' +
                    '<li class="page-item disabled"><a href="#" class="page-link" > « </a> </li>' +
                    '<li class="page-item disabled"><a aria-label="Önceki" href="#" class="page-link"> Önceki </a></li>';
            }

            for(var i = _min; i <= _max;i++) {

                var _class = (i == this.params.current_page) ? 'class="page-item active"' : 'class="page-item"';
                _html+=
                    '                                       <li '+_class+'><a href="#" data-page="'+i+'" class="page-link '+this.config.DomPaginatorLink+'">'+i+'</a></li>\n';
            }

            if(this.params.current_page < this.params.last_page) {
                _html+=
                    '                                       <li class="page-item"><a aria-label="Sonraki" href="#" data-page="'+(this.params.current_page + 1)+'" class="page-link '+this.config.DomPaginatorLink+'">Sonraki</a></li>'+
                    '                                       <li class="page-item"><a href="#" data-page="'+this.params.last_page+'" class="page-link '+this.config.DomPaginatorLink+'">»</a></li>';
            } else {
                _html+= '' +
                    '<li class="page-item disabled"><a aria-label="Sonraki" href="#" class="page-link" >Sonraki </a> </li>  \n'+
                    '<li class="page-item disabled"><a href="#" class="page-link"> » </a></li>';

            }

            _html+=
                '                                       <li class="page-item disabled"><a href="#" class="page-link">Toplam : <span class="badge badge-secondary">'+this.params.total+'</span></a></li>';
            _html+=
                '  </ul>\n' +
                '</nav>';

            $("."+this.config.DomDestination).html(_html);
        }
    }
}

/*current_page:1
first_page_url:"http://catering.int/company/bankaccounts/load?page=1"
from:1
last_page:34
last_page_url:"http://catering.int/company/bankaccounts/load?page=34"
next_page_url:"http://catering.int/company/bankaccounts/load?page=2"
path:"http://catering.int/company/bankaccounts/load"
per_page:10
prev_page_url:null
to:10
total:335
*/