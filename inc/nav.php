<?php
/*
 * PC 메뉴(.menu) + 모바일 메뉴(.menu_m).
 * 내용은 inc/events.php 에서 만들어지므로 이 파일은 보통 고칠 일이 없습니다.
 */
require_once dirname(__FILE__) . '/events.php';

$cur = null;
foreach ($EVENTS as $ev) {
    if ($ev['dir'] === $CURRENT_EVENT) { $cur = $ev; }
}
$cur_base   = '/archive/' . $CURRENT_EVENT;
$cur_about  = $cur_base . '/about/' . (($cur && $cur['congrats']) ? 'Congratulatory' : 'Greetings') . '.html';

if (!function_exists('skku_about_links')) {
    function skku_about_links($dir, $congrats) {
        $links = array();
        if ($congrats) {
            $links[] = array("/archive/$dir/about/Congratulatory.html", '축사 <small>Congratulatory Message</small>');
        }
        $links[] = array("/archive/$dir/about/Greetings.html", '인사말 <small>Greetings</small>');
        $links[] = array("/archive/$dir/about/Faculty.html", '지도교수 <small>Faculty Members</small>');
        return $links;
    }
}

$genres = array(
    array('ballet.html',       '발레 <small>Ballet</small>'),
    array('contemporary.html', '컨템포러리 댄스 <small>Contemporary Dance</small>'),
    array('korean_dance.html', '한국무용 <small>Korean Dance</small>'),
);
?>
                <div class="menu">
                    <ul class="">
                        <li class="hover_menu only_00">
                            <button class="dropbtn"><a href="/">MAIN</a></button>
                        </li>
                        <li class="hover_menu only_01">
                            <button class="dropbtn"><a href="<?php echo $cur_about; ?>">ABOUT</a></button>
                            <div class="menu_content cont_02">
                                <div class="sub">
                                    <i></i>
<?php foreach (skku_about_links($CURRENT_EVENT, $cur && $cur['congrats']) as $l) { ?>
                                    <a href="<?php echo $l[0]; ?>"><?php echo $l[1]; ?></a>
<?php } ?>
                                </div>
                            </div>
                        </li>
                        <li class="hover_menu only_02">
                            <button class="dropbtn"><a href="<?php echo $cur_base; ?>/index.html"><i></i>PERFORMANCE</a></button>
                            <div class="menu_content cont_01">
                                <div class="sub">
                                    <i></i>
<?php foreach ($genres as $g) { ?>
                                    <a href="<?php echo $cur_base; ?>/performance/<?php echo $g[0]; ?>"><?php echo $g[1]; ?></a>
<?php } ?>
                                </div>
                            </div>
                        </li>
                        <li class="hover_menu only_03">
                            <button class="dropbtn">ARCHIVE</button>
                            <div class="menu_content cont_03">
<?php foreach ($EVENTS as $i => $ev) { $sfx = $i === 0 ? '' : sprintf('_%02d', $i); ?>
                                <div class="sub<?php echo $sfx; ?>">
                                    <i></i>
                                    <a class="over" href="/archive/<?php echo $ev['dir']; ?>/index.html"><?php echo $ev['label']; ?></a>
                                    <ul class="menu_sub<?php echo $sfx; ?>">
                                        <i></i>
<?php foreach (skku_about_links($ev['dir'], $ev['congrats']) as $l) { ?>
                                        <li class="sub"><a href="<?php echo $l[0]; ?>"><?php echo $l[1]; ?></a></li>
<?php } ?>
                                    </ul>
                                </div>
<?php } ?>
                            </div>
                        </li>
                        <li class="hover_menu only_04">
                            <button class="dropbtn">ALUMNI</button>
                            <div class="menu_content cont_04">
<?php foreach ($ALUMNI_YEARS as $y) { ?>
                                <div class="sub">
                                    <i></i>
                                    <a class="over" href="/alumni/<?php echo $y; ?>/alumni.html"><?php echo $y; ?>년 졸업생</a>
                                </div>
<?php } ?>
                            </div>
                        </li>
                        <li class="hover_menu only_05">
                            <button class="dropbtn"><a href="/home/bbs/board.php?bo_table=notice">NOTICE</a></button>
                            <div class="menu_content cont_05">
                            </div>
                        </li>
                    </ul>
                    <div class=""></div>
                </div>
                <div class="menu_m">
                    <div class="menu_line" onclick="openNav()">
                        <a href="javascript:void(0);">
                            <span><span></span></span>
                            <span><span></span></span>
                            <span><span></span></span>
                        </a>
                    </div>
                    <div id="mo_nav" class="overlay">
                        <a href="javascript:void(0);" class="close_btn" onclick="closeNav()">&times;</a>
                        <div class="overlay_content">
                            <ul class="show">
                                <li class="first"><a href="/">MAIN</a>
                                </li>
                                <li class="first"><a href="<?php echo $cur_about; ?>">ABOUT</a>
                                    <ul class="cont_m cont_m_02">
<?php foreach (skku_about_links($CURRENT_EVENT, $cur && $cur['congrats']) as $l) { ?>
                                        <li class="sub"><a href="<?php echo $l[0]; ?>"><?php echo $l[1]; ?></a></li>
<?php } ?>
                                    </ul>
                                </li>
                                <li class="first"><a href="<?php echo $cur_base; ?>/index.html">PERFORMANCE</a>
                                    <ul class="cont_m cont_m_01">
<?php foreach ($genres as $g) { ?>
                                        <li class="sub"><a href="<?php echo $cur_base; ?>/performance/<?php echo $g[0]; ?>" class="a_box"><?php echo $g[1]; ?></a></li>
<?php } ?>
                                    </ul>
                                </li>
                                <li class="first"><a href="#">ARCHIVE</a>
                                    <ul class="cont_m cont_m_03">
<?php foreach ($EVENTS as $ev) { ?>
                                        <li class="sub">
                                            <a href="/archive/<?php echo $ev['dir']; ?>/index.html"><?php echo $ev['label']; ?>
                                                <span>
                                                    <a href="#" >
                                                        <img src="/img/gnb_arrow.png" alt="서브메뉴오픈" width="12">
                                                    </a>
                                                </span>
                                            </a>
                                            <ul class="cont_m cont_m_01">
<?php foreach (skku_about_links($ev['dir'], $ev['congrats']) as $l) { ?>
                                                <li class="sub"><a href="<?php echo $l[0]; ?>"><?php echo $l[1]; ?></a></li>
<?php } ?>
                                            </ul>
                                        </li>
<?php } ?>
                                    </ul>
                                </li>
                                <li class="first">
                                    <a href="#">ALUMNI</a>
                                    <ul class="cont_m cont_m_03">
<?php foreach ($ALUMNI_YEARS as $y) { ?>
                                        <li class="sub">
                                            <a href="/alumni/<?php echo $y; ?>/alumni.html" ><?php echo $y; ?>년 졸업생</a>
                                        </li>
<?php } ?>
                                    </ul>
                                </li>
                                <li>
                                    <a href="/home/bbs/board.php?bo_table=notice">NOTICE</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
