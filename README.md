# WhizbizForum Module Script
The Whizbiz Business Listing CMS Forum Module where ideas and views on a particular issue can be exchanged.

# Features
- Easy Forum Settings Configration in Admin Panel
- Adsense Ads place ready
- Google Analytics code ready
- reCaptcha Validation for anti bot
- Lock and Unlock Topic Post
- Pin and Unpin Topic Post
- Set topic permission if only admin can post or open for everyone.
- Social Login Facebook and Google +
- Synchronize Session Login with Whizbiz Script
- SEO Url Friendly

# Baseon Codeigniter Framework 
Is an open-source software rapid development web framework, for use in building dynamic web sites with PHP

# Installation
First you must have a whizbiz Busniness Directory CMS can be bought in codecanyon which is worth $32

Second read the documentation and follow the instruction in the docu

# Author
Hello my name is Clinton from Philippines, I made this module for my Whizbiz Script since I would like to add a forum for my users.

# Demo
https://www.waraywarayako.ph

https://forum.waraywarayako.ph/


Add .htaccess file
--------------------

.htaccess is a configuration file for use on web servers running the Apache Web Server software. When a .htaccess file is placed in a directory which is in turn 'loaded via the Apache Web Server', then the .htaccess file is detected and executed by the Apache Web Server software. These .htaccess files can be used to alter the configuration of the Apache Web Server software to enable/disable additional functionality and features that the Apache Web Server software has to offer. These facilities include basic redirect functionality, for instance if a 404 file not found error occurs, or for more advanced functions such as content password protection or image hot link prevention.

Write this codes below:

	- RewriteEngine On
	- RewriteCond %{REQUEST_FILENAME} !-f
	- RewriteCond %{REQUEST_FILENAME} !-d
	- RewriteRule ^(.*)$ index.php/$1 [L]

