var SystemSetting = function () {
    var elMainView = $("#main-view");
    var qrplaceholder = $("#qr-placeholder");
    var containerQR = elMainView.find(".wa-qrcode");
    var containerWA = elMainView.find(".wa-info");
    var containerLog = elMainView.find(".wa-logs");
    var imgQR = containerQR.find('img');

    var handleWASession = function () {
        var socket = io.connect(HOST);

        socket.on('connect', function () {
            updateWAInfo({ ready: false, message: "Checking ..." });
        });

        socket.on("qr", function (src) {
            imgQR.attr('src', src);
            updateWAInfo({ qr: true });
        });

        socket.on('ready', function (phoneNumber) {
            updateWAInfo({ ready: true, phone: phoneNumber });
        });

        socket.on('disconnect', function () {
            updateWAInfo({ ready: false, message: "Server Offline" });
        });

        containerWA.find('.btn-disconnect-wa').on('click', function () {
            socket.emit('logout');
            updateWAInfo({ ready: false, message: "Checking ..." });
        });
    };

    var updateWAInfo = function (options) {
        var setting = $.extend(true, {
            ready: false,
            qr: false,
            message: '',
            phone: ''
        }, options);

        elMainView.find('.wa-section').hide();

        if (setting.ready) {
            containerWA.find('.wa-number').text(setting.phone);
            qrplaceholder.hide();
            containerWA.show();
        } else if (setting.qr) {
            containerQR.show();
            qrplaceholder.hide();
        } else {
            containerLog.html(setting.message);
            containerLog.show();
        }
    }

    return {
        init: function () {
            handleWASession();
        },
    };
}();
