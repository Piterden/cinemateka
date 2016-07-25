@section('vue_components')
<script>
Vue.component('single-tag', vueComponents.select2.extend({
        props: {
            options: {
                type: Object,
                default: function() {
                    return {
                        width: '100%',
                        maximumSelectionLength: 2
                    };
                }
            }
        },
        ready: function() {
            var vm = this;

            setTimeout(function() {
                vm.$select.off('select2:select');

                vm.$select.next().on('keyup', '.select2-search__field', vm.tabAutoOpen);

                vm.$select.on('select2:closing', function() {
                    vm.$select.next().off('keyup', '.select2-search__field', vm.tabAutoOpen);
                });

                vm.$select.on('select2:close', function() {
                    setTimeout(function() {
                        vm.$select.next().on('keyup', '.select2-search__field', vm.tabAutoOpen);
                    }, 1000);
                });

                vm.$select.on('select2:select', function(a, b, c) {
                    var value = vm.$select.val();
                    if(Array.isArray(value)) {
                        if(value.length == 2) {
                            if(vm.value == value[0]) {
                                vm.value = value[1];
                                vm.$select.val(value.shift(1));
                            }
                            if(vm.value == value[1]) {
                                vm.value = value[0];
                                vm.$select.val(value.pop());
                            }
                            vm.$select.trigger('change');

                        } else {
                            vm.value = value[0];
                        }
                    } else {
                        vm.value = '';
                    }
                });

            }, 1);
        },
        methods: {
            tabAutoOpen: function(event) {
                var vm = this;

                var tabKey = 9;
                if(event.which === tabKey || event.keyCode === tabKey) {
                    vm.$select.select2('open');
                }
            }
        }
    }));
</script>
@append