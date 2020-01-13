<?php

use yii\helpers\Html;
use app\assets\AppAsset;
use yii\grid\GridView;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>

    <?= GridView::widget([
        'dataProvider' => $provider,
        'columns' => [
            [
                'attribute' => 'name',
                'label' => 'имя'
            ],
            /* [
                'attribute' => 'birth',
                'label' => 'возраст'
            ], */
            [
                'label' => 'полных лет',
                'value' => function ($data) {
                    return (int)Yii::$app->formatter->asRelativeTime($data->birth);
                },
            ],
        ],
    ]) ?>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>