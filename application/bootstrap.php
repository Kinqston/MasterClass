<?php

ini_set('display_errors', '0');     # don't show any errors...
error_reporting(E_ALL | E_STRICT);  # ...but do log them

require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';
require_once 'core/route.php';
require_once 'core/rights.php';
require_once 'core/user.php';
require_once 'core/database_info/info.php';
require_once 'core/model_authorization.php';
require_once 'core/validator.php';
Route::start();
