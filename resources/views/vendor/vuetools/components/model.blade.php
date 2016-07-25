<script>
	vueForms.newModel = function(data, type, model, blank, url) {
		return new vueForms.model({
			data: function() {
				var rtn = {};
				rtn.data = data;
				rtn.type = type;
				rtn.model = model;
				rtn.blank = blank;
				rtn.url = url;
				rtn.storedData = this._cloneRecords(rtn.data);

				return rtn;
			}
		});
	}	

	vueForms.model = Vue.extend({
		methods: {
			_cloneRecords: function(records) {
				var recordKeys = Object.keys(records);
				var rtn = new Object;

				for (var i = 0; i < recordKeys.length; i++) {
					rtn[recordKeys[i]] = new Object;
					rtn[recordKeys[i]].model = records[recordKeys[i]].model;
					rtn[recordKeys[i]].type = records[recordKeys[i]].type;
					if(records[recordKeys[i]].type == 'object') {
						rtn[recordKeys[i]].data = clone(records[recordKeys[i]].data)
					} else if(records[recordKeys[i]].type == 'array') {
						rtn[recordKeys[i]].data = new Array;
						for(var k = 0; k < records[recordKeys[i]].data.length; k++) {
							rtn[recordKeys[i]].data[k] = clone(records[recordKeys[i]].data[k]);
						}
					}
				}
				return rtn;
			},
			resetModel: function () {
				this.data = this._cloneRecords(this.storedData);
			},
			save: function(itemsToSync) {
				var recordsToUpdate = null;
				if(this.type == "array") {
					if(typeof(itemsToSync) == 'Array') {
						recordsToUpdate = Object.filter(this.data, function(elem, key) {
							return (itemsToSync.includes(key) && elem.vue_updated == true);
						});
					} else if(typeof(itemsToSync) != 'undefined') {
						recordsToUpdate = Object.filter(this.data, function(elem, key) {
							return (itemsToSync == key && elem.vue_updated == true);
						});
					} else {
						recordsToUpdate = Object.filter(this.data, function(elem) {
							return (elem.vue_updated == true);
						});
					}

					if(recordsToUpdate != null) {
						this.saveArray(recordsToUpdate);
					}

				} else {
					if(this.data.vue_updated == true) {
						recordsToUpdate = this.data;	
					}

					if(recordsToUpdate != null) {
						this.saveObject(recordsToUpdate);
					}
				}
			},
			saveObject: function(recordsToUpdate) {
				var vm = this;
				$.ajax({
					dataType: "JSON",
					method: "POST",
					url: this.url,
					data: {records: JSON.stringify(recordsToUpdate)},
				}).done(function(data) {
					vm.storedData = data;
					if(data.vue_created == true) {
						vm.data.id = data.id;
		 			}
					vm.storedData.vue_created = false;
					vm.storedData.vue_updated = false;
					vm.storedData.vue_deleted = false;
					vm.data.vue_created = false;
					vm.data.vue_updated = false;
					vm.data.vue_deleted = false;

				}).fail(function() {
					alert('There was an error when trying to reach the server');
					model.resetForm();
				});
			},
			saveArray: function(recordsToUpdate) {
				var vm = this;
				$.ajax({
					dataType: "JSON",
					method: "POST",
					url: this.url,
					data: {records: JSON.stringify(recordsToUpdate)},
				}).done(function(data) {
				 	var dataKeys = Object.keys(data);
				 	for(key in dataKeys) {
				 		vm.storedData[key] = data[key];
				 		if(vm.data[key].vue_created == true) {
			 				vm.data[key].id = data[key].id;
			 			}

				 		vm.storedData[key].vue_created = false;
						vm.storedData[key].vue_updated = false;
						vm.storedData[key].vue_deleted = false;
						vm.data[key].vue_created = false;
						vm.data[key].vue_updated = false;
						vm.data[key].vue_deleted = false;
				 	}
				}).fail(function() {
					alert('There was an error when trying to reach the server');
					model.resetForm();
				});
			}		
		}
	});

	Vue.component('standard-form', vueForms.standardForm);
</script>
@append