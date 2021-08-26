!function(e){var t={};function r(n){if(t[n])return t[n].exports;var o=t[n]={i:n,l:!1,exports:{}};return e[n].call(o.exports,o,o.exports,r),o.l=!0,o.exports}r.m=e,r.c=t,r.d=function(e,t,n){r.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},r.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},r.t=function(e,t){if(1&t&&(e=r(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(r.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)r.d(n,o,function(t){return e[t]}.bind(null,o));return n},r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,"a",t),t},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r.p="",r(r.s=11)}([function(e,t){e.exports=window.wp.element},function(e,t){e.exports=window.jQuery},function(e,t){e.exports=window.wp.i18n},function(e,t){e.exports=window.blocksyOptions},function(e,t){e.exports=window.React},function(e,t,r){var n=r(8);function o(e,t,r,n,i){var c=new Error(r,n,i);return c.name="UseFetchError",c.status=e,c.statusText=t,Object.setPrototypeOf(c,Object.getPrototypeOf(this)),Error.captureStackTrace&&Error.captureStackTrace(c,o),c}o.prototype=Object.create(Error.prototype,{constructor:{value:Error,enumerable:!1,writable:!0,configurable:!0}}),Object.setPrototypeOf(o,Error),e.exports=function(e,t,r){var i=(r&&r.depends||t&&t.depends||[]).reduce((function(e,t){return e||!t}),!1);return n(!i&&function(e,t,r){return fetch(e,t).then(r&&r.formatter||t&&t.formatter||function(e){if(!e.ok)throw new o(e.status,e.statusText,"Fetch error");return e.json()})},e,t||{},r||{})}},function(e,t,r){var n=r(10);e.exports=function(){var e=function(){e.id=n(),e.subscribers.forEach((function(e){e()}))};return e.id=n(),e.subscribers=[],e.subscribe=function(t){e.subscribers.push(t)},e.unsubscribe=function(t){e.subscribers.indexOf(t)>=0&&e.subscribers.splice(e.subscribers.indexOf(t),1)},e}},function(e,t,r){var n=r(4);e.exports=function(e){var t=n.useState(e.id),r=function(){return t[1](e.id)};return n.useEffect((function(){return e.subscribe(r),function(){return e.unsubscribe(r)}}),[]),t[0]}},function(e,t,r){var n=r(4),o=r(9);e.exports=function(e){var t=Array.prototype.slice.call(arguments,[1]),r=n.useState({isLoading:!!e});return n.useEffect((function(){e&&(!r[0].isLoading&&r[1]({data:r[0].data,isLoading:!0}),e.apply(null,t).then((function(e){r[1]({data:e,isLoading:!1})})).catch((function(e){r[1]({error:e,isLoading:!1})})))}),o(t)),r[0]}},function(e,t){e.exports=function e(){for(var t=[],r=0;r<arguments.length;r++){var n=arguments[r];if(n instanceof Array)for(var o=0;o<n.length;o++)t=t.concat(e(n[o]));else if("undefined"!=typeof URL&&n instanceof URL)t=t.concat(n.toJSON());else if(n instanceof Object)for(var i=Object.keys(n),c=0;c<i.length;c++){var a=i[c];t=t.concat([a]).concat(e(n[a]))}else t=t.concat(n)}return t}},function(e,t,r){for(var n=self.crypto||self.msCrypto,o="-_",i=36;i--;)o+=i.toString(36);for(i=36;i---10;)o+=i.toString(36).toUpperCase();e.exports=function(e){var t="",r=n.getRandomValues(new Uint8Array(e||21));for(i=e||21;i--;)t+=o[63&r[i]];return t}},function(e,t,r){"use strict";r.r(t);var n=r(2),o=r(0),i=r(3),c=r(1),a=r.n(c),s=r(5),u=r.n(s),l=r(6),d=r.n(l),f=r(7),b=r.n(f);function p(e,t,r,n,o,i,c){try{var a=e[i](c),s=a.value}catch(e){return void r(e)}a.done?t(s):Promise.resolve(s).then(n,o)}function m(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function y(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?m(Object(r),!0).forEach((function(t){v(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):m(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function v(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}function O(e,t){return function(e){if(Array.isArray(e))return e}(e)||function(e,t){if("undefined"==typeof Symbol||!(Symbol.iterator in Object(e)))return;var r=[],n=!0,o=!1,i=void 0;try{for(var c,a=e[Symbol.iterator]();!(n=(c=a.next()).done)&&(r.push(c.value),!t||r.length!==t);n=!0);}catch(e){o=!0,i=e}finally{try{n||null==a.return||a.return()}finally{if(o)throw i}}return r}(e,t)||function(e,t){if(!e)return;if("string"==typeof e)return j(e,t);var r=Object.prototype.toString.call(e).slice(8,-1);"Object"===r&&e.constructor&&(r=e.constructor.name);if("Map"===r||"Set"===r)return Array.from(e);if("Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r))return j(e,t)}(e,t)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function j(e,t){(null==t||t>e.length)&&(t=e.length);for(var r=0,n=new Array(t);r<t;r++)n[r]=e[r];return n}var g=function(e){e.el,e.id;var t=e.sidebar,r=e.updateList,c=O(Object(o.useState)(!1),2),a=c[0],s=c[1],u=O(Object(o.useState)(null),2),l=u[0],d=u[1],f=Object(o.useRef)(),b=function(){wp.ajax.send({url:"".concat(wp.ajax.settings.url,"?action=blocksy_sidebars_update"),contentType:"application/json",data:JSON.stringify(l)}).then((function(){r(),s(!1)}))};return Object(o.createElement)(o.Fragment,null,Object(o.createElement)("span",{onClick:function(){d(null),s(!0)}},Object(o.createElement)("p",{className:"ct-tooltip-top"},"Sidebar Settings")),Object(o.createElement)(i.Overlay,{items:a,className:"ct-admin-modal ct-custom-sidebars-modal",initialFocusRef:f,onDismiss:function(){s(!1)},render:function(){return Object(o.createElement)("div",{className:"ct-modal-content",ref:f},Object(o.createElement)("h2",null,Object(n.sprintf)(Object(n.__)("%s - Sidebar Display Conditions","blc"),t.name)),Object(o.createElement)("p",null,Object(n.__)("Add one or more conditions in order to display your sidebar.","blc")),Object(o.createElement)("div",{className:"ct-modal-scroll"},Object(o.createElement)(i.OptionsPanel,{onChange:function(e,r){return d(y(y(y({},t),l||{}),{},{conditions:r}))},options:{conditions:{type:"blocksy-display-condition",value:[],label:!1,design:"none"}},value:{conditions:(l?l.conditions:t.conditions)||[]},hasRevertButton:!1})),Object(o.createElement)("div",{className:"ct-modal-actions has-divider"},Object(o.createElement)("button",{className:"button-primary",disabled:!l,onClick:b},Object(n.__)("Save Settings","blc"))))}}))},h=d()(),w=function(){var e,t,r=b()(h),n=Array.from(document.querySelectorAll('[id*="ct-dynamic-sidebar"] .blocksy-settings')),i=u()("".concat(ct_localizations.ajax_url,"?action=blocksy_sidebars_list"),{method:"POST",formatter:(e=regeneratorRuntime.mark((function e(t){var r,n,o;return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.json();case 2:if(r=e.sent,n=r.success,o=r.data,n&&o.sidebars){e.next=7;break}throw new Error;case 7:return e.abrupt("return",o.sidebars);case 8:case"end":return e.stop()}}),e)})),t=function(){var t=this,r=arguments;return new Promise((function(n,o){var i=e.apply(t,r);function c(e){p(i,n,o,c,a,"next",e)}function a(e){p(i,n,o,c,a,"throw",e)}c(void 0)}))},function(e){return t.apply(this,arguments)}),depends:[r]}),c=i.data,a=i.isLoading;i.error;return Object(o.createElement)("div",null,!a&&n.map((function(e,t){var r=e.parentNode.id.replace("ct-dynamic-sidebar-",""),n=c.find((function(e){return e.id===r}));return Object(o.createPortal)(Object(o.createElement)(g,{el:e,id:r,sidebar:n,updateList:function(){return h()}}),e)})))};function S(e){return function(e){if(Array.isArray(e))return x(e)}(e)||function(e){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e))return Array.from(e)}(e)||function(e,t){if(!e)return;if("string"==typeof e)return x(e,t);var r=Object.prototype.toString.call(e).slice(8,-1);"Object"===r&&e.constructor&&(r=e.constructor.name);if("Map"===r||"Set"===r)return Array.from(e);if("Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r))return x(e,t)}(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function x(e,t){(null==t||t>e.length)&&(t=e.length);for(var r=0,n=new Array(t);r<t;r++)n[r]=e[r];return n}Object(i.onDocumentLoaded)((function(){var e=S(document.querySelectorAll('.widgets-holder-wrap:not(.inactive-sidebar) [id*="ct-dynamic-sidebar"] .sidebar-description > .description'));if(e.map((function(e){e.parentNode.insertAdjacentHTML("beforebegin",'<div class="blocksy-settings"></div>'),e.classList.add("ct-tooltip-top")})),e.length>0){var t=document.createElement("div");document.body.appendChild(t),Object(o.render)(Object(o.createElement)(w,null),t)}})),a()(document).on("submit",".ct-sidebars-manager form",(function(e){e.preventDefault();var t=document.querySelector(".ct-sidebars-manager form input");t.value&&wp.ajax.send({url:"".concat(wp.ajax.settings.url,"?action=blocksy_sidebars_create&name=").concat(t.value),contentType:"application/json"}).then((function(){return location.reload()}))})),a()(document).on("input",".ct-sidebars-manager form input",(function(e){e.preventDefault();var t=document.querySelector(".ct-sidebars-manager form input"),r=document.querySelector(".ct-sidebars-manager form button");t.value?r.removeAttribute("disabled"):r.setAttribute("disabled",!0)})),a()(document).on("click.ctDynamicSidebars",'[id*="ct-dynamic-sidebar"] .sidebar-description',(function(e){e.preventDefault(),0!==a()(this).closest(".sidebar-description").length&&a()(this).hasClass("sidebar-description")&&wp.ajax.send({url:"".concat(wp.ajax.settings.url,"?action=blocksy_sidebars_remove&id=").concat(a()(this).closest(".widgets-sortables")[0].id.replace("ct-dynamic-sidebar-","")),contentType:"application/json"}).then((function(){return location.reload()}))}))}]);