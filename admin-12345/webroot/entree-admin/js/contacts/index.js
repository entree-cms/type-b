!function(e){var t={};function n(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(r,o,function(t){return e[t]}.bind(null,o));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=1)}([function(e,t){},function(e,t,n){"use strict";n.r(t);n(0);$(document).on("click",'[data-class="btn-del"]',function(e){var t=$(e.target).data("id"),n=$("#contact-"+t),r=n.find(".date").text(),o=n.find(".time").text(),a=n.find(".td-name").text().trim(),i=DEL_CFM_MSG.replace("%DATE%",r).replace("%TIME%",o).replace("%NAME%",a);confirm(i)&&$("<form>").attr("method","post").append($("<input>").attr({type:"hidden",name:"contact_id",value:t}),$("<input>").attr({type:"hidden",name:"action",value:"delete"}),$("<input>").attr({type:"hidden",name:"_csrfToken",value:CSRF_TOKEN})).appendTo("body").submit()})}]);