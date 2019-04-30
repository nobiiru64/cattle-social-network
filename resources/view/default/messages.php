<div class="container pt-5">

    <? if ($member): ?>
        <div class="row text-center pb-5">
            <div class="col-3"><img class="avatar" src="<?= getAvatar($member) .'?' . rand(0,10000) ?>">
            <p class="pt-3"><?= ($member) ?></p></div>
            <div class="col-6"><?= $member_text ?></div>
        </div>
    <? endif;?>

    У вас <?= $message_count ?> Сообщений
    <form method="post" action="<?= $action ?>">
        <div class="form-group">
            <label for="comment">Наберите сообщение:</label>
            <textarea class="form-control" name="text" cols="40" rows="3" id="comment"></textarea>
        </div>
        На стену <input type="radio" name="pm" value="0" checked="checked">
        Личное <input type="radio" name="pm" value="1" />
        <input type="submit" class="btn btn-info" value="Отправить"></form><br>
    </form>
    <div class="row">
        <? foreach($messages as $key => $message): ?>
            <div class="col-12">
                <div> [<?= date('d.m.y h:i',$message['time']); ?>]
                    Написал <a href="/messages/<?= $message['auth'] ?>">
                        <?= $message['auth'] ?> </a> : <?= $message['message'] ?>
                    <? if ($message['pm']) echo "(Личное)" ?>
                </div>
            </div>
        <? endforeach; ?>
    </div>

</div>


