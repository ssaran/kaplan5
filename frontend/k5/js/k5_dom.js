"use strict";
/*jshint esversion: 6 */

(function() {
    window.k5.dom = (function () {
        return {
            async process(response, callBack = null) {
                // Divide response types into groups for better concurrency
                const cssTasks = [];
                const dataTasks = [];
                const htmlTasks = [];
                const jsTasks = [];

                for (const [key, item] of Object.entries(response)) {
                    if (!item || !item.Type) {
                        console.error(`RESPONSE ELEMENT ${key} UNDEFINED`, item);
                        continue;
                    }

                    switch (item.Type) {
                        case "css":
                            cssTasks.push(this.processCss(item));
                            break;
                        case "data":
                            dataTasks.push(this.processData(item));
                            break;
                        case "html":
                            htmlTasks.push(this.processHtml(item));
                            break;
                        case "katmer":
                            htmlTasks.push(this.processKatmer(item));
                            break;
                        case "modal":
                        case "modal5":
                            htmlTasks.push(this.processModal5(item));
                            break;
                        case "tab":
                            htmlTasks.push(this.processTab(item));
                            break;
                        case "js":
                            jsTasks.push(this.processJs(item));
                            break;
                        case "js_lib":
                            jsTasks.push(this.loadJsLib(item));
                            break;
                        case "js_module":
                            jsTasks.push(this.loadJsModule(item));
                            break;
                    }
                }

                // Process tasks concurrently
                await Promise.all([
                    Promise.all(cssTasks),
                    Promise.all(dataTasks),
                    Promise.all(htmlTasks),
                    Promise.all(jsTasks),
                ]);

                if (callBack && typeof callBack === "function") {
                    callBack(response);
                }
            },

            async processData(item) {
                try {
                    item.Content = JSON.parse(item.Content);
                } catch (e) {
                    console.error("JSON parse error in ui data", e);
                }
            },

            async processHtml(item) {
                if (!item?.Mode) {
                    console.info("Process HTML undefined", item);
                    return;
                }

                const _dest = document.getElementById(item.DomID)
                    || document.getElementById(item.DomDestination)
                    || document.getElementById('layout_content');

                if (!_dest) {
                    console.warn("Destination element not found", item);
                    return;
                }

                const contentWrapper = `<div id="${item.DomID}">${item.Content}</div>`;

                switch (item.Mode) {
                    case 'content-add':
                        _dest.innerHTML = contentWrapper;
                        break;
                    case 'content-append':
                        _dest.insertAdjacentHTML('beforeend', contentWrapper);
                        break;
                    case 'content-prepend':
                        _dest.insertAdjacentHTML('afterbegin', contentWrapper);
                        break;
                    case 'content-replace':
                        _dest.innerHTML = item.Content;
                        break;
                    case 'content-new':
                        const newElement = document.createElement(item.newElementType || "div");
                        newElement.id = item.DomID;
                        newElement.className = item.className || "";
                        newElement.innerHTML = item.Content;
                        document.getElementById(item.parentDomId)?.appendChild(newElement);
                        break;
                    case 'remove':
                        document.getElementById(item.DomID)?.remove();
                        break;
                    case 'layout-clean':
                        _dest.innerHTML = '';
                        break;
                    default:
                        console.warn("Unsupported HTML processing mode", item.Mode);
                }
            },

            async processCss(item) {
                if (document.getElementById(item.DomID)) {
                    if (item.Refresh) {
                        document.getElementById(item.DomID).remove();
                    } else {
                        return; // Skip if not refreshing
                    }
                }

                const linkElement = document.createElement("link");
                linkElement.rel = "stylesheet";
                linkElement.type = "text/css";
                linkElement.href = item.Content;
                linkElement.id = item.DomID;
                linkElement.className = "css-load";

                document.head.appendChild(linkElement);
            },

            async processJs(item) {
                if (!item.Mode) item.Mode = "add";

                const existingScript = document.getElementById(item.DomID);

                if (existingScript) {
                    if (item.Refresh) {
                        existingScript.remove();
                    } else {
                        return; // Skip if not refreshing
                    }
                }

                const scriptElement = document.createElement("script");
                scriptElement.language = "javascript";
                scriptElement.id = item.DomID;
                scriptElement.className = "js-cover";

                if (item.Mode === "add") {
                    scriptElement.text = item.Content;
                } else if (item.Mode === "load") {
                    scriptElement.src = item.Content;
                }

                document.body.appendChild(scriptElement);
            },

            async loadJsLib(item) {
                await this.loadScript(item.Content, item.DomID, false, item.Refresh);
            },

            async loadJsModule(item) {
                await this.loadScript(item.Content, item.DomID, true, item.Refresh);
            },

            async loadScript(src, DomID, isModule = false, refresh = false) {
                if (document.getElementById(DomID)) {
                    if (refresh) {
                        document.getElementById(DomID).remove();
                    } else {
                        return; // Skip if not refreshing
                    }
                }

                const scriptElement = document.createElement("script");
                scriptElement.src = src;
                scriptElement.id = DomID;
                scriptElement.type = isModule ? "module" : "text/javascript";

                document.body.appendChild(scriptElement);

                // Wait for the script to load
                return new Promise((resolve, reject) => {
                    scriptElement.onload = resolve;
                    scriptElement.onerror = reject;
                });
            },

            async processModal5(item) {
                k5.tpl.modal.get(
                    item.Modal_DomID,
                    item.Modal_Title,
                    item.Modal_Body,
                    item.Modal_Footer,
                    item.Modal_Size,
                    item.Modal_Close,
                    item.Config
                );
            },

            async processTab(item) {
                if (!item?.Mode) {
                    console.warn("Process Tab undefined", item);
                    return;
                }
                k5.tpl.tabs.Add(item);
            },

            async processKatmer(item) {
                const _dest = document.getElementById(item.DomDestination) || document.getElementById('layout_content');
                if (!_dest) {
                    console.warn("Katmer destination not found", item);
                    return;
                }

                if (item.Mode === 'content-add') {
                    _dest.innerHTML = item.Content;
                } else if (item.Mode === 'content-append') {
                    _dest.innerHTML += item.Content;
                }
            }
        };
    })();
})();


