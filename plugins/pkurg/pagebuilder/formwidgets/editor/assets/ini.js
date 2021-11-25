$(document).ready
(
	function()
	{
		code=$("textarea").eq(0);
		
		$("button").eq(0).click
		(
			function()
			{
				code.css('white-space', 'normal').show_code(code.minify());
			}
		);
		
		$("button").eq(1).click
		(
			function()
			{
				val=$.replace_tag(code.minify());
				el=$("<div></div>").html(val);
				$.prettify_code(el);
				code.css('white-space', 'pre').show_code($.undo_tag(el.html()));
			}
		);
	}
);
