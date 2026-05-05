<?php

$cfg['blowfish_secret'] = getenv('PHPMYADMIN_BLOWFISH_SECRET') ?: 'local-docker-phpmyadmin-secret';

$i = 0;
$i++;

$cfg['Servers'][$i]['auth_type'] = 'cookie';
$cfg['Servers'][$i]['host'] = getenv('DB_HOST') ?: 'db';
$cfg['Servers'][$i]['port'] = getenv('DB_PORT') ?: '3306';
$cfg['Servers'][$i]['compress'] = false;
$cfg['Servers'][$i]['AllowNoPassword'] = false;

$cfg['TempDir'] = '/var/lib/phpmyadmin/tmp';
