# li3_profiler

`li3_profiler` is a [Lithium](https://github.com/unionofrad/lithium) library for profiling requests built on [Jim Rubenstein](http://www.jimsc.com/)'s [PHP Profiler](https://github.com/jimrubenstein/php-profiler).

## Description

The library profiles the primary classes of your application and presents them in a concise report available on each page. Out of the box the library will profile the following:

* Routing
* Controller
* Session (_read, write_)
* Authentication (_check, set, clear_)
* Database queries
* View rendering

The injection of the report into the response is handled automatically by the library.

## Installation

Clone the repository from your `app/libraries` folder in your application and initialize submodules.

    $ cd app/libraries
    $ git clone https://github.com/joebeeson/li3_profiler
    $ git submodule init && git submodule update

Add the library to your application's `app/config/bootstrap/libraries.php` file.

    Libraries::add('li3_profiler');

Visit your application, you should see something similar to the following image...

![Example](http://i.imgur.com/9YxLE.png)

## Configuration

To view the available configuration options you should view the `li3_profiler/config/bootstrap.php` file to see everything available to you.

