<?php

namespace Catalyst;

use Catalyst\Entity\User;
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
        if (!$this->argsManager->getCreateTable()) {
            $this->checkExistingFile();
        }
    }

    public function run() {
        if ($this->argsManager->getCreateTable()) {
            // TODO: create table
            echo 'CREATE TABLE' . PHP_EOL;
        } else {
            $this->parseFile();
        }
    }

    private function checkDatabaseConnection() {
        try {
            $this->em->getConnection()->connect();
        } catch (\Exception $e) {
            exit('Connection failed: ' . $e->getMessage() . PHP_EOL);
        }
    }

    private function checkExistingFile() {
        $file = $this->argsManager->getFile();
        if (!file_exists($file)) {
            echo 'No such file or directory in ' . $file . PHP_EOL;
            exit;
        }
    }

    private function createTable() {}

    private function parseFile() {
        $file = fopen($this->argsManager->getFile(), 'r');
        while (($line = fgets($file)) !== false) {
            $tabLine = explode(',', $line);
            if ($this->checkNbCol($tabLine) and $this->checkName($tabLine) and $this->checkEmail($tabLine)) {
                $user = new User();
                $user->setName(ucwords(strtolower(trim($tabLine[0]))));
                $user->setSurname(ucwords(strtolower(trim($tabLine[1]))));
                $user->setEmail(strtolower(trim($tabLine[2])));
                $this->em->persist($user);
            }
        }
        fclose($file);
        if (!$this->argsManager->getDryRun()) {
//            $this->em->flush(); // TODO: test ORM
            echo PHP_EOL . 'All correct records are stored.' . PHP_EOL;
        }
    }

    private function checkNbCol($array) {
        if (count($array) != 3) {
            echo 'Wrong format: ' . implode(',', $array); // TODO: Throwing an Exception
            return false;
        }
        return true;
    }

    private function checkName($array) {
        $firstname = trim($array[0]);
        $lastname = trim($array[1]);
        if (!preg_match("/^[a-zA-Z\s-']*$/", $firstname) or !preg_match("/^[a-zA-Z\s-']*$/", $lastname)) {
            echo 'Invalid name: ' . implode(',', $array); // TODO: Throwing an Exception
            return false;
        }
        return true;
    }

    private function checkEmail($array) {
        if (!filter_var(trim($array[2]), FILTER_VALIDATE_EMAIL)) {  // TODO: documentation filter email
            echo 'Invalid email: ' . implode(',', $array); // TODO: Throwing an Exception
            return false;
        }
        return true;
    }
}