<?php
use sunnnnn\admin\auth\components\helpers\MenuHelper;
use sunnnnn\admin\auth\components\widgets\Menu;
?>

<aside class="main-sidebar">
    <section class="sidebar">
        <?=
            Menu::widget([
                'options' => ['class' => 'sidebar-menu'],
                'items' => MenuHelper::getAssignedMenu(),
            ]);
        ?>
    </section>
</aside>