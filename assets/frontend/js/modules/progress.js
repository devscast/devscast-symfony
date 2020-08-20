import $ from 'jquery'
import 'jquery.appear'

const progressLine = $('.progress-line');
if (progressLine.length) {
    progressLine.appear(function () {
        let el = $(this);
        let percent = el.data('width');
        $(el).css('width', percent + '%');
    }, {accY: 0});
}

const countBox = $('.count-box');
if (countBox.length) {
    countBox.appear(function () {
        const $t = $(this),
            n = $t.find(".count-text").attr("data-stop"),
            r = parseInt($t.find(".count-text").attr("data-speed"), 10);

        if (!$t.hasClass("counted")) {
            $t.addClass("counted");
            $({
                countNum: $t.find(".count-text").text()
            }).animate({
                countNum: n
            }, {
                duration: r,
                easing: "linear",
                step: function () {
                    $t.find(".count-text").text(Math.floor(this.countNum));
                },
                complete: function () {
                    $t.find(".count-text").text(this.countNum);
                }
            });
        }

    }, {accY: 0});
}
