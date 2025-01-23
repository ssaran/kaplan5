"use strict";
/*jshint esversion: 6 */

(function() {
    window.k5.filter = {
        creditCard: function(CC) {
            if (CC.length != 16) {
                return null;
            }

            if (CC.length > 19) {
                return false;
            }

            var sum = 0; var mul = 1; var l = CC.length;
            for (var i = 0; i < l; i++) {
                var digit = CC.substring(l-i-1,l-i);
                var tproduct = parseInt(digit ,10)*mul;
                if (tproduct >= 10) {
                    sum += (tproduct % 10) + 1;
                } else {
                    sum += tproduct;
                }

                mul = (mul == 1) ? mul + 1 : mul - 1;
            }
            if ((sum % 10) == 0) {
                return true;
            } else {
                return false;
            }
        },
        tcNo: function(tcNo) {
            tcNo = tcNo.toString();
            var isEleven = /^[0-9]{11}$/.test(tcNo);
            var totalX = 0;
            for (var i = 0; i < 10; i++) {
                totalX += Number(tcNo.substr(i, 1));
            }
            var isRuleX = totalX % 10 == tcNo.substr(10,1);
            var totalY1 = 0;
            var totalY2 = 0;
            for (var i = 0; i < 10; i+=2) {
                totalY1 += Number(tcNo.substr(i, 1));
            }
            for (var i = 1; i < 10; i+=2) {
                totalY2 += Number(tcNo.substr(i, 1));
            }
            var isRuleY = ((totalY1 * 7) - totalY2) % 10 == tcNo.substr(9,0);
            return isEleven && isRuleX && isRuleY;
        },
        email: function(str) {
            Util.convertToASCII(str);
            str = str.replace(/[^a-zA-Z0-9-_$.@]/g, '')
            return str;
        },
    };
})();



