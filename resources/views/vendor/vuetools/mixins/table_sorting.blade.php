@section('vue_mixins')
<script>
    vueMixins.tableSorting = {
        data: function() {
            return {
                tableFilters: {
                    orderMulti: function(keys, rows, args) {
                        var tmpArray = keys.filter(function() {
                            return true;
                        });

                        var sortColumns = args.orderMulti;
                        var sortPriority = args.orderMultiPriority.filter(function(elem) {
                            return (elem != '');
                        });
                        tmpArray.sort(function(a, b) {
                            for(var index in sortPriority) {
                                var sortField = sortColumns[sortPriority[index]]['field'];
                                var sortDir = sortColumns[sortPriority[index]]['dir'];
                                var sortFunction = vueSorts[sortColumns[sortPriority[index]]['type']];

                                var aField = getObjectField(sortField, rows[a]);
                                var bField = getObjectField(sortField, rows[b]);

                                if((typeof(aField) == 'undefined' || aField == null)
                                    && (typeof(bField) == 'undefined' || bField == null)) {
                                    return 0;
                                } else if((typeof(aField) != 'undefined' && aField != null)
                                    && (typeof(bField) == 'undefined' || bField == null)) {
                                    return 1 * sortDir;
                                } else if((typeof(aField) == 'undefined' || aField == null)
                                    && (typeof(bField) != 'undefined' && bField != null)) {
                                    return -1 * sortDir;
                                }

                                var result = sortFunction(aField, bField) * sortDir;
                                if((result) != 0) {
                                    return result;
                                }
                            }

                            return 0;
                        });
                        return tmpArray;
                    }
                },
                filterArgs: {
                    orderMulti: {},
                    orderMultiPriority: [],
                }
            }
        },
        methods: {
            sort: function(field, icon, add, priority) {
                field = field.replace(/\./g, '');

                var sortDir = this.filterArgs.orderMulti[field]['dir'];
                var orderMulti = clone(this.filterArgs.orderMulti);
                var orderMultiPriority = this.filterArgs.orderMultiPriority.filter(function() {return true;});
                if(typeof(priority) != 'undefined') {
                    while(priority > orderMultiPriority.length) {
                        orderMultiPriority.push('');
                    }
                    orderMultiPriority[priority] = field;
                } else if(!add) {
                    for(var key in this.filterArgs.orderMulti) {
                        if(key != field) {
                            orderMulti[key].dir = 0;
                        }
                    }
                    orderMultiPriority = [field];

                    $(this.$el).find('th i')
                        .removeClass('fa-sort-amount-asc')
                        .removeClass('fa-sort-amount-desc')
                        .addClass('fa-sort');
                } else {
                    var index = orderMultiPriority.findIndex(function(elem) {
                        return (field == elem);
                    });
                    if(index == -1) {
                        index = orderMultiPriority.length;
                        orderMultiPriority[index] = field;
                    } else {

                    }
                }
                
                if(sortDir == 0) {
                    sortDir = 1;
                    icon
                        .removeClass('fa-sort-amount-asc')
                        .removeClass('fa-sort-amount-desc')
                        .removeClass('fa-sort')
                        .addClass('fa-sort-amount-asc');
                    orderMulti[field].dir = sortDir;
                } else if(sortDir == 1) {
                    sortDir = -1;
                    icon
                        .removeClass('fa-sort-amount-asc')
                        .removeClass('fa-sort-amount-desc')
                        .removeClass('fa-sort')
                        .addClass('fa-sort-amount-desc');
                    orderMulti[field].dir = sortDir;
                } else if(sortDir == -1) {
                    sortDir = 0;
                    icon
                        .removeClass('fa-sort-amount-asc')
                        .removeClass('fa-sort-amount-desc')
                        .removeClass('fa-sort')
                        .addClass('fa-sort');
                    orderMulti[field].dir = sortDir;
                }

                this.$set('filterArgs.orderMultiPriority', orderMultiPriority);
                this.$set('filterArgs.orderMulti', orderMulti);
                
                this.$emit('sorted', field, sortDir, icon);
            }
        },
        directives: {
            sort: {
                params: ['sortPriority'],
                bind: function () {
                    var field = this.expression;
                    var fieldStripped = field.replace(/\./g, '');
                    $(this.el).append('<i class="pull-right fa fa-sort"></i>');
                    $(this.el).css('cursor', 'pointer');
                    $(this.el).addClass(fieldStripped);
                    var directive = this;
                    var dir = 0;
                    var callSort = false;
                    
                    var icon = $(directive.el).find('i');

                    var priority = 0;

                    if(typeof(this.params.sortPriority) != 'undefined') {
                        priority = this.params.sortPriority;
                    }

                    if(this.modifiers.asc) {
                        //dir of 0 will turn into 1 when sort is called
                        dir = 0;
                        callSort = true;
                    } else if(this.modifiers.desc) {
                        //dir of 1 will turn into -1 when sort is called
                        dir = 1;
                        callSort = true;
                    }

                    directive.vm.filterArgs.orderMulti[fieldStripped] = {
                        field: directive.expression,
                        dir: dir,
                        type: directive.arg,
                        class: fieldStripped
                    };
                    
                    this.el.addEventListener("click", function(event) {
                        directive.vm.sort(fieldStripped, icon, event.shiftKey);
                    });

                    if(callSort) {
                        directive.vm.sort(fieldStripped, icon, true, priority);
                    }
                },
                unbind: function () {
                    this.el.removeEventListener("click");
                }
            }
        }
    };
</script>
@append