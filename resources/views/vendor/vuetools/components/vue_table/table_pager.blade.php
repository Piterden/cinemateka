<template id="vue-table-pager">
    <div class="btn-group">
        <button type="button"
            class="btn btn-default"
            @click="prevPage"
        >Prev</button>
        <button type="button"
            :class="{'btn': true, 'btn-default': (comCurrentPage != page), 'btn-primary': (comCurrentPage == page)}"
            @click="setPage(page)"
            v-for="page in pages"
            track-by="$index"
        >
            @{{ (page) }}
        </button>
        <button type="button"
            class="btn btn-default"
            @click="nextPage"
        >Next</button>
    </div>
</template>

@section('vue_components')
<script>
    vueComponents.tablePager = Vue.extend({
        template: '#vue-table-pager',
        computed: {
            numPages: function() {
                return Math.ceil(this.comLength / this.comPageSize);
            },
            pages: function() {
                var max = 5;
                var pages = [];

                if(this.numPages < 5) {
                    max = this.numPages;
                }

                var i = -2;
                if(this.numPages > 5 
                    && (this.comCurrentPage + 2) >= this.numPages) {
                    i = -4 + (this.numPages - this.comCurrentPage);
                }
                

                for(var cnt = max; cnt > 0; i++){
                    if(this.comCurrentPage + i >= 1) {
                        if((this.comCurrentPage + i) <= this.numPages) {
                            pages.push(this.comCurrentPage + i);    
                        }
                        cnt--;
                    }
                }

                if ((pages[max - 1]) < (this.numPages)) {
                    if(this.comCurrentPage != (this.numPages - 3) && this.comCurrentPage != (this.numPages - 4)) {
                        pages.push('..');    
                    }
                    if(this.comCurrentPage == (this.numPages - 4)) {
                        pages.push(this.numPages - 1);    
                    }
                    pages.push(this.numPages);
                } 
                if (pages[0] > 1) {
                    if(this.comCurrentPage != 4 && this.comCurrentPage != 5) {
                        pages.unshift('..');
                    }
                    if(this.comCurrentPage == 5) {
                        pages.unshift(2);
                    }
                    pages.unshift(1);
                }
                
                return pages;
            },
            comCurrentPage: {
                get: function() {
                    return this.$parent.filterArgs.limitBy.page + 1;
                },
                set: function(val) {
                    this.$parent.filterArgs.limitBy.page = val - 1;
                }
            },
            comLength: function() {
                return this.$parent.tableLength;
            },
            comPageSize: function() {
                return this.$parent.filterArgs.limitBy.pageSize;
            },
        },
        methods: {
            nextPage: function() {
                if((this.numPages) != this.comCurrentPage) {
                    this.comCurrentPage += 1;
                }
            },
            prevPage: function() {
                if(this.comCurrentPage != 0) {
                    this.comCurrentPage -= 1;   
                }
            },
            setPage: function(pageNum) {
                if(pageNum == '..') {
                    return;
                }
                this.comCurrentPage = pageNum;
            },    
        },
        watch: {
            pages: function(val, oldVal) {
                if((this.numPages) < this.comCurrentPage) {
                    if(this.pages.length > 0) {
                        this.comCurrentPage = this.numPages;    
                    } else {
                        this.comCurrentPage = 0;
                    }
                }

                if(this.comCurrentPage == 0 && this.numPages > 0) {
                    this.comCurrentPage = 1;
                }
            }
        }
    });

    Vue.component('table-pager', vueComponents.tablePager);
</script>
@append