<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="styling.css">

	<title>2023 Internships</title>
</head>
<body>
	<div class="container">
		<div class="row">
			<h1>2023 Internships</h1>
		</div>
	</div> 
	<div class="container">
		<div class="row">
		    <div class="buttonlink">
				<a class="page-link" href="search_form.php" role="button">Search for Internships</a>
			</div>
			<div class="buttonlink">
				<a class="page-link" href="add_internship.php" role="button">Add Internship</a>
			</div>
			<div class="buttonlink">
				<a class="page-link" href="delete_internship.php" role="button">Remove Internship</a>
			</div>
			<div class="buttonlink">
				<a class="page-link" href="edit_internship.php" role="button">Edit Internship Status</a>
			</div>

		</div>
	</div> 

	<h1>Inspirational Quotes</h1>

	<div class="row">
		<div id="inspo"><h3>The internship search can be rough... </h3><h3>Get some inspiration!</h3></div>
			<form id='search-form'>
				<div>
					<div>
						<label for="search-term">Enter a quote keyword:</label>
						<input type="text" class="form-control" id="search-term" placeholder="work...">
					</div>
					
					<div>
						<button type="submit" class="search">Search</button>
					</div>
				</div>
			</form>
		</div> 
		<div class="row">
			<table>
				<thead>
					<tr>
						<th>Image</th>
						<th>Artist</th>
						<th>Quote</th>
					</tr>
				</thead>
				<tbody>

					<tr>
						<td></td>
						<td></td>
						<td></td>
					</tr>

				</tbody>
			</table>
		</div> 
	<script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>

	<script>
		var keywords= [];
		$.ajax({
      		url: 'https://zenquotes.io/api/keywords/95d53ad7e5dc6181af38b4fa1d35407a20eeb99a',
      		dataType: 'json',
		}).then((data) => {
			console.log(data);
			keywords = data;
			
		}).fail((error) => {
			alert("AJAX error 1");
			console.log(error);
		})

		document.querySelector('#search-form').onsubmit = function(){
			var term = document.querySelector('#search-term').value.trim();
			term = term.toLowerCase();
			if (term.length > 0) {
				const url = `https://zenquotes.io/api/quotes/95d53ad7e5dc6181af38b4fa1d35407a20eeb99a&keyword=${term}`;

				$.ajax({
					url: url,
					dataType: "json"
				}).then((data) => {
					document.querySelector("tbody").innerHTML = '';

					for(q of data){

						console.log(q);
						var validKeyWord = false;
						for (var i = 0; i < keywords.length; i++) {
							if (keywords[i].k == term) {
						        validKeyWord = true;
						    }
						}
                        if (validKeyWord == true) {
							createRow(q);
						}
						else{
							console.log('INVALID KEYWORD ENTERED');
        					var keywordsprint = [];
        					for (var i = 0; i < keywords.length; i++) {
        					  keywordsprint.push(' ' + keywords[i].k);
        					}
						
        					alert(
        					  'Not a valid keyword. Choose from the following:\n' + keywordsprint
        					);
						}
					}}).fail((error) => {
					alert("AJAX Error 2");
					console.log(error);
				}) 
			}

			return false;
		}


		function createRow(quote){
			console.log(quote);
			var tr = document.createElement('tr');
			var Author = document.createElement('td');
			var Quote = document.createElement('td');
			var Image = document.createElement('td');
			var img = document.createElement('img');

			Author.innerHTML = quote.a; 
			Quote.innerHTML = quote.q;

			img.src = quote.i; 
			img.alt = quote.a + "'s Image";

			Image.appendChild(img);
			tr.appendChild(Image);
			tr.appendChild(Author);
			tr.appendChild(Quote);
			document.querySelector('tbody').appendChild(tr);
		}

	</script>
</body>
</html>
