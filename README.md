# ZF / Laminas Fundamentals -- Feb 2021

## Lab Notes
* Lab: New Project
  * Instructions for Laminas Skeleton: 
  * https://docs.laminas.dev/tutorials/getting-started/skeleton-application/

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
