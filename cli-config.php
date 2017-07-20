<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
require_once 'user_upload.php';

return ConsoleRunner::createHelperSet($entityManager);