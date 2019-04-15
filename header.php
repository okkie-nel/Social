<?php
    $pages = array(
        'profile' => 'Profile',
        'friends' => 'Friends');
?>
<header>
    <nav>
        <a>
        <img src="img/logo.png" alt=""/>
        </a>
        <ul>
                <?php foreach ($pages as $pageId => $pageTitle): ?>

                <li <?=(($pg == $pageId) ? 'class="active"' : '')?>>
                    <a href="<?=$pageId?>.php"><img class="menuico" src="img/<?=$pageId?>.png" alt=""/><?=$pageTitle?></a>
                </li>
                <?php endforeach; ?>
             <li>
                 <a href="logout.php"><img class="menuico" src="img/logout.png" alt=""/><span>Logout</span></a>
            </li>
        </ul>
    </nav>
</header>

