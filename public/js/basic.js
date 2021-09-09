/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************!*\
  !*** ./resources/js/basic.js ***!
  \*******************************/
window.app = createApp({
  data: function data() {
    return {
      all_count: 0
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