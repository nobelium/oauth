Oauth
=====

> A minimalistic Open Authentication Provider in php

The Oauth server mainly handles three types of requests

- Login by users
- Authenticating Client
- Api calls

In short, when the client wants to use a users credential,

- The user is redirected to a login page with the client key 
- The server creates a request token if the user is successfully authenticated.
- The client then requests the server for a access token using the request token and the clients secret
- If the client secret and the request token are found to be generic, the client is 
provided a access token

This access token can be used with all the requests made by client to authenticate the client.

Installation
------------
Clone the repository

```git clone git@github.com:nobelium/oauth.git```

Edit the config file

```emacs -nw ./oauth/class/config.inc.php```

Import the Mysql dump

Make sure you have installed mod_rewrite for apache
Don't forget to add the repo to /etc/httpd/conf so as to allow rewrite rule

* * *

This is a very minimalistic Oauth provider. This can be scalled to authentica client with different type of permissions