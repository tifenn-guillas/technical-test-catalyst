<?php

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

if (array_key_exists('help', $options)) {
    displayUsage($argv[0]);
}

// Check presence of args
if ((!array_key_exists('h', $options) or !array_key_exists('u', $options) or !array_key_exists('p', $options))
    or (array_key_exists('create_table', $options) and array_key_exists('file', $options))  // create_table and file are present
    or (!array_key_exists('create_table', $options) and !array_key_exists('file', $options)))   // create_table and file are absent
{
    displayUsage($argv[0]);
}

// Check MySQL connection
try {
    $dbh = new PDO('mysql:host=' . $options['h'], $options['u'], $options['p']);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage() . PHP_EOL;
    exit;
}

// Check value of file if necessary
if (array_key_exists('file', $options)) {
    if ($options['file'] == '--create_table' or $options['file'] == '--dry_run') {
        displayUsage($argv[0]);
    }
    if (!file_exists($options['file'])) {
        echo 'No such file or directory in ' . $options['file'] . PHP_EOL;
        exit;
    }
}

var_dump($options); // TODO: remove this line

function displayUsage($program) {
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
