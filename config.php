<?php

!defined('ALPHA_NUM') && define('ALPHA_NUM', '/^[\w-]+$/');
!defined('ALPHA') && define('ALPHA', '/^[a-zA-Z]*$/');
!defined('DIGITS') && define('DIGITS', '/^\d+$/');
!defined('PAGE') && define('PAGE', '/(\d)+(#[A-Za-z_-]+)?/');
!defined('ROOT') && define('ROOT', __DIR__);

/**
 * ---------- Regex Strong Password ----------
 * ^: anchored to beginning of string
 * \S*: any set of characters
 * (?=\S{8,}): of at least length 8
 * (?=\S*[a-z]): containing at least one lowercase letter
 * (?=\S*[A-Z]): and at least one uppercase letter
 * (?=\S*[\d]): and at least one number
 */
!defined('PASSWORD') && define('PASSWORD', '/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/');

/**
 * DB GLOBAL VARIABLES
 */
!defined('DB_DSN') && define('DB_DSN', $DB_DSN);
!defined('DB_USER') && define('DB_USER', $DB_USER);
!defined('DB_PASSWORD') && define('DB_PASSWORD', $DB_PASSWORD);
