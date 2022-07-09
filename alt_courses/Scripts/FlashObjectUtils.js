//SHARE-IN-MEMORY=true
//
// Copyright (c) 2007. Adobe Systems Incorporated.
// All rights reserved.
//
// DESCRIPTION:
//  A file intended for any Flash object related utility classes or functions or global variables.

// A global variable used in Translators/FlashObject.htm and Inspectors/_pi_flv_common.js.
// We set its id to the id of the Flash Video object currently in edit so that Flash object 
// translator will not prompt it as missing Flash object.
if (typeof flashVideoInEdit == 'undefined')
{
    flashVideoInEdit = {};
    flashVideoInEdit.id = "";
}    

FlashObjectFuncName = "swfobject.registerObject";
FlashObjectLibraryFile = "swfobject_modified.js";
