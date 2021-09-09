/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************!*\
  !*** ./resources/js/basic.js ***!
  \*******************************/
window.app = createApp({
  data: function data() {
    return {
      config: {
        web_title: '',
        web_phone: '',
        web_address: '',
        web_email: '',
        web_facebook: '',
        web_line: '',
        meta_keyword: '',
        meta_description: ''
      }
    };
  },
  delimiters: ["${", "}"],
  mounted: function mounted() {
    setTimeout(function () {
      loading.show = false;
    }, 1);
  },
  methods: {}
}).mount('#app');
/******/ })()
;