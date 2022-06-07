## cURL

https://www.yiiframework.com/extension/yii-curl

## Render

https://www.yiiframework.com/doc/api/1.1/CController#render-detail

Eg: Returning a view at the end of a controller action

### Render Partial

https://www.yiiframework.com/doc/api/1.1/CController#renderPartial-detail

Ie: Rendering a repeated template

## Inserting JS from within PHP

https://www.yiiframework.com/doc/api/1.1/CClientScript#registerScript-detail

Eg:
```php
Yii::app()->clientScript->registerScript("any_name", <<<JavaScript
    console.log('testing');
JavaScript, CClientScript::POS_BEGIN
);
```

## Turning PHP output into a JS-compatible variable

https://www.yiiframework.com/doc/api/1.1/CJavaScript#encode-detail

Eg:
```js
var isSo = "<?= CJavaScript::encode($decider ? true : false); ?>";
```

## Active Record

### `setPrimaryKey(null)` 

https://www.yiiframework.com/doc/api/1.1/CActiveRecord#setPrimaryKey-detail

Just does `$model->id = null`, where the Primary Key is just id. But helps when the PK is not the ID column or is a composite key.

### `setIsNewRecord(true)`

https://www.yiiframework.com/doc/api/1.1/CActiveRecord#setIsNewRecord-detail

Updates the internal management of the model by Yii, when the model was loaded from the DB (or saved already) this is set to false. But setting this to true tells Yii to make the query on save() to be an INSERT instead of an UPDATE.

### findByAttributes

https://forum.yiiframework.com/t/findbyattributes-example/40656

## Generate URL

- https://www.yiiframework.com/doc/api/2.0/yii-web-urlmanager#createUrl()-detail
- https://www.yiiframework.com/doc/api/2.0/yii-web-urlmanager#createAbsoluteUrl()-detail
