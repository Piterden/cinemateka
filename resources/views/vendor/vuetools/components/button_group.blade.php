<template id="vue-button-group">
	<div class="btn-group vue-button-group">
	    <button v-for='button in buttons' 
	    	type="button" 
	    	:class="{
	    		'btn': true, 
	    		'btn-xs': (size == 'small'), 
	    		'btn-lg': (size == 'large'), 
	    		'btn-default': (value != button.value), 
	    		'btn-primary': (value == button.value)
    		}"
	    	@click="updateValue(button.value)"
    	>
    		@{{ button.text }}
    	</button>
	</div>
</template>

@section('vue_components')
<script>
	vueComponents.buttonGroup = Vue.extend({
		template: '#vue-button-group',
		props: {
			buttons: Array,
			value: String,
			size: {
				type: String,
				default: 'small'
			}
		},
		methods: {
			updateValue: function(val) {
				this.value = val;
			}
		}
	});

	Vue.component('button-group', vueComponents.buttonGroup);

</script>
@append