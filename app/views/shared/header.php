<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title><?= isset($title) ? $title : 'Painel Visitadores' ?></title>
        <link rel="icon" href="https://static.wixstatic.com/media/5ede7b_719545c97a084f288b8566db52756425%7Emv2.png/v1/fill/w_192%2Ch_192%2Clg_1%2Cusm_0.66_1.00_0.01/5ede7b_719545c97a084f288b8566db52756425%7Emv2.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
        <link rel="stylesheet" href="/assets/custom.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const burger = document.querySelector('.navbar-burger');
                const menu = document.getElementById('navbarMenu');
                if (burger && menu) {
                    burger.addEventListener('click', function () {
                        burger.classList.toggle('is-active');
                        menu.classList.toggle('is-active');
                    });
                }
            });
        </script>
    </head>
    <body>