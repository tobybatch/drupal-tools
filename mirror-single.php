<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'mirror-drupal.php';

define('USAGE', "Usage: " . $argv[0] . " aliasfile");

if (!isset($argv[1])) {
    echo USAGE . "\n";
    echo "  Alias file is manadatory\n";
    return 1;
}

$aliasfile = $argv[1];

echo $aliasfile . "\n";

if (!file_exists($aliasfile)) {
    echo USAGE . "\n";
    echo "  Alias doen not exist ($aliasfile)\n";
    return 1;
}

include $aliasfile;
$alias = array_pop(array_keys($aliases));
$settings = $aliases[$alias]; // could be referrenced as $aliases[0]

# print_r($alias);
# print "\n";
# print_r($settings);
# print "\n";

mirrorSite($alias, $settings);
