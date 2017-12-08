<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title>404 - {{$config ? $config->name : ''}}</title>

    <link rel="stylesheet" href="/home/assets/css/reset.min.css">

    <link rel='stylesheet prefetch' href='/home/assets/css/googlefont.css'>

    <link rel="stylesheet" href="/home/assets/css/style.css">


</head>

<body>

<div class="content">
    <canvas class="snow" id="snow"></canvas>
    <div class="main-text">
        <h1>warning.<br/>该页面被大雪覆盖了！</h1><a class="home-link" href="/">点击返回首页</a>
    </div>
    <div class="ground">
        <div class="mound">
            <div class="mound_text">404</div>
            <div class="mound_spade"></div>
        </div>
    </div>
</div>

<script src="/home/assets/js/index.js"></script>

</body>
</html>
