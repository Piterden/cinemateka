<template id="vue-datepicker">
	<div class="input-group" style="width: 100%">
		<slot>
		    <input type="text" 
		        class="form-control" 
		        readonly="readonly" 
		        data-date-format="mm/dd/yy"
		        @click="openDatepicker"
		        :value="inputDate"
		    />
	    </slot>
	    <div class="input-group-addon btn btn-primary" 
	    	v-show="showIcon"
	    	@click="openDatepicker"
    	>
	        <i class="fa fa-calendar"></i>
	    </div>
	    <div class="input-group-addon btn btn-danger"
	    	v-show="showDelete"
	    	@click="clearDate"
    	>
	        <i class="fa fa-trash"></i>
	    </div>
	</div>
</template>

@section('vue_components')
<script>
	vueComponents.datepicker = Vue.extend({
		template: '#vue-datepicker',
		props: {
			date: {
				default: '',
			},
			startDate: {
				coerce: function (val) {
		    		return val + ''
	      		}
	      	},
			endDate: {
				coerce: function (val) {
		    		return val + ''
	      		}
	      	},
	      	showIcon: {
				default: true,
				coerce: function (val) {
		    		return val && true;
	      		}
	      	},
	      	showDelete: {
				default: false,
				coerce: function (val) {
		    		return val && true;
	      		}
	      	},

		},
		computed: {
			inputDate: function() {
				return this.getDateString(this.date);
			}
		},
		watch: {
			startDate: function() {
				this.setStartDate();
			},
			endDate: function() {
				this.setEndDate();	
			}
		},
		ready: function() {
			var $datepicker = $(this.$el);
			var $input = $datepicker.find('input');
			var vm = this;
			var options = {
				format: 'mm/dd/yy',
	            minView: 2,
	            autoclose: true,
			};
			
			var date;
			if(typeof(this.date) == 'undefined'){
				date = moment('null');	
			} else {
				date = moment(vm.date);
			}

			if(date.isValid()) {
				options.date = date.format('MM/DD/YY');
			}

			$input.datetimepicker(options);

			this.setStartDate();
			this.setEndDate();
			
			var updateDate = function() {
				$input.off('changeDate', updateDate);
				vm.date = moment($input.val(), 'MM/DD/YY').format('MM/DD/YY');
				vm.$dispatch('updated', vm.date);
				$input.on('changeDate', updateDate);
			};

			$input.on('changeDate', updateDate);
		},
		methods: {
			getDateString: function (date, format) {
				if(typeof(format) == 'undefined') {
					format = 'MM/DD/YY';
				}

				if(typeof(date) == 'undefined' 
					|| date == null 
					|| date == '') {
					date = moment('null');
				} else {
					date = moment(date);
				}

				if(date.isValid()) {
					return date.format(format);
				} else {
					return '';
				}
			},
			setStartDate: function() {
				var $input = $(this.$el).find('input');
				var date = this.getDateString(this.startDate, 'YYYY-MM-DD');
				if(date != '') {
					$input.datetimepicker('setStartDate', date);	
				} else {
					$input.datetimepicker('setStartDate');
				}
			},
			setEndDate: function() {
				var $input = $(this.$el).find('input');
				var date = this.getDateString(this.endDate, 'YYYY-MM-DD');
				if(date != '') {
					$input.datetimepicker('setEndDate', date);	
				} else {
					$input.datetimepicker('setEndDate');
				}
			},
			openDatepicker: function() {
				var $datepicker = $(this.$el);
				var $input = $datepicker.find('input');
				$input.datetimepicker('show');
			},
			clearDate: function() {
				var $datepicker = $(this.$el);
				var $input = $datepicker.find('input');
				$input.val('');
				this.date = null;
				this.$dispatch('updated', this.date);
			},
		}
	});

	Vue.component('datepicker', vueComponents.datepicker);

</script>
@append