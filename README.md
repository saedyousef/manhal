# After cloning this project make the following:

## Install the googleapi sdk in your project
``composer install``

#### You may need to configure the database credientials at
`` /path_to_project/Constants/Credentials.php ``

#### Once you've done with the database credentials you need to open your browser and initiailze the migration
hit `` http://localhost/migration.php`` this command need to be executed one time

#### Make sure the server in your webserver virtual host/nginx block is ``localhost`` to make sure that the google callback will reach out the application 
