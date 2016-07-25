<template id="vue-select2" v-cloak>
	<select v-slot>
		
	</select>
</template>

@section('vue_components')
<script>
	vueComponents.select2 = Vue.extend({
		template: '#vue-select2',
		props: {
			value: null,
			disabled: String
		},
		ready: function() {
			var $select = $(this.$el);
			var vm = this;

			setTimeout(function() {
				$select.val(vm.value);

				$select.select2({
		            width: '100%',
		            minimumResultsForSearch: 6
		        })
				
				$select.on('select2:select', function() {
					vm.value = $select.val();
				});

				$select.on('select2:unselect', function() {
					vm.value = $select.val();
				});

			}, 1);
		},
		watch: {
	    	value: function (val, oldVal) {
	    		var $select = $(this.$el);
	    		$select.val(this.value);
	    		$select.trigger('change');
	      	}
	    }
	});

	Vue.component('select2', vueComponents.select2);

</script>
@append