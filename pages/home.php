<?php

use App\Controllers\Database;

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Font Awesome -->
    <link
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
            rel="stylesheet"
    />
    <!-- Google Fonts -->
    <link
            href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
            rel="stylesheet"
    />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"> -->
    <title>Dev chat</title>
    <style>
        body {
            background: #fcfcfc;
        }

        #all_mess {
            max-height: 350px;
            overflow: auto;
            padding-right: 20px;
        }
    </style>
</head>
<body>
<!-- Создание меню на сайте (без функций) -->
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <h5 class="my-0 mr-md-auto">Dev chat</h5>
    <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="#">Главная</a>
        <a class="p-2 text-dark" href="#">Про мемы</a>
        <a class="p-2 text-dark" href="#">Крипта</a>
        <a class="p-2 text-dark" href="#" title="$$$$">Сколько ты зарабатываешь?</a>
    </nav>
    <button id="join-chat" class="btn btn-outline-primary" data-toggle="modal" data-target="#reg">Вход в чат</button>
    <button id="exit-chat" class="d-none btn btn-outline-primary">Выйти из чата</button>
</div>

<!-- Основная часть страницы -->
<div class="container">
    <div class="py-5 text-center">
        <h2>Чат разработчиков и других бездельников</h2>
        <p class="lead">Укажите ваше имя и начинайте переписку</p>
    </div>
    <div class="row">
        <div class="col-4">
            <!-- Форма для получения сообщений и имени -->
            <h3>Форма сообщений</h3>
            <form id="messForm" class="d-none" action="#" method="post">
                <label class="form-label" for="name">Ваш никнейм:</label>
                <b id="nick">Nickname</b>
                <br>
                <div class="input-group mt-3 mb-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile02">
                        <label class="custom-file-label" for="inputGroupFile02">Добавьте картинку</label>
                    </div>
                </div>
                <label class="form-label" for="message">Сообщение</label>
                <textarea name="message" id="message" rows="5" class="form-control"
                          placeholder="Введите сообщение"></textarea>
                <br>
                <input type="submit" value="Отправить" class="btn btn-primary">
            </form>
            <h6 id="123" class="alert alert-info">
                Войдите в чат чтобы отправить сообщение
            </h6>
        </div>
        <div class="col-6">
            <div class="head d-flex justify-content-between">
                <h3>Сообщения</h3>
                <span>В чате онлайн: <span id="users-online">0</span></span>
            </div>
            <!-- Вывод всех сообщений будет здесь -->
            <div id="all_mess">
                <!-- Ниже пример структуры которую нужно распечатывать 1 вид сообщения это сообщение от нас 2 вид от других людей -->
                <!--
                    Виды цвета сообщений:
                    success
                    primary
                    secondary
                    danger
                    warning
                    info
                -->
                <?php
                $lastMessages = Database::getAll("SELECT * FROM `messages` ORDER BY id ASC LIMIT 20");
                foreach ($lastMessages

                as $item){
                ?>
                <div class="alert alert-<?= $item['color'] ?> col-6">
                <p class="d-flex justify-content-between align-items-center">
                    <span><?= $item['name'] ?></span>
                    <span class="d-none text-right badge badge-dark">Admin</span>
                </p>
                <img class="d-none" style="width: 100px; height: 100px; object-fit: cover;" class=""
                     src="https://yt4.ggpht.com/e2vhsw7wa0sO-QSqS3BzRhj-LkmSllra0-AjIi8kpM0PX3A9kfvsXJX8IWUhiEfFCaQXfmfPEoM=s32-c-k-c0x00ffffff-no-rj"
                     alt="">
                <p class="mt-2">
                    <?= $item['message'] ?>
                </p>
            </div>
            <?php
            }
            ?>

        </div>
    </div>
        <div class="col-2">
            <div class="head d-flex justify-content-between">
            <h3>Пользователи</h3>
        </div id="users">

            <div style="display: flex; justify-content: space-around">
                <h7>имя</h7>
                <span>онлайн</span>
            </div>
        </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="reg" tabindex="-1" role="dialog" aria-labelledby="reg" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="loginForm" action="#" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Вход в чат</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label class="form-label" for="name">Введите никнейм</label>
                <input type="text" name="name" id="name" placeholder="Введите никнейм" class="form-control">
                <br>
                <label class="form-label" for="color">Ваш цвет в чате</label>
                <select name="color" class="custom-select" id="color">
                    <option value="success" selected>Зеленый</option>
                    <option value="primary">Синий</option>
                    <option value="secondary">Серый</option>
                    <option value="danger">Красный</option>
                    <option value="warning">Оранжевый</option>
                    <option value="info">Небесный</option>
                </select>
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-primary">Отправить</button>
            </div>
        </form>
    </div>
</div>

<script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
<script src="../assets/js/script.js"></script>
</body>
</html>