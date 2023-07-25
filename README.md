# Create Invoice with API

`create-invoice-with-api` is a Laravel based invoice generation application. This application helps users to generate their invoices and presents them in JSON format.

## Installation

1. First, clone the project:
   git clone https://github.com/memisgunduz/create-invoice-with-api.git

2. After cloning the project, install the dependencies:
   cd create-invoice-with-api
   composer install

3. Create `.env` file and input your database configurations:
   cp .env.example .env
   php artisan key:generate

4. Create the database and seed the data:
   php artisan migrate --seed

## Usage

Run project:
php artisan serve
