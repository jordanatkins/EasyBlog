EasyBlog
========

EasyBlog is a simple, lightweight PHP blogging script.
It is open source and licensed under the Apache License, Version 2.0.

Contents:
* About
* Installing 
* Customising
* Contributing


About
========
EasyBlog was first made when I needed a small script for my old website, WordPress was too much for what I needed and was a pain to maintain, so I made this.
It is based on open source software, such as [Bootstrap, by Twitter](http://getbootstrap.com/2.3.2). Sicne it uses this, it's easy to change the way your entire blog/website looks, this is described in the customising section of this README.

Installing
==========
EasyBlog requires a few things installed on your web server. Before appempting to install the script, please make sure you have  [PHP](http://php.net/) and [MySQL](http://www.mysql.com/) installed on your web server.
Most web hosts have this, if they don't, you can probably contact support and ask them to install it on your server. If you're just testing it out on a local server, I suggest [USBWebServer](http://www.usbwebserver.net/), since it has MySQL and PHP.

Installation:
* Download the files from the official repo on [Github](https://github.com/oxafemble/easyblog).
* Upload the downloaded files to the root of your web server. You can upload them to some other directory, however you will neded to modify some code.
* Open includes/config.php and modify the database info to suit your MySQL server. You can also change $siteTitle to suit your site's title. However, this will be in the install page once I get around to finishing the script.
* Run /install.php in your browser and follow the prompts, after this your website will be ready to use.

Customising
===========

Since EasyBlog uses [Bootstrap](http://getbootstrap.com/2.3.2) 2.0, the entire site's style can be changed easily by modifying a few files.
Some free themes for Bootstrap can be downloaded from [Bootswatch](http://bootswatch.com/2/) for free. You can also make your own theme using the [customizer that Bootstrap provides](http://getbootstrap.com/2.3.2/customize.html).

Once you have the files, replace bootstrap-responsive.min.css and bootstrap.min.css with the new CSS files. Make sure you keep the file names the same.

If you download a specific theme, you may also have to replace JavaScript files. You can do this by replacing the files in assets/js/
You may also have to edit a bit of HTML, the structure of the pages can be changed by modifying includes/template.html. 

Contributing
============
We happily accept contributions, especially through pull requests on GitHub. Submissions 
must be licensed under the Apache License, Version 2.0.

Please read CONTRIBUTING.md for important guidelines to follow.