function activeNavbar(path = "") {
    $("li#navbar-"+path).addClass("active");
}

function getScrollPercent() {
    now = window.pageYOffset;
    documentHeight = $(document).height();
    windowHeight = $(window).height();
    return now/(documentHeight-windowHeight);
}

function fbInit(d, s, id, app_id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId="+app_id;
    fjs.parentNode.insertBefore(js, fjs);
}

function fbSignIn() {
    connectingDialog();
    FB.login(function (response) {
        if (response.status==='connected') {
            FB.api('/me',{fields: 'name'}, function (response) {
                $.ajax({
                    type: "POST",
                    url: "/user",
                    dataType: "text",
                    headers: { "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content") },
                    data: {social: 'facebook', id:response.id, name:response.name},
                    success: function() {
                        location.reload();
                    },
                });
            });
        } else {
            clearDialog();
        }
    }, {scope:'public_profile'});
}

function ggSignIn(googleUser) {
    console.log("ggSignIn");
    connectingDialog();
    var profile = googleUser.getBasicProfile();
    $.ajax({
        type: "POST",
        url: "/user",
        dataType: "text",
        headers: { "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content") },
        data: {social: 'google', email:profile.getEmail(), name:profile.getName()},
        success: function() {
            (function() {
                var auth2 = gapi.auth2.getAuthInstance();
                auth2.signOut().then(function () {
                    location.reload();
                });
            })();
        },
    });
}

function connectingDialog() {
    console.log("connectingDialog");
    $('html').css({"background-color":"#000", "height":"100%"});
    $('body').css({"opacity":0.3, "height":"100%"});
    var html = 
        '<div id="connecting" style="position:fixed; top: 45%; left: 30%">'+
            '<p style="font-size: 50px; font-weight: bold; text-align: center; color: #FFF">'+
                'CONNECTING...'+
            '</p>'+
        '</div>';
    $('html').append(html);
}

function clearDialog() {
    console.log("clearDialog");
    $('html').removeAttr("style");
    $('body').removeAttr("style");
    $('div#connecting').remove();
}