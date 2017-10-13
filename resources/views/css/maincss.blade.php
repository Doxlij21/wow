<style>
    body {
        -webkit-text-size-adjust: 100%;
        -moz-text-size-adjust: 100%;
        -ms-text-size-adjust: 100%;
        text-size-adjust: 100%;
        color: #cecece;
        background-color: #69797e;
        word-wrap: break-word;
        line-height: 1.28;
    }
    body, div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6, pre, code, form, fieldset, legend, input, button, textarea, p, blockquote, th, td {
        margin: 0;
        padding: 0;
    }
    .full-wrap {
        min-height: 1300px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 20px;
        width: 1210px;
        position: relative;
        z-index: 150;
        padding: 0 20px;
        background: #121215;
        -webkit-box-shadow: 0 0 5px #000;
        -moz-box-shadow: 0 0 5px #000;
        -khtml-box-shadow: 0 0 5px #000;
        box-shadow: 0 0 5px #000;
    }
    header {
        display: block;
        padding-top: 10px;
    }
    .pageWidth {
        padding-right: 0;
        padding-left: 0;
        margin: 0 auto;
    }
    #content .pageContent {
        overflow: hidden;
        width: 100%;
    }

    /* Login */

    #loginContainer
    {
        z-index: 9999;
        top: 97.9px;
        left: 50px;
        right: 50px;
        position: fixed;
        display: block;
    }

    #loginContainer  .loginCon
    {
        background: #fff;
        border-bottom: 1px solid #fff;
        border-top: 1px solid #fff;
        margin-top: 0;
        box-shadow:0 1px 2px rgba(0,0,0,.1);
        min-width: 310px;
        max-width: 375px;
        margin: 0 auto;
        overflow: hidden;
        padding: 25px 25px 5px;
    }

    .tabs>li:hover
    {
        box-shadow: 0 -1px 0 #6441a4 inset;
    }

    .tabs .selected
    {
        box-shadow: 0 -1px 0 #6441a4 inset;
    }

    input
    {
        line-height: 28px;
        padding: 0 7px;
        height: 30px;
        font: inherit;
        letter-spacing: inherit;
        color: #706a7c;
        vertical-align: top;
        border: 1px solid #dad8de;
        -webkit-background-clip: padding-box;
        -moz-background-clip: padding;
        box-sizing: border-box;
        background: #fff;
    }

    #loginContainer .loginCon .item
    {
        position: relative;
        margin-bottom: 21px;
        width: 100%;
        box-sizing: border-box;
    }

    #loginContainer .loginCon .item .tabs
    {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: row;
        flex-direction: row;
        -ms-flex-align: end;
        align-items: flex-end;
        padding: 0;
        margin-bottom: 1rem;
        box-shadow: 0 -1px 0 #dad8de inset;
    }

    button
    {
        font-style: normal;
        font-size: 12px;
        font-family: verdana,arial,sans-serif;
        color: rgb(152, 152, 153);
        background-color: rgb(0, 0, 0);
        padding: 0px 7px;
        border: 1px solid rgb(52,52,52);
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -khtml-border-radius: 4px;
        border-radius: 4px;
        text-align: center;
        outline: none;
        line-height: 29px;
        display: inline-block;
        cursor: pointer;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        box-sizing: border-box;
        height: 29px;
        min-width: 100px;
    }

    button:hover
    {
        text-decoration: none;
        background-color: rgb(52,52,52);
    }

    /* Menu */

    ul.menu {
        overflow-x: scroll;
        overflow-y: hidden;
        border: 0px solid #000000;
        height: 90px;
        width: 100%;
        padding: 0 0 0 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgb(18, 18, 21);
        -webkit-box-shadow: 0 0 5px #000;
        -moz-box-shadow: 0 0 5px #000;
        -khtml-box-shadow: 0 0 5px #000;
        box-shadow: 0 0 5px #000;
    }

    ul.menu>li {
        border-left: 1px solid black;
        border-right: 1px solid black;
        float: left;
        list-style: none;
        position: relative;

    }

    ul.menu>li .navigatorUrl a {
        color: black;
        display: block;
        padding-top: 25px;
        padding-bottom: 25px;
        padding-left: 10px;
        padding-right: 10px;
        height: 40px;
        text-decoration: none;
        font-size: 35px;
        line-height: 43px;
    }

    ul.menu>li .navigatorUrl a:hover {
        color:white;
    }

    ul.menu>li>ul {
        display: none;
    }

    ul.menu>li:hover>ul {
        display: block;
        position: absolute;
        top: auto;
        background-color: #2b2b2b;
        z-index: 1000;
        padding: 0 0 0 0;
    }

    ul.menu>li:hover>ul>li {
        float: none;
        width: 150px;
        list-style: none;
    }

    ul.menu>li:hover>ul>li>a {
        padding: 6px 20px 8px;
        display: block;
        color: white;
        text-decoration: none;
    }

    ul.menu>li:hover>ul>li>a:hover {
        background-color: transparent;
        color: #c1deff;
    }

    header .userbar {
        float: right;
        color: #969ca5;
    }

    .menuMenu
    {
        font-size: 80px;
        background: rgb(196, 16, 90);
        color: black;
        cursor: pointer;
        border: 0px solid #000000;
        height: 90px;
        width: 100%;
        padding: 0 0 0 0;
        display: flex;
        align-items: center;
        justify-content: center;
        -webkit-box-shadow: 0 0 5px #000;
        -moz-box-shadow: 0 0 5px #000;
        -khtml-box-shadow: 0 0 5px #000;
        box-shadow: 0 0 5px #000;
        margin-bottom: 5px;
    }
    .menuMenu:hover{
        color: white;
    }
    .menu::-webkit-scrollbar {
        margin-top:5px;
        width: 1em;
    }

    .menu::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    }

    .menu::-webkit-scrollbar-thumb {
        background-color: #69797e;
        outline: 1px solid slategrey;
    }
    .navigatorUrl {
        background: rgb(113, 173, 37);
    }

    #overlays {
        visibility: hidden;
        position: absolute;
        top: 0px;
        left: 0px;
        z-index: 9998;
        opacity: 0.6;
        display: block;
        width: 100%;
        height: 100%;
        background-color: rgb(44, 44, 44);
    }

    footer {
        display: block;
        background: #1b1c20;
        font-size: 12px;
        position: relative;
        margin: 20px 0 0;
    }

</style>