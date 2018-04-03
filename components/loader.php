<?php
define("ASSETS_URI", get_template_directory_uri() . '/assets');

// register vue and global plugins
wp_register_script('httpVueLoader', ASSETS_URI . '/js/http-vue-loader.js');
wp_register_script('vue-comment-grid', ASSETS_URI . '/js/vue-comment-grid.js');
wp_register_script('v-tooltip', ASSETS_URI . '/js/v-tooltip.min.js');
wp_register_script('debounce', ASSETS_URI . '/js/debounce.js');

$plugins = array(
    'httpVueLoader',
    'vue-comment-grid',
    'v-tooltip',
    'debounce',
);
wp_register_script('vue', ASSETS_URI . '/js/vue.js', 
    $plugins
);

// register and enqueue app
wp_enqueue_script('app', ASSETS_URI . '/js/app.js', array('vue'));

// init app
function loader_init_app() {
    // load url of all components
    $files = glob(__DIR__ . '/**/*.vue');
    $components = array();

    foreach ($files as $file) {
        $path = str_replace(get_template_directory(), '', $file);
        $tmpl = get_template_directory_uri();
        $components[basename($file, '.vue')] = 'url:' . $tmpl . $path;
    }
    ob_start();
    ?>
    <script type="text/javascript">
    window.initApp(<?php echo json_encode($components); ?>);
    </script>
    <?php
    $output = ob_get_clean();
    ob_end_flush();
    echo $output;
}
add_action('wp_footer', 'loader_init_app');