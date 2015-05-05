<?php

global $pico_private_conf;
/*
 * "Private" setting can take 2 values :
 * - all : the whole site is private
 * - meta : files with the meta "private: true" are private
 */
$pico_private_conf['config']['private'] = "meta";

/*
 * set the hashing algorithm to use
 * - "sha1" 
 * - "bcrypt" : requires the password_verify function available in PHP 5.5, or PHP >= 5.3.7 with https://github.com/ircmaxell/password_compat
 *
 */
$pico_private_conf['config']['hash_type'] = "sha1";

/*
 * The key is the username and the value is the sha1/bcrypt hash of the password
 * Use a tool like http://www.sha1-online.com to generate sha1.
 * Use a tool like https://www.dailycred.com/article/bcrypt-calculator to generate bcrypt.
 */
$pico_private_conf['users']['admin'] = 'd033e22ae348aeb5660fc2140aec35850c4da997';

