@section('vue_scripts')
<script>
Vue.directive('slot', {
    bind: function () {
        var vm = this.vm;

        var raw;
        
        if(this.expression == '') {
            raw = vm._slotContents.default;
        } else {
            raw = vm._slotContents.default.children[this.expression];
        }
        if(typeof(raw) != 'undefined') {
            for (var i = 0; i < raw.children.length; i++) {
                var node = raw.children[i].cloneNode(true);
                this.el.appendChild(node);
                vm.$root.$compile(node, vm, this._scope);
            }
        }
    }
});

Vue.directive('go', {
    bind: function () {
        var directive = this;
        var vm = this.vm;
        var router = vm.$route.router;
        this.val = {};
        var addGoEvent = function() {
            var json = directive.val;
            routerObjects[json.name] = json.objects;
            router.go({name: json.name, params: json.params, query: json.query});
        };

        this.el.addEventListener('click', addGoEvent);
    },
    update: function(value) {
        this.val = value;
    },
    unbind: function() {
        var directive = this;
        var vm = this.vm;
        var router = vm.$route.router;
        var addGoEvent = function() {
            var json = directive.val;
            routerObjects[json.name] = json.objects;
            router.go({name: json.name, params: json.params, query: json.query});
        };
        this.val = {};
        this.el.removeEventListener('click', addGoEvent);
    }
});

Vue.directive('validate', {
    bind: function() {
        $(this.el).addClass('validate')
            .css('width', '0px')
            .css('height', '0px')
            .css('display', 'block')
            .css('border', 'none')
            .prop('tabindex', -1);
    },
    update: function(newValue, oldValue) {
        if(typeof(newValue) == 'undefined' || newValue == null) {
            newValue = '';
        }
        if(typeof(oldValue) == 'undefined' || oldValue == null) {
            oldValue = '';
        }
        
        $(this.el).val(newValue);
        if(this.vm.form != null) {
            this.vm.form.fv.validateField($(this.el));
            this.vm.form.fv.revalidateField($(this.el));    
        }
    }
});
</script>
@append