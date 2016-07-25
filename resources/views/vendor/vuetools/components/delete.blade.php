<template id="vue-delete">
    <button type="button" 
        :class='{
            "btn": true,
            "btn-danger": true,
            "vue-delete": true,
            "btn-xs": (size == "small"),
            "btn-lg": (size == "large")
        }'
        @click="tryDelete"
    >
        <span v-show="confirmed"><slot name="confirm-text">Confirm</slot></span>
        <slot>Remove</slot>
    </button>
</template>

@section('vue_components')
<script>
    vueComponents.delete = Vue.extend({
        template: '#vue-delete',
        props: {
            size: String
        },
        data: function () {
            return {
                confirmed: false    
            };
        },
        methods: {
            tryDelete: function() {
                var vm = this;
                if(vm.confirmed) {
                    vm.$emit('deleted');
                    vm.confirmed = false;
                } else {
                    setTimeout(function() {
                        vm.confirmed = false;
                    }, 3000);
                    vm.confirmed = true;
                }
            }
        }
    });

    Vue.component('delete', vueComponents.delete);

</script>
@append