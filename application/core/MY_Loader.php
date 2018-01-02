<?php 
//do not use exit()
if ( ! defined('BASEPATH')) { echo ('No direct script access allowed');} else {

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader {}
}