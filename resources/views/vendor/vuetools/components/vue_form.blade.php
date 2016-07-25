@section('vue_components')
<script>
	vueComponents.vueForm = Vue.extend({
		template: "<form><slot></slot></form>",
		props: {
			leaveWarning: {
				type: String,
				default: 'It looks like you have been editing something. '
                        + 'If you leave before saving, your changes will be lost.'
			},
			disableWarning: {
				type: Boolean,
				default: false
			}
		},
		data: function() {
			var data = {};
			data.loaded = false;
			data.fv = null;
			data.validating = false;
			return data;
		},
		attached: function() {
			this.load();
	    },
	    detached: function() {
	    	this.unload();
	    },
		methods: {
			addBeforeUnload() {
				if(!this.disableWarning) {
					window.addEventListener("beforeunload", this.pageLeaveWarning);	
				}
				
			},
			removeBeforeUnload() {
				if(!this.disableWarning) {
					window.removeEventListener("beforeunload", this.pageLeaveWarning);	
				}
			},
			load: function() {
				$(this.$el).formValidation({
					framework: 'bootstrap'
				});
				this.fv = $(this.$el).data('formValidation');
				this.addBeforeUnload();
				
				if(this.fv != null) {
					var vm = this;
		        }
		        this.loaded = true;
		        this.validating = false;
		        var vm = this;
			},
			unload: function() {
				this.removeBeforeUnload();
				if(this.fv != null) {
					var vm = this;

		            this.fv.destroy();
		            this.fv = null;
		        }
		        this.loaded = false;
		        this.validating = false;
			},
			pageLeaveWarning: function (event) {
				if(this.loaded && !this.disableWarning) {
					var confirmationMessage = this.leaveWarning;

				    (event || window.event).returnValue = confirmationMessage; //Gecko + IE
				    return confirmationMessage; //Gecko + Webkit, Safari, Chrome etc.	
				}
			},
			validate: function() {
				if(this.fv == null) {
					return true;
				}

				if(this.validating == false) {
					this.fv.validate();
				}

				var isValid = this.fv.isValid();
				if(isValid == null) {
					this.validating = true;
					var vm = this;
					setTimeout(function() {vm.validate()}, 150);
				} else if(isValid == false) {
					this.validating = false;
					this.$emit('validation-failed');
					return false;
				} else {
					this.validating = false;
					this.$emit('validated');
					return true
				}				
			}
		}
	});

	Vue.component('vue-form', vueComponents.vueForm);
</script>
@append