@section('vue_components')
<script>
vueComponents.newRow = Vue.component('new-row', vueComponents.editRow.extend({
        name: 'newRow'
    
}));
</script>
@append