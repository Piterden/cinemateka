@section('vue_components')
<script>
vueComponents.editRow = Vue.component('edit-row', {
    data: function() {
        var form = null;
        if(typeof(this.$parent.form) != 'undefined' && this.$parent.form != null) {
            form = this.$parent.form;
        }

        return {
            form: form,
            validating: false
        };
    },
    props: {
        row: Object,
        key: null
    },
    watch: {
        row: {
            handler: function(newVal, oldVal) {
                this.row.vue_updated = true;
            },
            deep: true,
        }
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
        deleteRow: function() {
            this.$parent.deleteRow(this.key);
        },
        hideRow: function() {
            this.$parent.hideRow(this.key);
        },
        validateRow: function($tr) {
            var vm = this;

            if(vm.form == null) {
                return true;
            }

            if(typeof($tr) == 'undefined') {
                $tr = $(vm.$el);
            }

            if(vm.validating == false) {
                $tr.find('[name]').each(function(index, elem) {
                    vm.form.fv.resetField($(elem));
                    vm.form.fv.validateField($(elem));
                });
            }

            var isValid = true

            $tr.find('[name]').each(function(index, elem) {
                var status = vm.form.fv.isValidField($(elem));
                if(isValid == true && status == null) {
                    isValid = null;
                } else if((isValid == true || isValid == null)  && status == false) {
                    isValid = false;   
                }
            });

            if(isValid == null) {
                vm.validating = true;
                setTimeout(function() {vm.validateRow()}, 150);
                return null;
            } else if(isValid == false) {
                vm.validating = false;
                return false;
            } else {
                vm.validating = false;
                vm.$emit('validatedRow');
                return true
            }   
        },

    }
});
</script>
@append