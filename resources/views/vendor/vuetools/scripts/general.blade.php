@section('vue_scripts')
<script>
    var vueForms = {};
    var vueComponents = {};
    var vueMixins = {};
    var vueSorts = {};

    @if(config('app.debug', 'false') == 'true')
        Vue.config.debug = true;
    @else
        Vue.config.debug = false;
    @endif

    Object.filter = function(obj, predicate) {
        var result = {};

        for(var key in obj) {
            if (obj.hasOwnProperty(key) && predicate(obj[key], key, obj)) {
                result[key] = obj[key];
            }
        }

        return result;
    };

    Object.findKey = function(obj, predicate) {
        for(var key in obj) {
            if (obj.hasOwnProperty(key) && predicate(obj[key], key, obj)) {
                return key;
            }
        }

        return -1;
    };

    function clone(obj) {
        if(Array.isArray(obj)) {
            return obj.filter(function(){return true;});
        } else {
            var rtn = new Object;
            var keys = Object.keys(obj);
            for(var i = 0; i < keys.length; i++) {
                rtn[keys[i]] = obj[keys[i]];
            }

            return rtn;    
        }
    }

    function getObjectField(field, object) {
        var rtn = object;
        var keys = field.split('.');
        for(var key in keys) {
            if(typeof(rtn[keys[key]]) == 'undefined'
                || rtn[keys[key]] == null) {
                return null;
            }
            rtn = rtn[keys[key]];
        }
        return rtn;
    }

    function clearThousandsComma($field, validatorName, validator) {
        var value = $field.val();
        var valueSplit = value.split('.');
        var front = valueSplit[0];
        var back;
        if(valueSplit.length > 1) {
            back = valueSplit[1];
        } else {
            back = '';
        }

        var frontReplaced = front.replace(/,([0-9]{3})/g, function(match, p1) {
            return p1;
        });
        
        if(back != '') {
            return frontReplaced + '.' + back;
        } else {
            return frontReplaced;
        }
    }
    
    function number_format(number, decimals, dec_point, thousands_sep, show_zero) {
        number = (number + '')
            .replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + (Math.round(n * k) / k)
                    .toFixed(prec);
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
            .split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '')
            .length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1)
                .join('0');
        }
        
        if(s.join(dec) == 0 && show_zero === 'false' ) {
            return '';  
        } else  {
            return s.join(dec);
        }
    }

    function contains(val, search) {
        var i;
        if (Vue.util.isPlainObject(val)) {
            var keys = Object.keys(val);
            i = keys.length;
            while (i--) {
                if (contains(val[keys[i]], search)) {
                    return true;
                }
            }
        } else if (Vue.util.isArray(val)) {
            i = val.length;
            while (i--) {
                if (contains(val[i], search)) {
                    return true;
                }
            }
        } else if (val != null) {
            return val.toString().toLowerCase().indexOf(search) > -1;
        }
    }
    Vue.mixin({
        methods: {
            can: function(level, area) {
                return true;
            },
            route: function(name, parameters) {
                var route = getObjectField(name, routes);
                var keys = [];
                if(typeof(parameters) != 'undefined') {
                     keys = Object.keys(parameters);
                }
                for(var i in keys) {
                    var toReplace = '_' + keys[i] + '_';
                    route = route.replace(toReplace, parameters[keys[i]]);
                }

                return route;
            }
        }
    });
</script>
@append