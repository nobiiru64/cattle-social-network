<div class="container pt-5 ">
    <h3 class="text-center">Ваш профиль</h3>
    <div class="row text-center">
        <div class="col-12">
            <img class="avatar" src="<?= getUserAvatar() .'?' . rand(0,10000) ?>">
            <p class="pt-3"><?= $user ?></p>
        </div>
        <div class="col-12">
            <?= $text ?>
        </div>
    </div>
    <div class="row justify-content-center">
        <form method="POST" action="/api/avatar/" enctype="multipart/form-data">
            <div class="row">
                <div class="col-12">
                    <label for="text"></label>
                    <div class="form-group">
                        <label for="comment">Описание:</label>
                        <textarea class="form-control" name="text" cols="50" rows="3" id="text"><?= $text ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="custom-file">
                        <input type="file" name="image" size="14" class="custom-file-input" id="validatedCustomFile">
                        <label class="custom-file-label" for="validatedCustomFile">Выберете аватар..</label>
                        <div class="invalid-feedback">Example invalid custom file feedback</div>
                    </div>
                </div>
                <div class="col-2">
                    <input type="submit" class="btn btn-outline-secondary" value="Save Profile">
                </div>
            </div>
        </form>
    </div>
</div>
