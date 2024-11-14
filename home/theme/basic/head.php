<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/head.php');
    return;
}

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
?>

<!-- 상단 시작 { -->
<div id="hd">
    <h1 id="hd_h1"><?php echo $g5['title'] ?></h1>
    <div id="skip_to_container"><a href="#container">본문 바로가기</a></div>

    <?php
    if(defined('_INDEX_')) { // index에서만 실행
        include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
    }
    ?>
    <div id="tnb">
    	<div class="inner">
			<ul id="hd_qnb">
	            <li><a href="<?php echo G5_BBS_URL ?>/faq.php">FAQ</a></li>
	            <li><a href="<?php echo G5_BBS_URL ?>/qalist.php">Q&A</a></li>
	            <li><a href="<?php echo G5_BBS_URL ?>/new.php">새글</a></li>
	            <li><a href="<?php echo G5_BBS_URL ?>/current_connect.php" class="visit">접속자<strong class="visit-num"><?php echo connect('theme/basic'); // 현재 접속자수, 테마의 스킨을 사용하려면 스킨을 theme/basic 과 같이 지정  ?></strong></a></li>
	        </ul>
		</div>
    </div>
    <div id="hd_wrapper">

        <div id="logo">
            <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_IMG_URL ?>/logo.png" alt="<?php echo $config['cf_title']; ?>"></a>
        </div>
    
        <div class="hd_sch_wr">
            <fieldset id="hd_sch">
                <legend>사이트 내 전체검색</legend>
                <form name="fsearchbox" method="get" action="<?php echo G5_BBS_URL ?>/search.php" onsubmit="return fsearchbox_submit(this);">
                <input type="hidden" name="sfl" value="wr_subject||wr_content">
                <input type="hidden" name="sop" value="and">
                <label for="sch_stx" class="sound_only">검색어 필수</label>
                <input type="text" name="stx" id="sch_stx" maxlength="20" placeholder="검색어를 입력해주세요">
                <button type="submit" id="sch_submit" value="검색"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">검색</span></button>
                </form>

                <script>
                function fsearchbox_submit(f)
                {
                    if (f.stx.value.length < 2) {
                        alert("검색어는 두글자 이상 입력하십시오.");
                        f.stx.select();
                        f.stx.focus();
                        return false;
                    }

                    // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
                    var cnt = 0;
                    for (var i=0; i<f.stx.value.length; i++) {
                        if (f.stx.value.charAt(i) == ' ')
                            cnt++;
                    }

                    if (cnt > 1) {
                        alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
                        f.stx.select();
                        f.stx.focus();
                        return false;
                    }

                    return true;
                }
                </script>

            </fieldset>
                
            <?php echo popular('theme/basic'); // 인기검색어, 테마의 스킨을 사용하려면 스킨을 theme/basic 과 같이 지정  ?>
        </div>
        <ul class="hd_login">        
            <?php if ($is_member) {  ?>
            <li><a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php">정보수정</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/logout.php">로그아웃</a></li>
            <?php if ($is_admin) {  ?>
            <li class="tnb_admin"><a href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>">관리자</a></li>
            <?php }  ?>
            <?php } else {  ?>
            <li><a href="<?php echo G5_BBS_URL ?>/register.php">회원가입</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/login.php">로그인</a></li>
            <?php }  ?>

        </ul>
    </div>
    
    <nav id="gnb">
        <h2>메인메뉴</h2>
        <div class="gnb_wrap">
            <ul id="gnb_1dul">
                <li class="gnb_1dli gnb_mnal"><button type="button" class="gnb_menu_btn" title="전체메뉴"><i class="fa fa-bars" aria-hidden="true"></i><span class="sound_only">전체메뉴열기</span></button></li>
                <?php
				$menu_datas = get_menu_db(0, true);
				$gnb_zindex = 999; // gnb_1dli z-index 값 설정용
                $i = 0;
                foreach( $menu_datas as $row ){
                    if( empty($row) ) continue;
                    $add_class = (isset($row['sub']) && $row['sub']) ? 'gnb_al_li_plus' : '';
                ?>
                <li class="gnb_1dli <?php echo $add_class; ?>" style="z-index:<?php echo $gnb_zindex--; ?>">
                    <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="gnb_1da"><?php echo $row['me_name'] ?></a>
                    <?php
                    $k = 0;
                    foreach( (array) $row['sub'] as $row2 ){

                        if( empty($row2) ) continue; 

                        if($k == 0)
                            echo '<span class="bg">하위분류</span><div class="gnb_2dul"><ul class="gnb_2dul_box">'.PHP_EOL;
                    ?>
                        <li class="gnb_2dli"><a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>" class="gnb_2da"><?php echo $row2['me_name'] ?></a></li>
                    <?php
                    $k++;
                    }   //end foreach $row2

                    if($k > 0)
                        echo '</ul></div>'.PHP_EOL;
                    ?>
                </li>
                <?php
                $i++;
                }   //end foreach $row

                if ($i == 0) {  ?>
                    <li class="gnb_empty">메뉴 준비 중입니다.<?php if ($is_admin) { ?> <a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php">관리자모드 &gt; 환경설정 &gt; 메뉴설정</a>에서 설정하실 수 있습니다.<?php } ?></li>
                <?php } ?>
            </ul>
            <div id="gnb_all">
                <h2>전체메뉴</h2>
                <ul class="gnb_al_ul">
                    <?php
                    
                    $i = 0;
                    foreach( $menu_datas as $row ){
                    ?>
                    <li class="gnb_al_li">
                        <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="gnb_al_a"><?php echo $row['me_name'] ?></a>
                        <?php
                        $k = 0;
                        foreach( (array) $row['sub'] as $row2 ){
                            if($k == 0)
                                echo '<ul>'.PHP_EOL;
                        ?>
                            <li><a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>"><?php echo $row2['me_name'] ?></a></li>
                        <?php
                        $k++;
                        }   //end foreach $row2

                        if($k > 0)
                            echo '</ul>'.PHP_EOL;
                        ?>
                    </li>
                    <?php
                    $i++;
                    }   //end foreach $row

                    if ($i == 0) {  ?>
                        <li class="gnb_empty">메뉴 준비 중입니다.<?php if ($is_admin) { ?> <br><a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php">관리자모드 &gt; 환경설정 &gt; 메뉴설정</a>에서 설정하실 수 있습니다.<?php } ?></li>
                    <?php } ?>
                </ul>
                <button type="button" class="gnb_close_btn"><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div id="gnb_all_bg"></div>
        </div>
    </nav>
    <!-- 메뉴 -->
    <div id="skku_wrap">
        <div class="skku_inner">
            <header class="header">
                <div class="menu">
                    <ul class="">
                        <li class="hover_menu only_00">
                            <button class="dropbtn"><a href="/">MAIN</a></button>
                        </li>
                        <li class="hover_menu only_01">
                            <button class="dropbtn"><a href="/about/Greetings.html">ABOUT</a></button>
                            <div class="menu_content cont_02">
                                <!-- 임시주석 -->
                                    <div class="sub">
                                        <i></i>
                                        <a href="/about/Congratulatory.html">축사 <small>Congratulatory Message</small></a>
                                        <a href="/about/Greetings.html">인사말 <small>Greetings</small></a>
                                        <a href="/about/Faculty.html">지도교수 <small>Faculty Members</small></a>
                                    </div>
                            </div>
                        </li>
                        <li class="hover_menu only_02">
                            <button class="dropbtn"><a href="/performance_main.html">PERFORMANCE</a></button>
                            <div class="menu_content cont_01">
                                <!-- 임시주석 -->
                                <div class="sub">
                                    <i></i>
                                    <a href="/performance/contemporary.html">컨템포러리 댄스 <small>Contemporary Dance</small></a>
                                    <a href="/performance/korean_dance.html">한국무용 <small>Korean Dance</small></a>
                                    <a href="/performance/ballet.html">발레 <small>Ballet</small></a>
                                </div>
                            </div>   
                        </li>
                        <li class="hover_menu only_03">
                            <button class="dropbtn">ARCHIVE</button>
                            <div class="menu_content cont_03">
                                <div class="sub">
                                    <i></i>
                                    <a class="over" href="/archive/2021/index.html">2021 작품발표회</a>
                                    <ul class="menu_sub">
                                        <i></i>
                                        <li class="sub"><a href="/about/Congratulatory.html">축사 <small>Congratulatory Message</small></a></li>
                                        <li class="sub"><a href="/about/Greetings.html">인사말 <small>Greetings</small></a></li>
                                        <li class="sub"><a href="/about/Faculty.html">지도교수 <small>Faculty Members</small></a></li>
                                    </ul>
                                </div>
                                <div class="sub_01">
                                    <i></i>
                                    <a class="over" href="/archive/2022/index.html">2021 졸업발표회</a>
                                    <ul class="menu_sub_01">
                                        <i></i>
                                        <li class="sub"><a href="/archive/2022/about/Congratulatory.html">축사 <small>Congratulatory Message</small></a></li>
                                        <li class="sub"><a href="/archive/2022/about/Greetings.html">인사말 <small>Greetings</small></a></li>
                                        <li class="sub"><a href="/archive/2022/about/Faculty.html">지도교수 <small>Faculty Members</small></a></li>
                                    </ul>
                                </div>
                                <div class="sub_02">
                                    <i></i>
                                    <a class="over" href="/archive/2022_work/index.html">2022 작품발표회</a>
                                    <ul class="menu_sub_02">
                                        <i></i>
                                        <li class="sub"><a href="/archive/2022_work/about/Congratulatory.html">축사 <small>Congratulatory Message</small></a></li>
                                        <li class="sub"><a href="/archive/2022_work/about/Greetings.html">인사말 <small>Greetings</small></a></li>
                                        <li class="sub"><a href="/archive/2022_work/about/Faculty.html">지도교수 <small>Faculty Members</small></a></li>
                                    </ul>
                                </div>
                                <div class="sub_03">
                                    <i></i>
                                    <a class="over" href="/archive/2022_graduate/index.html">2022 졸업발표회</a>
                                    <ul class="menu_sub_03">
                                        <i></i>
                                        <li class="sub"><a href="/archive/2022_graduate/about/Congratulatory.html">축사 <small>Congratulatory Message</small></a></li>
                                        <li class="sub"><a href="/archive/2022_graduate/about/Greetings.html">인사말 <small>Greetings</small></a></li>
                                        <li class="sub"><a href="/archive/2022_graduate/about/Faculty.html">지도교수 <small>Faculty Members</small></a></li>
                                    </ul>
                                </div>
                                <div class="sub_04">
                                    <i></i>
                                    <a class="over" href="/archive/2022_showcase/index.html">2022 쇼케이스</a>
                                    <ul class="menu_sub_04">
                                        <i></i>
                                        <li class="sub"><a href="/archive/2022_showcase/about/Greetings.html">인사말 <small>Greetings</small></a></li>
                                        <li class="sub"><a href="/archive/2022_showcase/about/Faculty.html">지도교수 <small>Faculty Members</small></a></li>
                                    </ul>
                                </div>
                                <div class="sub_05">
                                    <i></i>
                                    <a class="over" href="/archive/2023_work/index.html">2023 작품발표회</a>
                                    <ul class="menu_sub_05">
                                        <i></i>
                                        <li class="sub"><a href="/archive/2023_work/about/Congratulatory.html">축사 <small>Congratulatory Message</small></a></li>
                                        <li class="sub"><a href="/archive/2023_work/about/Greetings.html">인사말 <small>Greetings</small></a></li>
                                        <li class="sub"><a href="/archive/2023_work/about/Faculty.html">지도교수 <small>Faculty Members</small></a></li>
                                    </ul>
                                </div> 
                                <div class="sub_06">
                                    <i></i>
                                    <a class="over" href="/archive/2023_graduate/index.html">2023 졸업발표회</a>
                                    <ul class="menu_sub_06">
                                        <i></i>
                                        <li class="sub"><a href="/archive/2023_graduate/about/Congratulatory.html">축사 <small>Congratulatory Message</small></a></li>
                                        <li class="sub"><a href="/archive/2023_graduate/about/Greetings.html">인사말 <small>Greetings</small></a></li>
                                        <li class="sub"><a href="/archive/2023_graduate/about/Faculty.html">지도교수 <small>Faculty Members</small></a></li>
                                    </ul>
                                </div>                             
                                <div class="sub_07">
                                    <i></i>
                                    <a class="over" href="/archive/2024_work/index.html">2024 작품발표회</a>
                                    <ul class="menu_sub_07">
                                        <i></i>
                                        <li class="sub"><a href="/archive/2024_work/about/Congratulatory.html">축사 <small>Congratulatory Message</small></a></li>
                                        <li class="sub"><a href="/archive/2024_work/about/Greetings.html">인사말 <small>Greetings</small></a></li>
                                        <li class="sub"><a href="/archive/2024_work/about/Faculty.html">지도교수 <small>Faculty Members</small></a></li>
                                    </ul>
                                </div>
                                <div class="sub_08">
                                    <i></i>
                                    <a class="over" href="/performance_main.html">2024 졸업발표회</a>
                                    <ul class="menu_sub_08">
                                        <i></i>
                                        <li class="sub"><a href="/about/Congratulatory.html">축사 <small>Congratulatory Message</small></a></li>
                                        <li class="sub"><a href="/about/Greetings.html">인사말 <small>Greetings</small></a></li>
                                        <li class="sub"><a href="/about/Faculty.html">지도교수 <small>Faculty Members</small></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="hover_menu only_04">
                        <button class="dropbtn">ALUMNI</button>
                            <div class="menu_content cont_04">
                                <div class="sub">
                                    <i></i>
                                    <a class="over" href="/alumni/2022/alumni.html">2022년 졸업생</a>
                                </div>
                                <div class="sub">
                                    <i></i>
                                    <a class="over" href="/alumni/2023/alumni.html">2023년 졸업생</a>
                                </div>
                                <div class="sub">
                                    <i></i>
                                    <a class="over" href="/alumni/2024/alumni.html">2024년 졸업생</a>
                                </div>
                                <!-- <div class="sub">
                                    <i></i>
                                    <a class="over" href="/alumni/2025/alumni.html">2025년 졸업생</a>
                                </div> -->
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
                                <li class="first"><a href="/about/Greetings.html">ABOUT</a>
                                    <ul class="cont_m cont_m_02">
                                        <!-- <li class="sub"><a href="/about/Congratulatory.html">축사 <small>Congratulatory Message</small></a></li> -->
                                        <li class="sub"><a href="/about/Greetings.html">인사말 <small>Greetings</small></a></li>
                                        <li class="sub"><a href="/about/Faculty.html">지도교수 <small>Faculty Members</small></a></li>
                                    </ul>
                                </li>
                                <li class="first"><a href="/performance_main.html">PERFORMANCE</a>     
                                    <!-- 임시주석 -->
                                     <ul class="cont_m cont_m_01">
                                         <li class="sub"><a href="/performance/contemporary.html" class="a_box">컨템포러리 댄스 <small>Contemporary Dance</small></a></li>
                                         <li class="sub"><a href="/performance/korean_dance.html" class="a_box">한국무용 <small>Korean Dance</small></a></li>
                                         <li class="sub"><a href="/performance/ballet.html" class="a_box">발레 <small>Ballet</small></a></li>
                                    </ul> 
                                </li>
                                <li class="first"><a href="#">ARCHIVE</a>
                                    <ul class="cont_m cont_m_03">
                                    <li class="sub">
                                            <a href="/archive/2021/index.html" >2021 작품발표회
                                                <span>
                                                    <a href="#" >
                                                        <img src="/img/gnb_arrow.png" alt="서브메뉴오픈" width="12">
                                                    </a>
                                                </span>
                                            </a>                                
                                            <ul class="cont_m cont_m_01">
                                                <li class="sub"><a href="/archive/2021/about/Congratulatory.html">축사 <small>Congratulatory Message</small></a></li>
                                                <li class="sub"><a href="/archive/2021/about/Greetings.html">인사말 <small>Greetings</small></a></li>
                                                <li class="sub"><a href="/archive/2021/about/Faculty.html">지도교수 <small>Faculty Members</small></a></li>
                                            </ul>
                                        </li>
                                        <li class="sub">
                                            <a href="/archive/2022/index.html" >2021 졸업발표회
                                                <span>
                                                    <a href="#" >
                                                        <img src="/img/gnb_arrow.png" alt="서브메뉴오픈" width="12">
                                                    </a>
                                                </span>
                                            </a>                                
                                            <ul class="cont_m cont_m_01">
                                                <li class="sub"><a href="/archive/2022/about/Congratulatory.html">축사 <small>Congratulatory Message</small></a></li>
                                                <li class="sub"><a href="/archive/2022/about/Greetings.html">인사말 <small>Greetings</small></a></li>
                                                <li class="sub"><a href="/archive/2022/about/Faculty.html">지도교수 <small>Faculty Members</small></a></li>
                                            </ul>
                                        </li>
                                        <li class="sub">
                                            <a href="/archive/2022_work/index.html" >2022 작품발표회
                                                <span>
                                                    <a href="#" >
                                                        <img src="/img/gnb_arrow.png" alt="서브메뉴오픈" width="12">
                                                    </a>
                                                </span>
                                            </a>                                
                                            <ul class="cont_m cont_m_01">
                                                <li class="sub"><a href="/archive/2022_work/about/Congratulatory.html">축사 <small>Congratulatory Message</small></a></li>
                                                <li class="sub"><a href="/archive/2022_work/about/Greetings.html">인사말 <small>Greetings</small></a></li>
                                                <li class="sub"><a href="/archive/2022_work/about/Faculty.html">지도교수 <small>Faculty Members</small></a></li>
                                            </ul>
                                        </li>
                                        <li class="sub">
                                            <a href="/archive/2022_graduate/index.html" >2022 졸업발표회
                                                <span>
                                                    <a href="#" >
                                                        <img src="/img/gnb_arrow.png" alt="서브메뉴오픈" width="12">
                                                    </a>
                                                </span>
                                            </a>                                
                                            <ul class="cont_m cont_m_01">
                                                <li class="sub"><a href="/archive/2022_graduate/about/Congratulatory.html">축사 <small>Congratulatory Message</small></a></li>
                                                <li class="sub"><a href="/archive/2022_graduate/about/Greetings.html">인사말 <small>Greetings</small></a></li>
                                                <li class="sub"><a href="/archive/2022_graduate/about/Faculty.html">지도교수 <small>Faculty Members</small></a></li>
                                            </ul>
                                        </li>
                                        <li class="sub">
                                            <a href="/archive/2022_showcase/index.html" >2022 쇼케이스
                                                <span>
                                                    <a href="#" >
                                                        <img src="/img/gnb_arrow.png" alt="서브메뉴오픈" width="12">
                                                    </a>
                                                </span>
                                            </a>                                
                                            <ul class="cont_m cont_m_01">
                                                <li class="sub"><a href="/archive/2022_showcase/about/Greetings.html">인사말 <small>Greetings</small></a></li>
                                                <li class="sub"><a href="/archive/2022_showcase/about/Faculty.html">지도교수 <small>Faculty Members</small></a></li>
                                            </ul>
                                        </li>
                                        <li class="sub">
                                            <a href="/archive/2023_work/index.html" >2023 작품발표회
                                                <span>
                                                    <a href="#" >
                                                        <img src="/img/gnb_arrow.png" alt="서브메뉴오픈" width="12">
                                                    </a>
                                                </span>
                                            </a>                                
                                            <ul class="cont_m cont_m_01">
                                                <li class="sub"><a href="/archive/2023_work/about/Congratulatory.html">축사 <small>Congratulatory Message</small></a></li>
                                                <li class="sub"><a href="/archive/2023_work/about/Greetings.html">인사말 <small>Greetings</small></a></li>
                                                <li class="sub"><a href="/archive/2023_work/about/Faculty.html">지도교수 <small>Faculty Members</small></a></li>
                                            </ul>
                                        </li>         
                                        <li class="sub">
                                            <a href="/archive/2023_graduate/index.html">2023 졸업발표회
                                                <span>
                                                    <a href="#" >
                                                        <img src="/img/gnb_arrow.png" alt="서브메뉴오픈" width="12">
                                                    </a>
                                                </span>
                                            </a>                                
                                            <ul class="cont_m cont_m_01">
                                                <li class="sub"><a href="/archive/2023_graduate/about/Congratulatory.html">축사 <small>Congratulatory Message</small></a></li>
                                                <li class="sub"><a href="/archive/2023_graduate/about/Greetings.html">인사말 <small>Greetings</small></a></li>
                                                <li class="sub"><a href="/archive/2023_graduate/about/Faculty.html">지도교수 <small>Faculty Members</small></a></li>
                                            </ul>
                                        </li>    
                                        <li class="sub">
                                            <a href="/archive/2024_work/index.html">2024 작품발표회
                                                <span>
                                                    <a href="#" >
                                                        <img src="/img/gnb_arrow.png" alt="서브메뉴오픈" width="12">
                                                    </a>
                                                </span>
                                            </a>                                
                                            <ul class="cont_m cont_m_01">
                                                <li class="sub"><a href="/archive/2024_work/about/Congratulatory.html">축사 <small>Congratulatory Message</small></a></li>
                                                <li class="sub"><a href="/archive/2024_work/about/Greetings.html">인사말 <small>Greetings</small></a></li>
                                                <li class="sub"><a href="/archive/2024_work/about/Faculty.html">지도교수 <small>Faculty Members</small></a></li>
                                            </ul>
                                        </li>           
                                        <li class="sub">
                                            <a href="/performance_main.html">2024 졸업발표회
                                                <span>
                                                    <a href="#" >
                                                        <img src="/img/gnb_arrow.png" alt="서브메뉴오픈" width="12">
                                                    </a>
                                                </span>
                                            </a>                                
                                            <ul class="cont_m cont_m_01">
                                                <li class="sub"><a href="/about/Congratulatory.html">축사 <small>Congratulatory Message</small></a></li>
                                                <li class="sub"><a href="/about/Greetings.html">인사말 <small>Greetings</small></a></li>
                                                <li class="sub"><a href="/about/Faculty.html">지도교수 <small>Faculty Members</small></a></li>
                                            </ul>
                                        </li>                                
                                    </ul>
                                </li>
                                <li class="first">
                                    <a href="#">ALUMNI</a>
                                    <ul class="cont_m cont_m_03">
                                        <li class="sub">
                                            <a href="/alumni/2022/alumni.html" >2022년 졸업생</a>                                
                                        </li>                                 
                                        <li class="sub">
                                            <a href="/alumni/2023/alumni.html" >2023년 졸업생</a>                                
                                        </li>   
                                        <li class="sub">
                                            <a href="/alumni/2024/alumni.html" >2024년 졸업생</a>                                
                                        </li>  
                                        <!-- <li class="sub">
                                            <a href="/alumni/2025/alumni.html" >2025년 졸업생</a>                                
                                        </li>                               -->
                                    </ul> 
                                </li>
                                <li>
                                    <a href="/home/bbs/board.php?bo_table=notice">NOTICE</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="title"><span>News & Updates</span></div>
             </header>
        </div>
    </div>
    <script>
    
    $(function(){
        $(".gnb_menu_btn").click(function(){
            $("#gnb_all, #gnb_all_bg").show();
        });
        $(".gnb_close_btn, #gnb_all_bg").click(function(){
            $("#gnb_all, #gnb_all_bg").hide();
        });
    });
      //모바일 메뉴
      function openNav() {
        document.getElementById("mo_nav").style.height = "100%";
        document.getElementById("main").style.overflow = "hidden";
    }
  
    function closeNav() {
        document.getElementById("mo_nav").style.height = "0%";
        document.getElementById("main").style.overflow = "inherit";
    }

    // 모바일 메뉴토글
    $('.show').tendina({
    onHover: false,
    speed: 300,

  });
    </script>

</div>
<!-- } 상단 끝 -->


<hr>

<!-- 콘텐츠 시작 { -->
<div id="wrapper">
    <div id="container_wr">
   
    <div id="container">
        <?php if (!defined("_INDEX_")) { ?><h2 id="container_title"><span title="<?php echo get_text($g5['title']); ?>"><?php echo get_head_title($g5['title']); ?></span></h2><?php }