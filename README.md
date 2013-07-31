# Pico Private Plugin

Provide an authentication form to keep your site private.

## Install

1. Download a copy and extract the folder `pico_private` in your `plugins` folder,
2. [Setup your theme](#setup-your-theme),
3. Test everything is working with user "admin" and password "admin",
4. Open the `pico_private_pass.php` file and insert your users and theirs password,
5. **REMOVE admin user**.


## How it works

The whole site will be "protected" behind a login form.

The plugin will display a login form when a user is not logged in.
Once logged in, the user will be able to browse your website normally.

Users and passwords are stored in `pico_private_pass.php` and you can add as many users you want.
Passwords must be a SHA1 string.

### Add users

Users are stored in an associative array : 

* Keys are usernames
* Values are SHA1 passwords

### Setup your theme

All you need to do is create inside your theme's folder a `login.html` page which will display the login form. The form is pretty simple : 

````html
<form method="post" action="">
   {% if login_error %}<p class="error">{{ login_error }}</p>{% endif %}
   <input type="text" name="username" id="username" placeholder="Username"/>
   <input type="password" name="password" id="password" placeholder="Password"/>
   <input class="alignright" type="submit" value="Login" />
</form>
```

Then it's up to you to style the form to match your site design.

When the user is logged_in, the plugin adds two variables to the `$twig_vars`, that you can use in your theme : 

* `authed` : Is user logged_in (boolean)
* `username` : The username (string)
