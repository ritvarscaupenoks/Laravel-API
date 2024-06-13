## Movie database API

This project provides an API for managing a movie database and their TV broadcast schedules.

## Setup Instructions

**Clone the repository**:
    ```bash
    git clone https://github.com/ritvarscaupenoks/Laravel-Movies.git
    cd movies
    ```
**Install all the dependencies using composer**:
    ```bash
    composer install
    ```
**Copy the example env file and make the required configuration changes in the .env file**:
    - Copy the `.env.example` file to `.env`:
        ```bash
        cp .env.example .env
        ```
    - Update the `.env` file with your database configuration:
        ```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=your_database
        DB_USERNAME=your_db_username
        DB_PASSWORD=your_db_password
        ```
**Run migrations**:
    ```bash
    php artisan migrate
    ```
 **Start the development server**:
    ```bash
    php artisan serve
    ```
