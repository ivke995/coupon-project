
# Project Title

Coupon Generator Generate all types of coupons for your application.

Built With PHP Laravel Bootstrap Installation Make a new folder at your local machine. 
Inside that folder open CLI or Git Bash and run following git command.
```bash
git clone https://github.com/ivke995/coupon-project
```
# Run app

In your CLI or Git Bash, enter the root of folder where your project has been created.

Run following command.
```bash
composer install
```

After successfully composer installation run following command.
```bash
composer update
```

Run app Before you run project you must edit env variables inside .env file.

```bash
DB_CONNECTION=mysql 
DB_HOST=127.0.0.1 DB_PORT=3306 
DB_DATABASE=YOUR DB NAME 
DB_USERNAME=YOUR DB USERNAME 
DB_PASSWORD=YOUR DB PASSWORD 
```
If you don't have npm, you must install it.


php artisan serve Project should be serverd on http://localhost:8000

Running migration and seeders To run migrations and seeders for you database, run following command.
```bash
php artisan migrate:refresh --seed 
```
Credentials for login 
```bash
email: marko@gmail.com 
password: 12345   
```
If you want to register more users, you must uncomment register route inside "web.php" file,and hit:
 ```bash
 http://127.0.0.1:8000/auth/register 
```
// Features::registration(),
## Demo

Insert gif or link to demo


## Deployment

To deploy this project run

```bash
  
```
