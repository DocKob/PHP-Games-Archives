Devana - the open source browser strategy game
-------------
Read the "license.txt" file for information about copyright.
Requirements: http web server, mysql database system, php, openssl.
Before using this code make sure you have the latest versions of the above mentioned software requirements.

Installation steps:
1. create a database in mysql;
2. import the "install/devana.sql" file in the database you just created;
3. edit the database connection data in the "devana/core/config.php" file;
4. optionally, edit the email settings in the "devana/core/email/email.php" file;
5. go to the install page "http://localhost/devana/install/install.php"
 to add the admin account and map data to the database;
    - optionally, you can edit the map you'll be using by changing the "install/grid.png" image;
     - each pixel represents one map sector;
     - blue (RGB: 0 0 255) is for water, green (RGB: 0 255 0) is for land;
6. delete the "install" folder;

For more information visit http://devana.eu.