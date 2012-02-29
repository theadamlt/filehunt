$(document).ready(function(){

	$('.autosuggest').keyup(function(){
		
		var search_term = $(this).attr('value');
		$.post('../search_term.php', {search_term:search_term}, function(data) {
			$('.result').html(data);

			$('.result li').click(function(){
				var result_value = $(this).text();
				$('.autosuggest').attr('value', result_value);
				$('.result').html('');
			});
		});

	});

});