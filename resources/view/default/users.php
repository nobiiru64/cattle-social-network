<div class="container pt-5">
    <h3 class="text-center">Люди</h3>
    <? foreach($users as $user => $status): ?>
    <a href="/id/<?= $user ?>">
        <div class="media text-muted pt-3 border-bottom">
            <img src="<?= getAvatar($user) ?>" class="bd-placeholder-img mr-2 rounded" width="32"height="32">
            <div><strong class="d-block text-dark text-gray-dark">@<?= $user ?></strong>
                [<a href="/add/<?= $user ?>">Следить</a>]
                [<a href="/remove/<?= $user ?>">Удалить</Удалить></a>] <?= $status ?>
            </div>
        </div>
    </a>
    <? endforeach; ?>
    <ul>
        <? foreach($users as $user => $status): ?>

        <? endforeach; ?>
    </ul>

</div>
