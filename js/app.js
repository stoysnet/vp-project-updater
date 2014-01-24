$(function () {
	"use strict";
	$('[data-toggle="tooltip"]').tooltip();
	
	var modal = $('#output');
	modal.modal({
		backdrop: 'static',
		keyboard: false,
		show: false
	});
	
	$.ajaxSetup({
		cache:false,
		timeout: 1e10 //pretty much no
	});
	
	function startAntTask(e) {
		$(document.body).off('click', '.row a', startAntTask);
		var task = $(this).attr('href').replace(/^#/, '');
		$(document.body).addClass('loading');
		$.get(
				'startant.php',
				{task: task}
			)
			.done(function (data) {
				$('#taskname').text(task);
				$(document.body).removeClass('loading');
				var pre = $('<pre></pre>');
				pre.text(data);
				$('.modal-body', modal).html(pre);
				modal.modal('show');
			})
			.always(function () {
				$(document.body).on('click', '.row a', startAntTask);
			});
		e.preventDefault();
	}
	
	$(document.body).on('click', '.row a', startAntTask);
	
});
