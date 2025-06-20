/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.plugins.addExternal('ckeditor_wiris', 'plugin.js');

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.removeButtons = 'About,Image';
	config.extraPlugins = 'ckeditor_wiris,base64image,pastebase64';
	
};
