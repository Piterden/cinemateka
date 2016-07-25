@section('vue_components')
<script>
    vueComponents.vueTableInline = vueComponents.vueTable.extend({
    	'mixins': [vueMixins.tableInline]
    });
    Vue.component('vue-table-inline', vueComponents.vueTableInline);
</script>
@append