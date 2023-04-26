var Tpl = function () { return {
    fetchData : null,
    setCustomData: function (el,dataset) {
        for(var d in dataset) {
            var data = dataset[d];
            el.dataset[d] = data;
        }
        return el;
    },
    setAttribs: function (el,attirbs) {
        for(var a in attirbs) {
            if(a !== 'dataset') {
                el.setAttribute(a,attirbs[a]);
            } else {
                el = Tpl.setCustomData(el,attirbs[a]);
            }
        }
        return el;
    },
    Node: function (tagName,content=false,attrib=false,dataset=false,childs=false) {
        var node = document.createElement(tagName);
        if(content) {
            var tof = typeof (content);
            switch (tof) {
                case 'string':
                case 'number':
                    node.innerHTML = content;
                    break;
                default:
                    node.appendChild(content);
                    break;
            }
        }
        if(attrib) {
            node = Tpl.setAttribs(node,attrib);
        }
        if(dataset) {
            node = Tpl.setCustomData(node,dataset);
        }
        if(childs) {
            var len = childs.length;
            for (var i = 0; i < len; i++) {
                let _cDom = node.appendChild(childs[i]);
                if(isDomElement(_cDom)) {
                    node.appendChild(childs[i]);
                } else {
                    console.error("Current element is not dom element",typeof _cDom);
                }
            }
        }
        return node;
    },
    Dom: function (tagName,attrib=false,childs=false) {
        let node = document.createElement(tagName);
        if(attrib) {
            node = Tpl.setAttribs(node,attrib);
        }
        if(childs) {
            let tof = typeof (childs);
            switch (tof) {
                case "string":
                case "number":
                    node.innerHTML = childs;
                    break;
                case undefined:
                case "undefined":
                    console.log("Undefined childs",childs);
                    break;
                case "object":
                    try {
                        for (let i = 0; i < childs.length; i++) {
                            if(isDomElement(childs[i])) {
                                node.appendChild(childs[i]);
                            } else {
                                node.append(childs[i]);
                            }
                        }
                    } catch (err) {
                        console.warn("catch",err,"node",node,"childs",childs);
                        console.log("Type of Child",tof);
                        console.log("node",node);
                        console.log("childs",childs);
                        console.log("is dom node",isDomElement(node));
                    }
                    break;
                default:
                    try {
                        if(isDomElement(childs)) {
                            node.appendChild(childs);
                        } else {
                            node.append(childs);
                        }
                    } catch (err) {
                        console.warn("catch",err,"node",node,"childs",childs);
                        console.log("Type of Child",tof);
                        console.log("node",node);
                        console.log("childs",childs);
                    }
                    break;
            }
        }
        return node;
    }
};
}();

var BsTpl = function () { return {
    Badge: function (content,badgeClass='badge-secondary',id=false) {
        var nEl = document.createElement('span');
        nEl.className = 'badge '+badgeClass;
        if(id) { nEl.id = id; }
        if(content) {
            if(typeof (content) == 'string') {
                nEl.innerHTML = content;
            } else {
                nEl.appendChild(content);
            }
        }
        return nEl;
    },
    PullRight: function (content,id=false) {
        var nEl = document.createElement('span');
        nEl.className = 'pull-right';
        if(id) { nEl.id = id; }
        if(content) {
            if(typeof (content) == 'string') {
                nEl.innerHTML = content;
            } else {
                nEl.appendChild(content);
            }
        }
        return nEl;
    }
};
}();

var FaTpl = function () { return {
    Get: function (icon,id=false) {
        var fa = document.createElement('i');
        fa.className = 'fa '+icon;
        if(id) { fa.id = id; }
        return fa;
    }
};
}();

function isDomElement(element) {
    return element instanceof Element || element instanceof HTMLDocument;
}