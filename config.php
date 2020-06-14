<?php

require 'environment.php';

global $config;

if (ENVIRONMENT == 'development') {
    $config['dbname'] = 'telecon';
    $config['host'] = 'localhost';
    $config['dbuser'] = 'root';
    $config['dbpass'] = '';
} else {
    $config['dbname'] = 'telecon';
    $config['host'] = 'phpmyadmin.tares.arvixe.com';
    $config['dbuser'] = 'teleconmysql';
    $config['dbpass'] = 'telecon';
}