$(document).ready(function()
{
	$('.numpad').keyboard({
	 	layout: 'custom',
 	 	customLayout: {
		   'default' : [
		    '7 8 9',
		    '4 5 6',
		    '1 2 3',
		   ]
		  },
	  	maxLength : 1,
		restrictInput : true, // Prevent keys not in the displayed keyboard from being typed in
		preventPaste : true,  // prevent ctrl-v and right click
		autoAccept : true,
		visible: function(e, keyboard, el) {
			keyboard.$preview[0].select();
			$("button")
            // don't stack the binds each time the keyboard becomes visible
            .unbind('click.states')
            .bind('click.states', function(){
                keyboard.accept(); 
            });
		}
	}).addTyping();

	//Bind 'start Solving' click
	$('#soduku-solve').click(function(e){
		e.preventDefault();
		ajaxSubmitBoard();
	});

});

function ajaxSubmitBoard()
{
	$.ajax({
		type: 'POST',
		url : 'solve.php',
		data: {numbers: _getNumbers()},
		success: function(data)
		{
			console.log(data);
		}

	});
}

function _getNumbers()
{
	var numsObj = {};
	$('.numpad').each(function(){
		var key = $(this).attr('id');
		numsObj[key] = $(this).val();
	})
	return numsObj;
}