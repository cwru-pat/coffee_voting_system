
# Coffee Voting System [![Build Status](https://travis-ci.org/cwru-pat/coffee_stuff.svg?branch=master)](https://travis-ci.org/cwru-pat/coffee_stuff)

## Frontend Libraries & Extensions

 - [Bootstrap](http://getbootstrap.com/)
 - [jQuery](https://jquery.com/)
 - [selectize](https://github.com/brianreavis/selectize.js)
 - [bootstrap-datepicker](https://bootstrap-datepicker.readthedocs.org/en/latest/)
 - [Summernote](http://summernote.org/#/)
 - [Font Awesome](http://fortawesome.github.io/Font-Awesome/)
 - [Typewatch](https://github.com/dennyferra/TypeWatch)

## Server Dependencies

 - Install LAMP
   - Install Apache (`sudo apt-get install apache2`)
   - Install mysql (`sudo apt-get install mysql-server mysql-client`)
   - Install PHP (`sudo apt-get install php5`)
   - Link php/mysql: (`sudo apt-get install php5-mysql`)
 - Create a database/user. Log in to mysql (`mysql -u root -p`), and do something like:
   - `CREATE DATABASE coffee;`
   - `CREATE USER 'coffee'@'localhost' IDENTIFIED BY 'coffee';`
   - `GRANT ALL ON coffee.* TO coffee`
 - Download and unzip [phpCAS](https://wiki.jasig.org/display/casc/phpcas)
   - phpCAS requires php5-curl (`sudo apt-get install php5-curl`)
 - Set up [PHPCodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer), easiest via pear `sudo apt-get install php-pear` and `sudo pear install PHP_CodeSniffer`.
   - This can be run using a command like `phpcs --standard=PSR2 -n **/*.php` (Which travis-ci will check.)
 - Set up [jshint](http://jshint.com/) and [jscs](http://jscs.info/): `sudo apt-get install npm`, then install using `sudo npm install jshint -g` and `sudo npm install jscs -g`.
   - These can be run using a command like `jshint js` or `jscs js`.

## Setting up the script

 - Clone! `cd ` to the web directory (probably something like `cd /var/www`)
   - `git clone https://github.com/cwru-pat/coffee_stuff.git`
   - Change to this directory, `cd coffee_stuff`
 - Copy the settings file, `cp private/.default-config.php private/.config.php`. The file `private/.config.php` is ignored in .gitignore, so you can edit it without worrying about passwords being committed.
   - Edit the `$config['database'][...]` to reflect the mysql credentials created above.
   - Edit `$config['web']['path']` to point to the URL where you can view the system.
   - Edit `$config['phpCAS']['location']` to point to system path where the CAS.php file inside the phpCAS directory is (it should probably not be a subdirectory of this repo).
 - A pre-commit hook to run tests exists. Run `cp pre-commit .git/hooks/pre-commmit` to enable it.

## Notes
 - For database changes, tables that do not exist are created, but changes to existing tables need to be done by hand (for now).
 - To run tests by hand, try `./ci/ci-tests.sh`.
