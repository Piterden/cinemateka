<template id="vue-icheck">
	<input type='checkbox'
		v-model="value"
		:true-value="1"
		:false-value="0"
	/>
</template>

@section('vue_components')
<script>
	vueComponents.icheck = Vue.extend({
		template: '#vue-icheck',
		props: {
			value: {
				coerce: function (val) {
			        return true && val;
		      	}
			},
			disabled: String
		},
		ready: function() {
			var $checkbox = $(this.$el);
			var vm = this;
			if(typeof(this.disabled) != "undefined") {
				$checkbox.prop('disabled', true);
			}

			$checkbox.iCheck({
			 	checkboxClass: 'icheckbox_square-blue'
			});
			
			$checkbox.on('ifToggled', function() {
				if($checkbox.prop('checked')) {
					vm.value = true;
					vm.$emit('checked');
					vm.$emit('toggled', true);
				} else {
					vm.value = false;
					vm.$emit('unchecked');
					vm.$emit('toggled', false);
				}
			});
		},
		watch: {
	    	'value': function (val, oldVal) {
	    		var $checkbox = $(this.$el);
	    		$checkbox.iCheck('update');
	      	}
	    },
		methods: {
			disable: function() {
				var $checkbox = $(this.$el);
				$checkbox.iCheck('disable');
			},
			enable: function() {
				var $checkbox = $(this.$el);
				$checkbox.iCheck('enable');
			}
		}
	});

	Vue.component('icheck', vueComponents.icheck);

</script>
@append