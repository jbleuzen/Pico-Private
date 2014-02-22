# Pico Private Plugin

Provide an authentication form to keep your [Pico](http://pico.dev7studios.com/) site or parts of it private.

## Install

1. Download a copy and extract the folder `pico_private` in your `plugins` folder,
2. [Setup your theme](#setup-your-theme),
3. Test everything is working with user "admin" and password "admin",
4. Open the `pico_private_pass.php` file and insert your users and theirs password,
5. **REMOVE admin user**.

Pico executes plugins by alphabetical order. If we want to protect all our URLs even those generated from plugins, we must execute Pico Private first.
In order to execute Pico Private first, it's a good idea to prepend the folder's name with an underscore like `_pico_private`.

## How it works

The content of selected pages will only be visible after the user is sucessfully logged in.

The plugin will display a login form when a user is not logged in.
Once logged in, the user will be able to browse your website normally.

Users and passwords are stored in `pico_private_pass.php` and you can add as many users you want.
Passwords must be a SHA1 string.

### Add users

Users are stored in an associative array : 

* Keys are usernames
* Values are SHA1 passwords

### Setup your theme

If you want to protect **all pages** you have to alter your main template file (usually index.html). 
Find the "{{content}}" part and add change it to:
````html
{% if authed %}
    {{ content }}
{% else %}
    <form method="post" action="">
       {% if login_error %}<p class="error">{{ login_error }}</p>{% endif %}
       <input type="text" name="username" id="username" placeholder="Username" value="{{ username }}"/>
       <input type="password" name="password" id="password" placeholder="Password"/>
       <input class="alignright" type="submit" value="Login" />
    </form>
{% endif %}
```

If you want to protect **single pages** duplicate your main template file, rename it to "private.html" and add the same lines as above.
On every *.md file you want to protect:
Add the following to the meta comment:
````html
Template: private
````


Then it's up to you to style the form to match your site design.

When the user is logged_in, the plugin adds two variables to the `$twig_vars`, that you can use in your theme : 

* `{{ authed }}` : Is user logged_in (boolean)
* `{{ username }}` : The username (string)
