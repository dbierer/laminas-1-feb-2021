# ZF / Laminas Fundamentals -- Feb 2021

## Lab Notes
* For Fri 12 Feb 2021
  * Lab: New Module
    * Composer auto-load refresh:
```
php composer.phar dump-autoload
```
* Lab: New Project
  * Starting directory is this:
```
/home/vagrant/Zend/workspaces/DefaultWorkspace/
```
  * Download Composer 2 and place it in that directory
  * Skip step #4
  * Instructions for Laminas Skeleton: 
  * https://docs.laminas.dev/tutorials/getting-started/skeleton-application/
  * Make sure the path to the new project is as follows:
```
/home/vagrant/Zend/workspaces/DefaultWorkspace/onlinemarket.work
```
  * Move `composer.phar` into the `onlinemarket.work` folder just created
  * Correct syntax for installing the skeleton (from a terminal window):
```
cd /home/vagrant/Zend/workspaces/DefaultWorkspace/
wget https://getcomposer.org/composer.phar
php composer.phar create-project -s dev laminas/laminas-mvc-skeleton onlinemarket.work
mv composer.phar onlinemarket.work
```
  * To test the installation, from the browser: `http://onlinemarket.work/`

## TODO
* Find example of custom autoloader using `spl_autoload_register`

## Class Notes
* Documentation + overview
  * https://getlaminas.org

## VM Notes

### phpMyAdmin
* From the browser `http://localhost` page, the link to phpMyAdmin is wrong
  * Should be `http://phpmyadmin`
  * Highly recommended: update to the 5.0.4 release (from a terminal window)
  * From a terminal window, get phpMyAdmin
```
wget -O phpmyadmin.zip https://files.phpmyadmin.net/phpMyAdmin/5.0.4/phpMyAdmin-5.0.4-all-languages.zip
```
  * Unzip and rename the folder
```
unzip phpmyadmin.zip
mv phpMyAdmin-5.0.4-all-languages phpmyadmin
```
  * Modify the Apache host config file: change references from `/etc` to `/home/vagrant`
```
sudo gedit /etc/apache2/sites-available/phpmyadmin.conf
```
  * Save and exit
  * Restart the web server and test
```
sudo /etc/init.d/apache2 restart
```
  * Update the `localhost` main page.  Change the link from `http://localhost/phpmyadmin` to `http://phpmyadmin`
```
sudo gedit /var/www/html/index.html 
```

### onlinemarket.complete
* Correction needed in the following file:
```
/home/vagrant/Zend/workspaces/DefaultWorkspace/onlinemarket.complete/modules/Events/src/Controller/AdminController.php
```
* Change the following line:
```
$registrations = $this->regTable->findAllForEvent($eventId);
```
  * Change `regTable` to `registrationTable`
