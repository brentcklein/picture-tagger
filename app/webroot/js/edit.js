// app/webroot/edit.js

function submitForm ($form){
	
	// console.log('Entered submitForm()');

	// $('.updateForm').submit(function (e) {
	// 	e.preventDefault();
	// 	e.stopPropagation();
	// 	console.log('Update form submitted');
	// 	console.log('Ajaaaaaax');
	// });

	$.ajax({
		type: "PUT",
		url: $form.attr('action'),
		data: $form.serialize(),
		dataType: 'json',
		success: function (response){
			console.log('Success!');
			// Do schmancy stuff to update display now that item has been marked as Not Universal
			// console.log(response);
			$('.' + response.id).each(function() {
				console.log($(this));
				$(this).text(response.object.Label.void);
			});
		},
		error: function (response){
			console.log('Failure. =/');
			// Maybe do schmancy CakePHP Flash stuff to tell the user nothing happened?
			console.log(response);
			var w = window.open();
			$(w.document.body).html(response.responseText);
		}
	});

	// console.log($(form).serialize());

	// form.submit();	
}

$(document).ready(function (){



	$('.voidCheckbox').change(function () {
		console.log('A voidCheckbox was changed!')
		var form = this.form;
		var $form = $(form);
		submitForm ($form);
		console.log('submitForm() called');
	});

	// $('#testButton').click(function () {
	// 	console.log('testButton clicked');

	// });

});