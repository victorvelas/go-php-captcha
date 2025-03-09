"use strict";

(function () {
    const el = document.getElementById("rotate-wrap");
    const capt = new GoCaptcha.Rotate({
        width: 300,
        height: 300,
        title: 'Alinee la siguiente imagen',
        scope : false
    })
    capt.mount(el);
    capt.setData({
        image: '../.caches/master.jpg',
        thumb: '../.caches/thumb.png',
        angle: 0,

    })
    capt.setEvents({
        rotate: function (angle) {

        },
        refresh: function () {
            // ...
        },
        close: function () {
            // ...
        },
        confirm: async function (angle, reset) {

            console.log(angle);
            let response = await fetch('checkRotator.php', {
                method: "POST",
                body: (() => {
                    const fd = new FormData();
                    fd.append('captcha_value', angle);
                    return fd;
                })()
              });
            let json = await response.json();
            if (json.status === true) {
                alert('Nice work :D');
            } else {
                alert('incorrect captcha');
            }
        },
    })
})();
