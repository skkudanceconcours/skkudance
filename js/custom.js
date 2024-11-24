//
$(document).ready(function () {
  var $randomnbr = $(".nbr");
  var $timer = 10;
  var $it;
  var $data = 0;
  var index;
  var change;
  // var letters = ["2", "0", "2", "1"];
  var letters = ["3"];
  $randomnbr.each(function () {
    change = Math.round(Math.random() * 100);
    $(this).attr("data-change", change);
  });

  function random() {
    return Math.round(Math.random() * 9);
  }

  function select() {
    return Math.round(Math.random() * $randomnbr.length + 1);
  }

  function value() {
    $(".nbr:nth-child(" + select() + ")").html("" + random() + "");
    $(".nbr:nth-child(" + select() + ")").attr("data-number", $data);
    $data++;

    $randomnbr.each(function () {
      if (
        parseInt($(this).attr("data-number")) >
        parseInt($(this).attr("data-change"))
      ) {
        index = $(".ltr").index(this);
        $(this).html(letters[index]);
        $(this).removeClass("nbr");
      }
    });
  }

  $it = setInterval(value, $timer);
});

//모바일 메뉴
function openNav() {
  document.getElementById("mo_nav").style.height = "100vh";
  document.getElementById("main").style.overflow = "hidden";
}

function closeNav() {
  document.getElementById("mo_nav").style.height = "0%";
  document.getElementById("main").style.overflow = "inherit";
}

//애니메이션
$(document).ready(function () {
  aniCtrl();
  $(window).scroll(function () {
    aniCtrl();
  });
});

function aniCtrl() {
  var _st = $(window).scrollTop();
  var _wH = $(window).height();
  $(".ani-item").each(function () {
    var _this = $(this);
    if (_this.offset().top <= _st + _wH && !_this.hasClass("done")) {
      _this.addClass("done");
    }
  });
}

//totop
$(function () {
  $("#top_btn").on("click", function () {
    $("html, body").animate({ scrollTop: 0 }, "500");
    return false;
  });
});
$(window).scroll(function () {
  if ($(window).scrollTop() > 300) {
    $("#top_btn").addClass("show");
  } else {
    $("#top_btn").removeClass("show");
  }
});
