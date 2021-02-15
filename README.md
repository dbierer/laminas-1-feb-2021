# ZF / Laminas Fundamentals -- Feb 2021

## Lab Notes
* For Wed 17 Feb 2021
  * Lab: Creating and Accessing a Service
* For Mon 15 Feb 2021
  * Lab: Using a Built-in Controller Plugin
  * Lab: Using a Custom Controller Plugin
  * Lab: New Controllers and Factories
    * **IMPORTANT**: use `Laminas` in place of `Zend`!

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
* If you see an error that indicates page not found:
  * Check the routing configuration in `/module/MODULE/config/module.config.php`
  * Check to see if module is on `/config/modules.config.php`
  * Check to see if the module is listed in `composer.json` under `autoload`.`psr-4`
  * Also: if it produces output: make sure the `view_manager` key is set in `/module/MODULE/config/module.config.php`
  * Check to see if a view template has been created
* Documentation + overview
  * https://getlaminas.org
* Using tools to generate components
  * PHPCL Laminas-Tools
```
php composer.phar require phpcl/laminas-tools
vendor/bin/phpcl-laminas-tools module|controller `pwd` MODULE_NAME|CLASS
```
* To create a controller (using the PHPCL Laminas Tools)
```
/bin/phpcl-laminas-tools controller `pwd` Market\\Controller\\ViewController
```
  * To generate a factory:
```
vendor/bin/generate-factory-for-class Namespace\\Class\\Name
// or
vendor/bin/phpcl-laminas-tools factory `pwd` Namespace\\Class\\Name
```
* To create a controller plugin (using the PHPCL Laminas Tools)
```
/bin/phpcl-laminas-tools controller-plugin `pwd` Market\\Controller\\Plugin\\TimePlugin
```
  * And then: fill in the logic for the `__invoke()` method in the `TimePlugin` class
  * Review `Market/config/module.config.php` and make sure there's an entry under `controller_plugins`
  * When you use the plugin, reference it using the `alias` name
* To enable development mode:
   * Creates a symlink for `/config/development.config.php.dist` to `/config/development.config.php`
```
php composer.phar development-enable
```
* To disable development mode:
```
php composer.phar development-disable
```


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
