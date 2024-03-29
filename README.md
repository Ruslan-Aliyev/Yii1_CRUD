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

Run only specific migration script

```
./yiic migrate mark the_script_just_before
./yiic migrate
```

### Stored Procedures

In plain MySQL:
```
DELIMITER $$ -- Changes delimiter to $$ so can use ; within the procedure
CREATE PROCEDURE <Your-procedure-name>(<argument1><argument2>...<argumentN>)
BEGIN
	<Code-that-stored-procedure-executes>; -- Use the ; symbol within the procedure
END$$
DELIMITER ; -- Resets the delimiter
```
For example:
```
DELIMITER $$ -- Changes delimiter to $$ so can use ; within the procedure
CREATE PROCEDURE select_employees(IN thisDay datetime)
BEGIN
	select * 
	from employees 
    where probationEnds > thisDay
	limit 1000; -- Use the ; symbol within the procedure
END$$ 
DELIMITER ; -- Resets the delimiter
```
- https://www.mysqltutorial.org/getting-started-with-mysql-stored-procedures.aspx
- https://www.sqlshack.com/learn-mysql-the-basics-of-mysql-stored-procedures

In Yii v1 migration script
```php
class m220216_030106_create_stored_procedure_employees extends CDbMigration
{
    private $procName = 'sp_GetEmployees';

    public function safeUp()
    {
        $dropSql = "DROP PROCEDURE IF EXISTS $this->procName;";
        $this->execute($dropSql);

        $createSql = "
        CREATE PROCEDURE $this->procName (IN thisDay datetime)
        BEGIN
            select * 
            from employees 
            where probationEnds > thisDay
            limit 1000; -- Use the ; symbol within the procedure
        END;";
        
        $this->execute($createSql);
    }

    public function safeDown()
    {
        $this->execute("DROP PROCEDURE IF EXISTS $this->procName;");
    }
}
```
Calling it from eg model:
```php
public function retrieveEmployees($someDate)
{
    $someDate = $someDate . " 00:00:00";

    $sql = "CALL sp_GetEmployees(:someDate);";
    $params = ['params' =>
        [
            ':someDate' => $someDate
        ]
    ];

    return new CSqlDataProvider($sql, $params);
}
```
- https://www.yiiframework.com/doc/api/1.1/CSqlDataProvider

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

## GridView

`appname/protected/views/posts/viewname.php`
```php
<?php 
    $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'whateverid-grid',
        'dataProvider'=>$dataProvider,
        'columns'=>array(
            'id',
            'title',
            //...
            array(
                'class'=>'CButtonColumn',
            ),
        ),
    )); 
?>
```
https://www.yiiframework.com/doc/api/1.1/CGridView

`appname/protected/controllers/PostsController.php`
```php
    public function actionSomething()
    {
        $model=new Posts();
        $dataProvider = $model->getdata();

       $this->render('viewname',array(
            'dataProvider'=>$dataProvider
        ));
    }
```
https://www.yiiframework.com/doc/api/1.1/CActiveDataProvider

`appname/protected/models/Posts.php`
```php
    public function getdata()
    {
        $criteria = new CDbCriteria;
        // ...

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
```
https://www.yiiframework.com/doc/api/1.1/CDbCriteria

## Command, Cron, ..

https://www.yiiframework.com/doc/api/1.1/CConsoleCommand
