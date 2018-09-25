# TODO List
This is a small project to understand and practice how to create an Rest API.

The project is created with **Laravel Framework 5.7.5** and **PHP 7.2.4**

### Steps to install the project:
1. Install **Composer**
2. Run **composer install**
3. Create **.env** file
4. Run **php artisan key:generate**
5. Create your database
6. Add configuration to .env file
7. Run **php artisan migrate**
8. Run **php artisan db:seed** (only in Dev environment)
9. Use these endpoints:
#### For get all users
GET: api/json/v1/users

#### For get all users with its todos
GET: api/json/v1/users?include=todos
