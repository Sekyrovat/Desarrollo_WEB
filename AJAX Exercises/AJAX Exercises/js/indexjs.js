

$.ajax({
	url : './data/restaurants.xml',
	type : 'GET',
	dataType : 'xml',
	success : function (data) {
		// console.log(data);
		
		let newHTML = "";

		//For each of the elements found, do the function
		$(data).find('restaurant').each(function () {
			{
				newHTML += `<li>
								${$(this).attr('name')}
							</li>`;
			}
		});
		$('#restaurantCatalog').append(newHTML);	
	},
	error : function (err) {
		console.log(err);
	}
})

$.ajax({
	url : './data/nutrition.xml',
	type : 'GET',
	dataType : 'xml',
	success : function (data) {
		let newHTML2 = "";

		$(data).find('food').each(function () {
			newHTML2 += `<tr>
							<td>
								${$(this).children('name').text()}
							</td>
							<td>
								${$(this).children('serving').text()}
							</td>
							<td>
								${$(this).children('calories').attr('total')}
							</td>
							<td>
								${$(this).children('cholesterol').text()}
							</td>
							<td>
								${$(this).children('sodium').text()}
							</td>
							<td>
								${$(this).children('carb').text()}
							</td>
							<td>
								${$(this).children('fiber').text()}
							</td>
							<td>
								${$(this).children('protein').text()}
							</td>
						</tr>`;
		});
		$('#foodTable').append(newHTML2);
	},
	error : function (err) {
		console.log(err);
	}
})

$.ajax({
	url : './data/mexicanStates.json',
	type : 'GET',
	dataType : 'json',
	success : function (data) {
		let newHTML3 = "";

		for (var i = 0; i < data.length; i++) {
			newHTML3 += `<option value="${data[i].identifier}">${data[i].state}</option>`;
		}

		$('#mexicanStates').append(newHTML3);

		/*
		 * We include a call to the javax of the capitals, since we want to make sure
		 * that the HTML is loadad and the state has been selected.
		 */

		 changeAction();
	},

	error : function (err) {
		console.log(err);
	}
})

function changeAction() {
	$('#mexicanStates').on("change",function (event) {
		let selectedValue = $('#mexicanStates').val();
		/*
		 * Now we can biuld up the ajax call, which will take the data.
		 * Since the ajax, is inside the function we use it every time we use the function.
		 * Try it the other way around, having an ajax done once and the function several.
		 */

		 $.ajax({
		 	url : './data/mexicanStatesCapitals.json',
		 	type : 'GET',
		 	dataType : 'json',
		 	success : function (data) {
		 		for(let i = 0; i < data.length; i++)
		 		{
		 			if (data[i].id == selectedValue){
		 				$('#stateCapital').val(data[i].capital);
		 				break;
		 			}
		 		}
		 	},
		 	error : function (err) {
		 		console.log(err);
		 	}
		 });
	});
}
