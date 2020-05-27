/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	// Setting own toolbars
	config.toolbar = [
		{ name: 'Fullscreen', items: [ 'Maximize' ] },
		{ name: 'Fonteffects', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript' ] },
		{ name: 'Fontalign', items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
		{ name: 'Links', items: [ 'Link', 'Unlink' ] },
		{ name: 'Lists', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ] },
		{ name: 'Insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'Iframe' ] },
		'/',
		{ name: 'styles', items: [ 'Styles', 'Format', 'FontSize' ] },
		{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
		{ name: 'Last', items: [ 'RemoveFormat', '-', 'Source' ] },
		{ name: 'others', items: [ '-' ] },
	];
	// Toolbar groups configuration.
	config.toolbarGroups = [
		{ name: 'Fullscreen' }, { name: 'others' },
		{ name: 'Fonteffects' }, { name: 'others' },
		{ name: 'Fontalign' }, { name: 'others' },
		{ name: 'Fontalign' }, { name: 'others' },
		{ name: 'Links' }, { name: 'others' },
		{ name: 'Insert' }, { name: 'others' },
		'/',
		{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
		{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
		{ name: 'Last' }, { name: 'others' }
	];
};

