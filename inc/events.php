<?php
/*
 * 사이트 메뉴 설정 — 공연/졸업생이 추가되면 여기만 고치면 됩니다.
 *
 * 새 공연 추가:
 *   1. archive/<폴더>/ 를 만들고 (header.php, footer.php 는 기존 폴더 것을 복사 후 $event_title 만 수정)
 *   2. 아래 $EVENTS 맨 끝에 한 줄 추가
 *   3. 메인 피쳐로 띄울 거면 $CURRENT_EVENT 를 그 폴더명으로 변경
 *
 * 주의: PC 아카이브 드롭다운은 항목 순서별 CSS(sub_01 ~ sub_14)로 위치를 잡습니다.
 *       16번째 항목(sub_15)부터는 css/header.css, css/style.css 에 스타일 추가가 필요합니다.
 */

// 메인 피쳐 (MAIN 메뉴의 ABOUT / PERFORMANCE 가 가리키는 공연)
$CURRENT_EVENT = '2026_graduate';

// 아카이브 목록 (메뉴에 표시되는 순서). congrats: 축사 페이지 유무
$EVENTS = array(
    array('dir' => '2021',          'label' => '2021 작품발표회', 'congrats' => true),
    array('dir' => '2022',          'label' => '2021 졸업발표회', 'congrats' => true),
    array('dir' => '2022_work',     'label' => '2022 작품발표회', 'congrats' => true),
    array('dir' => '2022_graduate', 'label' => '2022 졸업발표회', 'congrats' => true),
    array('dir' => '2022_showcase', 'label' => '2022 쇼케이스',   'congrats' => false),
    array('dir' => '2023_work',     'label' => '2023 작품발표회', 'congrats' => true),
    array('dir' => '2023_graduate', 'label' => '2023 졸업발표회', 'congrats' => true),
    array('dir' => '2024_work',     'label' => '2024 작품발표회', 'congrats' => true),
    array('dir' => '2024_graduate', 'label' => '2024 졸업발표회', 'congrats' => true),
    array('dir' => '2024_showcase', 'label' => '2024 쇼케이스',   'congrats' => false),
    array('dir' => '2025_work',     'label' => '2025 작품발표회', 'congrats' => true),
    array('dir' => '2025_graduate', 'label' => '2025 졸업발표회', 'congrats' => true),
    array('dir' => '2025_showcase', 'label' => '2025 쇼케이스',   'congrats' => false),
    array('dir' => '2026_work',     'label' => '2026 작품발표회', 'congrats' => true),
    array('dir' => '2026_graduate', 'label' => '2026 졸업발표회', 'congrats' => true),
);

// 졸업생 목록 (alumni/<연도>/alumni.html)
$ALUMNI_YEARS = array(2022, 2023, 2024, 2025, 2026);
