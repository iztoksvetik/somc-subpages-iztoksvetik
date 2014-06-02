jQuery(function() {
	// On click to order orderes the list
	jQuery('.ssis-order').click(function(e) {
		e.preventDefault();
		var list = jQuery(this).siblings('ul');
		var order = jQuery(this).attr('data-order');

		// Takes all the list elements form the list
		// detatching them so they keep their events
		var elements = [];
		list.children('li').each(function() {
			elements.push(jQuery(this).detach());
		});	
		// Passes all the elements trough order function that comapres them lexicographically
		var ordered = orderList(elements, order);

		// Loops trough the returned ordered list and appends it back to DOM
		for (var i = 0; i < ordered.length; i++) {
			list.append(ordered[i]);
		}
		// Hide the icon and display the other one depending on the ordering way
		jQuery(this).hide();
		if (order == 'asc') {
			other = 'desc';
		}
		else {
			other = 'asc';
		}
		jQuery(this).siblings('.ssis-order-' + other).css('display', 'block').addClass('ordered');
	});

	// Opens and closes sublists and styles them so its always contrasted to its parent
	jQuery('.ssis-more').click(function(e) {
		e.preventDefault();
		var li = jQuery(this).parent();
		var ul = jQuery(this).siblings('ul');
		var background = li.css('background-color');
		var icon = jQuery(this).children('i');

		if (background == 'rgb(255, 255, 255)') {
			new_bcg = 'rgb(243, 244, 246)';
		}
		else {
			new_bcg = 'rgb(255, 255, 255)';
		}
		ul.children('li').css('background-color', new_bcg);
		
		if (li.hasClass('open')) {
			li.css('border-top', 'none');
			icon.attr('class', 'icon-down-open');
			li.removeClass('open');
			ul.slideUp();
		} 
		else {
			li.css('border-top', '1px solid ' + new_bcg);
			icon.attr('class', 'icon-up-open');
			li.addClass('open');
			ul.slideDown();
		}
	})
});

// Simple function that orders the list by comparing the titles
function orderList(list, order) {
	var ordered = [list[0]];
	// Loop trough all the elements on the list starting with 2nd
	for (var i = 1; i < list.length; i++) {
		title = list[i].find('.title').html();
		// Loop trough all the elements of the ordered list
		for (var j = 0; j < ordered.length; j++) {
			previous = ordered[j].find('.title').html();
			// If the current element comes befre the one were comapring to, put it in the list before it
			if (compare(title, previous, order)) {
				ordered.splice(j, 0, list[i]);
				ordered.join();
				break;
			}
			// If theres no element after this we put the element on the end and break
			else if (ordered[ j + 1 ] === undefined) {
				ordered.push(list[i]);
				break;
			}
		}
	}
	return ordered;

}

function compare(element1, element2, order) {
	if (order == 'asc') {
		return element1 < element2;
	}
	return element1 > element2;
}