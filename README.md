# Pico Private Plugin

Provide an authentication form to keep your [Pico](http://pico.dev7studios.com/) site or part of it private.

## Install

1. Download a copy and extract the folder `pico_private` in your `plugins` folder,
2. [Setup your theme](#setup-your-theme),
3. Test everything is working with user "admin" and password "admin",
4. Open the `pico_private_pass.php` file and insert your users and theirs password,
5. **REMOVE admin user**.

Pico executes plugins by alphabetical order. If we want to protect all our URLs even those generated from plugins, we must execute Pico Private first.
In order to execute Pico Private first, it's a good idea to prepend the folder's name with an underscore like `_pico_private`.

## How it works

By default, the whole site will be "protected" behind a login form, but it's possible to keep just some content private.

The plugin will display a login form when a user cannot access content without being identified.
Once logged in, the user will be able to browse your website normally.

Users and passwords are stored in `pico_private_conf.php` and you can add as many users you want.
Passwords must be a SHA1 string.

## Keep some part private

If you don't want the whole site to be private, you can change the configuration in `pico_private_conf.php`. The variable `$pico_private_conf['config']['private']` can take two values : 

* "all" : The whole site is private
* "meta" : Only content with meta `Private: true` will be private.

Keep in mind that once a user is identified, he can access every contents with private meta !

## Configuration

### Add users

Users are stored in an associative array : 

* Keys are usernames
* Values are SHA1 passwords

### Setup your theme

All you need to do is create inside your theme's folder a `login.html` page which will display the login form. The form is pretty simple : 

````html
<form method="post">
   {% if login_error %}<p class="error">{{ login_error }}</p>{% endif %}
   <input type="text" name="username" id="username" placeholder="Username" value="{{ username }}"/>
   <input type="password" name="password" id="password" placeholder="Password"/>
   <input class="alignright" type="submit" value="Login" />
   {% if redirect_url %}<input type="hidden" name="redirect_url" value="{{ redirect_url }}"/>{% endif %}
</form>
```

Then it's up to you to style the form to match your site design.

When the user is logged_in, the plugin adds two variables to the `$twig_vars`, that you can use in your theme : 

* `{{ authed }}` : Is user logged_in (boolean)
* `{{ username }}` : The username (string)

### Password only mode

If a single password is secure enough for your needs the easiest way is to change those two lines:

In your template file replace the username input field with:

```html
<input type="hidden" name="username" id="username" value="no_user"/>
```

In the pico_private_pass.php file add:

```php
$pico_private_conf['users']['no_user'] = '-hashedpw-';
```
