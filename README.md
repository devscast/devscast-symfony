# devs-cast.com
[![Build Status](https://travis-ci.com/devscast/velocom-pwa.svg?branch=master)](https://travis-ci.com/devscast/devs-cast.com)


Numeric Builders - We develop web solutions.

We are freelance developers based in DRC and RSA, specializing in creating (and sometimes modeling) websites and applications of exceptional quality.

## Features
### Frontend
* [x] search and paginate blog post
* [x] search and paginate vidéo
* [ ] comment on videos and blog post
* [x] contact form with google-recaptcha
* [ ] authentication for users
* [ ] user's account
* [ ] course and code source download link
* [ ] online payments for course
* [ ] e-mail newsletter subscription

### Backend
* [x] authentication for admins
* [x] CRUD blog posts
* [x] CRUD videos
* [ ] upload videos
* [x] CRUD tags
* [ ] CRUD courses
* [ ] newsletter management
* [ ] users management
* [ ] incomes management
* [ ] XLS, CSV, PDF export for incomes

#### Languages 
* [ ] English
* [x] French

## How to contribute

* Fork the repo on your github
* Clone your forked repo 
* Add or choose an issue at https://github.com/devscast/finance-manager/issues
* Do not change a feature or function that is not relevant to your issue.
* Make your changes
* Commit fast, Commit often , keep it optional
* Commit with A Clear message
* Push your changes on your forked repo
* Make a pull request to the original repo
* If a conflict occurs when you ask Git to merge your code, try to resolve it with a new commit

## Software requirements

* PHP Version 7.4
* Mysql >= 5.5
* Nodejs >= 10.1

## Set up the App

```bash
$ git clone https://github.com/devscast/finance-manager.git finance
$ cd finance
$ composer install
$ npm install
$ npm run build

## database setup create .env.local conforming with .env
$ php bin/console doctrine:database:create
$ php bin/console doctrine:migrations:migrate

## run app
$ php -S localhost:8000 -t public 
```

## Screenshots

##### Current frontend
![frontend](https://github.com/bernard-ng/devscast-symfony/blob/master/.github/screenshots/frontend.png "Frontend")

##### Current Backend
![backend](https://github.com/bernard-ng/devscast-symfony/blob/master/.github/screenshots/backend.png "Backend")
