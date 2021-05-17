<div style="position:absolute;bottom:10px;right:10px;">
<pre>
<?php
if (!$f3) {
    $f3 = \Base::instance();
}
$args = [
    'included_files' => get_included_files(),
    'max_memory' => memory_get_peak_usage(),
];
if ($db = $f3->get('SHOW_DB')) {
    $dbs = explode(',', $db);
    $databases = [];
    foreach($dbs as $key) {
        $db = $f3->get($key);
        if (is_string($db)) {
            $db = new \DB\SQL($db);
        }
        $databases[$key] = $db->log();
    }
    $args['databases'] = $databases;
}
var_dump($args);
?>
</pre>
</div>
