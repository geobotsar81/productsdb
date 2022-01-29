# ProductsDB

The task at hand was to create a product database, seed it with 5m+ products, and display some statistical data in charts by querying the database.

-   Statistics/Charts demo at: https://productsdb.george-botsaris.com/statistics
-   Products pagination demo at: https://productsdb.george-botsaris.com/

## A. Problem analysis

There were 2 main areas to focus when tackling the above task.

-   The first was how to handle seeding the database with this amount of data.
-   The second was how to best query the data from the db and display the statistics, in the most fast and efficient way.

### A1. Tech Stack

-   To develop the application, Laravel was used, along with Inertiajs and Vuejs. By using Inertiajs it means that there is a tight coupling of the backend with the frontend, but in my opinion this overweights the complexity of having two mainten 2 web apps, along with exposing an api and routing.
-   MYSQL was used for the database, and although other alternatives like MongoDB might have been better, this was a matter of using what i was familiar with for the allocated time, and from some research it seems that MYSQL can handle well data up to 100m+ records.

### A2. Seeding the database

-   The best way to seed the database was using chunks in the database seeder. That meant splitting the seeding in smaller pieces/chunks in order to avoid memory exhaustion issues.
-   Further to that, insert was used db instead of db create as it is faster, and the product array was emptied in each iteration to avoid memory leakage.
-   Lastly the php memory limit on the docker container was increased, as the default 128M didnt give a lot of room to work with.

### A3. Querying the database

-   During the initial migration 3 indexes were created for the columns that would be queried. This would help for fetching the queried data from the database faster.
-   While querying the database the Query Builder was used instead of Eloquent, for better performance.
-   For pagination, simple paginate was used instead of paginate, to avoid db count in the pagination query, which slowed down the operations.
-   All statistical data were generated by executing queries on the database usin the Query Builder, instead of fetching the data and then using Collections methods to generate the statistics.
-   After the sql queries where finalized, i have decided to split them into 5 calls instead of one. This way the axios calls were able to run in parallel, which improved the performance x5.

### A4. Application performance monitoring

-   Sentry was installed on the backed and frontend in order to be able to monitor the application's performance.
-   Also some queries times were tracked with microtime and displayed in the statistics section along with the charts.

## B. Project files

-   Global Styles: resources/css/app.scss.
-   Vue components: resources/js/Pages && resources/js/Shared && resources/js/Layouts.
-   Routes: routes/web.php.
-   Product Model: app/Models/Product.php - The Product Model.
-   Product Controller: app/Http/Controllers/ProductController.php - The Product Controller.
-   Product Repository: app/Repositories/ProductRepository.php - handles any database related operations.
-   Product Request: app/Http/Requests/SearchFormRequest - handles form fields validation.
-   Product Seeder: database/Seeders/ProductSeeder.php - handles seeding of the database.

## C Installation instructions

### Run already setup project

Skip to Step 1 if the project has not been set up yet

     npm run docker-start (to start docker containers)
     npm run docker-watch (to npm watch for changes)

### 1. Setup repository

    git init
    git clone git@github.com:geobotsar81/productsdb.git

### 2. Setup docker containers

    sudo mkdir docker/mysql && sudo chmod -R 777 docker
    npm run docker-build

#### 2a. Edit etc/hosts and point your nginx ip address to your domain

    sudo nano /etc/hosts
    172.10.0.6 productsdb.example

### 3. Install composer dependancies

    docker compose run --rm composer install

### 4. Install npm dependancies

    docker compose run --rm npm install

### 5. Fix file permissions

    sudo chmod -R o+w storage/ bootstrap/

### 6. Create storage link

    docker compose run --rm artisan storage:link

### 7. Run Migrations and seed database

    docker exec -it php8 /bin/bash
    php artisan migrate
    php artisan db:seed

### 8. Run tests

    npm run docker-test
    npm run docker-dusk-test

### 9. Other

    docker exec -it php8 /bin/bash
