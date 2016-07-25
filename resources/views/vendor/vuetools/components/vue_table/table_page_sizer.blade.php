<template id="vue-table-page-sizer">
    <div class="form-horizontal">
    	<div class="form-group">
    		<label class="control-label col-md-5" style="padding-right: 0;">
				Page Size:
			</label>
			<div class="col-md-7">
			    <select v-model="comPageSize"
			    	class="form-control"
				>
			    	<option v-for="size in sizes" :value="size">
			            @{{ size }}
			        </option>
			    </select>
	    	</div>
    </div>
</template>

@section('vue_components')
<script>
	vueComponents.tablePageSizer = Vue.extend({
		template: '#vue-table-page-sizer',
		props: {
			sizes: {
				type: Array,
	      		default: function () {
	        		return [10, 25, 50, 100];
	      		}
			}
		},
		computed: {
			comPageSize: {
				get: function() {
					return this.$parent.filterArgs.limitBy.pageSize;
				},
				set: function(val) {
					this.$parent.filterArgs.limitBy.pageSize = val;
				}
			}
		}
	});

	Vue.component('table-page-sizer', vueComponents.tablePageSizer);

</script>
@append