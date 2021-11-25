##Table of Contents
1. Backend Page Builder
2. Frontend Content Builder

##1) Backend Page Builder

Video manual
!![640x360](//player.vimeo.com/video/362164143)

##2) Frontend Content Builder

Create layout.

example **builder-layout.htm** (modifed layout from demo theme)

    ==
	<!DOCTYPE html>
	<html>
	<head>
	    <meta charset="utf-8">
	    <title>October CMS - {{ this.page.title }}</title>
	    <meta name="description" content="{{ this.page.meta_description }}">
	    <meta name="title" content="{{ this.page.meta_title }}">
	    <meta name="author" content="OctoberCMS">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta name="generator" content="OctoberCMS">
	    <link rel="icon" type="image/png" href="{{ 'assets/images/october.png'|theme }}">
	    {% styles %}
	</head>
	<body>   
	    {% page %}
	    <script src="{{ 'assets/vendor/jquery.js'|theme }}"></script>
	    <script src="{{ 'assets/vendor/bootstrap.js'|theme }}"></script>
	    <script src="{{ 'assets/javascript/app.js'|theme }}"></script>
	    {% framework extras %}
	    {% scripts %}
	</body>
	</html>


Create content file. 
**example empty main.htm**

Create cms page and add ContentBuilder component.

**example main.htm**

	title = "main"
	url = "/"
	layout = "builder-layout"
	is_hidden = 0
	robot_index = "index"
	robot_follow = "follow"

	[ContentBuilder]
	file = "main.htm"
	==
	{% component 'ContentBuilder' %}

Go to frontend and edit your page.

Video manual
!![640x360](//player.vimeo.com/video/362164143)
!![640x360](//player.vimeo.com/video/362164143)

##Drag&Drop Built-in Blocks
Plugin comes with a set of built-in blocks, in this way you're able to build your templates faster. If the default set is not enough you can always add your own custom blocks.
##Limitless styling
Plugin implements simple and powerful Style Manager module which enables independent styling of any component inside the canvas. It's also possible to configure it to use any of the CSS properties
##Responsive design
GrapesJS gives you all the necessary tools you need to optimize your templates to look awesomely on any device. In this way you're able to provide various viewing experience. In case more device options are required, you can easily add them to the editor.
##The structure always under control
You can nest components as much as you can but when the structure begins to grow the Layer Manager comes very handy. It allows you to manage and rearrange your elements extremely faster, focusing always on the architecture of your structure.
##The code is there when you need it
You don't have to care about the code, but it's always there, available for you. When the work is done you can grab and use it wherever you want. Developers could also implement their own storage interfaces to use inside the editor.
##Asset Manager
With the Asset Manager is easier to organize your media files and it's enough to double click on the image to change it