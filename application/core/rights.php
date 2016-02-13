<?php
define('U_VIEW', 1 << 0);   // 0001
define('U_EDIT', 1 << 1); // 0010 EDIT
define('U_PROFESSOR', U_VIEW | U_EDIT);
define('U_USER', U_VIEW);