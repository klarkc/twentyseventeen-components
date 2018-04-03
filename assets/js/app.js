(function () {
    const Vue = window.Vue;
    Vue.use(window.httpVueLoader);
    Vue.use(window['vue-js-grid'].default);
    Vue.use(window.VTooltip);
    
    window.initApp = (components) => { 
        new Vue({
            el: '.site',
            name: 'App',
            components,
        })
    }
})();