## SP3
## Student/Project manager with ORM 
### How to run:
    1) Create schema named "myDB" in your database
    2) In terminal type: php composer.phar dump-autoload
    3) In terminal type: vendor/bin/doctrine orm:schema-tool:update --force --dump-sql
    4) Open index.php through localhost.