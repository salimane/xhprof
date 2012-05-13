<?php
global $xhprof_baseurl;
$xhprof_baseurl = "http://xhprof.local";
function is_ajax() {
  return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
}

function is_xhprof_url() {
  global $xhprof_baseurl;
  return $_SERVER['SERVER_NAME'] == $xhprof_baseurl;
}

if (extension_loaded('xhprof') && !is_xhprof_url()) {
  $utils_path = __DIR__ . "/../xhprof_lib/utils/";
  include_once $utils_path.'xhprof_lib.php';
  include_once $utils_path.'xhprof_runs.php';
  xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
}
