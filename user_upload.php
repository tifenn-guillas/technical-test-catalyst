<?php
require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Catalyst\ArgsManager;
use Catalyst\App;

$paths = array("./src/Entity");
$isDevMode = false;

$shortOpts = "h:";  // MySQL host required
$shortOpts .= "u:"; // MySQL username required
$shortOpts .= "p:"; // MySQL password required

$longOpts  = array(
    "help",         // display usage
    "create_table", // build MySQL users table
    "file:",         // file required
    "dry_run",      // run script without database change
);

$options = getopt($shortOpts, $longOpts);
$options['program'] = $argv[0];

$argsManager = new ArgsManager($options);
$params = $argsManager->getParams();

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'host'     => $params['h'],
    'dbname' => $params['db'],
    'user'     => $params['u'],
    'password' => $params['p'],
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);

$app = new App($entityManager, $argsManager);
$app->run();