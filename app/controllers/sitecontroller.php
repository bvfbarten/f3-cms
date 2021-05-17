<?php

namespace Controllers;

use Web;
use Image;
use Log;

class SiteController extends Controller  {
    public function default($f3, $slug) {
        $slug = $slug['*'];
        if ($slug == "") {
            $slug = "index";
        }
        $slug = "{$slug}.php";
        if (is_file($f3->get('UI')."{$slug}")) {
            echo render("{$slug}", compact('f3', 'slug'));
        } else {
			$f3->error(404);
        }
    }
    function afterroute($f3) {
        if ($t = $f3->get('TEMPLATE')) {
            echo render($t);
        } else {
            if ($f3->get('PAGE')) {
                echo render($f3->get('PAGE'));
            }
        }
    }
	function error($f3) {
		$log=new Log('error.log');
		$log->write($f3->get('ERROR.text'));
        if (is_string($f3->get('ERROR.trace'))){
            $f3->set('ERROR.trace', explode("\n", $f3->get('ERROR.trace')));
        }
		foreach ($f3->get('ERROR.trace') as $frame)
			if (isset($frame['file'])) {
				// Parse each backtrace stack frame
				$line='';
				$addr=$f3->fixslashes($frame['file']).':'.$frame['line'];
				if (isset($frame['class']))
					$line.=$frame['class'].$frame['type'];
				if (isset($frame['function'])) {
					$line.=$frame['function'];
					if (!preg_match('/{.+}/',$frame['function'])) {
						$line.='(';
						if (isset($frame['args']) && $frame['args'])
							$line.=$f3->csv($frame['args']);
						$line.=')';
					}
				}
                if ($f3->get('DEBUG') >= 3) {
                    print($addr.' '.$line);
                }
				// Write to custom log
				$log->write($addr.' '.$line);
			}
        varDie($f3->get('ERROR'));
        //varDie($f3->get('ERROR'));
		//$f3->set('PAGE','error.htm');
	}
}

