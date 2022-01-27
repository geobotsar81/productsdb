# ProductsDB

[TOC]

## A. Project summary

## B. Process

Created Project
Install composer and npm packages
Created Model and Migration. Added indexes for columns that would be searchable
Created Product Seeder. Researched best way to seed big volume of data. Used chunking. Increased php memory limit on docker container
Seeded 2,000,000 x 2-3 times

## C Installation instructions

### 0. Run already setup project

Skip to Step 1 if the project has not been set up yet

     npm run docker-start (to start docker containers)
     npm run docker-watch (to npm watch for changes)

### 1. Setup repository

    git init
    git clone ...

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

    npm run docker-artisan -- migrate
    npm run docker-artisan -- db:sed

### 8. Run tests

    npm run docker-test
    npm run docker-dusk-test
