<?php
# Build.php is a simple PHP script for executing the example.php script, and then using chromium browser to create a PDF of the HTML file. To hide undesirable changes by the browser, this script injects some CSS changes.
// Dependencies: PHP, Chromium (web browser)
$location = realpath(dirname(__FILE__, 2));
require_once $location . '/example.php';
$data = file_get_contents("{$location}/temporary/destination.html");
$addition = <<<EOT
<style>
@media print {
    html, body {
        margin: 0;
        padding: 0;
    }
    @page {
        margin: 0;
        size: auto;
    }
}
</style>
EOT;
$data = preg_replace('/<\/head>/i', $addition . "\n</head>", $data);
file_put_contents("{$location}/temporary/destination_chromium.html", $data);
exec("chromium --headless --print-to-pdf=\"{$location}/temporary/destination.pdf\" \"{$location}/temporary/destination_chromium.html\"");
?>