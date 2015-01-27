<?php

global $pico_private_conf;
/*
 * "Private" setting can take 2 values :
 * - all : the whole site is private
 * - meta : files with the meta "private: true" are private
 */
$pico_private_conf['config']['private'] = "meta";

/*
 * The key is the username and the value is the sha1 hash of the password
 * Use a tool like http://www.sha1-online.com to generate.
 */
$pico_private_conf['users']['admin'] = 'd033e22ae348aeb5660fc2140aec35850c4da997';

