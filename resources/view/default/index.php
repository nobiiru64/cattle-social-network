<!-- <h1>Hello, world</h1>

<button onclick="fetchMessage()">Fetch Message</button>
<p id="message">Click on the button to fetch the message.</p>
Мой профиль
-->
<section class="pt-5 text-center">
    <div class="container">
        <?php if ($loggedin): ?>
            Добро пожаловать, <?= $user ?>!
        <? else: ?>
        <span class="main">
            Добро пожаловать в <?= $appname ?>, Пожалуйста зайдите или зарегестрируйтесь чтобы войти.
        </span>
        <? endif; ?>
    </div>

</section>



