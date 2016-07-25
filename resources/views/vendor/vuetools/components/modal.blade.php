@section('vue_components')
<script>
	vueComponents.modal = Vue.extend({
	props: {
		sendData: {
			type: String,
			default: 'false'
		},
		recordSet: Object
	},
	data: function() {
		return {
			record: {},
			storedRecord: {},
			blank: false,
			url: '',
		}		
	},
	ready: function () {
		var vm = this;
		$(this.$el).on('show.bs.modal', function(event) {
			if(event.namespace == "bs.modal") {
				if(typeof(vm.$root.formValidation) != 'undefined') {
		            $(vm.$el).find('.validate').each(function (index, element) {
		                vm.$root.formValidation.addField($(element));
		            });
				}
			}

			setTimeout(function() {
				$(vm.$el).find('.focus').focus();
			}, 500);
		});

		$(this.$el).on('hide.bs.modal', function(event) {
			if(event.namespace == "bs.modal") {
				if(typeof(vm.$root.formValidation) != 'undefined') {
		            $(vm.$el).find('.validate').each(function (index, element) {
		                vm.$root.formValidation.resetField($(element));
		                vm.$root.formValidation.removeField($(element));
		            });
		        }
	        }
		});
	},
	methods: {
		resetRecord: function() {
			var keys = Object.keys(this.record);

			for(var i = 0; i < keys.length; i++) {
				this.record[keys[i]] = this.storedRecord[keys[i]];
			}
		},
		_mixAlterData: function(record, alterData) {
			if(typeof(alterData) != 'undefined') {
				var rtn = record;
				var keys = Object.keys(alterData);

				for(var i = 0; i < keys.length; i++) {
					rtn[keys[i]] = alterData[keys[i]];
				}
				return rtn;	
			} else {
				return record;	
			}
		},
		loadData: function(newRecord, url, alterData) {
			this.blank = false;
			this.storedRecord = clone(newRecord);
			this.record = this._mixAlterData(newRecord, alterData);
			this.url = url;
			$(this.$el).modal('show');
		},
		loadBlank: function(newRecord, url, alterData) {
			this.blank = true;
			this.record = clone(this._mixAlterData(newRecord, alterData));
			this.url = url;
			$(this.$el).modal('show');
		},
		saveData: function() {
			var vm = this;
			if(typeof(recursive) == "undefined") {
				recursive = false;
			}

			if (this.validationIsValid(recursive) == null) {
			    // Stop submission because of validation error.
			    setTimeout(function() {vm.saveData(recursive)}, 150);
			    return false;

			} else if (this.validationIsValid(recursive) == false) {
				return false;
				
			}
			var recordSetIndex = 0;
			if(this.blank) {
				recordSetIndex = this.recordSet.data.push(this.record);
			}

			if(this.sendData == "true") {
				var sendData = {
					model: this.recordSet.model,
					type: 'object',
					data: this.record
				};

				Ajax.saveSingle(sendData, this, this.url, recordSetIndex);
			}

			$(this.$el).modal('hide');

			vm.$dispatch('saved', vm.record);
		},
		deleteData: function () {
			this.record.vue_deleted = true;
			var currentId = this.record.id;
			var index = this.recordSet.data.findIndex(function (elem) {
				return (currentId == elem.id);
			});
			if(index >= 0) {
				this.recordSet.data.splice(index, 1);
			}
			this.saveData();
		},
		cancel: function() {
			this.resetRecord();
		},
		validationIsValid: function (recursive) {
			if(typeof(this.$root.formValidation) == 'undefined') {
				return true;
			}

			if(typeof(recursive) == "undefined") {
				recursive = false;
			}

			// Validate the container
			if(recursive === false) {
				this.$root.formValidation.resetForm();
				this.$root.formValidation.validateContainer($(this.$el));
			}
			var isValidContainer = this.$root.formValidation.isValidContainer($(this.$el));
			if (isValidContainer === false || isValidContainer === null) {
			    // if (isValidContainer === false)
			    // 	$.unblockUI();
			    
			    // Stop submission because of validation error.
			    return isValidContainer;

			} else {
				return true;
				
			}
		}
	}
});

Vue.component('modal', vueComponents.modal);

</script>
@append