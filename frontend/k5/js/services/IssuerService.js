"use strict";

function IssuerService() {
    this._name = '';
    this._prefix = '';
    this._domElements = {};
    this._routes = {};
}

IssuerService.prototype.Setup = function(name,prefix) {
    this._name = name;
    this._prefix = prefix;
    this._domElements = {};
    this._routes = {};
};

IssuerService.prototype.AddDomElement = function (domName,domValue) {
    this._domElements[domName] = domValue;
};

IssuerService.prototype.GetDomElement = function (domName) {
    if(this._domElements.hasOwnProperty(domName)) {
        return this._domElements[domName];
    }
};

IssuerService.prototype.RemoveDomElement = function (domName) {
    if(this._domElements.hasOwnProperty(domName)) {
        delete this._domElements[domName];
    }
};

IssuerService.prototype.ListDomElement = function () {
    for (var key in this._domElements) {
        if (this._domElements.hasOwnProperty(key)) {
            console.log(key,this._domElements[key]);
        }
    }
};

IssuerService.prototype.AddRoute = function (name,url,callbacks=[]) {
    this._routes[name] = new RouteElement(name,url,callbacks);
};

/**
 *
 * @param name
 * @returns {*}
 * @constructor
 */
IssuerService.prototype.GetRoute = function (name) {
    if(this._routes.hasOwnProperty(name)) {
        return this._routes[name];
    }
};

IssuerService.prototype.RemoveRoute = function (name) {
    if(this._routes.hasOwnProperty(name)) {
        delete this._routes[name];
    }
};

IssuerService.prototype.ListRoute = function () {
    for (var key in this._routes) {
        if (this._routes.hasOwnProperty(key)) {
            console.log(key,this._routes[key]);
        }
    }
};

/**
 *
 * @param name
 * @param url
 * @param callbacks
 * @constructor
 */
function RouteElement(name,url,callbacks=[]) {
    this.name = name;
    this.url = url;
    this.callbacks = callbacks;
}