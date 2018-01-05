<?php 
//do not use exit()
if ( ! defined('BASEPATH')) { echo ('No direct script access allowed');} else {

/* load the MX_Router class */
require APPPATH.'third_party/MX/Router.php';

class MY_Router extends MX_Router {}
}