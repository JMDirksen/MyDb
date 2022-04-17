# MyDb

## Requirements

    sudo apt install apache2 php mariadb-server php-mysql

## Setup database

Don't forget to change "mySecurePassword" in below code.

    sudo mariadb
      create database mydb;
      create user mydb@localhost identified by "mySecurePassword";
      grant all privileges on mydb.* to mydb@localhost;
      flush privileges;

    sudo mariadb mydb < db.sql

## Configuration

Copy or rename the `config.template.php` to `config.php`  
Set the password in `config.php` to the one used in the code above.
