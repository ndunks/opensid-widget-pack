import jQuery from "jquery";

jQuery(function ($) {
    var loader = {
        '.widget_opensid_widget_perangkat': function (el) {
            let self = $(el);
            let slider = self.find('.slider-items');
            let sliderCount = self.find("li img").length;
            let sliderIndex = 0;
            function sliderPos() {
                slider.css("left", -sliderIndex * 100 + "%");
            }

            self.find(".arrow-right").click(function () {
                (sliderIndex >= sliderCount - 1) ? (sliderIndex = 0) : sliderIndex++;
                sliderPos();
            });

            self.find(".arrow-left").click(function () {
                sliderIndex <= 0 ? (sliderIndex = sliderCount - 1) : sliderIndex--;
                sliderPos();
            });

            let goSlider = setInterval(() => {
                self.find(".arrow-right").click();
            }, 3000);

            self.on({
                mouseenter: () => {
                    clearInterval(goSlider);
                },
                mouseleave: () => {
                    goSlider = setInterval(() => {
                        self.find(".arrow-right").click();
                    }, 3000);
                }
            });
        }
    }

    var matched;
    for (let field in loader) {
        matched = $(field);
        if (matched.length) {
            matched.each(
                function (v, i, a) {
                    loader[field](i);
                }
            )
        }
    }
})