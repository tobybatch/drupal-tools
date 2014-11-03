<?php

function mysqlCheckUser($user, $pass, $name, &$output, &$retval) {
  $drop = sprintf(
    'mysql-checkuser -u %s -p %s -n %s',
    $user, $pass, $name
  );
  return exec($drop, $output, $retval);
}

function mysqlCreateUser($user, $pass, $name, &$output, &$retval) {
  $drop = sprintf(
    'mysql-checkuser -u %s -p %s -n %s',
    $user, $pass, $name
  );
  return exec($drop, $output, $retval);
}

function createDB($user, $pass, $name, &$output, &$retval) {
  $drop = mysqlCheckUser($user, $pass, $name, $output, $retval);
  
  if ($retval === 0) { // exit status 0 = db !exists
    $create = mysqlCreateUser($user, $pass, $name, $output, $retval);
  }
}

function drupalExists($target, $site) {
  $drupal_exists = FALSE;
  
  $settings = $target . DIRECTORY_SEPARATOR . 'sites' . DIRECTORY_SEPARATOR . $site . DIRECTORY_SEPARATOR . 'settings.php';
  $drupal_exists = file_exists($settings);
//  if (is_dir($target)) {
//    $cmd = 'drush -r ' . $target . ' status';
//    exec($cmd, $output, $retval);
//    if ($retval != 0) {
//      $drupal_exists = TRUE;
//    }
//  } 
  
  return $drupal_exists;
}

function mirrorSite($alias, $settings) {
  $sitename = 'default';
  $connectionname = 'default';
  
  $database = $settings['databases'][$sitename][$connectionname];
  # print_r($database);
  $output = array();
  $retval = 0;

  createDB($database['username'], $database['password'], $database['database'], $output, $retval);
  
  $target = '/var/www/html/' . $alias;
  
  $drupal_exists = drupalExists($target, $sitename);

  $source = '@' . $alias;
  $self = FALSE;
  if ($drupal_exists) {
    // do a drush alias rsync
    $cmd = "drush -y -r $target rsync @$alias @self --include-vcs --include-conf --exclude-paths=\"*.sass-cache*\" --progress -O";
  } else {
    // else do a drush std sync
    $cmd = "drush -y rsync @$alias $target --include-vcs --include-conf --exclude-paths=\"*.sass-cache*\" --progress -O ";
  }

  echo $cmd . "\n";
  exec($cmd);
  chdir($target);
  $cmd = "drush -y sql-sync @$alias @self";
  echo $cmd . "\n";
  exec($cmd);
}
// vim: set filetype=php expandtab tabstop=2 shiftwidth=2 autoindent smartindent:
