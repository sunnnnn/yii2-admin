<?php
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;
?>
<div class="content-wrapper">
        <?= Breadcrumbs::widget(
            [
        		'homeLink'=>[
        		   'label' => '主页',
        		   'url' => Url::to(['/site/index']),
        		],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        ) ?>

    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>