<?php
define("LOADER_URI", get_template_directory_uri() . '/' . basename(__DIR__));

$loadedTemplates = array();

function components_loader_format_script_tag($output, $handle, $src) {
    global $loadedTemplates;

    // if path is for components folder
    if (strpos($src, LOADER_URI) !== false) {
        $scriptTmpl = '<script type="module" src="%s"></script>';
        $output = sprintf($scriptTmpl, esc_url($src));
        if (!in_array($handle, $loadedTemplates)) {
            $themePath = get_template_directory();
            $themePath = str_replace(ABSPATH, '', $themePath);
            $scriptPath = parse_url($src);
            $scriptName = basename($scriptPath['path']);
            $tmplPath = str_replace($scriptName, 'template.html', $scriptPath['path']);
            $tmplPath = str_replace($themePath, '', $tmplPath);
            $output .= "\n\n" . require($themePath . $tmplPath);
            array_push($loadedTemplates, $handle);
        }
    }
    return $output;
}
add_filter('script_loader_tag', 'components_loader_format_script_tag', 10, 3);