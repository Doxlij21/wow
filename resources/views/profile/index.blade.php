<!doctype html>
<html style="min-width: 1410px; background-color: #69797e;">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="initial-scale=1.0001, minimum-scale=0.7, user-scalable=yes"/>
    <script src="/js/jquery-3.2.1.min.js"></script>
    @extends('css.maincss')
    <script src="/js/login/loginWrap.js"></script>
    <script src="/js/login/login.js"></script>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>
<body style="display: none">
<div class="full-wrap">
    <div id="headerMover">
        <header>
        </header>
        <div id="content" class="indexNews">
            <div class="pageWidth">
                <div class="pageContent">
                    <div style="background: aqua;float:left;height: 500px;width: 150px;" id="profileMenu">
                        <form class="form" action="{{route('profile.post.menu', $user->id)}}" enctype="multipart/form-data">
                            <ul class="profileMenu">
                                <li class="profileMenuItem">
                                    <a href="#create static"> Create static </a>
                                </li>
                            </ul>
                            {!! csrf_field() !!}
                        </form>
                    </div>
                    <div>
                        <script>
                            var profilemenuitem = $('.profileMenuItem');
                            var output = document.querySelector('#profileContent');
                            var form = $(".form");

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            profilemenuitem.on("click", function(event) {
                                event.preventDefault();
                                var text = this.innerText;

                                $.ajax
                                ({
                                    type: 'POST',
                                    url: '{{route('profile.post.menu', $user->id)}}',
                                    data: { name: text },

                                    success:function(data)
                                    {
                                        console.log(text);
                                    }
                                    ,error:function(data)
                                    {
                                        debugger;
                                        alert("Error");
                                    }
                                });
                            });

                        </script>
                    </div>
                    <div style="background: brown;float: left;height: 500px;width: 1060px;" id="profileContent">
                        @if($menuFilter->menu_name == 'Create static')
                        <div id="static">
                            <div class="staticTitle">
                                <label for="staticTitle">Chose static title</label>
                                <input type="text" name="staticTitle">
                            </div>
                            <div class="staticUsers">

                            </div>
                        </div>
                        @else
                            321
                        @endif
                    </div>
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