<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Custom language
| -------------------------------------------------------------------------
|
*/

$hook['post_controller_constructor'] = array(
    'class' => 'LanguageLoader',
    'function' => 'initialize',
    'filename' => 'LanguageLoader.php',
    'filepath' => 'hooks'
);
