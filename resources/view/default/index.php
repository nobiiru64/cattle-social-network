<!-- <h1>Hello, world</h1>

<button onclick="fetchMessage()">Fetch Message</button>
<p id="message">Click on the button to fetch the message.</p>
Мой профиль
-->
<section class="pt-5 text-center">
    <div class="container">
        <?php if ($loggedin): ?>
            Добро пожаловать, <b><?= $user ?></b>!

            <h3>Лента</h3>
            <div class="row justify-content-center">
                <div class="col-5">

                </div>
                <div class="col-2 pb-4 pr-5">
                    <div class="button btn-info btn jsSendFeed">Отправить</div>
                </div>
            </div>
            <div class="row justify-content-center jsCommentForm" style="display: none">
                <div class="col-6">
                    <label for="text"></label>
                    <div class="form-group">
                        <textarea class="form-control" name="text" cols="50" rows="3" id="text"></textarea>
                    </div>
                    <div class="jsSendMessage btn button btn-success mb-5">Отправить</div>
                </div>
            </div>
            <div class="align-items-center flex-column d-flex justify-content-center">
            <?php foreach ($feed as $item): $item = (object) $item; ?>

                <div class="col-6 pb-4 message" data-id="<?= $item->id ?>">
                    <div class="card <? if ($item->user == $this->user) echo 'my-message'; ?>"style="height: 100px">
                        <div class="row">
                            <div class="user col-2 pt-3 pl-4">
                                <img src="<?= getAvatar($item->user)  .'?' .rand(0,10000)?>" class="avatar-60">
                            </div>
                            <div class="col-8 pt-4">
                                <div class="d-flex flex-column align-items-start">
                                    <div>@<?= $item->user ?> <?= date("y.m.d h:i",strtotime($item->created_at));  ?></div>
                                    <div><?= $item->message ?></div>
                                </div>
                            </div>
                            <div class="col-2 pt-2 pr-4">
                                <? if ($item->user == $this->user): ?>
                                    <button type="button" data-id="<?= $item->id ?>" class="close" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                <? endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <? endforeach; ?>
            </div>


        <? else: ?>
        <span class="main">
            Добро пожаловать в <?= $appname ?>, Пожалуйста зайдите или зарегестрируйтесь чтобы войти.
        </span>
        <? endif; ?>
    </div>

</section>



