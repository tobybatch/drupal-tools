drupal-tools
============

These tools rely on https://github.com/tobybatch/Shell-tools

Visit that repositiory to install those and add them to the path of the user that will run these commands.

For each site you wish to mirror create an alias file in the users $HOME/.drush. e.g.

    localadmin@server01 ~  $ cat .drush/live.zz_1.0.1.alias.drushrc.php 
    <?php
    $aliases["live.zz_1.0.1"] = array (
      'root' => '/var/www/zz_1.0.1',
      'uri' => 'http://default',
      '#name' => 'live.zz_1.0.1',
      'remote-host' => 'zz.co.uk',
      'remote-user' => 'admin',
      'databases' => array (
        'default' => array (
          'default' => array (
            'database' => 'zz1_0_0',
            'username' => 'zz1_0_0',
            'password' => 'zz1_0_0',
            'host' => 'localhost',
            'port' => '',
            'driver' => 'mysql',
            'prefix' => '',
          ),
        ),
      ),
    );

You will need to set up key trust between this user and the 'remote-user' and set the /etc/mysql/mysecret to hold the mysql root password, this should be chmod 600 or 400 to just this user.  The root password is needed to ceate new databases for new sites.
