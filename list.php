<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список - Архыз</title>
    <script language="JavaScript" type="text/javascript"
            src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script>

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap"
          rel="stylesheet">
    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
    <link rel="manifest" href="img/favicon/site.webmanifest">
    <link rel="mask-icon" href="img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="css/style.css">
    <style>
        .modal-delete {
            position: fixed;
            top: 0;
            left: 0;

            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;

            background-color: rgba(0, 0, 0, .5);
            opacity: 1;
            z-index: 100;
        }

        .modal-delete__content {
           
            width: fit-content;
            margin: 30px;
            height: fit-content;
            background-color: white;
            z-index: 100;
            padding: 20px;
        }

        .modal-delete__alert {
            margin: 0 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    
        .modal-delete__text {
            font-family: "Manrope";
            font-size: 14px;
        }

        .modal-delete__btn-group {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .modal-delete__btn {
            font-family: "Manrope";
            font-size: 14px;
            padding: 10px 15px;
            min-width: 70px;
        }
    
        .hide {
            display: none;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <a href="/r" class="back title">Назад</a>
    </div>
    <form class="search" onsubmit="return false">
        <input type="text" id="searchText" oninput="searchingProcessing(this.value)" class="search__input title"
               placeholder="Найти человека" autocomplete="off">
        <!--        <input value="" " type="submit" class="search__btn">-->
        <img hidden style="margin-left: 10px" id="gif_load" width="40" height="40" src="img/loading.gif" alt="загрузка...">
    </form>
    <div class="list" id="list">
        <?php
        require_once 'bd-con.php';
        //ЗАПОЛНЯЕМ ЛИСТ
        fillList($_GET['where']);
        ?>
    </div>
</div>
<div class="modal-delete hide">
    <div class="modal-delete__content">
        <div class="modal-delete__alert">
            <span class="modal-delete__text">Вы действительно хотите удалить пользователя?</span>
        </div>
        <div class="modal-delete__btn-group">
            <button class="modal-delete__btn">Да</button>
            <button class="modal-delete__btn">Нет</button>
        </div>
    </div>
</div>
<?php require_once 'js/connect_js.php'; ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.list__btn').forEach(btn => {
            btn.onpointerdown = e => {
                let timeOut = setTimeout(e => {
                    document.querySelector('.modal-delete').classList.remove('hide')
                    btn.onclick = event => {
                        event.preventDefault()
                    }
                }, 1000)

                document.onpointerup = e => {
                    clearTimeout(timeOut)
                }
            }
        })
    })
</script>
</body>
</html>