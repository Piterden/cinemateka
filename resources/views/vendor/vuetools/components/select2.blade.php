<template id="vue-select2">
	<select v-slot style="display: none;">
		
	</select>
</template>

@section('vue_components')
<script>
	vueComponents.select2 = Vue.extend({
		template: '#vue-select2',
		props: {
			value: null,
			disabled: String,
			options: {
				type: Object,
				default: function() {
		            return {
		            	width: '100%',
		            	minimumResultsForSearch: 6
		            };
		        }
			},
			list: {
				type: [Object, Array],
				default: function() {
					return new Array();
				}
			},
			valueField: {
				type: String
			},
			textField: {
				type: String
			}
		},
		computed: {
			selectData: function() {
				var vm = this;
				var list = vm.list;
				var valueField = vm.valueField;
				var textField = vm.textField;


				var rtn = $.map(list, function (obj) {
				  	obj.id = obj[valueField];
				  	obj.text = obj[textField];

				  	return obj;
				});

				return rtn;
			}
		},
        data: function() {
        	return {
	            '$select': {},
	            'select2': {},
	            'firstCompute': true
	        }
        },
        methods: {
        	initSelect2: function() {
        		var vm = this;
        		

				vm.$select = $(vm.$el);

				vm.$nextTick(function() {
					var options = vm.options;
					if(!(Array.isArray(vm.list) && vm.list.length == 0)) {
						options.data = vm.selectData;
					} else {
						options.data = [];
					}
					
					vm.select2 = vm.$select.select2(options);
					vm.$select.val(vm.value);
					vm.$select.trigger('change');
					
					vm.$select.on('select2:select', function() {
						vm.value = vm.$select.val();
					});

					vm.$select.on('select2:unselect', function() {
						vm.value = vm.$select.val();
					});

					vm.$select.show();
					vm.$set('firstCompute', false);
				});
        	}
        },
		ready: function() {
			this.initSelect2();
		},
		watch: {
	    	value: function (val, oldVal) {
	    		var vm = this;

	    		vm.$select.val(this.value);
	    		vm.$select.trigger('change');
	      	},
	      	list: function() {
	      		if(!this.firstCompute) {
					this.$select.select2('data', null);
					this.$select.select2('destroy');
					this.$select.html('');
					this.$nextTick(function() {
						this.initSelect2();
					});
					
				}
	      	}
	    }
	});

	Vue.component('select2', vueComponents.select2);

</script>
@append