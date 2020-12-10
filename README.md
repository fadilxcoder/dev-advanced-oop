# Packages used from packagist.org

### Required

- https://packagist.org/packages/vlucas/phpdotenv
- https://packagist.org/packages/josantonius/session

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
