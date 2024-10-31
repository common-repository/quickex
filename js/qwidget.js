_$('.js-select-currency').select2({theme: 'currency', language: "en"});

var pairs;

_$.ajax({
    url: '/api/pairs',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
        pairs = data;
        var _$options = _$();
        var _pairs = Object.keys(pairs);
        var from = _$('.js-select-currency-1').val();
        for (var i in Object.keys(pairs)) {
            var option = _$('<option>').attr('value', _pairs[i]).html(_pairs[i]);
            if (from == _pairs[i]) {
                option.attr('selected', 'selected');
            }
            _$options = _$options.add(option);
        }
        _$('.js-select-currency').html(_$options).trigger('change');
    },
    error: function () {

    }
});

function getFirst(arr) {
    if (arr.length) {
        return arr[0];
    }
    return null;
}

function getLast(arr) {
    if (arr.length) {
        return arr[arr.length - 1];
    }
    return null;
}

var interval = {data: {result: {}}, pair: ''};

function floorDecimal(n, decimals) {
    var d = Math.pow(10, decimals);
    return parseInt(n * d) / d;
}

function getRate() {
    _$('#amount-to').val('...');
    _$('.js-exchange-button').attr("disabled", "disabled");
    _$(".js-exchange-error-from").removeClass("active");
    var pair = getPair();
    if (interval.pair !== pair) {
        updateInterval(function () {
            getRate();
        });
        return;
    }

    var rate = 0;
    var amount = _$('#amount-from').val();

    var min = getFirst(interval.data.result);
    if (min !== null) {
        min = min.amount;
    }
    var max = getLast(interval.data.result);
    if (max !== null) {
        max = max.amount;
    }
    var error = false;

    if (min === null || amount < min) {
        error = {msg: interval.data.errors.min, value: min};
    }
    if (amount > max) {
        error = {msg: interval.data.errors.max, value: max};
    }

    if (error === false) {
        var _rate = 0;
        var prevRate = 0;
        var prevAmount = 0;
        var result = interval.data.result;
        for (var i = 0; i < result.length; i++) {
            _amount = result[i].amount;
            _rate = result[i].rate;
            if (amount >= prevAmount && amount < _amount) {
                rate = amount * prevRate;
                break;
            } else {
                prevAmount = _amount;
                prevRate = _rate;
            }
        }
        if (rate === 0) {
            rate = amount * prevRate;
        }
        rate = floorDecimal(rate, 8);
        _$('.js-exchange-button').removeAttr("disabled");
    } else {
        _$(".js-exchange-error-from .text").text(error.msg);
        _$(".js-exchange-error-from").addClass("active");
        _$('.js-exchange-button').attr("disabled", "disabled");
        rate = '...';
    }
    _$('#amount-to').val(rate);
}

function getPair() {
    var from = _$('#currency-from').val();
    var to = _$('#currency-to').val();
    return from + to;
}

updating = false;

function updateInterval(callback) {
    if (updating) {
        return;
    }
    var from = _$('#currency-from').val();
    var to = _$('#currency-to').val();
    var pair = getPair();
    if (typeof (xhr) !== 'undefined') {
        xhr.abort();
    }
    updating = true;
    xhr = _$.ajax({
        url: '/api/rate-interval',
        type: 'GET',
        data: {'from': from, 'to': to},
        dataType: 'json',
        success: function (data) {
            interval.pair = pair;
            if (data) {
                interval.data = data;
            } else {
                interval.data = {result: {}};
            }
            if (typeof (callback) == 'function') {
                callback();
            }
            updating = false;
        },
        error: function () {
            updating = false;
        }
    });
}

setInterval(function () {
    updateInterval();
}, 5000);

_$('.target').change(function () {
    if (_$(this).hasClass('js-select-currency-1')) {
        var _pairs = pairs[_$(this).val()];
        var _$options = _$();
        for (var i in _pairs) {
            var option = _$('<option>').attr('value', _pairs[i]).html(_pairs[i]);
            if (_$('.js-select-currency-2').val() == _pairs[i]) {
                option.attr('selected', 'selected');
            }
            _$options = _$options.add(option);
        }
        _$('.js-select-currency-2').html(_$options).trigger('change');
    }
    getRate();
});

_$('.exchange__input').on('keyup', function () {
    getRate();
});

function setReverse() {

    var select1Value = _$('.js-select-currency-1').val();
    var select2Value = _$('.js-select-currency-2').val();

    _$('.js-select-currency-1').val(select2Value).trigger("change");
    _$('.js-select-currency-2').val(select1Value).trigger("change");
}

_$(".js-reverse").on('click', function () {
    setReverse();
});

_$('.js-exchange-error-from').on('click', function () {
    _$(".js-exchange-from").val(_$(this).data('value'));
    _$(this).removeClass("active");
    _$('.js-exchange-button').removeAttr("disabled");
    getRate();
});

/*START validate numbers*/
function validateNumber(event) {

    if (event.key === ",") {
        event.target.value = event.target.value.replace(/,/g, '\.')
    }

    if (!(!event.shiftKey //Disallow: any Shift+digit combination
        && !(event.keyCode < 48 || event.keyCode > 57) //Disallow: everything but digits
        || !(event.keyCode < 96 || event.keyCode > 105 || event.key == "б" || event.key == "ю" || event.key == "/") //Allow: numeric pad digits
        || event.keyCode == 46 // Allow: delete
        || event.keyCode == 8  // Allow: backspace
        || event.keyCode == 9  // Allow: tab
        || event.keyCode == 27 // Allow: escape
        || event.keyCode == 110 // Allow: digit
        || event.keyCode == 17 // Allow: ctrlKey
        || event.keyCode == 91 // Allow: cmdKey
        || event.keyCode == 86 // Allow: vKey
        || event.keyCode == 88 // Allow: xKey
        || event.keyCode == 67 // Allow: cKey
        || event.keyCode == 90 // Allow: zKey
        || event.key == "."
        || event.key == ","
        || event.keyCode == 190 // Allow: escape
        || (event.keyCode == 65 && (event.ctrlKey === true || event.metaKey === true)) // Allow: Ctrl+A
        || (event.keyCode == 67 && (event.ctrlKey === true || event.metaKey === true)) // Allow: Ctrl+C
        //Uncommenting the next line allows Ctrl+V usage, but requires additional code from you to disallow pasting non-numeric symbols
        //|| (event.keyCode == 86 && (event.ctrlKey === true || event.metaKey === true)) // Allow: Ctrl+Vpasting
        || (event.keyCode >= 35 && event.keyCode <= 39) // Allow: Home, End
    )) {
        event.preventDefault();
    }
}

var onlyNumbers = document.querySelectorAll(".js-onlyNumbers");

if (onlyNumbers.length) {
    Array.prototype.forEach.call(onlyNumbers, function (onlyNumber) {
        onlyNumber.addEventListener("keydown", validateNumber);
    });
}
/* END validate numbers*/

getRate();

_$('.exchange__input').on('input', function (e) {
    var value = _$(this).val();
    if (value == '') {
        return;
    }
    if (/^0[0-9]+/g.test(value)) {
        value = "0." + value.substring(1, value.length);
    }
    value = value.replace(",", ".").replace(/[^.\d]+/g, "").replace(/^([^\.]*\.)|\./g, '$1');
    if ((/^\./.test(value))) {
        value = '0' + value;
    }
    if (value.length > 20) {
        value = value.substring(0, 20);
    }
    _$(this).val(value);
    _$(this).data('val', value);
});

/* START input for phones */
function isIosDevice() {
    return navigator.userAgent.match(/iPad|iPod|iPhone/i) != null;
}

if (isIosDevice()) {
    _$('.exchange__input[type="tel"]').on('touchstart', function () {
        _$(this).attr('type', 'number');
    });

    _$('.exchange__input[type="tel"]').on('keydown blur', function () {
        _$(this).attr('type', 'tel');
    });
}
/* END input for phones */