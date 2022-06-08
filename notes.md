## cURL

https://www.yiiframework.com/extension/yii-curl

## Render

https://www.yiiframework.com/doc/api/1.1/CController#render-detail

Eg: Returning a view at the end of a controller action
```php
public function actionIndex()
{
    // ...
    $this->render('index', array(
        'data'=>$data,
    ));
}
```

### Render Partial

https://www.yiiframework.com/doc/api/1.1/CController#renderPartial-detail

Ie: Rendering a repeated template

Eg:
```php
$renderedAsString = $this->renderPartial('_partial_view', $data, true); // true means not to display, but return as string
```

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

**Full Example**

```php
$something = new Something();
$something->created = new CDbExpression('NOW()'); // https://www.yiiframework.com/doc/api/1.1/CDbExpression
$something->updated = new CDbExpression('NOW()');
$something->createdby = $someUser->id;
$something->updatedby = $someUser->id;
$something->setPrimaryKey(null);
$something->setIsNewRecord(true);

if (!$something->save())
{
    // Give some errro
}
```

### `findByAttributes`

https://forum.yiiframework.com/t/findbyattributes-example/40656

## Generate URL

### `createUrl`

https://www.yiiframework.com/doc/api/2.0/yii-web-urlmanager#createUrl()-detail

### `createAbsoluteUrl`

> This method prepends the URL created by `createUrl()` with the `$hostInfo`. 

So it gives the full URL (beginning with `http...`), not the relative URL (beginning with `/...`)

https://www.yiiframework.com/doc/api/2.0/yii-web-urlmanager#createAbsoluteUrl()-detail

Eg: `Yii::app()->createAbsoluteUrl('path/to/' . $id)`
