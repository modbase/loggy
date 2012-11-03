(function () {
	$('input[name^="warning"]').change(function () {
		$(this).parent().parent().children().last().children().val(parseInt($(this).val())+1);
	});

	$('.toggle').click(function () {
		var row = $($(this).data('details'));

		if (row.hasClass('hide')) {
			row.removeClass('hide');
		} else {
			row.addClass('hide');
		}
	});

	setInterval(function () {
		$('#clock').html(getClock());
	}, 500);
})();

function getClock() {
	var today = new Date();
	var h = today.getHours();
	var m = today.getMinutes();
	var s = today.getSeconds();
	m = ('0' + m).slice(-2);
	s = ('0' + s).slice(-2);
	return h +':'+ m +':'+ s;
}