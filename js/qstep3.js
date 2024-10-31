_$(document).ready(function () {
    _$('.copy-link').click(function () {
        var contentHolder = document.getElementById(_$(this).data('id'));
        var range = document.createRange(),
            selection = window.getSelection();
        selection.removeAllRanges();
        range.selectNodeContents(contentHolder);
        selection.addRange(range);
        document.execCommand('copy');
        selection.removeAllRanges();
        _$(this).text('Copied');
    });

    function getInfo() {
        _$.ajax({
            url: '/exchange/status',
            type: 'GET',
            dataType: 'json',
            data: {
                id: txid
            },
            success: function (response) {
                var status = response.status;
                var pathname = window.location.pathname;

                _$('.status-name').text(response.statusName);
                _$('.progress').css('width', response.progress + '%');

                if (status != 'success' && pathname != '/exchange/step-3') {
                    window.location.href = '/exchange/step-3?id=' + txid;
                } else if (status == 'success' && pathname != '/exchange/step-4') {
                    window.location.href = '/exchange/step-4?id=' + txid;
                }
            },
            error: function () {

            }
        });

        setTimeout(getInfo, 5000);
    }

    getInfo();

});