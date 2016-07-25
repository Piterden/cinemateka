<template id="vue-table">
    <div class="row">
        <div class="col-md-2">
            <table-page-sizer></table-page-sizer>
        </div>
        <div class="col-md-2">
            <table-searcher></table-searcher>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered">
                <thead class="no-border">
                </thead>
                <tbody class="no-border">
                    <tr :is="'show-' + rowModes[$key]"
                        :row.sync="row"
                        v-for="row in tableRows"                                
                    ></tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table-pager class="pull-right"></table-pager>
        </div>
    </div>
</template>

@section('vue_components')
<script>
    vueComponents.vueTable = Vue.extend({
        template: '#vue-table',
        mixins: [
            vueMixins.tablePaging(),
            vueMixins.tableSorting,
            vueMixins.tableSearching()
        ],
        props: {
            source: null,
            rowType: {
                type: String,
                default: ''
            },
            modes: {
                type: Array,
                default: function() {
                    return [
                        'show',
                        'edit'
                    ];
                }
            },
            form: {
                type: Object,
                default: function() {
                    if(this.$parent.$options.name == 'vue-form') {
                        return this.$parent;
                    } else {
                        return null;
                    }
                }
            },
            customFilters: {
                type: Object,
                coerce: function(filters) {
                    if(!Vue.util.isPlainObject(filters)) {
                        return null;
                    }
                    for(var key in filters) {
                        if(typeof(filters[key].filter) !== 'function') {
                            console.warn('vueTable.props.customFilters: Malformed filters property');
                            return null;
                        }
                        if(!Vue.util.isPlainObject(filters[key].args)) {
                            console.warn('vueTable.props.customFilters: Malformed filters property');
                            return null;
                        }
                    }
                    
                    return filters;
                }
            }
        },
        watch: {
            source: {
                deep: true,
                handler: function() {
                    if(Array.isArray(this.source)) {
                        this.source = {};
                    }
                    this.tableDataUpdated();
                }
            },
            tableFilters: {
                deep: true,
                handler: function() {
                    this.tableDataUpdated();
                }
            },
            filterArgs: {
                deep: true,
                handler: function() {
                    this.tableDataUpdated();
                }
            },
            customFilters: {
                deep: true,
                handler: function() {
                    if(this.customFilters == null) {
                        this.$set('customFiltersKeys', {});
                        this.$set('customFiltersLengths', {});
                    }

                    this.tableDataUpdated();
                }
            },
        },
        data: function() {
            var data = {};
            data.tableFilters = {};
            data.tableFilters.removeDeleted = function(keys, rows, args) {
                return keys.filter(function(key) {
                    return (rows[key].vue_deleted == false);
                });
            };
            data.filterArgs = {};
            data.filterArgs.removeDeleted = {};

            data.customFiltersKeys = {};
            data.customFiltersLengths = {};

            var keys = Object.keys(this.source);
            var rowModes = {};
            for(var i = 0; i < keys.length; i++) {
                rowModes[keys[i]] = this.rowType + '-' + this.modes[0] + '-row';
            }
            data.rowModes = rowModes;

            data.tableLength = 0;
            data.tableKeys = [];

            return data;
        },
        ready: function() {
            this.tableDataUpdated();
        },
        methods: {
            updateTableKeys: function(source, tableFilters, filterArgs, customFilters) {
                if(Array.isArray(source)) {
                    source = {};
                }

                var sourceKeys = Object.keys(source);
                if(sourceKeys.length == 0) {
                    return {tableKeys: [], tableLength: 0};
                }

                var rtn = {};

                var filteredKeys = sourceKeys;
                var customFiltersKeys = {};
                var customFiltersLengths = {};

                filteredKeys = tableFilters.removeDeleted(filteredKeys, source, filterArgs);
                filteredKeys = tableFilters.search(filteredKeys, source, filterArgs);
                filteredKeys = tableFilters.orderMulti(filteredKeys, source, filterArgs);
 
                for(var key in customFilters) {
                    var currentFilter = customFilters[key].filter;
                    var currentArgs = customFilters[key].args;
                    customFiltersKeys[key] = currentFilter(filteredKeys, source, currentArgs);
                }

                if(_.size(customFiltersKeys) > 0) {
                    filteredKeys = _.union(_.flatten(customFiltersKeys));
                }
                
                //Get length of table before paging
                rtn.tableLength = filteredKeys.length;
                filteredKeys = tableFilters.limitBy(filteredKeys, source, filterArgs);

                for(var key in customFilters) {
                    customFiltersLengths[key] = customFiltersKeys[key].length;
                    customFiltersKeys[key] = tableFilters.limitBy(customFiltersKeys[key], source, filterArgs);
                }

                rtn.tableKeys = filteredKeys;
                rtn.customFiltersKeys = customFiltersKeys;
                rtn.customFiltersLengths = customFiltersLengths;

                return rtn;
            },
            tableDataUpdated: function() {
                var tableData = this.updateTableKeys(this.source, this.tableFilters, this.filterArgs, this.customFilters);
                this.$set('tableKeys', tableData.tableKeys);
                this.$set('tableLength', tableData.tableLength);
                if(this.customFilters != null) {
                    for(var key in tableData.customFiltersKeys) {
                        this.$set('customFiltersKeys.' + key, tableData.customFiltersKeys[key]);
                        this.$set('customFiltersLengths.' + key, tableData.customFiltersLengths[key]);
                    }
                }
            },
            cycleRow: function(key) {
                var currentMode = this.rowModes[key];
                var vm = this;
                var index = this.modes.findIndex(function(elem) {
                    return (vm.rowType + '-' + elem + '-row') == currentMode;
                });
                index += 1;
                if(index >= this.modes.length) {
                    index = 0;
                }
                this.$set('rowModes.' + key, this.rowType + '-' + this.modes[index] + '-row');
            },
            setRow: function(key, mode) {
                this.$set('rowModes.' + key, this.rowType + '-' + mode + '-row');
            },
            newRow: function(row, key, mode) {
                if(typeof(mode) == 'undefined') {
                    mode = 'edit';
                }
                this.$set('rowModes.' + key, this.rowType + '-' + mode + '-row');
                this.$set('source.' + key, row);
            },
            deleteRow: function(key) {
                delete this.rowModes[key];
                delete this.source[key];
            },
            hideRow: function(key) {
                this.$set('source.' + key + '.vue_deleted', true);
            },
            deleteHiddenRows: function() {
                var hiddenRows = Object.filter(this.source, function(elem) {
                    return elem.vue_deleted;
                });

                for(var key in hiddenRows) {
                    this.deleteRow(key);
                }
            },
            getUpdatedRows: function() {
                return Object.filter(this.source, function(elem, key, object) {
                    return elem.vue_updated;
                });
            }
        }
    });

    Vue.component('vue-table', vueComponents.vueTable);
</script>
@append