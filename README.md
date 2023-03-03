# Docker configuration for PHP Laravel Application
This repository will contain basic docker configuration with docker-compose.yml and Dockerfile for run PHP laravel project

# Instructions
- Clone the repository
- run ```mkdir src``` in root directory
- run ```mkdir mariadb``` in root directory
- run ```docker-compose build && docker-compose up -d```

Now your environment is ready.

### Now you need to create your laravel application into src directory.
You PHP docker environment is symlink with src directory. So you need to access to your PHP docker environment and open bash or shell.
For achieve it, you need to run
```
docker exec -it php_8 /bin/sh      
```

Now you can run ```composer create-project laravel/laravel .```
. used for install laravel in current directory. 

After install of laravel you can see laravel is installed in src directory, and you can update your application from src directory.