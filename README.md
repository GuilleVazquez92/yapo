# Challenge presented to Yapo.cl (Laravel 9,Inertia-SSR - Vue3 - Bootstrap 5)

This challenge is built  with Laravel 9 setup, InertiaJs with Server Side Rendering (SSR), Vue Js 3 and Bootstrap 5

## Project in Production

In order to add value to this project, I uploaded it to a server at the following address:
http://164.92.92.162/
- The project is mounted on a cloud server.
- It is mounted on Digital Ocean with Ubuntu 22.10 and LAMP configuration

## Application video tutorial 
https://www.loom.com/share/703bac334d6c4a9195886ab1bf51f449

## Requirements

* PHP 8.0 or latest
* Node 14 or latest

## How to start 

```bash
$ cp .env.example .env # setup your database
$ composer install
$ php artisan key:gen
$ npm install
$ npm run dev # optional only if any changes you make in resource/js
$ php artisan migrate --seed
$ php artisan serve
```

## Compile Assets

```bash
$ npm run dev
```

or

```bash
$ npm run watch
```


## Available endpoints
### Production
* http://164.92.92.162/api/search_tracks
* http://164.92.92.162/api/fav

### Others
* base_url/api/search_tracks
* base_url/api/fav

## Constructing Searches
### get api/search_tracks
This get request expects the name parameter as input.
* Example: http://164.92.92.162/api/search_tracks?name=Radiohead

### post api/fav
This post request receives the following arguments in JSON format :artistName, trackId, user, trackName.
* Example : POST http://164.92.92.162/api/fav  with the following body:
* {"artisName": "Radiohead",
"cancion_id": 125,
"usuario" : "sebastian",
"ranking" : "5/5"
}

### Run test
Go to the App folder and run the following command:
* php artisan test
