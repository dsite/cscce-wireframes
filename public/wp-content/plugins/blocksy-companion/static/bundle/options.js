!function(e){var t={};function n(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(r,o,function(t){return e[t]}.bind(null,o));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=16)}([function(e,t){e.exports=window.wp.element},function(e,t){e.exports=window.wp.i18n},function(e,t){e.exports=window.blocksyOptions},function(e,t,n){var r;
/*!
  Copyright (c) 2017 Jed Watson.
  Licensed under the MIT License (MIT), see
  http://jedwatson.github.io/classnames
*/!function(){"use strict";var n={}.hasOwnProperty;function o(){for(var e=[],t=0;t<arguments.length;t++){var r=arguments[t];if(r){var c=typeof r;if("string"===c||"number"===c)e.push(r);else if(Array.isArray(r)&&r.length){var a=o.apply(null,r);a&&e.push(a)}else if("object"===c)for(var i in r)n.call(r,i)&&r[i]&&e.push(i)}}return e.join(" ")}e.exports?(o.default=o,e.exports=o):void 0===(r=function(){return o}.apply(t,[]))||(e.exports=r)}()},function(e,t){e.exports=window.wp.components},function(e,t){e.exports=window.ctEvents},function(e,t){e.exports=window.React},function(e,t,n){(function(t){function n(e){return(n="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}var r="object"===("undefined"==typeof window?"undefined":n(window))&&window.window===window?window:"object"===("undefined"==typeof self?"undefined":n(self))&&self.self===self?self:"object"===(void 0===t?"undefined":n(t))&&t.global===t?t:this;function o(e,t,n){var r=new XMLHttpRequest;r.open("GET",e),r.responseType="blob",r.onload=function(){i(r.response,t,n)},r.onerror=function(){console.error("could not download file")},r.send()}function c(e){var t=new XMLHttpRequest;t.open("HEAD",e,!1);try{t.send()}catch(e){}return t.status>=200&&t.status<=299}function a(e){try{e.dispatchEvent(new MouseEvent("click"))}catch(n){var t=document.createEvent("MouseEvents");t.initMouseEvent("click",!0,!0,window,0,0,0,80,20,!1,!1,!1,!1,0,null),e.dispatchEvent(t)}}var i="object"!==("undefined"==typeof window?"undefined":n(window))||window!==r?function(){}:"download"in HTMLAnchorElement.prototype?function(e,t,n){var i=r.URL||r.webkitURL,l=document.createElement("a");t=t||e.name||"download",l.download=t,l.rel="noopener","string"==typeof e?(l.href=e,l.origin!==location.origin?c(l.href)?o(e,t,n):a(l,l.target="_blank"):a(l)):(l.href=i.createObjectURL(e),setTimeout((function(){i.revokeObjectURL(l.href)}),4e4),setTimeout((function(){a(l)}),0))}:"msSaveOrOpenBlob"in navigator?function(e,t,r){if(t=t||e.name||"download","string"==typeof e)if(c(e))o(e,t,r);else{var i=document.createElement("a");i.href=e,i.target="_blank",setTimeout((function(){a(i)}))}else navigator.msSaveOrOpenBlob(function(e,t){return void 0===t?t={autoBom:!1}:"object"!==n(t)&&(console.warn("Deprecated: Expected third argument to be a object"),t={autoBom:!t}),t.autoBom&&/^\s*(?:text\/\S*|application\/xml|\S*\/\S*\+xml)\s*;.*charset\s*=\s*utf-8/i.test(e.type)?new Blob([String.fromCharCode(65279),e],{type:e.type}):e}(e,r),t)}:function(e,t,c,a){if((a=a||open("","_blank"))&&(a.document.title=a.document.body.innerText="downloading..."),"string"==typeof e)return o(e,t,c);var i="application/octet-stream"===e.type,l=/constructor/i.test(r.HTMLElement)||r.safari,u=/CriOS\/[\d]+/.test(navigator.userAgent);if((u||i&&l)&&"object"===("undefined"==typeof FileReader?"undefined":n(FileReader))){var s=new FileReader;s.onloadend=function(){var e=s.result;e=u?e:e.replace(/^data:[^;]*;/,"data:attachment/file;"),a?a.location.href=e:location=e,a=null},s.readAsDataURL(e)}else{var d=r.URL||r.webkitURL,f=d.createObjectURL(e);a?a.location=f:location.href=f,a=null,setTimeout((function(){d.revokeObjectURL(f)}),4e4)}};e.exports=i}).call(this,n(12))},function(e,t){e.exports=window.wp.hooks},function(e,t,n){var r=n(13);function o(e,t,n,r,c){var a=new Error(n,r,c);return a.name="UseFetchError",a.status=e,a.statusText=t,Object.setPrototypeOf(a,Object.getPrototypeOf(this)),Error.captureStackTrace&&Error.captureStackTrace(a,o),a}o.prototype=Object.create(Error.prototype,{constructor:{value:Error,enumerable:!1,writable:!0,configurable:!0}}),Object.setPrototypeOf(o,Error),e.exports=function(e,t,n){var c=(n&&n.depends||t&&t.depends||[]).reduce((function(e,t){return e||!t}),!1);return r(!c&&function(e,t,n){return fetch(e,t).then(n&&n.formatter||t&&t.formatter||function(e){if(!e.ok)throw new o(e.status,e.statusText,"Fetch error");return e.json()})},e,t||{},n||{})}},function(e,t,n){var r=n(15);e.exports=function(){var e=function(){e.id=r(),e.subscribers.forEach((function(e){e()}))};return e.id=r(),e.subscribers=[],e.subscribe=function(t){e.subscribers.push(t)},e.unsubscribe=function(t){e.subscribers.indexOf(t)>=0&&e.subscribers.splice(e.subscribers.indexOf(t),1)},e}},function(e,t,n){var r=n(6);e.exports=function(e){var t=r.useState(e.id),n=function(){return t[1](e.id)};return r.useEffect((function(){return e.subscribe(n),function(){return e.unsubscribe(n)}}),[]),t[0]}},function(e,t){var n;n=function(){return this}();try{n=n||new Function("return this")()}catch(e){"object"==typeof window&&(n=window)}e.exports=n},function(e,t,n){var r=n(6),o=n(14);e.exports=function(e){var t=Array.prototype.slice.call(arguments,[1]),n=r.useState({isLoading:!!e});return r.useEffect((function(){e&&(!n[0].isLoading&&n[1]({data:n[0].data,isLoading:!0}),e.apply(null,t).then((function(e){n[1]({data:e,isLoading:!1})})).catch((function(e){n[1]({error:e,isLoading:!1})})))}),o(t)),n[0]}},function(e,t){e.exports=function e(){for(var t=[],n=0;n<arguments.length;n++){var r=arguments[n];if(r instanceof Array)for(var o=0;o<r.length;o++)t=t.concat(e(r[o]));else if("undefined"!=typeof URL&&r instanceof URL)t=t.concat(r.toJSON());else if(r instanceof Object)for(var c=Object.keys(r),a=0;a<c.length;a++){var i=c[a];t=t.concat([i]).concat(e(r[i]))}else t=t.concat(r)}return t}},function(e,t,n){for(var r=self.crypto||self.msCrypto,o="-_",c=36;c--;)o+=c.toString(36);for(c=36;c---10;)o+=c.toString(36).toUpperCase();e.exports=function(e){var t="",n=r.getRandomValues(new Uint8Array(e||21));for(c=e||21;c--;)t+=o[63&n[c]];return t}},function(e,t,n){"use strict";n.r(t);var r=n(0),o=n(4),c=n(1),a=n(2),i=n(3),l=n.n(i);function u(e){return function(e){if(Array.isArray(e))return m(e)}(e)||function(e){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e))return Array.from(e)}(e)||b(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function s(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(e);t&&(r=r.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,r)}return n}function d(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?s(Object(n),!0).forEach((function(t){f(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):s(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}function f(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}function p(e,t){return function(e){if(Array.isArray(e))return e}(e)||function(e,t){if("undefined"==typeof Symbol||!(Symbol.iterator in Object(e)))return;var n=[],r=!0,o=!1,c=void 0;try{for(var a,i=e[Symbol.iterator]();!(r=(a=i.next()).done)&&(n.push(a.value),!t||n.length!==t);r=!0);}catch(e){o=!0,c=e}finally{try{r||null==i.return||i.return()}finally{if(o)throw c}}return n}(e,t)||b(e,t)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function b(e,t){if(e){if("string"==typeof e)return m(e,t);var n=Object.prototype.toString.call(e).slice(8,-1);return"Object"===n&&e.constructor&&(n=e.constructor.name),"Map"===n||"Set"===n?Array.from(e):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?m(e,t):void 0}}function m(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n];return r}var y=function(e){return e.filter((function(e,t,n){return n.findIndex((function(t){return t.ID===e.ID}))===t}))},O=[],j=function(e){var t=e.condition,n=e.onChange,o=p(Object(r.useState)(O),2),i=o[0],l=o[1],s=Object(r.useMemo)((function(){return{post_ids:"post",page_ids:"page",custom_post_type_ids:"ct_cpt"}[t.rule]}),[t.rule]),f=Object(r.useMemo)((function(){return(t.payload||{}).post_id||""}),[t.payload&&t.payload.post_id]),b=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"";fetch("".concat(wp.ajax.settings.url,"?action=blocksy_conditions_get_all_posts"),{headers:{Accept:"application/json","Content-Type":"application/json"},body:JSON.stringify(d(d({post_type:s},e?{search_query:e}:{}),f?{alsoInclude:f}:{})),method:"POST"}).then((function(e){return e.json()})).then((function(e){var t=e.data.posts;l((function(e){return y([].concat(u(e),u(t)))})),O=y([].concat(u(O),u(t)))}))};return Object(r.useEffect)((function(){b()}),[s]),Object(r.createElement)(a.Select,{option:{appendToBody:!0,defaultToFirstItem:!1,searchPlaceholder:Object(c.__)("Type to search by ID or title...","blc"),placeholder:"post_ids"===t.rule?Object(c.__)("Select post","blc"):"page_ids"===t.rule?Object(c.__)("Select page","blc"):Object(c.__)("Custom Post Type ID","blc"),choices:i.filter((function(e){var t=e.post_type;return"ct_cpt"===s?"post"!==t&&"page"!==t:s===t})).map((function(e){return{key:e.ID,value:e.post_title}})),search:!0},value:f,onChange:function(e){return n(e)},onInputValueChange:function(e){i.find((function(t){return t.post_title===e}))||b(e)}})};function h(e,t){return function(e){if(Array.isArray(e))return e}(e)||function(e,t){if("undefined"==typeof Symbol||!(Symbol.iterator in Object(e)))return;var n=[],r=!0,o=!1,c=void 0;try{for(var a,i=e[Symbol.iterator]();!(r=(a=i.next()).done)&&(n.push(a.value),!t||n.length!==t);r=!0);}catch(e){o=!0,c=e}finally{try{r||null==i.return||i.return()}finally{if(o)throw c}}return n}(e,t)||S(e,t)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function v(e,t){if(null==e)return{};var n,r,o=function(e,t){if(null==e)return{};var n,r,o={},c=Object.keys(e);for(r=0;r<c.length;r++)n=c[r],t.indexOf(n)>=0||(o[n]=e[n]);return o}(e,t);if(Object.getOwnPropertySymbols){var c=Object.getOwnPropertySymbols(e);for(r=0;r<c.length;r++)n=c[r],t.indexOf(n)>=0||Object.prototype.propertyIsEnumerable.call(e,n)&&(o[n]=e[n])}return o}function _(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(e);t&&(r=r.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,r)}return n}function g(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?_(Object(n),!0).forEach((function(t){E(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):_(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}function E(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}function w(e){return function(e){if(Array.isArray(e))return x(e)}(e)||function(e){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e))return Array.from(e)}(e)||S(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function S(e,t){if(e){if("string"==typeof e)return x(e,t);var n=Object.prototype.toString.call(e).slice(8,-1);return"Object"===n&&e.constructor&&(n=e.constructor.name),"Map"===n||"Set"===n?Array.from(e):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?x(e,t):void 0}}function x(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n];return r}var C=[],k=[],A=[],N=function(e){var t=e.value,n=e.onChange,o=blocksy_admin.all_condition_rules.reduce((function(e,t){var n=t.rules,r=t.title;return[].concat(w(e),w(n.map((function(e){return g(g({},e),{},{group:r})}))))}),[]).reduce((function(e,t){var n=t.title,r=t.id,o=v(t,["title","id"]);return[].concat(w(e),[g({key:r,value:n},o)])}),[]),i=h(Object(r.useState)(C),2),u=(i[0],i[1],h(Object(r.useState)(k),2)),s=u[0],d=u[1],f=h(Object(r.useState)(A),2),p=f[0],b=f[1],m=function(e){return"post_ids"===e.rule||"page_ids"===e.rule||"custom_post_type_ids"===e.rule||"taxonomy_ids"===e.rule||"post_with_taxonomy_ids"===e.rule||"current_language"===e.rule};return Object(r.useEffect)((function(){fetch("".concat(wp.ajax.settings.url,"?action=blocksy_conditions_get_all_taxonomies"),{headers:{Accept:"application/json","Content-Type":"application/json"},method:"POST"}).then((function(e){return e.json()})).then((function(e){var t=e.data,n=t.taxonomies,r=t.languages;d(n),k=n,b(r),A=r}))}),[]),Object(r.createElement)("div",{className:"ct-display-conditions"},t.map((function(e,i){return Object(r.createElement)("div",{className:l()("ct-condition-group",{"ct-cols-3":m(e),"ct-cols-2":!m(e)}),key:i},Object(r.createElement)(a.Select,{key:"first",option:{inputClassName:"ct-condition-type",selectInputStart:function(){return Object(r.createElement)("span",{className:"ct-".concat(e.type)})},placeholder:Object(c.__)("Select variation","blc"),choices:{include:Object(c.__)("Include","blc"),exclude:Object(c.__)("Exclude","blc")}},value:e.type,onChange:function(r){n(t.map((function(t,n){return g({},n===i?g(g({},e),{},{type:r}):t)})))}}),Object(r.createElement)(a.Select,{key:"second",option:{appendToBody:!0,placeholder:Object(c.__)("Select rule","blc"),choices:"user"===e.category?o.filter((function(e){return 0===e.key.indexOf("user_")})):o.filter((function(e){return-1===e.key.indexOf("user_")})),search:!0},value:e.rule,onChange:function(r){n(t.map((function(t,n){return g({},n===i?g(g({},e),{},{rule:r}):t)})))}}),("post_ids"===e.rule||"custom_post_type_ids"===e.rule||"page_ids"===e.rule)&&Object(r.createElement)(j,{condition:e,onChange:function(r){n(t.map((function(t,n){return g({},n===i?g(g({},e),{},{payload:g(g({},e.payload),{},{post_id:r})}):t)})))}}),("taxonomy_ids"===e.rule||"post_with_taxonomy_ids"===e.rule)&&Object(r.createElement)(a.Select,{option:{appendToBody:!0,defaultToFirstItem:!1,placeholder:Object(c.__)("Select taxonomy","blc"),choices:s.map((function(e){return g({key:e.id,value:e.name},e.group?{group:e.group}:{})})),search:!0},value:(e.payload||{}).taxonomy_id||"",onChange:function(r){n(t.map((function(t,n){return g({},n===i?g(g({},e),{},{payload:g(g({},e.payload),{},{taxonomy_id:r})}):t)})))}}),"current_language"===e.rule&&Object(r.createElement)(a.Select,{option:{appendToBody:!0,defaultToFirstItem:!1,placeholder:Object(c.__)("Select language","blc"),choices:p.map((function(e){return{key:e.id,value:e.name}})),search:!0},value:(e.payload||{}).language||"",onChange:function(r){n(t.map((function(t,n){return g({},n===i?g(g({},e),{},{payload:g(g({},e.payload),{},{language:r})}):t)})))}}),Object(r.createElement)("button",{type:"button",onClick:function(e){e.preventDefault();var r=w(t);r.splice(i,1),n(r)}},"×"))})),Object(r.createElement)("div",{className:"ct-conditions-actions"},Object(r.createElement)("button",{type:"button",className:"button add-condition",onClick:function(e){e.preventDefault(),n([].concat(w(t),[{type:"include",rule:"everywhere",payload:{}}]))}},Object(c.__)("Add Display Condition","blc")),Object(r.createElement)("button",{type:"button",className:"button add-condition",onClick:function(e){e.preventDefault(),n([].concat(w(t),[{type:"include",rule:"user_logged_in",payload:{},category:"user"}]))}},Object(c.__)("Add User Condition","blc"))))};function P(e,t){return function(e){if(Array.isArray(e))return e}(e)||function(e,t){if("undefined"==typeof Symbol||!(Symbol.iterator in Object(e)))return;var n=[],r=!0,o=!1,c=void 0;try{for(var a,i=e[Symbol.iterator]();!(r=(a=i.next()).done)&&(n.push(a.value),!t||n.length!==t);r=!0);}catch(e){o=!0,c=e}finally{try{r||null==i.return||i.return()}finally{if(o)throw c}}return n}(e,t)||function(e,t){if(!e)return;if("string"==typeof e)return D(e,t);var n=Object.prototype.toString.call(e).slice(8,-1);"Object"===n&&e.constructor&&(n=e.constructor.name);if("Map"===n||"Set"===n)return Array.from(e);if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return D(e,t)}(e,t)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function D(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n];return r}var T=function(e){var t=e.option,n=t.display,o=void 0===n?"inline":n,i=t.modalTitle,l=void 0===i?Object(c.__)("Transparent Header Display Conditions","blc"):i,u=t.modalDescription,s=void 0===u?Object(c.__)("Add one or more conditions to display the transparent header.","blc"):u,d=e.value,f=e.onChange,p=P(Object(r.useState)(!1),2),b=p[0],m=p[1],y=P(Object(r.useState)(null),2),O=y[0],j=y[1];return"inline"===o?Object(r.createElement)(N,{value:d,onChange:f}):Object(r.createElement)(r.Fragment,null,Object(r.createElement)("button",{className:"button-primary",style:{width:"100%"},onClick:function(e){e.preventDefault(),m(!0),j(null)}},Object(c.__)("Add/Edit Conditions","blc")),Object(r.createElement)(a.Overlay,{items:b,className:"ct-admin-modal ct-builder-conditions-modal",onDismiss:function(){m(!1),j(null)},render:function(){return Object(r.createElement)("div",{className:"ct-modal-content"},Object(r.createElement)("h2",null,l),Object(r.createElement)("p",null,s),Object(r.createElement)("div",{className:"ct-modal-scroll"},Object(r.createElement)(N,{value:O||d,onChange:function(e){j(e)}})),Object(r.createElement)("div",{className:"ct-modal-actions has-divider"},Object(r.createElement)("button",{className:"button-primary",disabled:!O,onClick:function(){f(O),m(!1)}},Object(c.__)("Save Conditions","blc"))))}}))},I=n(7),z=n.n(I);function L(e){return function(e){if(Array.isArray(e))return M(e)}(e)||function(e){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e))return Array.from(e)}(e)||F(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function R(e,t){return function(e){if(Array.isArray(e))return e}(e)||function(e,t){if("undefined"==typeof Symbol||!(Symbol.iterator in Object(e)))return;var n=[],r=!0,o=!1,c=void 0;try{for(var a,i=e[Symbol.iterator]();!(r=(a=i.next()).done)&&(n.push(a.value),!t||n.length!==t);r=!0);}catch(e){o=!0,c=e}finally{try{r||null==i.return||i.return()}finally{if(o)throw c}}return n}(e,t)||F(e,t)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function F(e,t){if(e){if("string"==typeof e)return M(e,t);var n=Object.prototype.toString.call(e).slice(8,-1);return"Object"===n&&e.constructor&&(n=e.constructor.name),"Map"===n||"Set"===n?Array.from(e):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?M(e,t):void 0}}function M(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n];return r}var U=function(){var e=R(Object(r.useState)(null),2),t=e[0],n=e[1],o=R(Object(r.useState)(null),2),i=o[0],u=o[1],s=R(Object(r.useState)(!1),2),d=s[0],f=s[1],p=R(Object(r.useState)(!1),2),b=p[0],m=p[1],y=R(Object(r.useState)(["options"]),2),O=y[0],j=y[1],h=Object(r.useRef)(),v=Object(r.useRef)();return Object(r.useEffect)((function(){var e=function(e){e.stopPropagation(),e.preventDefault(),e.dataTransfer.dropEffect="copy",f(!0)},t=function(e){e.stopPropagation(),e.preventDefault(),f(!1)},r=function(e){e.stopPropagation(),e.preventDefault(),f(!1);var t=Array.from(e.dataTransfer.files||[]);if(Array.from(e.dataTransfer.items||[]).length>0){var r=e.dataTransfer.items[0].getAsFile();n(r)}else t.length>0&&n(t[0])};return v.current.addEventListener("dragover",e,!1),v.current.addEventListener("dragleave",t,!1),v.current.addEventListener("drop",r,!1),function(){v.current.removeEventListener("dragover",e,!1),v.current.removeEventListener("dragleave",t,!1),v.current.removeEventListener("drop",r,!1)}}),[]),Object(r.createElement)("div",{className:"ct-import-export"},Object(r.createElement)("div",{className:"ct-title","data-type":"simple"},Object(r.createElement)("h3",null,Object(c.__)("Export Options","blc")),Object(r.createElement)("div",{className:"ct-option-description"},Object(c.__)("Click the button below to export the customization settings for this theme.","blc"))),Object(r.createElement)("div",{className:"ct-control","data-design":"block"},Object(r.createElement)("header",null),Object(r.createElement)("section",null,Object(r.createElement)("button",{className:"button",onClick:function(e){e.preventDefault(),m(!0)}},Object(c.__)("Export Customizations","blc")))),Object(r.createElement)("div",{className:"ct-title","data-type":"simple"},Object(r.createElement)("h3",null,Object(c.__)("Import Options","blc")),Object(r.createElement)("div",{className:"ct-option-description"},Object(c.__)("Upload a file to import customization settings for this theme.","blc"))),Object(r.createElement)("div",{className:"ct-control","data-design":"block"},Object(r.createElement)("header",null),Object(r.createElement)("section",null,Object(r.createElement)("div",{className:"ct-file-upload"},Object(r.createElement)("button",{type:"button",className:l()("button ct-upload-button",{active:d}),ref:v,onClick:function(){h.current.click()}},t?t.name:Object(c.__)("Click or drop to upload a file...","blc")),Object(r.createElement)("input",{ref:h,type:"file",onChange:function(e){var t=R(e.target.files,1)[0];n(t)}}),Object(r.createElement)("button",{className:"button",onClick:function(e){if(e.preventDefault(),t){var n=new FileReader;n.readAsText(t,"UTF-8"),n.onload=function(e){var t=new FormData;t.append("action","blocksy_customizer_import"),t.append("nonce",ct_customizer_localizations.customizer_reset_none),t.append("wp_customize","on"),t.append("data",e.target.result);try{fetch(window.ajaxurl,{method:"POST",body:t}).then((function(e){200===e.status&&e.json().then((function(e){e.success,e.data;location.reload()}))}))}catch(e){}}}}},Object(c.__)("Import Customizations","blc"))))),ct_customizer_localizations.has_child_theme&&Object(r.createElement)(r.Fragment,null,Object(r.createElement)("div",{className:"ct-title","data-type":"simple"},Object(r.createElement)("h3",null,Object(c.__)("Copy Options","blc")),Object(r.createElement)("div",{className:"ct-option-description"},Object(c.__)("Copy and import your customizations from parent or child theme.","blc"))),ct_customizer_localizations.is_parent_theme&&Object(r.createElement)("div",{className:"ct-control","data-design":"block"},Object(r.createElement)("header",null),Object(r.createElement)("section",null,Object(r.createElement)("button",{className:"button",onClick:function(e){e.preventDefault(),u("child")}},Object(c.__)("Copy From Child Theme","blc")))),!ct_customizer_localizations.is_parent_theme&&Object(r.createElement)("div",{className:"ct-control","data-design":"block"},Object(r.createElement)("header",null),Object(r.createElement)("section",null,Object(r.createElement)("button",{className:"button",onClick:function(e){e.preventDefault(),u("parent")}},Object(c.__)("Copy From Parent Theme","blc"))))),Object(r.createElement)(a.Overlay,{items:i,className:"ct-admin-modal ct-import-export-modal",onDismiss:function(){return u(!1)},render:function(){return Object(r.createElement)("div",{className:"ct-modal-content"},Object(r.createElement)("svg",{width:"35",height:"35",viewBox:"0 0 66 66"},Object(r.createElement)("path",{d:"M66 33.1c0 2.8-.4 5.5-1.1 8.2 0 0-1.7-.6-1.9-.6 3.4-13.1-2.2-27.4-14.5-34.5C41.3 2 33 .9 25 3.1c-3.5.9-6.7 2.4-9.5 4.4L20 12 6 15 9 1l5 5c3.1-2.2 6.6-3.9 10.5-4.9 2.7-.7 5.4-1.1 8-1.1 5.9-.1 11.7 1.4 17 4.4C60.1 10.5 66 21.7 66 33.1zm-49 6.3l2.4-3c-.3-1.2-.4-2.3-.4-3.4s.1-2.2.4-3.3l-2.4-3 2.5-4.3 3.8.5c1.6-1.6 3.6-2.7 5.8-3.3l1.4-3.6h5l1.4 3.6c2.2.6 4.2 1.8 5.8 3.3l3.8-.5 2.5 4.3-2.4 3c.3 1.1.4 2.2.4 3.3s-.1 2.2-.4 3.3l2.4 3-2.5 4.3-3.8-.5c-1.6 1.6-3.6 2.7-5.8 3.3L35.4 50h-5L29 46.4c-2.2-.6-4.2-1.8-5.8-3.3l-3.8.5-2.4-4.2zm8-6.4c0 4.4 3.6 8 8 8s8-3.6 8-8-3.6-8-8-8-8 3.6-8 8zm25.9 25.3c-3 2.1-6.3 3.7-9.9 4.7-8 2.1-16.4 1-23.5-3.1C5.2 52.8-.4 38.5 3 25.4c-.7-.1-1.3-.3-2-.5-.7 2.7-1 5.3-1 8 0 11.4 5.9 22.5 16.5 28.6 7.6 4.4 16.5 5.6 25 3.3 4-1.1 7.6-2.8 10.8-5.2l4.6 4.6 3-14-14 3 5 5.1z"})),Object(r.createElement)("h2",{className:"ct-modal-title"},!ct_customizer_localizations.is_parent_theme&&Object(c.__)("Copy From Parent Theme","blc"),ct_customizer_localizations.is_parent_theme&&Object(c.__)("Copy From Child Theme","blc")),Object(r.createElement)("p",null,!ct_customizer_localizations.is_parent_theme&&Object(c.__)("You are about to copy all the settings from your parent theme into the child theme. Are you sure you want to continue?","blc"),ct_customizer_localizations.is_parent_theme&&Object(c.__)("You are about to copy all the settings from your child theme into the parent theme. Are you sure you want to continue?","blc")),Object(r.createElement)("div",{className:"ct-modal-actions has-divider","data-buttons":"2"},Object(r.createElement)("button",{onClick:function(e){e.preventDefault(),e.stopPropagation(),u(!1)},className:"button"},Object(c.__)("Cancel","blc")),Object(r.createElement)("button",{className:"button button-primary",onClick:function(e){e.preventDefault();var t=new FormData;t.append("action","blocksy_customizer_copy_options"),t.append("wp_customize","on"),t.append("strategy",i);try{fetch(window.ajaxurl,{method:"POST",body:t}).then((function(e){200===e.status&&e.json().then((function(e){e.success,e.data;location.reload()}))}))}catch(e){}}},Object(c.__)("Yes, I am sure","blc"))))}}),Object(r.createElement)(a.Overlay,{items:b,className:"ct-admin-modal ct-export-modal",onDismiss:function(){return m(!1)},render:function(){return Object(r.createElement)("div",{className:"ct-modal-content"},Object(r.createElement)("h2",{className:"ct-modal-title"},Object(c.__)("Export Settings","blc")),Object(r.createElement)("p",null,Object(c.__)("Choose what set of settings you want to export.","blc")),Object(r.createElement)("div",{className:"ct-export-options"},["options","widgets"].map((function(e){return Object(r.createElement)("div",{className:"ct-checkbox-container",onClick:function(){1===O.length&&O[0]===e||j((function(t){return t.includes(e)?t.filter((function(t){return t!==e})):[].concat(L(t),[e])}))}},{options:Object(c.__)("Customizer settings","blc"),widgets:Object(c.__)("Widgets settings","blc")}[e],Object(r.createElement)("span",{className:l()("ct-checkbox",{active:O.includes(e)})},Object(r.createElement)("svg",{width:"10",height:"8",viewBox:"0 0 11.2 9.1"},Object(r.createElement)("polyline",{className:"check",points:"1.2,4.8 4.4,7.9 9.9,1.2 "}))))}))),Object(r.createElement)("div",{className:"ct-modal-actions has-divider","data-buttons":"2"},Object(r.createElement)("button",{onClick:function(e){e.preventDefault(),e.stopPropagation(),m(!1)},className:"button"},Object(c.__)("Cancel","blc")),Object(r.createElement)("button",{className:"button button-primary",onClick:function(e){e.preventDefault();var t=new FormData;t.append("action","blocksy_customizer_export"),t.append("strategy",O.join(":")),t.append("wp_customize","on");try{fetch(window.ajaxurl,{method:"POST",body:t}).then((function(e){200===e.status&&e.json().then((function(e){var t=e.success,n=e.data;if(t){var r=new Blob([n.data],{type:"application/octet-stream;charset=utf-8"});z()(r,"blocksy-export.dat"),m(!1)}}))}))}catch(e){}}},Object(c.__)("Export","blc"))))}}))},B=n(5),H=n.n(B),V=n(8),$=n(9),G=n.n($),Y=n(10),q=n.n(Y),J=n(11),W=n.n(J);function X(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}function K(e){return function(e){if(Array.isArray(e))return te(e)}(e)||function(e){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e))return Array.from(e)}(e)||ee(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function Q(e,t,n,r,o,c,a){try{var i=e[c](a),l=i.value}catch(e){return void n(e)}i.done?t(l):Promise.resolve(l).then(r,o)}function Z(e,t){return function(e){if(Array.isArray(e))return e}(e)||function(e,t){if("undefined"==typeof Symbol||!(Symbol.iterator in Object(e)))return;var n=[],r=!0,o=!1,c=void 0;try{for(var a,i=e[Symbol.iterator]();!(r=(a=i.next()).done)&&(n.push(a.value),!t||n.length!==t);r=!0);}catch(e){o=!0,c=e}finally{try{r||null==i.return||i.return()}finally{if(o)throw c}}return n}(e,t)||ee(e,t)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function ee(e,t){if(e){if("string"==typeof e)return te(e,t);var n=Object.prototype.toString.call(e).slice(8,-1);return"Object"===n&&e.constructor&&(n=e.constructor.name),"Map"===n||"Set"===n?Array.from(e):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?te(e,t):void 0}}function te(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n];return r}var ne=q()(),re=function(e){e.forcedEdit;var t,n,o=e.headerId,i=Z(Object(r.useState)(!1),2),l=i[0],u=i[1],s=Z(Object(r.useState)(null),2),d=s[0],f=s[1],p=Object(r.useContext)(a.PlacementsDragDropContext),b=(p.builderValueCollection,p.builderValueDispatch,Object(r.useRef)()),m=W()(ne),y=G()("".concat(blocksy_admin.ajax_url,"?action=blocksy_header_get_all_conditions"),{method:"POST",formatter:(t=regeneratorRuntime.mark((function e(t){var n,r,o;return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.json();case 2:if(n=e.sent,r=n.success,o=n.data,r&&o.conditions){e.next=7;break}throw new Error;case 7:return e.abrupt("return",o.conditions);case 8:case"end":return e.stop()}}),e)})),n=function(){var e=this,n=arguments;return new Promise((function(r,o){var c=t.apply(e,n);function a(e){Q(c,r,o,a,i,"next",e)}function i(e){Q(c,r,o,a,i,"throw",e)}a(void 0)}))},function(e){return n.apply(this,arguments)}),depends:[m]}),O=y.data,j=y.isLoading;y.error;return Object(r.createElement)(r.Fragment,null,Object(r.createElement)("button",{className:"button-primary",style:{width:"100%"},onClick:function(e){j||(e.preventDefault(),e.stopPropagation(),u(!0))}},Object(c.__)("Add/Edit Conditions","blc")),Object(r.createElement)(a.Overlay,{items:l,initialFocusRef:b,className:"ct-admin-modal ct-builder-conditions-modal",onDismiss:function(){u(!1),f(null)},render:function(){var e;return Object(r.createElement)("div",{className:"ct-modal-content",ref:b},Object(r.createElement)("h2",null,sprintf(Object(c.__)("Display Conditions","blc"))),Object(r.createElement)("p",null,Object(c.__)("Add one or more conditions in order to display your header.","blc")),Object(r.createElement)("div",{className:"ct-modal-scroll"},Object(r.createElement)(a.OptionsPanel,{onChange:function(e,t){f((function(e){return[].concat(K((e||O).filter((function(e){return e.id!==o}))),[{id:o,conditions:t}])}))},options:{conditions:(e={type:"blocksy-display-condition",design:"none",value:[]},X(e,"design","none"),X(e,"label",!1),e)},value:{conditions:((d||O).find((function(e){return e.id===o}))||{conditions:[]}).conditions},hasRevertButton:!1})),Object(r.createElement)("div",{className:"ct-modal-actions has-divider"},Object(r.createElement)("button",{className:"button-primary",disabled:!d,onClick:function(){fetch("".concat(wp.ajax.settings.url,"?action=blocksy_header_update_all_conditions"),{headers:{Accept:"application/json","Content-Type":"application/json"},method:"POST",body:JSON.stringify(d)}).then((function(e){return e.json()})).then((function(){ne(),u(!1)}))}},Object(c.__)("Save Conditions","blc"))))}}))};function oe(){return(oe=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var r in n)Object.prototype.hasOwnProperty.call(n,r)&&(e[r]=n[r])}return e}).apply(this,arguments)}function ce(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(e);t&&(r=r.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,r)}return n}function ae(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?ce(Object(n),!0).forEach((function(t){ie(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):ce(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}function ie(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}function le(e,t){return function(e){if(Array.isArray(e))return e}(e)||function(e,t){if("undefined"==typeof Symbol||!(Symbol.iterator in Object(e)))return;var n=[],r=!0,o=!1,c=void 0;try{for(var a,i=e[Symbol.iterator]();!(r=(a=i.next()).done)&&(n.push(a.value),!t||n.length!==t);r=!0);}catch(e){o=!0,c=e}finally{try{r||null==i.return||i.return()}finally{if(o)throw c}}return n}(e,t)||function(e,t){if(!e)return;if("string"==typeof e)return ue(e,t);var n=Object.prototype.toString.call(e).slice(8,-1);"Object"===n&&e.constructor&&(n=e.constructor.name);if("Map"===n||"Set"===n)return Array.from(e);if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return ue(e,t)}(e,t)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function ue(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n];return r}var se=function(){var e=le(Object(r.useState)(!1),2),t=e[0],n=e[1],i=(ct_customizer_localizations.header_builder_data.secondary_items.header,ct_customizer_localizations.header_builder_data.header,Object(r.useContext)(a.PlacementsDragDropContext)),u=i.builderValueDispatch,s=i.builderValue,d=(i.option,i.builderValueCollection),f=i.panelsActions,p=Object(V.applyFilters)("blocksy.header.available-sections",null,d.sections)||d.sections.filter((function(e){var t=e.id;return"type-2"!==t&&"type-3"!==t&&-1===t.indexOf("ct-custom")}));return Object(r.createElement)(r.Fragment,null,Object(r.createElement)("ul",{className:l()("ct-panels-manager")},p.map((function(e){var t=e.name,o=e.id,i=t||{"type-1":Object(c.__)("Global Header","blocksy")}[o]||o,d="builder_header_panel_".concat(o),p=ct_customizer_localizations.header_builder_data.header_data.header_options,b={label:i,"inner-options":ae(ae({},o.indexOf("ct-custom")>-1?{conditions_button:{label:Object(c.__)("Edit Conditions","blc"),type:"jsx",design:"block",render:function(){return Object(r.createElement)(re,{headerId:o})}},divider:{type:"ct-divider"}}:{}),p)};return Object(r.createElement)(a.PanelMetaWrapper,oe({id:d,key:o,option:b},f,{getActualOption:function(e){var t=e.open;return Object(r.createElement)(r.Fragment,null,o===s.id&&Object(r.createElement)(a.Panel,{id:d,getValues:function(){return ae({id:o},s.settings||{})},option:b,onChangeFor:function(e,t){u({type:"BUILDER_GLOBAL_SETTING_ON_CHANGE",payload:{optionId:e,optionValue:t,values:Object(a.getValueFromInput)(p,Array.isArray(s.settings)?{}:s.settings||{})}})},view:"simple"}),Object(r.createElement)("li",{className:l()({active:o===s.id,"ct-global":"type-1"===o}),onClick:function(){o===s.id?t():u({type:"PICK_BUILDER_SECTION",payload:{id:o}})}},Object(r.createElement)("span",{className:"ct-panel-name"},i),o.indexOf("ct-custom")>-1&&o!==s.id&&Object(r.createElement)("span",{className:"ct-remove-instance",onClick:function(e){e.preventDefault(),e.stopPropagation(),n(o)}},Object(r.createElement)("i",{className:"ct-tooltip-top"},Object(c.__)("Remove header","blc")),Object(r.createElement)("svg",{width:"11px",height:"11px",viewBox:"0 0 24 24"},Object(r.createElement)("path",{d:"M9.6,0l0,1.2H1.2v2.4h21.6V1.2h-8.4l0-1.2H9.6z M2.8,6l1.8,15.9C4.8,23.1,5.9,24,7.1,24h9.9c1.2,0,2.2-0.9,2.4-2.1L21.2,6H2.8z"})))))}}))}))),Object(r.createElement)(o.Slot,{name:"PlacementsBuilderPanelsManagerAfter"},(function(e){return 0===e.length?null:e})),Object(r.createElement)(a.Overlay,{items:t,className:"ct-admin-modal ct-reset-options",onDismiss:function(){return n(!1)},render:function(){return Object(r.createElement)("div",{className:"ct-modal-content"},Object(r.createElement)("h2",{className:"ct-modal-title"},Object(c.__)("Remove Header","blc")),Object(r.createElement)("p",null,Object(c.__)("You are about to remove a custom header, are you sure you want to continue?","blc")),Object(r.createElement)("div",{className:"ct-modal-actions has-divider","data-buttons":"2"},Object(r.createElement)("button",{onClick:function(e){e.preventDefault(),e.stopPropagation(),n(!1)},className:"button"},Object(c.__)("Cancel","blc")),Object(r.createElement)("button",{className:"button button-primary",onClick:function(e){e.preventDefault(),u({type:"REMOVE_BUILDER_SECTION",payload:{id:t}}),n(!1)}},Object(c.__)("Confirm","blc"))))}}))};H.a.on("blocksy:options:before-option",(function(e){if(e.option&&"ct-header-builder"===e.option.type){var t=e.content;e.content=Object(r.createElement)(r.Fragment,null,t,Object(r.createElement)(o.Fill,{name:"PlacementsBuilderPanelsManager"},Object(r.createElement)(se,null)))}})),H.a.on("blocksy:options:register",(function(e){e["blocksy-display-condition"]=T,e["blocksy-customizer-options-manager"]=U}))}]);