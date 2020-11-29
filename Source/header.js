function toggleMenu() {
    var menu = document.getElementById("menu-pages");
    var content = document.getElementById("main-content");
    var menuItems = document.querySelectorAll("#menu-pages a").length;
    if (menu.style.maxHeight != 0 && menu.style.maxHeight != "0px") {
        window.setTimeout(function() {
            menu.style.maxHeight = 0;
            content.style.paddingTop = "50px";
        }, 1);
    } else {
        window.setTimeout(function() {
            menu.style.maxHeight = (menuItems * 50) + "px";
            content.style.paddingTop = ((menuItems + 1) * 50) + "px";
        }, 1);
    }
}

function checkWindowSize() {
    var menu = document.getElementById("menu-pages");
    var content = document.getElementById("main-content");
    if (document.documentElement.clientWidth > 620) {
        if (menu.style.maxHeight == null || menu.style.maxHeight != "0px") {
            window.setTimeout(function() {
                menu.style.maxHeight = "0px";
            }, 1);
        } else {
            window.setTimeout(function() {
                content.style.paddingTop = "50px";
            }, 1);
        }
    } else {
        if (menu.style.maxHeight == "50px") {
            menu.style.maxHeight = 0;
        }
    }
}

window.addEventListener("resize", checkWindowSize);