function activeNavbar(path = "") {
    $("li#navbar-"+path).addClass("active");
}

function getScrollPercent() {
    now = window.pageYOffset;
    documentHeight = $(document).height();
    windowHeight = $(window).height();
    return now/(documentHeight-windowHeight);
}