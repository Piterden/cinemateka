@section('vue_components')
<script>
vueComponents.showRow = Vue.component('show-row', {
    props: {
        row: Object,
        key: null
    },
    methods: {
        cycleRow: function() {
            this.$parent.cycleRow(this.key);
        },
        setRow: function(mode) {
            this.$parent.setRow(this.key, mode);
        },
        newRow: function(row, mode) {
            if(typeof(mode) == 'undefined') {
                mode = 'edit';
            }

            this.$parent.newRow(row, this.key, mode);
        },
        hideRow: function() {
            this.$parent.hideRow(this.key);
        },
        deleteRow: function() {
            this.$parent.deleteRow(this.key);
        }
    }
});
</script>
@append