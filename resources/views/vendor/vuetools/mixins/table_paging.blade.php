@section('vue_mixins')
<script>
    vueMixins.tablePaging = function(pageSize, page) {
        if(typeof(pageSize) == 'undefined') {
            pageSize = 10;
        }
        if(typeof(page) == 'undefined') {
            page = 0;
        }
        return {
            data: function() {
                var vm = this;
                return {
                    tableFilters: {
                        limitBy: function(keys, rows, args) {
                            var offset = args.limitBy.pageSize * args.limitBy.page;
                            return vm
                                .$options
                                .filters
                                .limitBy(keys, args.limitBy.pageSize, offset);
                        }
                    },
                    filterArgs: {
                        limitBy: {
                            pageSize: pageSize,
                            page: page
                        }  
                    }
                }
            }
        };
    };
</script>
@append