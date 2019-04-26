<?php
$app->get('/','Nobiiru\Controller\MainController@index');
$app->get('/404','Nobiiru\Controller\MainController@notFound');

$app->get('/profile','Nobiiru\Controller\ProfileController@index');
$app->get('/friends','Nobiiru\Controller\FriendsController@index');


$app->get('/messages/:user','Nobiiru\Controller\MessagesController@showMessages');
$app->post('/messages/:user','Nobiiru\Controller\MessagesController@showMessagesPost');
$app->get('/messages/','Nobiiru\Controller\MessagesController@index');
//$app->post('/messages/','Nobiiru\Controller\MessagesController@showMessagesPost');

$app->get('/signup','Nobiiru\Controller\MainController@signup');
$app->post('/signup','Nobiiru\Controller\MainController@signupPost');

$app->get('/login','Nobiiru\Controller\MainController@login');
$app->post('/login','Nobiiru\Controller\MainController@loginPost');

$app->get('/users','Nobiiru\Controller\MembersController@index');
$app->get('/add/:user', 'Nobiiru\Controller\MembersController@addFriend');
$app->get('/remove/:user', 'Nobiiru\Controller\MembersController@removeFriend');
$app->get('/id/:user', 'Nobiiru\Controller\MembersController@showProfile');
$app->get('/id/', 'Nobiiru\Controller\MembersController@index');

$app->get('/logout','Nobiiru\Controller\MainController@logout');

$app->post('/api/text','Nobiiru\Controller\ProfileController@changeUserDescription');
$app->post('/api/avatar','Nobiiru\Controller\ProfileController@uploadUserImage');


