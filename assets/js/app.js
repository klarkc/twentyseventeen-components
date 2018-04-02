(function () {
    const Vue = window.Vue;
    const httpVueLoader = window.httpVueLoader;
    Vue.use(window.httpVueLoader);
    Vue.use(window['vue-js-grid'].default);
    
    window.initApp = (components) => { 
        new Vue({
            el: '.app',
            name: 'App',
            components,
        })
    }
})();