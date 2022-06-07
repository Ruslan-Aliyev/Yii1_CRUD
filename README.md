# Install

Download at https://github.com/yiisoft/yii

# Setup

```
cd framework
./yiic webapp ../yii1_crud
```
A new folder called "yii1_crud" is created.

So now you have 

```
- yii1
    - demos
    - framework
    - requirements
    - yii1_crud
    composer.json
    ...
```

Most of the times, you'll be developing inside the `yii1_crud/protected` folder.

The initial look:

![](/Illustrations/initial_appearance.PNG)

# Default accounts

In `yii1_crud/protected/components/UserIdentity.php::authenticate()`, you will find that the 2 default credentials are:

- demo/demo
- admin/admin

## Deeper look into authentication

`yii1/yii1_crud/protected/controllers/UserController.php::actionLogin()`

`$model->login() // $model is LoginForm`

`yii1/yii1_crud/protected/models/LoginForm.php::login()`

`$this->_identity->authenticate(); // $this->_identity is UserIdentity`

`yii1_crud/protected/components/UserIdentity.php::authenticate()`

# Database

## Connnection Configs

`yii1_crud/protected/config/database.php`

## Migrations

Basic commands:

```
./yiic migrate create migration_script_name # create
./yiic migrate # migrate
./yiic migrate down 1 # rollback migration by 1. It can be any integer
```

## Active Record for Yii1

https://www.yiiframework.com/doc/api/1.1/CActiveRecord

## Relations

https://www.yiiframework.com/doc/guide/1.1/en/database.arr

# Gii Module

Enable it in `yii1_crud/protected/config/main.php::modules::gii`.

Set a password for it.

Access it by: `http://localhost/yii1/yii1_crud/index.php?r=gii`

# MVC Conventions

Route: `http://localhost/yii1/yii1_crud/?r={controller}/{action}`

Controller: `yii1/yii1_crud/protected/controllers/{Controller}Controller.php::action{Action}()`

View: `yii1/yii1_crud/protected/views/{controller}/{action}.php`

# Logs

Inside `yii1/yii1_crud/protected/runtime/application.log`

Log to it by `Yii::log('a string');` or `Yii::log(print_r($an_array, true));`

# Tutorial

https://www.youtube.com/playlist?list=PLRd0zhQj3CBnYFqV6YxkwBKIBFsj2Zc36

## Create DB table

Use Raw SQL:
```
CREATE TABLE `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(50) NOT NULL,
    `password` varchar(32) NOT NULL,
     PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

Or use migrations:

Inside `yii1/yii1_crud/protected` run `./yiic migrate create create_users_table`. A migration file in `yii1/yii1_crud/protected/migrations/` is created.

See `yii1/yii1_crud/protected/migrations/m220424_055800_create_users_table.php` to see how the equivalent is written using a migration script.

## MVC

Use Gii's Model Generator to create a model class for users. It will be `yii1/yii1_crud/protected/models/Users.php`

Just to check that all is working, write `<?php print_r( Users::model()->findAll() ); ?>` into `yii1/yii1_crud/protected/views/site/index.php`, see if the `users` table's contents gets regurgitated out.

Use Gii to generate controller and view for user.

Put `$users = Users::model()->findAll()` into `UserController::actionIndex()`. 

Pass `$users` onto view by `$this->render('index', ['users_key' => $users]);`.

You can receive it in view as `<?php $users_key ... ?>`.
