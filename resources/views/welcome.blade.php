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
            @include('layouts.lang.lang')
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
                        @if(count($usercharacters) > 0)
                                <div onClick="$('.showNoti').toggle()">
                                    <span style="color: red">{{count($usercharacters)}}</span> new notifications
                                </div>
                            <div class="showNoti" style="display: none">
                                @foreach($usercharacters as $usercharacter)
                                    <a href="{{route('mark.asread',$usercharacter->id)}}">
                                        <li>You're character: {{$usercharacter->battlenet_user_character_name}} invited to this static: {{\App\WowStatic::find($usercharacter->static_id)->static_name}}</li>
                                    </a>
                                @endforeach
                            </div>
                        @else
                        @endif
                        {{--@foreach($usercharacters->characters as $usercharacter)--}}
                            {{--@if(count($usercharacter->noticharacters) > 0)--}}
                                {{--@foreach($usercharacter->noticharacters as $noticharacter)--}}
                                    {{--<li>--}}
                                        {{--You're character {{$noticharacter->static_guests_names}} invited to this static {{\App\WowStatic::find(\App\StaticGuests::find($noticharacter->notifiable_id)->static_id)->static_name}}--}}
                                    {{--</li>--}}
                                {{--@endforeach--}}
                            {{--@else--}}
                            {{--@endif--}}
                        {{--@endforeach--}}
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
<script src="/js/lang/lang.js"></script>
<script src="/js/menu/menu.js"></script>
</html>