{{-- this requires the bower package: jquery-timepicker-dt --}}
<template id="vue-timepicker">
	<div class="input-group">
		<input type="text" class="form-control" />
		<span class="input-group-btn">
			<button class="btn btn-default toggle-timepicker" type="button"><i class="fa fa-clock-o"></i></button>
		</span>
	</div>
</template>
​
@section('vue_components')
<script>
	vueComponents.timepicker = Vue.extend({
		template: '#vue-timepicker',
		props: {
			value: null,
			disabled: String
		},
		ready: function() {
			var $obj = $(this.$el).find('input');
			var vm = this;

			setTimeout(function() {
				$obj.val(vm.value);

				$obj.timepicker({ 'scrollDefault': 'now', 'showOn': null });

				$obj.next().click(function(e) {
					$obj.timepicker('show');
				});

				$obj.on('changeTime', function() {
					vm.value = $obj.val();
					console.log(vm.value);
					if(typeof(vm.$root.formValidation) != "undefined") {
						vm.$root.formValidation.revalidateField($obj);
					}
				});

				$obj.on('showTimepicker', function() {
					$('.ui-timepicker-wrapper').css('width', $obj.outerWidth());
				});

				$( window ).resize(function() {
					if ($obj.timepicker('isVisible')) {
						$('.ui-timepicker-wrapper').css('width', $obj.outerWidth());
					}
				});

			}, 1);

			$obj.keydown(function(e) {
				var time = $obj.timepicker('getTime');
				if (time === null || typeof time === 'undefined') {
					time = moment();
				}

	      		switch(e.which) {
			        case 37: // left
			        	$obj.timepicker('setTime', moment(time).subtract(1, 'minute').toDate());
			        break;
			        case 38: // up
			        	$obj.timepicker('setTime', moment(time).add(1, 'hour').toDate());
			        break;
			        case 39: // right
			        	$obj.timepicker('setTime', moment(time).add(1, 'minute').toDate());
			        break;
			        case 40: // down
			        	$obj.timepicker('setTime', moment(time).subtract(1, 'hour').toDate());
			        break;

			        default: return; // exit this handler for other keys
			    }
			    e.preventDefault(); // prevent the default action (scroll / move caret)
	      	});

		},
		watch: {
	    	value: function (val, oldVal) {
	    		var $obj = $(this.$el);
	    		$obj.val(this.value);
	    		$obj.trigger('change');
	      	}
	    }
	});

	Vue.component('timepicker', vueComponents.timepicker);

</script>
@append
