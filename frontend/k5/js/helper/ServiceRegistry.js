"use strict";

function ServiceRegistry() {
    this._registry = {};
}

ServiceRegistry.prototype.Setup = function() {
    this._registry = {};
};

ServiceRegistry.prototype.Add = function (strKey,serviceObject,force=false) {
    if(force !== false) {
        if(this._registry.hasOwnProperty(strKey)) {
            return;
        }
    }
    this._registry[strKey] = serviceObject;
};

ServiceRegistry.prototype.Get = function (strKey) {
    if(this._registry.hasOwnProperty(strKey)) {
        return this._registry[strKey];
    }
};

ServiceRegistry.prototype.Delete = function (strKey) {
    if(this._registry.hasOwnProperty(strKey)) {
        delete this._registry[strKey];
    }
};

ServiceRegistry.prototype.List = function () {
    for (var key in this._registry) {
        if (this._registry.hasOwnProperty(key)) {
            console.log(key,this._registry[key]);
        }
    }
};