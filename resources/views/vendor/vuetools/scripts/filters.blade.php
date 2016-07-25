@section('vue_scripts')
<script>
	vueSorts.date = function(a, b) {
		if(typeof(a) == 'undefined'
			|| a == ''
			|| a == null) {
			a = moment('null');
		} else {
			a = moment(a);
		}

		if(typeof(b) == 'undefined'
			|| b == ''
			|| b == null) {
			b = moment('null');
		} else {
			b = moment(b);
		}

		if(!a.isValid() && !b.isValid()) {
			return 0;
		} else if(a.isValid() && !b.isValid()) {
			return 1;
		} else if(!a.isValid() && b.isValid()) {
			return -1;
		} else if(a.isBefore(b, 'day')) {
			return -1;
		} else if(b.isBefore(a, 'day')) {
			return 1;
		} else {
			return 0;		
		}
	}

	vueSorts.dateTime = function(a, b) {
		if(typeof(a) == 'undefined'
			|| a == ''
			|| a == null) {
			a = moment('null');
		} else {
			a = moment(a);
		}

		if(typeof(b) == 'undefined'
			|| b == ''
			|| b == null) {
			b = moment('null');
		} else {
			b = moment(b);
		}

		if(!a.isValid() && !b.isValid()) {
			return 0;
		} else if(a.isValid() && !b.isValid()) {
			return 1;
		} else if(!a.isValid() && b.isValid()) {
			return -1;
		} else if(a.isBefore(b, 'second')) {
			return -1;
		} else if(b.isBefore(a, 'second')) {
			return 1;
		} else {
			return 0;		
		}
	}

	vueSorts.number = function(a, b) {
		if(a > b) {
			return 1;
		} else if(a < b) {
			return -1;
		} else {
			return 0;
		}
	}

	vueSorts.alpha = function(a, b) {
		return a.localeCompare(b);
	}

	vueSorts.boolean = function(a, b) {
		if(a == true && b == false) {
			return 1;
		} else if(a == false && b == true) {
			return -1;
		} else {
			return 0;
		}
	}

	Vue.filter('isObject', function(object) {
		return Vue.util.isPlainObject(object);
	});

	Vue.filter('date', function(date, format) {
		var filterDate
		if(date == '' || date == null) {
			filterDate = moment('null');
		} else {
			filterDate = moment(date);
		}
	    
	    if(filterDate.isValid()) {
	    	if(typeof(format) != 'undefined') {
	    		return filterDate.format(format);	
	    	} else {
	    		return filterDate.format("{{ config('vue.defaultDateFormat') }}");
	    	}
	    } else {
	        return '';
	    }
	});

	Vue.filter('number', {
	 	read: function(number, decimals, decimalPoint, thousandsSeperator) {
			if(typeof(number) == 'undefined' || isNaN(number)) {
				return '';
			} else {
				if(typeof(decimals) == 'undefined') {
					decimals = {{ config('vue.defaultDecimals', 2) }};
				}
				if(typeof(decimalPoint) == 'undefined') {
					decimalPoint = "{{ config('vue.defaultDecimalPoint', '.') }}";
				}
				if(typeof(thousandsSeperator) == 'undefined') {
					thousandsSeperator = "{{ config('vue.defaultThousandSeparator', ',') }}";
				}

				return number_format(number, decimals, decimalPoint, thousandsSeperator);
			}
		},
		write: function(number) {
			var value = number;
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
	});

	Vue.filter('length', function(array) {
	    return array.length;
	});

	Vue.filter('notIn', function(array, compareArray, compareElement) {
		if(typeof(compareElement) == 'undefined') {
			return array.filter(function(elem) {
		    	var index = compareArray.indexOf(elem);
		    	return (index == -1);
		    });	
		} else {
			return array.filter(function(elem) {
		    	var index = compareArray.findIndex(function(compareElem) {
		    		return elem[compareElement] == compareElem[compareElement];
		    	});

		    	return (index == -1);
		    });	
		}
	    
	});

	
</script>
@append