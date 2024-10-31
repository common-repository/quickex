function Qvalidator() {

    let me = {
        submitButton: _$(".js-submit-order-send"),
        checkboxAdmire: _$(".js-checkbox-admire"),
        orderFields: function () {
            return _$(".js-order-field");
        }
    };

    me.checkValid = function () {
        me.submitButton.attr("disabled", "true");
        let setValid = true;
        me.orderFields().each(function () {
            let orderField = _$(this);
            if (orderField.next().hasClass("active") || !orderField.val().trim()) {
                setValid = false;
            }
        });

        if (_$('#destination_address').val() == _$('#refund_address').val()) {
            _$('#refund_address').parents(".order__wrap").removeClass("success");
            _$('#refund_address').next().addClass("active").html('INVALID ADDRESS');
            setValid = false;
        }

        if (setValid) {
            me.submitButton.removeAttr("disabled");
        }

        return setValid;
    };

    me.checkAdmire = function () {
        let checked = me.checkboxAdmire.is(':checked');

        if (checked) {
            me.submitButton.removeAttr("disabled");
        } else {
            me.submitButton.attr("disabled", "true");
        }

        return checked;
    };

    me.validateExchange = function (destinationCurrency, value) {
        let result;
        let validateAjax = _$.ajax({
            url: '/api/validate-address?currency=' + destinationCurrency + '&address=' + value,
            type: 'GET',
            async: false,
            dataType: 'json',
            success: function (resp) {
                result = resp;
            },
            error: function () {
                result['result'] = false;
            }
        });
        return result;
    };

    me.getValidate = function (currentField) {
        let destinationCurrency = currentField.data('currency');
        let address = currentField.val().trim();
        if (address !== "") {
            let result = me.validateExchange(destinationCurrency, address);
            currentField.parent().find(".exchange__error").removeClass('active');
            currentField.parent().find(".q-field-success").addClass('hidden');
            currentField.removeClass("success").removeClass('error');
            if (result.result === false) {
                currentField.parent().find(".exchange__error").addClass('active');
                currentField.addClass("error");
                currentField.next().html(result['message']);
                me.submitButton.attr("disabled", "true");
            } else {
                currentField.parent().find(".q-field-success").removeClass('hidden');
                currentField.addClass("success");
                me.submitButton.removeAttr("disabled");
            }
        }

        if (me.checkAdmire()) {
            me.checkValid();
        }
    };

    me.validate = function () {
        me.orderFields().each(function () {
            let orderField = _$(this);
            setTimeout(function () {
                me.getValidate(orderField);
            }, 300);
        });
    };

    me.orderFields().each(function () {
        let orderField = _$(this);
        orderField.blur(function () {
            me.getValidate(orderField);
        });
        orderField.change(function () {
            orderField.next().removeClass("active");
        });

        orderField.bind("paste", function () {
            setTimeout(function () {
                me.getValidate(orderField);
            }, 100)
        });

        orderField.bind("input", function () {
            orderField.parent().parent().removeClass("success");

            if (orderField.next().hasClass("active")) {
                orderField.next().removeClass("active");
            }
        });
    });

    me.submitButton.on('click', function () {
        me.validate();
        return me.submitButton.attr("disabled");
    });

    me.checkboxAdmire.on("change", function () {
        if (me.checkValid()) {
            me.checkAdmire();
        }
    });

    me.submitButton.attr("disabled", true);
    return me;
}

let validator = Qvalidator();