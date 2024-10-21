# News Aggregator API

A RESTful API for a news aggregation service built with Laravel and Docker.

## Features

- User authentication (register, login, logout, forget & reset password)
- Article management (CRUD operations)
- User preferences
- Personalized news feed
- Data aggregation from NewsAPI, The Guardian and New York Times

## Quick Start

1. Clone the repository:
    ```shell
    git clone git@github.com:EngineerSaudAhmad/news-aggregator.git
    cd news-aggregator-api
    ```


2. Copy `.env.example` to `.env` and configure your environment variables:

    ```shell
    cp .env.example .env
    ```

3. Build and start the Docker containers:

   ```docker-compose up -d```


4. Install dependencies and set up the application:

   ```shell
   docker-compose exec -it news-aggregator-app composer install
   docker-compose exec -it news-aggregator-app php artisan key:generate
   docker-compose exec -it news-aggregator-app php artisan migrate
   docker-compose exec -it news-aggregator-app php artisan db:seed
   ```

The API is now running at `http://localhost` and the API documentation is available at `http://localhost/api/documentation`.

## API Documentation

Detailed API documentation is available through Swagger UI. After setting up the project, visit `http://localhost/api/documentation` in your browser.

```shell
# To publish and updated Swagger UI.
docker exec -it news-aggregator-app php artisan l5-swagger:generate
```

## Additional Notes

- The application uses Laravel Sanctum for API authentication.
- Article data is aggregated from multiple sources using scheduled commands on daily basis.
  - To fetch article manually, run following command
    ```docker exec -it news-aggregator-app php artisan fetch:articles```
- The project follows Laravel best practices and SOLID principles.
