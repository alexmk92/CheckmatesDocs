<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
/*
|--------------------------------------------------------------------------
| Checkmates - License info
|--------------------------------------------------------------------------
|
| Author      - Alex Sims
|
| License     - GPL : Feel free to use this code for learning purposes, do
|				not attempt to rebrand this as your own work.
|
| Description -
|
|
|--------------------------------------------------------------------------
| Instanciate route constants
|--------------------------------------------------------------------------
|
| Define any path constants here to point to different functional areas
| of the site, BASEPATH, VIEWPATH, COREPATH, CONFPATH, CLASSPATH
|
| Only define constants if they are not already defined in the application.
|
*/
defined('BASEPATH') or define('BASEPATH', ".");
defined('VIEWPATH') or define('VIEWPATH', BASEPATH."/app/views/");
defined('COREPATH') or define('COREPATH', BASEPATH."/app/core/");
defined('CONFPATH') or define('CONFPATH', BASEPATH."/app/config/");
/*
|--------------------------------------------------------------------------
| Instanciate directory constants
|--------------------------------------------------------------------------
|
| Define any constants which point to a public directory, these can then
| be used as a quick clean reference to any of the public directories.
|
*/
defined('STYLEDIR') or define('STYLEDIR', BASEPATH."/public/css/");
defined('IMAGEDIR') or define('IMAGEDIR', BASEPATH."/public/img/");
defined('LIBRADIR') or define('LIBRADIR', BASEPATH."/public/lib/");
defined('REQUEST_URL')  or define('REQUEST_URL', "http://52.11.19.198/checkmates/api/v2/");
defined('URL') or define('URL', '/checkmates/api/v2');
/*
|--------------------------------------------------------------------------
| Route user to requested page
|--------------------------------------------------------------------------
|
| If a valid page is requested then serve that view to the user, else
| we are on the index (home) page.
|
*/
require(VIEWPATH . "components/header.php");
if(isset($_GET['page'])) {
    $view = $_GET['page'];
    $active = strtolower($view);
    if(file_exists(VIEWPATH.$view.".php")) {
        $title = $view;
        require_once(VIEWPATH.$view.".php");
    } else {
        require_once(VIEWPATH . "index.php");
    }
} else {
    // This should only happen when a bogus URL is requested
    require_once(VIEWPATH."index.php");
}
require(VIEWPATH . "components/footer.php");