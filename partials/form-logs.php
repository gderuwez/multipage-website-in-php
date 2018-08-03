<?php
$file = file_get_contents('./logs/logs.txt', true);
$file = rtrim(trim($file), ',');
$file = '[' . $file . ']';
$log = json_decode($file, true);

foreach ($log as $key => $value) {
  echo '<pre>';
  echo $log[$key]['date'];
  echo '<br>';
  if (isset($log[$key]['first_name'])) {
    echo $log[$key]['first_name'];
    echo '<br>';
  }
  if (isset($log[$key]['format'])) {
    echo $log[$key]['format'];
  }
  echo '</pre>';
}
 ?>
