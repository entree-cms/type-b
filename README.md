Entree CMS type B
---

# Description
**Entree CMS type B** is CMS specialized for blogs based on the CakePHP3 framework.

# Installation
## 1. Run  "composer install" and "npm i".
```sh
$ cd /path/to/entree-cms/
$ composer install
$ npm i
```

## 2. Create the database for Entree CMS.

## 3. Set up config file.
You need edit **/.env**.

## 4. Initialize the database.
Entree CMS has migration files. You can initialize the database with following command.

```sh
$ cd /path/to/entree-cms/admin-12345
$ bin/cake migrations migrate
$ bin/cake migrations seed
```

## 5. Sing in
Access to https://yourdomain/admin-12345 and sign in with following account.

<dl>
<dt>User ID</dt><dd>admin</dd>
<dt>Password</dt><dd>12345</dd>
</dl>

# License
MIT
