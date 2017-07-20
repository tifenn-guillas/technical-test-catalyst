<?php

namespace Catalyst;

use Doctrine\ORM\EntityManager;

class App
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var ArgsManager
     */
    private $argsManager;

    /**
     * @param EntityManager $em
     * @param ArgsManager $argsManager
     */
    public function __construct(EntityManager $em, ArgsManager $argsManager) {
        $this->em = $em;
        $this->argsManager = $argsManager;
        $this->checkDatabaseConnection();
        $this->checkExistingFile();
    }

    public function run() {
        // TODO: parse file
        // TODO: create table
    }

    private function checkDatabaseConnection() {
//        try {
//            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->database;
//            $dbh = new \PDO($dsn, $this->username, $this->password);
//            $dbh = null;
//        } catch (\PDOException $e) {
//            echo 'Connection failed: ' . $e->getMessage() . PHP_EOL;
//            exit;
//        }
    }

    private function checkExistingFile() {
        $file = $this->argsManager->getFile();
        if (!file_exists($file)) {
            echo 'No such file or directory in ' . $file . PHP_EOL;
            exit;
        }
    }
}