"use strict";

const _module = class Module {
    constructor(name,prefix) {
        this._name = name;
        this._prefix = prefix;
        this._store = {};
    }

    GetCurrentDomain()
    {
        return window.location.href.split("/")[2];
    }

    Set(index,key,data)
    {
        if(!this._store.hasOwnProperty(index)) {
            this._store[index] = {};
        }

        if(!this._store[index].hasOwnProperty(key)) {
            this._store[index][key] = {};
        }

        this._store[index][key] = data;
    }

    Get(index,key)
    {
        if(!this._store.hasOwnProperty(index)) {
            return false;
        }

        if(!this._store[index].hasOwnProperty(key)) {
            return false;
        }

        return this._store[index][key];
    }

    Log(index,key= null)
    {
        if(!this._store.hasOwnProperty(index)) {
            console.error("Log can't found index : ",index);
            return false;
        }

        if(key !== null && !this._store[index].hasOwnProperty(key)) {
            console.error("Log can't found index key : ",index,key);
            return false;
        }
        if(key === null) {
            console.log("log "+index,this._store[index]);
        } else {
            console.log("log "+index+"."+key,this._store[index][key]);
        }
    }
}
