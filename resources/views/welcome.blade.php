<!doctype html>
<html style="min-width: 1410px; background-color: #69797e;">
<head>
    <meta name="viewport" content="initial-scale=1.0001, minimum-scale=0.7, user-scalable=yes"/>
    <script src="/js/jquery-3.2.1.min.js"></script>
    @extends('css.maincss')
    <script src="/js/login/loginWrap.js"></script>
    <script src="/js/login/login.js"></script>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>
<body style="display: none;">
@guest

@else
    @include('layouts.header')
@endguest
<div class="full-wrap">
    <div id="headerMover">
        <header>
        </header>
        <div id="content" class="indexNews">
            <div class="pageWidth">
                <div class="pageContent">
                    @guest
                        @lang('words.hello')
                        @include('layouts.mainlogin')
                        <div id="changelogs">
                            <div class="title">
                                Changelogs
                            </div>
                            <div class="text">
                                Alpha version 0.1
                            </div>
                        </div>
                    @else

                    @endguest
                </div>
            </div>
        </div>
    </div>
    <div id="overlays"></div>
</div>
<footer>
</footer>
</body>
<script src="/js/menu/menu.js"></script>
</html>