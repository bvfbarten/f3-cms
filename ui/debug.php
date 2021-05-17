<style>
.bb_debug_box {
    position:absolute;
    bottom:10px;
    right:10px;
    border:1px solid #000;
    border-radius:3px;
    box-shadow:2px 2px 2px #000;
    height:30px;
    overflow:hidden;
    width:30px;
}
.bb_debug_box:hover {
    height:auto;
    width:auto;
    max-height:100%;
    overflow:scroll;
}
</style>
<div id="bb_debug_box" class="bb_debug_box">
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
