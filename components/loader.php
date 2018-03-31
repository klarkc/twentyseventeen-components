<?php
define("LOADER_URI", get_template_directory_uri() . '/' . basename(__DIR__));

$registeredModules = array();

$dependencies = array(
    'https://unpkg.com/@webcomponents/webcomponentsjs@1.1.1/webcomponents-loader.js' => false,
    // 'https://unpkg.com/vue@2.5.16/dist/vue.js' => false,
    get_template_directory_uri(). '/assets/js/vue.js' => false,
    'https://unpkg.com/@vue/web-component-wrapper@1.2.0/dist/vue-wc-wrapper.global.js' => false,
);

function components_loader_get_register($src, $handle) {
    ob_start();
    ?>
    <script type="module">
        import Component from '<?php echo esc_url($src); ?>';
        function registerComponent() {
            // At this point we are guaranteed that all required polyfills have loaded,
            // all HTML imports have loaded, and all defined custom elements have upgraded
            const template = document.querySelector('#<?php echo $handle; ?>');
            const res = Vue.compile(template.innerHTML, {hasShadowRoot: true});
            Component.render = res.render;
            Component.staticRenderFns = res.staticRenderFns;
            const CustomElement = wrapVueWebComponent(Vue, Component);
            customElements.define('<?php echo $handle; ?>', CustomElement);
            console.assert(
                document.querySelector('<?php echo $handle; ?>')
                instanceof CustomElement
            );
        }

        if (window.WebComponents.ready) {
            registerComponent();
        } else {
            window.addEventListener('WebComponentsReady', registerComponent);
        }
    </script>
    <?php
    $output = ob_get_clean();
    ob_end_flush();
    return $output;
}

function components_loader_get_dependencies() {
    global $dependencies;
    
    $output = '';
    $scriptTmpl = '<script type="text/javascript" src="%s"></script>';
    foreach($dependencies as $dep => $loaded) {
        if ($loaded === true) continue;
        $output .= sprintf($scriptTmpl, $dep);
        $dependencies[$dep] = true;
    }

    return $output;
}

function components_loader_get_module($src) {
    $moduleTmpl = '<script type="module" src="%s"></script>';
    return sprintf($moduleTmpl, esc_url($src));
}

function components_loader_get_template($src, $handle) {
    $themePath = get_template_directory();
    $themePath = str_replace(ABSPATH, '', $themePath);
    $scriptPath = parse_url($src);
    $search = basename($scriptPath['path']);
    $replace = basename($scriptPath['path'], '.js') . '.html';
    $tmplPath = str_replace($search, $replace, $scriptPath['path']);
    $tmplPath = str_replace($themePath, '', $tmplPath);
    return require($themePath . $tmplPath);
}

function components_loader_format_script_tag($output, $handle, $src) {
    global $registeredModules;
    
    // must load if path is for components folder
    // and the component is still not loaded
    $mustLoad = (
        strpos($src, LOADER_URI) !== false &&
        !in_array($handle, $registeredModules)
    );
    if ($mustLoad) {
        // erase loading script
        $output = '';
        
        // load global dependencies
        $output .= components_loader_get_dependencies();
        
        // load module register
        $output .= components_loader_get_register($src, $handle);
        
        // load template
        $output .= components_loader_get_template($src, $handle);
        
        // do not repeat the load in future
        array_push($registeredModules, $handle);
    }
    return $output;
}
add_filter('script_loader_tag', 'components_loader_format_script_tag', 10, 3);