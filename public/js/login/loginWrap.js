function loginWrap() {
    el2 = document.getElementById("loginWrap");
    el2.style.display = (el2.style.display == "block") ? "block" : "block";
    ul2 = document.getElementById("registerWrap");
    ul2.style.display = (ul2.style.display == "block") ? "none" : "none";
    aa3 = document.getElementById("errorsWrap");
    aa3.style.display = (aa3.style.display == "block") ? "none" : "none";
    jQuery('#errors_tab').removeClass('selected');
    jQuery('#signup_tab').removeClass('selected');
    jQuery('#login_tab').addClass('selected');
}

function registerWrap() {
    el5 = document.getElementById("registerWrap");
    el5.style.display = (el5.style.display == "block") ? "block" : "block";
    ul5 = document.getElementById("loginWrap");
    ul5.style.display = (ul5.style.display == "block") ? "none" : "none";
    aa2 = document.getElementById("errorsWrap");
    aa2.style.display = (aa2.style.display == "block") ? "none" : "none";
    jQuery('#login_tab').removeClass('selected');
    jQuery('#errors_tab').removeClass('selected');
    jQuery('#signup_tab').addClass('selected');
}

function errorsWrap() {
    el8 = document.getElementById("registerWrap");
    el8.style.display = (el8.style.display == "block") ? "none" : "none";
    ul6 = document.getElementById("loginWrap");
    ul6.style.display = (ul6.style.display == "block") ? "none" : "none";
    aa1 = document.getElementById("errorsWrap");
    aa1.style.display = (aa1.style.display == "block") ? "block" : "block";
    jQuery('#login_tab').removeClass('selected');
    jQuery('#signup_tab').removeClass('selected');
    jQuery('#errors_tab').addClass('selected');
}

function loginClose() {
    $("#loginContainer").css('display','none');
    $("#overlays").css('display','none');
}