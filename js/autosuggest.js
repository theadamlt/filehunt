document.getElementById('select').value;

$(document).ready(function() {

	$('.autosuggest').keyup(function() {

		var search_term = $(this).attr('value');
		var select_val = document.getElementById('select').value;
		$.post('./search_term.php', {
			search_term: search_term,
			select_val: select_val
		}, function(data) {
			$('.result').html(data);

			$('.result li').click(function() {
				var result_value = $(this).text();
				$('.autosuggest').attr('value', result_value);
				$('.result').html('');
				document.myForm.submit();
			});
		});

	});

});
