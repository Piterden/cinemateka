<template id="vue-table-searcher">
    <input type="text" 
        v-model="comSearchText" 
        placeholder="Search"
        class="form-control"
    />
</template>

@section('vue_components')
<script>
	vueComponents.tableSearcher = Vue.extend({
		template: '#vue-table-searcher',
		computed: {
			comSearchText: {
				get: function() {
					return this.$parent.filterArgs.search;
				},
				set: function(val) {
					this.$parent.filterArgs.search = val;
				}
			}
		}
	});

	Vue.component('table-searcher', vueComponents.tableSearcher);
</script>
@append