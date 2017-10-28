<div id="selectLanguage" style="cursor: pointer">Select you'r language</div>
<div style="display: none" id="chooseLang">
    <form id="sendLangEN" method="post" name="lang" action="{{route('lang.post' ,'en')}}" enctype="multipart/form-data">
        <a href="#" onclick="document.getElementById('sendLangEN').submit();">
            <img width="50px" height="50px" src="/images/lang/uk.png">
        </a>
        {!! csrf_field() !!}
    </form>
    <form id="sendLangRU" method="post" name="lang" action="{{route('lang.post' ,'ru')}}" enctype="multipart/form-data">
        <a href="#" onclick="document.getElementById('sendLangRU').submit();">
            <img width="50px" height="50px" src="/images/lang/ru.png">
        </a>
        {!! csrf_field() !!}
    </form>
</div>