# pjs
A microCMS for coding in Pyjamas


# Installation

How to install in 5 steps :

1 / Install via Composer :
  $ composer require pjs/pjs

2 / After that, you need to copy inside your project folder the content of the folder :
  "vendor/pjs/pjs"

3 / Then, to construct a fonctional database, go to your phpMyAdmin to import the file :
  app/pjs.sql

4 / And, for Pjs could access to the database, put your phpMyAdmin password in the file :
  app/config.php

5 / Finally, for front-end dependencies, type in your terminal :
  $ npm install


If something wrong :
- Check the config file & your PhpMyAdmin parameters to verify if passwords match
- Type in your terminal at the root of the project => $ composer dump-autoload
- Send an Issue => https://github.com/philippebeck/pjs/issues


# Overview

Pjs, a microCMS for coding in pyjamas !

You will find a lot of features to construct a website :
  Php classes provided by Pam, the Php Appoachable Microframework
  JavaScript functions provided by Jim, the Javascript Interactive Microlibrary
  Css classes provided by Sam, the Scss Animated Microframework
  Filters & classes in the views by Twig, the Symfony Template Engine
  And others tools provided by Pjs, the microCMS

Pjs is a study project, but don't hesitate to send issues or pull requests, I will watch them promptly with interest...


# Documentation

All documentations will be available the next week...


# Contribution

Pjs needs you if you like it : sends pull requests on GitHub to improve it !!
