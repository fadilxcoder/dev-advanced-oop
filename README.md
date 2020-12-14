# Packages used from packagist.org

### Required

- https://packagist.org/packages/vlucas/phpdotenv
- https://packagist.org/packages/josantonius/session
- https://packagist.org/packages/ramsey/uuid
- https://packagist.org/packages/symfony/http-foundation
- https://packagist.org/packages/catfan/medoo

### Required --dev

- https://packagist.org/packages/tracy/tracy
- https://packagist.org/packages/fzaninotto/faker

# Notes

-   `"autoload": {`
-   `    "psr-4": {"Codebase\\": "app/"}`
-   `}`
- folder `app` with files having namespace `Codebase`
- After adding the autoload snippet, use command `composer dump-autoload` in docker cli.
- GOTO `src` folder and change files/folders permission : `sudo chown -R <your_file_owner_user_name> ./ && chgrp -R <your_file_owner_group_name> ./`
- Use command : `php bin/console database:init` to populate DB with data

# File Structure

- `router.php` : Defined routes in array
- `loader.php` : Handle application logics
- `bin/console` : CLI to run command - add more command in file to trigger specific action
- `assets` : JS & CSS
- `view` : Consist of layouts file
- `app/Fixtures/DataFixtures.php` : Data to be populated in DB
- `app/Managers/DbManager.php` : Singleton for DB connection
- `app/Managers/ViewManager.php` : Process the view file to be displayed
- `app/Services/UserManagementService.php` : DB queries service
