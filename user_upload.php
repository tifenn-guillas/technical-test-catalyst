<?php

$shortOpts = "h:";  // MySQL host required
$shortOpts .= "u:"; // MySQL username required
$shortOpts .= "p:"; // MySQL password required

$longOpts  = array(
    "help",         // display usage
    "create_table", // build MySQL users table
    "file",         // file required
    "dry_run",      // run script without database change
);

$options = getopt($shortOpts, $longOpts);

if (array_key_exists('help', $options)) {
    displayUsage($argv[0]);
    exit;
}

function displayUsage($program) {
    echo "
This program store into a MySQL database users data provided by a CSV file.

  Usage:
  $program --help
  $program -h <host> -u <username> -p <password> --create_table
  $program -h <host> -u <username> -p <password> --file <filename> [--dry_run]
  
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
}
