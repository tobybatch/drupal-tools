<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'mirror-drupal.php';

$dotdrush = getenv("HOME") . DIRECTORY_SEPARATOR . '.drush';

if ($handle = opendir($dotdrush)) {

  while (false !== ($entry = readdir($handle))) {
    if (strpos($entry, 'alias.drushrc.php')) {
      include $dotdrush . DIRECTORY_SEPARATOR . $entry;
    }
  }
}

foreach ($aliases as $alias => $settings) {
  echo "Processing $alias\n";

  mirrorSite($alias, $settings);

  echo "-------------------\n";
}
// vim: set filetype=php expandtab tabstop=2 shiftwidth=2 autoindent smartindent:
