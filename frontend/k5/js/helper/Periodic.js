function Periodic() {
    this._config = {};
    this._cpPanel = {};
    this._picker = null;
    this.activeDate = null;
    this.range = "day";
    this.mealID = null;
}

Periodic.prototype.Setup = function() {
    this._config.Pikaday = {};
    this._config.Route = {};
    this._cpPanel = {};
    this._cpPanel.daily = {};
    this._cpPanel.weekly = {};
    this._cpPanel.monthly = {};
};

Periodic.prototype.SetRoute = function (strKey,strRoute) {
    this._config.Route[strKey] = strRoute;
};

Periodic.prototype.SetDate = function (strDate) {
    this.activeDate = strDate;
};


Periodic.prototype.SetRange = function (range) {
    this.range = range;
};

Periodic.prototype.SetDomDestination = function (strDomDestination) {
    this._config.DomDestination = strDomDestination;
};

Periodic.prototype.SyncDate = function (route,da,dom_destination) {
    var _data = {};
    _data.date = da;
    _data.dom_destination = dom_destination;
    Main.xhrFetch(route, "POST", "json", _data);
};

Periodic.prototype.GetPlan = function() {
    var _data = {};
    _data.date = this.activeDate;
    _data.dom_destination = this._config.DomDestination;
    Main.xhrFetch(this._config.Route.Plan, "POST", "json", _data);
};

Periodic.prototype.SetTimeNavigation = function () {
    switch(this.range) {
        case "day": this.SetTimeNavigation_DAY(); break;
        case "week": this.SetTimeNavigation_WEEK(); break;
    }
};

Periodic.prototype.SetupPicker = function (pickerFormat,pickerField,triggerField) {
    this._config.Pikaday.Format = pickerFormat;
    this._config.Pikaday.Field = pickerField;
    this._config.Pikaday.Trigger = triggerField;
    this._config.Pikaday.UsageFormat = "YYYY-MM-DD";
};

Periodic.prototype.InitPicker = function () {
    if(this._picker != null) {
        this._picker.destroy();
    }
    var _c = this._config.Pikaday;
    this._picker = new Pikaday({
        field: document.getElementById(_c.Field),
        format: _c.Format,
        trigger: document.getElementById(_c.Trigger),
        onSelect: function(date) {
            var _date = moment(this._picker.toString(), _c.Format).toDate();
            this.activeDate = moment(_date).format(_c.UsageFormat);
            this.SetTodayCover();
            this.GetPlan();
            return null;
        },
        onOpen: function () {
            this._picker.setDate(this.activeDate);
        }
    });
};

Periodic.prototype.SetTodayCover = function () {
    var _date = moment(this.activeDate, this._config.Pikaday.UsageFormat).toDate();
    var _current = moment(_date).locale('tr').format("dddd, MMMM Do YYYY");
    var todayCover = document.getElementById("today_cover");
    var currentDateCover = document.getElementById("current_date_cover");
    if(todayCover == null) {
        console.info("today_cover dom object not found");
        return false;
    }
    if(currentDateCover == null) {
        console.info("current_date_cover dom object not found");
        return false;
    }

    todayCover.innerHTML = _current;
    var label = ""
    if(this.range == "day") {
        label = moment(_date).dayOfYear();
    }  else if(this.range == "week") {
        label = moment(_date).week();
    }
    //tagName,id=false,className='',innerHtml=false,dataset=false,custom=false
    var link = Tpl.newElement('a','','btn btn-default btn-sm link-void production-time-select',label,
        {action : "current"},
        []
    );

    currentDateCover.innerHTML = '';
    currentDateCover.appendChild(link);
};

Periodic.prototype.SetNavButtons = function (label) {
    var prevDateCover = document.getElementById("prev_date_cover");
    var currentDateCover = document.getElementById("current_date_cover");
    var nextDateCover = document.getElementById("next_date_cover");

    var prevLink = Tpl.newElement('a','','btn btn-default btn-sm  link-void production-time-select','<i class="fa fa-backward" aria-hidden="true"></i>',
        {action : "previous"}, []
    );
    var currentLink = Tpl.newElement('a','','btn btn-default btn-sm link-void production-time-select',label,
        {action : "current"}, []
    );
    var nextLink = Tpl.newElement('a','','btn btn-default btn-sm link-void production-time-select','<i class="fa fa-forward" aria-hidden="true"></i>',
        {action : "next"}, []
    );

    prevDateCover.innerHTML = '';
    prevDateCover.appendChild(prevLink);

    currentDateCover.innerHTML = '';
    currentDateCover.appendChild(currentLink);

    nextDateCover.innerHTML = '';
    nextDateCover.appendChild(nextLink);
}

Periodic.prototype.SetTimeNavigation_DAY = function () {
    var _date = moment(this.activeDate, this._config.Pikaday.UsageFormat).toDate();
    this.SetTodayCover();
    this.SetNavButtons(moment(_date).dayOfYear());
    this.InitPicker();
};

Periodic.prototype.SetTimeNavigation_WEEK = function () {
    var _date = moment(this.activeDate, this._config.Pikaday.UsageFormat).toDate();
    this.SetTodayCover();
    this.SetNavButtons(moment(_date).week());
    this.InitPicker();
};

Periodic.prototype.SetDestinationDate = function (Destination) {
    var _date = moment(this.activeDate, this._config.Pikaday.UsageFormat).toDate();
    if(Destination == "current") {
        this.activeDate = moment().format(this._config.Pikaday.UsageFormat)
    }

    if(Destination == "previous") {
        if(this.range == "day") {
            this.activeDate = moment(_date).add(-1, 'days').format(this._config.Pikaday.UsageFormat)
        } else if(this.range == "week") {
            this.activeDate = moment(_date).add(-1, 'weeks').format(this._config.Pikaday.UsageFormat)
        }
    }

    if(Destination == "next") {
        if(this.range == "day") {
            this.activeDate = moment(_date).add(1, 'days').format(this._config.Pikaday.UsageFormat)
        } else if(this.range == "week") {
            this.activeDate = moment(_date).add(1, 'weeks').format(this._config.Pikaday.UsageFormat)
        }
    }
    this.SetTodayCover();
    this.GetPlan();
};