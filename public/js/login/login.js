function login() {
    el = document.getElementById("loginContainer");
    el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
    ul = document.getElementById("overlays");
    ul.style.visibility = (el.style.visibility == "visible") ? "visible" : "hidden";
    el3 = document.getElementById("loginWrap");
    el3.style.display = (el3.style.display == "block") ? "block" : "block";
    el6 = document.getElementById("registerWrap");
    el6.style.display = (el6.style.display == "block") ? "none" : "none";
    aa5 = document.getElementById("errorsWrap");
    aa5.style.display = (aa5.style.display == "block") ? "none" : "none";
    jQuery('#signup_tab').removeClass('selected');
    jQuery('#errors_tab').removeClass('selected');
    jQuery('#login_tab').addClass('selected');
}

function register() {
    el1 = document.getElementById("loginContainer");
    el1.style.visibility = (el1.style.visibility == "visible") ? "hidden" : "visible";
    ul1 = document.getElementById("overlays");
    ul1.style.visibility = (el1.style.visibility == "visible") ? "visible" : "hidden";
    el4 = document.getElementById("registerWrap");
    el4.style.display = (el4.style.display == "block") ? "block" : "block";
    el7 = document.getElementById("loginWrap");
    el7.style.display = (el7.style.display == "block") ? "none" : "none";
    aa4 = document.getElementById("errorsWrap");
    aa4.style.display = (aa4.style.display == "block") ? "none" : "none";
    jQuery('#login_tab').removeClass('selected');
    jQuery('#errors_tab').removeClass('selected');
    jQuery('#signup_tab').addClass('selected');

}