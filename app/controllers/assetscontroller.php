<?php

namespace Controllers;

use Web;
use Image;

class AssetsController {
    public function images($f3, $slug){
        /**
         * image.jpg.webp -> converts jpg -> webp
         * image.jpg.100.webp -> resizes image to 100 width converts to webp
         * image.jpg.100x120.jpg -> resizes image to 100 x 120
         * image.jpg.100x120.png -> resizes image to 100 x 120 converts to png
         */
        $file = pathinfo($slug['*']);
        $convertTo = $file['extension'];
        $subFile = pathInfo($file['filename']);
        $commandsString = $subFile['extension'];
        $convertFrom = "{$file['dirname']}/{$subFile['basename']}";
        $commands = [];
        if (preg_match('/^(?<width>\d*)(|x(?<height>\d*))$/', $commandsString, $commands)) {
            $subFile = pathInfo($file['filename']);
            $convertFrom = "{$file['dirname']}/{$subFile['filename']}";
        } else {
            $commands = "";
        }

        if (!is_file($convertFrom)){
            throw new \Exception('File Not Found: ' . $convertFrom);
        }
        $image = new Image($convertFrom);
        if (isset($commands['height']) && $commands['height']){
            $image = $image->resize($commands['width'], $commands['height']);
        } elseif (isset($commands['width']) && $commands['width']){
            $image = $image->resize($commands['width']);
        } else {
            die('failed');
        }
        $quality = 9;
        if (strtolower($convertTo) == 'jpg') {
            $convertTo = 'jpeg';
            $quality = 85;
        }
        $slug[0] = "./{$slug[0]}";
        $fileInfo = pathinfo($slug[0]);
        $dirname = "{$fileInfo['dirname']}";
        if (!is_dir($dirname)) {
            mkdir($dirname, 0775, true);
        }
        $f3->write( $slug[0], $image->dump($convertTo,$quality) );
        chmod($slug[0], 0775);
        $image->render($convertTo, $quality);
    }
    public function js($f3, $args) {
        $args['type'] = 'js';
        return $this->minify($f3, $args);
    }
    public function css($f3, $args) {
        $args['type'] = 'css';
        return $this->minify($f3, $args);
    }
    public function minify($f3, $args) {
		$path = '.';
		$files = preg_replace('/(\.+\/)/','',$_GET['files']); // close potential hacking attempts  
		echo Web::instance()->minify($files, null, true, $path);
	}
}
