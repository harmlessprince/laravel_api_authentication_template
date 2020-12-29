# Laravel API Authentication Template

Laravel API Authentication Template is a fresh laravel 8 apllication, that makes use of **laravel passport** for authentication.


We all know laravel supports web authentication out of the box using session. But this support is not readily available for API. 

We will have to make use of third party extentsions such as paspport  or sanctum. I decided to create an API template to make development much easier for developers. 

Below is the step to follow to make use of this template

## Step 1: Cloning the repository

It is either you download the repo or clone it using your terminal. To clone the repo,
Navigate to the folder were you will be lunching your project, then run the command below 

```
git clone git@github.com:harmlessprince/laravel_api_authentication_template.git
```

After cloning successfully, you should see the file downloaded successfully downloaded to the directory you specified. 

## Step 2: Editing your enviroment variables
Laravel comes with a file called **.env.example**, with all typical configuration values.

```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_auth_api_template
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

```
But for you to able to run project on you local machine. We need to do three things

 1.  Create a file .env in the root of your project.

 2. Copy that example file contents into the created .env file with this command on linux or just use your normal copying of content technique suitable for your opersting system.
 ```
 cp .env.example .env
 ```
3. Edit the new .env file, in your text editor. You can change a lot of variables  but the main ones you need to change or add to your .env file are these.

```
APP_NAME="Basic Laravel Api Auth Template"
APP_ENV=local
APP_KEY=
APP_DEBUG=false
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=yourdatabasename
DB_USERNAME=databaseusername
DB_PASSWORD=databasepassword
```

## Step 3: Running composer install
Let run this "magic" command 
```
composer install
```
On this step, you may accounter some errors if some pacjages are not compatible wth you php version or extensions. So check or any messages and fix before proceding to the next step.

Incase of success, it looks like something like this

```
Installing dependencies from lock file (including require-dev)
Verifying lock file contents can be installed on current platform.
Nothing to install, update or remove
Generating optimized autoload files
> Illuminate\Foundation\ComposerScripts::postAutoloadDump
> @php artisan package:discover --ansi
Discovered Package: facade/ignition
Discovered Package: fideloper/proxy
Discovered Package: fruitcake/laravel-cors
Discovered Package: laravel/passport
Discovered Package: laravel/sail
Discovered Package: laravel/tinker
Discovered Package: nesbot/carbon
Discovered Package: nunomaduro/collision
Package manifest generated successfully.
79 packages you are using are looking for funding.
Use the `composer fund` command to find out more!

```

## Step 4: Generate application key.
We need to run this command: 
```
php artisan key:generate
```
It generates a random key which is automatically added to .env file **APP_KEY** variable.


## Step 5:  Passport install

This command will create the encryption keys needed to generate secure access tokens. In addition, the command will create "personal access" and "password grant" clients which will be used to generate access tokens:

```
php artisan passport:install
```


## Step 6: Migrating DB Schema.
In order to migrate we need to lunch this

```
php artisan migrate
```

then let seed the database.
```
php artisan db:seed
```
To speed up the process, you may run two commands above as one

```
php artisan migrate --seed
```

## Created Controllers
### AuthController
This controller consist of three major methods login, register, logout, user.

  #### Login  
  This method is in charge of the login in of user and authentication of user.

   #### Register 
  This method is charge of creating new users for the application.

   #### Logout 
  This method is in charge of the login out of user from the current device. It revokes the authenticated user token.


### ForgotContoller
This method consist of two methods, forgot and reset.
   #### forgot
   This method is in charge of sending forgot password email address to the user.

   #### reset
   This method updates the user password in the database, it checks if both the token and email supplied is valid.

### VerificationController 
This contoller contains of two methods as well.
   ### verify 
   This method is used to verify the user email address, It firs checks if the supplied signatures is valid, if user id is exist and then verifies the email address. then redirect the user to specified address.

   ### send
   This method is for resending verification email address to authenticated users. Some users might careless delete verification email address.

##  Available API Routes. 

### User 
Request Description: This request is used for getting authenticated user data

url: /user

method: user

action: get

### Register 
Request Description: This request is used for registering users into the database. If user is successfully registerd, email is sent to user for email verification. 

url: /register

method: register

action: post


### Login

Request Description: This request is used login user into the application

url: /login

method: login

action: post



### logout
Request Description: This request is used logout authenticataed user out of the application

url: /logout

method: logout

action: get

### Forgot password

Request Description: This request is used for send forgot password email to given email address

url: /forgot-password

method: forgot

action: post

### Reset password 


Request Description: This request is used to update the signature and token  password

url: /reste-password

method: reset

action: post


### Verffy Email


Request Description: This request is used for verifying user email address. 

url: /email/verify/{id}

method: verify

action: get

### Resend Email 

Request Description: This request is used to resend email verification notification to authenticated user 

url: /email/resend

method: verify

action: get




