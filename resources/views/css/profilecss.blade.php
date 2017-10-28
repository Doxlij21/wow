
<style>
    body {
        -webkit-text-size-adjust: 100%;
        -moz-text-size-adjust: 100%;
        -ms-text-size-adjust: 100%;
        text-size-adjust: 100%;
        color: #cecece;
        background-color: #212730;
        word-wrap: break-word;
        line-height: 1.28;
    }
    body, div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6, pre, code, form, fieldset, legend, input, button, textarea, p, blockquote, th, td {
        margin: 0;
        padding: 0;
    }
    content {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    #content {
        flex: 1 0 auto;
        margin-left: auto;
        margin-right: auto;
        margin-top: 60px;
        margin-bottom: 28px;
        width: 1210px;
        background-color: #212730;
        min-height: calc(91vh - 21px);
    }

    footer {
        flex: 0 0 auto;
        background: #1f242d;
        bottom: 0;
        width: 100%;
        height: 20px;
        text-align: center;
        font-size: 12px;
        color: white;
    }
    li{
        list-style-type: none;
    }

    #selectCharacters .active
    {
        display: block;
    }
    /*--------------------------------------------------------------
        menu
    --------------------------------------------------------------*/
    .gn-menu-main,
    .gn-menu-main ul {
        margin: 0;
        padding: 0;
        background: #1f242d;
        color: white;
        list-style: none;
        text-transform: none;
        font-weight: 300;
        font-family: 'Roboto', Arial, sans-serif;
        line-height: 43px;
    }
    .gn-menu-main {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 43px;
        font-size: 13px;
        z-index:2;
        box-shadow: 0 6px 4px -4px rgba(0, 0, 0, .2);
    }
    .gn-menu-main a {
        display: block;
        height: 100%;
        color: white;
        text-decoration: none;
        cursor: pointer;
    }
    .no-touchevents .gn-menu-main a:hover,
    .no-touchevents .gn-menu li.gn-search-item:hover,
    .no-touchevents .gn-menu li.gn-search-item:hover a {
        background: #1f242d;
        color: white;
    }
    .gn-menu-main > li {
        display: block;
        float: left;
        height: 100%;

        text-align: center;
    }
    .gn-menu-main li.gn-trigger {
        position: relative;
        width: 43px;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    .gn-menu-main > li:last-child {
        float: right;
        border-right: none;

    }
    .gn-menu-main > li > a {
        padding: 0 30px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: bold;
    }
    .gn-menu-main:after {
        display: table;
        clear: both;
        content: "";
    }
    .gn-menu-wrapper {
        position: fixed;
        top: 47px;
        bottom: 0;
        left: 0;
        overflow: hidden;
        width: 43px;
        background: #1f242d;
        box-shadow: 0 4px 4px rgba(0, 0, 0, .2);
        -webkit-transform: translateX(-60px);
        -moz-transform: translateX(-60px);
        transform: translateX(-60px);
        -webkit-transition: -webkit-transform 0.3s, width 0.3s;
        -moz-transition: -moz-transform 0.3s, width 0.3s;
        transition: transform 0.3s, width 0.3s;
    }
    .gn-scroller {
        position: absolute;
        overflow-y: scroll;
        width: 370px;
        height: 100%;
    }
    .gn-menu {
        text-align: left;
        font-size: 18px;
    }
    .gn-menu li:not(:first-child),
    .gn-menu li li {

    }
    .gn-submenu li {
        overflow: hidden;
        height: 0;
        -webkit-transition: height 0.3s;
        -moz-transition: height 0.3s;
        transition: height 0.3s;
    }
    .gn-submenu li a {
        color: white;
    }
    input.gn-search {
        position: relative;
        z-index: 10;
        padding-left: 43px;
        outline: none;
        border: none;
        background: transparent;
        color: #3498db;
        font-weight: 300;
        font-family: 'Roboto', Arial, sans-serif;
        cursor: pointer;
    }

    /* placeholder */
    .gn-search::-webkit-input-placeholder {
        color: white;
    }
    .gn-search:-moz-placeholder {
        color: white;
    }
    .gn-search::-moz-placeholder {
        color: white;
    }
    .gn-search:-ms-input-placeholder {
        color: white;
    }

    /* hide placeholder when active in Chrome */
    .gn-search:focus::-webkit-input-placeholder,
    .no-touchevents .gn-menu li.gn-search-item:hover .gn-search:focus::-webkit-input-placeholder {
        color: transparent
    }
    input.gn-search:focus {
        cursor: text;
    }
    .no-touchevents .gn-menu li.gn-search-item:hover input.gn-search {
        color: white;
    }

    /* placeholder */
    .no-touchevents .gn-menu li.gn-search-item:hover .gn-search::-webkit-input-placeholder {
        color: white;
    }
    .no-touchevents .gn-menu li.gn-search-item:hover .gn-search:-moz-placeholder {
        color: white;
    }
    .no-touchevents .gn-menu li.gn-search-item:hover .gn-search::-moz-placeholder {
        color: white;
    }
    .no-touchevents .gn-menu li.gn-search-item:hover .gn-search:-ms-input-placeholder {
        color: white;
    }
    .gn-menu-main  .gn-search-item a{
        position: absolute;
        top: 0;
        left: 0;
        height: 43px;
    }
    .fa::before {
        display: inline-block;
        width: 43px;
        text-align: center;
    }

    /* if an icon anchor has a span, hide the span */
    .fa + span {
        width: 0;
        height: 0;
        display: block;
        overflow: hidden;
    }
    .fa-bars:before {
        margin-left: -15px;
        vertical-align: -2px;
        width: 30px;
        height: 3px;
    }
    .no-touchevents  .menu-bars:hover .fa-bars::before,
    .no-touchevents  .menu-bars.gn-selected:hover .fa-bars::before {
        background: white;
    }


    /* styles for opening menu */
    .gn-menu-wrapper.gn-open-all,
    .gn-menu-wrapper.gn-open-part {
        -webkit-transform: translateX(0px);
        -moz-transform: translateX(0px);
        transform: translateX(0px);
    }
    .gn-menu-wrapper.gn-open-all {
        width: 340px
    }
    .gn-menu-wrapper.gn-open-all .gn-submenu li {
        height: 43px
    }
    @media screen and (max-width: 422px) {
        .gn-menu-wrapper.gn-open-all {
            -webkit-transform: translateX(0px);
            -moz-transform: translateX(0px);
            transform: translateX(0px);
            width: 100%;
        }
        #logo {
            display: none;
        }
        .gn-menu-wrapper.gn-open-all .gn-scroller {
            width: 130%
        }
    }
    #Navigation{
        padding-right: 0px;
    }

    .Navigation{
        height: 43px;
        padding: 0;
        margin: 0;
        float:right;
    }

    .Navigation li 	{
        height: auto;
        width: 75px;
        float: left;
        text-align: center;
        list-style: none;
        font:12px "Bonveno", "Century Gothic";

        padding: 0;
        margin: 0;
    }

    .Navigation a{
        padding:17px 5px;
        text-decoration: none;
        display: block;
    }
    .Navigation li ul{
        display: none;
        height: auto;
        padding: 0;
    }

    .Navigation li:hover ul{
        display: block;
    }


    .Navigation li:hover, a:hover {
        background: #1c2129;
        box-shadow: 0 0 7px 4px rgba(0, 0, 0, .2);
    }
    /*--------------------------------------------------------------
        tabs
    --------------------------------------------------------------*/
    UL.mytabs {
        font-weight: bold;
        font-size: 11px;
        margin: auto;
        width: auto;
    }
    UL.mytabs, UL.mytabs LI {
        margin: 0;
        padding: 0;
        list-style: none;
        float: left;
    }
    UL.mytabs LI { padding: 0 5px; }
    UL.mytabs LI A {
        float: left;
        padding: 3px;
        background: #212730;
        text-decoration: none;
        height: 12px;
        font:14px verdana,arial,sans-serif;
    }
    UL.mytabs LI A:HOVER, UL.mytabs LI.current A {
        background: #212730;
    }

    .mytabs-container {
        clear: both;
        box-shadow: 0 2px 4px rgba(0, 0, 0, .2);
        padding: 13px;
        top: 3px;
        background:#212730;
    }
    #classFilter {
        font-weight: bold;
        font-size: 11px;
        margin: auto;
        width: auto;
        padding:20px;
        cursor:pointer;
    }
    #staticHelper {
    }
    .buttons {
        padding: 20px 0;
        width: 100%;
        text-align: center;

    }
    .js-login-text {
        width: 100%;
        cursor:pointer;
        background:#212730;
        color:#cecece;
        box-shadow: 0 0 7px 4px rgba(0, 0, 0, .2);
    }
    /*--------------------------------------------------------------
        color class
    --------------------------------------------------------------*/
    .Deathknight {
        color: #C41F3B;
    }
    .Demonhunter {
        color: #A330C9;
    }
    .Druid {
        color: #FF7D0A;
    }
    .Hunter {
        color: #ABD473;
    }
    .Mage {
        color: #69CCF0;
    }
    .Monk {
        color: #008467;
    }
    .Paladin {
        color: #F58CBA;
    }
    .Priest {
        color: #FFFFFF;
    }
    .Rogue {
        color: #FFF569;
    }
    .Shaman {
        color: #2459FF;
    }
    .Warlock {
        color: #9482CA;
    }
    .Warrior {
        color: #C79C6E;
    }
    .All {
        color: #FFFFFF;
    }
    /*--------------------------------------------------------------
        userbar
    --------------------------------------------------------------*/
    #transferSelectedCharacter {
        padding:10px;
        height: 61px;
        max-width: 275px;
        text-align: center;
        font-size: 14px verdana,arial,sans-serif;
        text-decoration: none;
        cursor:pointer;
        box-shadow: 0 0 7px 2px rgba(0, 0, 0, .2);
    }
    #selectedthischaracter {
        margin:-5px 0 5px 0;
        height: 17px;
        text-align: center;
        box-shadow: 0 0 7px 2px rgba(0, 0, 0, .2);
    }

    .staticCharacter li{
        height: 51px;
        max-width: 275px;
        margin:10px;
        text-align: center;
        font-size: 14px verdana,arial,sans-serif;
        text-decoration: none;
        cursor:pointer;
        box-shadow: 0 0 7px 2px rgba(0, 0, 0, .2);
    }
    .staticCharacter li:hover {
        height: 51px;
        max-width: 276px;
        box-shadow: 0 0 7px 5px rgba(0, 0, 0, .2);
    }

    .staticCharacter a{
        text-decoration: none;
    }

    .staticCharacter ul{
        text-decoration: none;
        list-style: none;
    }
    .staticCharacter img {
        height: 50px;
        width: 50px;
        float:left;
    }
    /*--------------------------------------------------------------
        and userbar
    --------------------------------------------------------------*/
</style>