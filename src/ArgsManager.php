<?php

namespace Catalyst;

class ArgsManager
{
    /**
     * @var string
    */
    private $host;

    /**
     * @var string
     */
    private $database = 'catalyst';

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $file;

    /**
     * @var boolean
     */
    private $createTable;

    /**
     * @var boolean
     */
    private $dryRun;

    /**
     * @var boolean
     */
    private $help;

    /**
     * @var string
     */
    private $program;

    /**
     * ArgsManager constructor.
     */
    public function __construct($options)
    {
        $this->initArgs($options);
        $this->checkArgs();
    }

    /**
     *
     */
    private function initArgs($options) {
        $this->program = $options['program'];
        $this->host = isset($options['h']) ? $options['h'] : null;
        $this->username = isset($options['u']) ? $options['u'] : null;
        $this->password = isset($options['p']) ? $options['p'] : null;
        $this->file = isset($options['file']) ? $options['file'] : null;
        $this->createTable = isset($options['create_table']);
        $this->dryRun = isset($options['dry_run']);
        $this->help = isset($options['help']);
    }

    /**
     *
     */
    private function checkArgs() {
        if ($this->help) {
            $this->displayUsage();
        }

        // Check presence of args
        if ((!$this->host or !$this->username or !$this->password)
            or ($this->createTable and $this->file)     // create_table and file are present
            or (!$this->createTable and !$this->file))  // create_table and file are absent
        {
            $this->displayUsage();
        }

        // Check value of file if necessary
        if ($this->file == '--create_table' or $this->file == '--dry_run') {
            $this->displayUsage();
        }
    }

    /**
     *
     */
    private function displayUsage() {
        $program = $this->program;
        echo "
This program store into a MySQL database users data provided by a CSV file.

  Usage:
  $program --help
  $program -h <host> -u <username> -p <password> --create_table
  $program -h <host> -u <username> -p <password> [--dry_run] --file <filename>
  
  Options:
  --help                This help.
  -h <host>             MySQL host.
  -u <username>         MySQL username.
  -p <password>         MySQL password. 
  --create_table        Create the users table to MySQL.
  --file <filename>     Path to the CSV file to be parsed.
  --dry_run             Run the script without store users in MySQL.
  \n
";
        exit;
    }

    /**
     * @return array
     */
    public function getParams() {
        return array(
            'h' => $this->host,
            'db' => $this->database,
            'u' => $this->username,
            'p' => $this->password,
            'createTable' => $this->createTable,
            'dryRun' => $this->dryRun,
            'file' => $this->file
        );
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return bool
     */
    public function getCreateTable()
    {
        return $this->createTable;
    }

    /**
     * @return bool
     */
    public function getDryRun()
    {
        return $this->dryRun;
    }

    /**
     * @return string
     */
    public function getProgram()
    {
        return $this->program;
    }

}