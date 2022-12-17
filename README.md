- Clone the project to your local
- Please make sure you have Docker installed in your local
- Run the following commands in order in the main directory of the project
    * docker-compose build
    * docker-compose up -d
    * docker exec soccer_manager_backend php artisan migrate (for the first time)
    * docker-compose down (to stop project)
- phpMyAdmin link: http://localhost:8081/
