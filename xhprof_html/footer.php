<?php
if (extension_loaded('xhprof') && !is_xhprof_url()) {
  $profiler_namespace = 'myapp'; // namespace for your application
  $xhprof_data = xhprof_disable();
  $xhprof_runs = new XHProfRuns_Default();
  $url_id = (isset($_SERVER["SERVER_NAME"]) ? strtr($_SERVER["SERVER_NAME"].(isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"]: ""), " /.&=:?%", "________") : "")."_".uniqid();
  $run_id = $xhprof_runs->save_run($xhprof_data, $profiler_namespace, $url_id);

  // url to the XHProf UI libraries (change the host name and path)
  global $xhprof_baseurl;
  $profiler_url = sprintf($xhprof_baseurl.'/index.php?run=%s&source=%s', $run_id, $profiler_namespace);
  //if(!is_ajax()) echo '<a href="'.$profiler_url.'">Profiler output</a>';
}
