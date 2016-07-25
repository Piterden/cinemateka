@section('vue_mixins')
<script>
vueMixins.tableInline = {
		props: {
			blank: {
				type: Object
			}
		},
		data: function() {
			return {
				newRowsData: [],
				showNewRows: false,
				validating: false
			}
		},
		computed: {
			newRows: function() {
				var newRows = this.newRowsData;
				var show = this.showNewRows;

				if(newRows.length == 0) {
					show = false;
					this.$set('showNewRows', show);
				}

				if(show) {
					return newRows
				} else {
					return [];
				}
			}
		},
		ready: function() {
			var vm = this;
			vm.$on('validatedNewRows', function() {
                vm.saveNewRows();
            });
            vm.$on('newRowsValidationFailed', function() {
                vm.addNewRow();
            });
		},
		methods: {
			_cloneObject: function(records) {
				var recordKeys = Object.keys(records);
				var rtn = new Object;
				for (var i = 0; i < recordKeys.length; i++) {
					rtn[recordKeys[i]] = new Object;
					rtn[recordKeys[i]] = clone(records[recordKeys[i]]);
				}
				return rtn;
			},
			saveNewRows: function() {
				this.$set('showNewRows', false);
				this.$nextTick(function(){
					this.$emit('save', clone(this.newRowsData), this);
					this.clearNewRows();	
				});
			},
			clearNewRows: function() {
				this.$set('newRowsData', []);
			},
			addNewRow: function() {
				var index = this.newRowsData.length;

				this.newRowsData.$set(index, clone(this.blank));
				this.$set('showNewRows', true);
			},
			deleteNewRow: function(index) {
				var vm = this;
				if(typeof(index) != 'undefined') {
					vm.newRowsData.$remove(vm.newRowsData[index]);
				} else {
					vm.newRowsData.$remove(vm.newRowsData[(vm.newRowsData.length - 1)]);
				}
			},
			validateNewRows: function() {
	            var vm = this;

	            if(vm.form == null || vm.form.fv == null) {
	                return true;
	            }

	            if(vm.validating == false) {
	            	this.newRowsData.$remove(this.newRowsData[this.newRowsData.length - 1]);
	            }

	            vm.$nextTick(function() {
	            	var $trs = $(vm.$el).find('.new-row');

		            if(vm.validating == false) {		            	
		            	$trs.find('[name]').each(function(index, elem) {
		            		
		                    //vm.form.fv.resetField($(elem));
		                    vm.form.fv.validateField($(elem));
		                });
		            }
		            var isValid = true

		            $trs.find('[name]').each(function(index, elem) {

		                var status = vm.form.fv.isValidField($(elem));
		                if(isValid == true && status == null) {
		                    isValid = null;
		                } else if((isValid == true || isValid == null)  && status == false) {
		                    isValid = false;   
		                }
		            });

		            if(isValid == null) {
		                vm.validating = true;
		                setTimeout(function() {vm.validateNewRows()}, 150);
		                return null;
		            } else if(isValid == false) {
		                vm.validating = false;
		                vm.$emit('newRowsValidationFailed');
		                return false;
		            } else {
		                vm.validating = false;
		                vm.$emit('validatedNewRows');
		                return true
		            }   
	            });
		           
	        },
		},
	}
</script>
@append