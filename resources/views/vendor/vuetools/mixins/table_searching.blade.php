@section('vue_mixins')
<script>
    vueMixins.tableSearching = function(search) {
        if(typeof(search) == 'undefined') {
            search = '';
        }
        return {
            data: function() {
                var vm = this;
                var data = {
                    tableFilters: {
                        search: function(keys, rows, args) {
                            if(args.search == '') {
                                return keys;
                            }

                            return keys.filter(function(key) {
                                for(var field in args.orderMulti) {
                                    var cell = getObjectField(args.orderMulti[field].field, rows[key]);

                                    if(contains(cell, args.search.toLowerCase())) {
                                        return true;
                                    }
                                }
                                return false;
                            });
                        }
                    },
                    filterArgs: {
                        search: search
                    }
                };

                return data;
            }
        }
    };
</script>
@append