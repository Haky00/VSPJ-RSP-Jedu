<?php
    echo "
    <div id='menu'>

        <div id='menu-content'>

            <div class='center'>
                <a href='index.php' class='menu-item menu-element left'>
                    <svg class='menu-link center' width='1365.333' height='1098.667' viewBox='0 0 1024 824'>
                        <path d='M32 412v310h960V102H32v310zm450 0v250H92V162h390v250zm450 0v250H542V162h390v250zM152 269v30h270v-60H152v30zm0 143v30h270v-60H152v30zm0 143v30h270v-60H152v30zm450-286v30h270v-60H602v30zm0 143v30h270v-60H602v30zm0 143v30h210v-60H602v30z'/>
                    </svg>
                </a>
            </div>

            <div class='right menu-show'>

                <div class='menu-show-img right'>
                    <a onclick='toggleMenu()' class='menu-item menu-element right'>
                        <svg class='menu-link center' width='248' height='245.333' viewBox='0 0 186 184'>
                            <path d='M25 38v13h135V25H25v13zm0 54v13h135V79H25v13zm0 54v13h135v-26H25v13z'/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class='right' id='menu-pages'>

                ";
                if(session_id() == "")
                {
                    session_start();
                }
                if (!isset($_SESSION["opravneni"]))
                {
                    $menu = "
                    <div class='menu-separator left'></div>
                    <a href='prihlaseni.php' class='menu-item menu-element menu-btn left'>
                    <div class='menu-link center'>Přihlásit se</div>
                    </a>
                    <div class='menu-separator left'></div>";
                }
                else 
                {
                    $opravneni = $_SESSION["opravneni"];
                    $menu = "";
                    if ($opravneni == "Admin")
                    {
                    $menu = $menu . "
                    <div class='menu-separator left'></div>
                    <a href='novy_ucet.php' class='menu-item menu-element menu-btn left'>
                    <div class='menu-link center'>Nový uživatel</div>
                    </a>";
                    }
                    if ($opravneni == "Autor")
                    {
                    $menu = $menu . "
                    <div class='menu-separator left'></div>
                    <a href='prispevek.php' class='menu-item menu-element menu-btn left'>
                    <div class='menu-link center'>Nový příspěvek</div>
                    </a>";
                    }
                    $menu = $menu . "
                    <div class='menu-separator left'></div>
                    <a href='agenda.php' class='menu-item menu-element menu-btn left'>
                    <div class='menu-link center'>Moje agenda</div>
                    </a>
                    <div class='menu-separator left'></div>
                    <a href='ucet.php' class='menu-item menu-element menu-btn left'>
                    <div class='menu-link center'>Můj účet</div>
                    </a>
                    <div class='menu-separator left'></div>

                    ";
                }

                // <div class='menu-separator left'></div>
                // <a href='prispevek.php' class='menu-item menu-element menu-btn left'>
                //     <div class='menu-link center'>Nový příspěvek</div>
                // </a>
                // <div class='menu-separator left'></div>
                // <a href='agenda.php' class='menu-item menu-element menu-btn left'>
                //     <div class='menu-link center'>Agenda</div>
                // </a>
                // <div class='menu-separator left'></div>
                // <a href='ucet.php' class='menu-item menu-element menu-btn left'>
                //     <div class='menu-link center'>Můj účet</div>
                // </a>
                // <div class='menu-separator left'></div>

                echo $menu;

    echo "
            </div>
        </div>

    </div>
    ";
