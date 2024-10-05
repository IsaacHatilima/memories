## Laravel + Vue Starter project

This starter project is made using Laravel Breeze with Vue.js, the two work together through Inertia.

- [Laravel](https://laravel.com).
- [Inertia](https://inertiajs.com/).
- [Vue Js](https://vuejs.org/).

## Why?

Having a stater project with the essential basics can speed up your development process. This starter template is
created with the laravel command to create new projects.
After getting the fresh out of the box app. I refactored some of the controllers to move the logic to service classes to
that should there be need for an API, the code base already allows for that scaling.

Two-Factor Authentication with [Laravel Fortify](https://laravel.com/docs/11.x/fortify) was also added for extra
security. Because the app is using Fortify for authentication, you can modify the login process in the
[FortifyServiceProvider.php](https://github.com/IsaacHatilima/laravel-vue-starter/blob/master/app/Providers/FortifyServiceProvider.php)
. A ModelHelper class to handle **public_id** was also added because we don't want to have our primary keys in the url.

## Installation

To run the starter app locally, make the required changes to your **.env** file and run the following commands.

- ```composer install```
- ```php artisan key:generate```
- ```php artisan migrate```
- ```npm install```
- ```npm run dev```
- ```php artisan serve```


