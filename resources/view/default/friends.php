<div class="container pt-5">

    <?php if (!$friends): ?><h3 class="text-center">У вас еще нет друзей</h3><? endif; ?>
    <div class="row">
        <div class="col-12">
            <h3>Взаимные друзья</h3>
            <? foreach($mutual as $user): ?>
            <a href="/id/<?= $user ?>">
                <div class="media text-muted pt-3 border-bottom">
                    <img src="<?= getAvatar($user) ?>" class="bd-placeholder-img mr-2 rounded" width="32"height="32">
                    <div><strong class="d-block text-dark text-gray-dark">@<?= $user ?></strong></div>
                </div>
            </a>
            <? endforeach;?>
        </div>
        <div class="col-12">
            <h3>Подписчики</h3>
            <? foreach($followers as $user): ?>
                <a href="/id/<?= $user ?>">
                    <div class="media text-muted pt-3 border-bottom">
                        <img src="<?= getAvatar($user) ?>" class="bd-placeholder-img mr-2 rounded" width="32"height="32">
                        <div><strong class="d-block text-dark text-gray-dark">@<?= $user ?></strong></div>
                    </div>
                </a>
            <? endforeach;?>
        </div>
        <div class="col-12">
            <h3>Подписки</h3>
            <? foreach($following as $user): ?>
            <a href="/id/<?= $user ?>">
                <div class="media text-muted pt-3 border-bottom">
                    <img src="<?= getAvatar($user) ?>" class="bd-placeholder-img mr-2 rounded" width="32"height="32">
                    <div><strong class="d-block text-dark text-gray-dark">@<?= $user ?></strong></div>
                </div>
            </a>
            <? endforeach;?>
        </div>

    </div>

    <div class="text-center">
        <a class="btn button btn-info" href="/messages/">Посмотреть мои сообщения</a>
    </div>

</div>
