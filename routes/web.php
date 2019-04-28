<?php
use Cattle\App;
App::get('/','\Cattle\Controller\MainController@index');
App::get('/404','\Cattle\Controller\MainController@notFound');

App::get('/profile','\Cattle\Controller\ProfileController@index');
App::get('/friends','\Cattle\Controller\FriendsController@index');


App::get('/messages/:user','\Cattle\Controller\MessagesController@showMessages');
App::post('/messages/:user','\Cattle\Controller\MessagesController@showMessagesPost');
App::get('/messages/','\Cattle\Controller\MessagesController@index');
//App::post('/messages/','\Cattle\Controller\MessagesController@showMessagesPost');

App::get('/signup','\Cattle\Controller\MainController@signup');
App::post('/signup','\Cattle\Controller\MainController@signupPost');

App::get('/login','\Cattle\Controller\MainController@login');
App::post('/login','\Cattle\Controller\MainController@loginPost');

App::get('/users','\Cattle\Controller\MembersController@index');
App::get('/add/:user', '\Cattle\Controller\MembersController@addFriend');
App::get('/remove/:user', '\Cattle\Controller\MembersController@removeFriend');
App::get('/id/:user', '\Cattle\Controller\MembersController@showProfile');
App::get('/id/', '\Cattle\Controller\MembersController@index');

App::get('/logout','\Cattle\Controller\MainController@logout');

App::post('/api/text','\Cattle\Controller\ProfileController@changeUserDescription');
App::post('/api/avatar','\Cattle\Controller\ProfileController@uploadUserImage');


