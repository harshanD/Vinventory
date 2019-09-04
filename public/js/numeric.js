Number.prototype.format = function (n, x) {
    var re = '(\\d)(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$1,');
};

function toNumber(val, defaultVal = 0) {
    // alert('|'+val+'|')
    //   (isNumeric(val)) ? val.toString() : '';

    val = val.toString().replace(/\,/g, ''); // 1125, but a string, so convert it to number
    if (Number(val) === 0 || isNaN(val) || val == 'Nam') {
        return defaultVal;
    }
    return a = parseFloat(Number(val), 2);
}

$(document).ready(function () {
    $(".number").keyup(function () {
        if (!$.isNumeric(this.value)) {
            $(this).css('background', '#ff6666');
            $(this).val(this.value.replace(/[^\d.-]/g, ''));
            $(this).focus
            $(this).css('background', 'white')
            return false;
        } else {
            $(this).css('background', 'white')
            return false;
        }
    });
})


function qtyValidating(id) {
    if (!$.isNumeric($('#' + id).val())) {
        // $('#' + id).css('background', '#ff6666');
        $('#' + id).val(($('#' + id).val()).replace(/[^\d.-]/g, ''));
        $('#' + id).focus
        // $('#' + id).css('background', 'white')
        return false;
    } else {
        // $('#' + id).css('background', 'white')
        return false;
    }
}

function toNumber1(val, defaultVal = 0) {
    alert(val)
    val = val.toString().replace(/\,/g, ''); // 1125, but a string, so convert it to number
    if (Number(val) === 0 || isNaN(val) || val == 'Nam') {
        return defaultVal;
    }
    return a = parseFloat(Number(val), 2);
}