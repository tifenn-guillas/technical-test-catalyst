# Technical test Catalyst

## Requirements: 
- Ubuntu 16.04
- PHP7

## Installation

Install with Composer. If Composer is not installed on the system, an archive is included with the project. On the project directory:
```console
php composer.phar install
```
This command install the project and its dependencies.

## Dependencies

- [Doctrine2][1]: ORM

## Assumptions

- **CSV file columns**: I assumed there is only 3 columns, otherwise the file is considered as invalid. I assumed too, the first column is for the name, the second for the surname, and the last one for the email.
- **Database**: the name of the database is not given, so I called it 'catalyst'. It can be changed on the file `src/ArgsManager.php`.
- **Command create_table**: if a table 'Users' already exist, this one will be deleted with all of its data, and another one will be rebuilt without any data.
- **Email validation**: I followed PHP directive, see [PHP documentation][2] for more details. 

## Author

**Tifenn Guillas**
- <http://tifenn-guillas.fr>
- <http://github.com/tifenn-guillas>

[1]: http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/
[2]: http://php.net/manual/en/filter.filters.validate.php