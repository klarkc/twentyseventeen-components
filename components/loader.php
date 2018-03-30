<?php
define("LOADER_URI", get_template_directory_uri() . '/' . basename(__DIR__));

$loadedModules = array();

$dependencies = array(
    'https://unpkg.com/@webcomponents/webcomponentsjs@1.1.1/webcomponents-loader.js' => false,
    'https://unpkg.com/vue@2.5.16/dist/vue.js' => false,
    'https://unpkg.com/@vue/web-component-wrapper@1.2.0/dist/vue-wc-wrapper.global.js' => false,
);

function components_loader_get_register($module) {
    ob_start();
    ?>
    <script>
        window.addEventListener('WebComponentsReady', function() {
            // At this point we are guaranteed that all required polyfills have loaded,
            // all HTML imports have loaded, and all defined custom elements have upgraded
            let ElementClass = customElements.get('<?php echo $module; ?>');
            let element = document.querySelector('<?php echo $module; ?>');
            console.assert(element instanceof ElementClass);  // 👍
        });
    </script>
    <?
    return ob_end_clean();
}

function components_loader_get_dependencies() {
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
    $scriptName = basename($scriptPath['path']);
    $tmplPath = str_replace($scriptName, 'template.html', $scriptPath['path']);
    $tmplPath = str_replace($themePath, '', $tmplPath);
    array_push($loadedModules, $handle);
    return require($themePath . $tmplPath);
}

function components_loader_format_script_tag($output, $handle, $src) {
    global $loadedModules;

    // must load if path is for components folder
    // and components is still not loaded
    $mustLoad = (
        strpos($src, LOADER_URI) !== false &&
        !in_array($handle, $loadedModules)
    );
    if ($mustLoad) {
        // erase loading script
        $output = '';

        // load global dependencies
        $output .= components_loader_get_dependencies();

        // load module
        $output .= components_loader_get_module($src);

        // load template
        $output .= components_loader_get_template($src, $handle);
    }
    return $output;
}
add_filter('script_loader_tag', 'components_loader_format_script_tag', 10, 3);