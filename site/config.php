<?php
/**
 * Site configuration, this file is changed by user per site.
 *
 */

/**
 * Set level of error reporting
 */
error_reporting(-1);
ini_set('display_errors', 1);


/**
 * Set what to show as debug or developer information in the get_debug() theme helper.
 */
$nx->config['debug']['nexus'] = false;
$nx->config['debug']['session'] = false;
$nx->config['debug']['timer'] = true;
$nx->config['debug']['db-num-queries'] = true;
$nx->config['debug']['db-queries'] = true;


/**
 * Set database(s).
 */
$nx->config['database'][0]['dsn'] = 'sqlite:' . NEXUS_SITE_PATH . '/data/.ht.sqlite';


/**
 * What type of urls should be used?
 * 
 * default      = 0      => index.php/controller/method/arg1/arg2/arg3
 * clean        = 1      => controller/method/arg1/arg2/arg3
 * querystring  = 2      => index.php?q=controller/method/arg1/arg2/arg3
 */
$nx->config['url_type'] = 1;


/**
 * Set a base_url to use another than the default calculated
 */
$nx->config['base_url'] = null;


/**
 * How to hash password of new users, choose from: plain, md5salt, md5, sha1salt, sha1.
 */
$nx->config['hashing_algorithm'] = 'sha1salt';


/**
 * Allow or disallow creation of new user accounts.
 */
$nx->config['create_new_users'] = true;


/**
 * Define session name
 */
$nx->config['session_name'] = preg_replace('/[:\.\/-_]/', '', __DIR__);
$nx->config['session_key']  = 'nexus';


/**
 * Define default server timezone when displaying date and times to the user. All internals are still UTC.
 */
$nx->config['timezone'] = 'Europe/Stockholm';


/**
 * Define internal character encoding
 */
$nx->config['character_encoding'] = 'UTF-8';


/**
 * Define language
 */
$nx->config['language'] = 'en';


/**
 * Define the controllers, their classname and enable/disable them.
 *
 * The array-key is matched against the url, for example: 
 * the url 'developer/dump' would instantiate the controller with the key "developer", that is 
 * CCDeveloper and call the method "dump" in that class. This process is managed in:
 * $nx->FrontControllerRoute();
 * which is called in the frontcontroller phase from index.php.
 */
$nx->config['controllers'] = array(
  'index'     => array('enabled' => true,'class' => 'CCIndex'),
  'developer' => array('enabled' => true,'class' => 'CCDeveloper'),
  'guestbook' => array('enabled' => true,'class' => 'CCGuestbook'),
  'content'   => array('enabled' => true,'class' => 'CCContent'),
  'blog'      => array('enabled' => true,'class' => 'CCBlog'),
  'page'      => array('enabled' => true,'class' => 'CCPage'),
  'user'      => array('enabled' => true,'class' => 'CCUser'),
  'acp'       => array('enabled' => true,'class' => 'CCAdminControlPanel'),
  'me'       => array('enabled' => true,'class' => 'CCMe'),
  'source'       => array('enabled' => true,'class' => 'CCSource')
);

/**
 * Settings for the theme.
 */
$nx->config['theme'] = array(
  // The name of the theme in the theme directory
  'name'    => 'core', 
);
