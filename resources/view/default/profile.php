<div class="container pt-5 ">

    <? if (!$not_created): ?>
    <h3 class="text-center">Пользователь <?= $member ?></h3>

    <style>

    </style>
    <div class="row text-center">
        <div class="col-3"><img class="avatar" src="<?= $member_avatar .'?' . rand(0,100) ?>"></div>
        <div class="col-6"><?= $text ?></div>
        <div class="col-12">
            <a href="/messages/<?= $member ?>/" class="btn btn-outline-secondary">Написать</a>
        </div>
    </div>

    <? else: ?>
        <h3 class="text-center">Пользователь еще не создал свой профиль</h3>
    <? endif; ?>


</div>
