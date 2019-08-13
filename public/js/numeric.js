Number.prototype.format = function (n, x) {
    var re = '(\\d)(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$1,');
};

function toNumber(val, defaultVal = 0) {
    // alert(val)
    val = val.toString().replace(/\,/g, ''); // 1125, but a string, so convert it to number
    if (Number(val) === 0 || isNaN(val) || val == 'Nam') {
        return defaultVal;
    }
    return a = parseFloat(Number(val), 2);
}

function toNumber1(val, defaultVal = 0) {
    alert(val)
    val = val.toString().replace(/\,/g, ''); // 1125, but a string, so convert it to number
    if (Number(val) === 0 || isNaN(val) || val == 'Nam') {
        return defaultVal;
    }
    return a = parseFloat(Number(val), 2);
}