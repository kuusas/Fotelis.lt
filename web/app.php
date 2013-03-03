<?php
if (!defined('SILEX_ENV')) define('SILEX_ENV', (getenv('SILEX_ENV')?getenv('SILEX_ENV'):'prod'));
require_once __DIR__.'/../app/bootstrap.php';