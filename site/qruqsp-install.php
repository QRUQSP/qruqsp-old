<?php
//
// This file is the install script which will configure and setup the database
// and configuration files on disk.  The script will only run if it can't find
// a qruqsp-api.ini file.  This script can be uploaded to a webserver and it
// will download and install all the qruqsp modules.
//


//
// Figure out where the root directory is.  This file may be symlinked
//
$qruqsp_root = dirname(__FILE__);
$modules_dir = $qruqsp_root . '/qruqsp-mods';

//
// Verify no qruqsp-api.ini file
//
if( file_exists($qruqsp_root . '/qruqsp-api.ini') ) {
    print_page('no', 'qruqsp.installer.15', 'Already installed.</p><p><a href="/manager/">Login</a>');
    exit();
}

//
// Verify no .htaccess file exists.
//
if( file_exists($qruqsp_root . '/.htaccess') ) {
    print_page('no', 'qruqsp.installer.14', 'Already installed.</p><p><a href="/manager/">Login</a>');
    exit();
}

//
// If they didn't post anything, display the form, otherwise run an install
//
if( !isset($_POST['database_host']) ) {
    print_page('yes', '', '');
} else {
    install($qruqsp_root, $modules_dir);
}

exit();





function print_page($display_form, $err_code, $err_msg) {
?>
<!DOCTYPE html>
<html>
<head>
<title>QRUQSP Installer</title>
<style>
body { background: #fafafa; }
/******* The top bar across the window ******/
.headerbar {
    width: 100%;
    height: 2.5em;
    margin: 0px;
    padding: 0px;
    table-layout: auto;
    z-index: 2;
}

.headerbar td {
    margin: 0px;
    padding: 0px;
    vertical-align: bottom;
    background: #778;
    padding: 0.2em 0.3em 0.2em 0.3em;
    border-left: 1px solid #889;
    border-right: 1px solid #667;
}

.headerbar td.leftbuttons {
    text-align:left;
    margin: 0px;
    cursor: pointer;
    height: 100%;
    vertical-align: bottom;
    min-width: 2.5em;
    padding-top: 0px;
}

.headerbar td.rightbuttons {
    text-align:right;
    margin: 0px;
    align: right;
    height: 100%;
    cursor: pointer;
    vertical-align: bottom;
    min-width: 2.0em;
    padding-top: 0px;
}

.headerbar td.avatar {
    text-align: center;
    width: 3.0em;
    cursor: pointer;
    vertical-align: middle;
}

.headerbar td.homebutton img.avatar {
    width: 1.8em;
    height: 1.8em;
    margin: 0px;
    border: 1px solid #eee;
    vertical-align: middle;
}

.headerbar td.title {
    min-width: 10%; 
    width: 80%;
    max-width:90%;
    font-size: 1.2em;
    text-align:center;
    color: #eee;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    vertical-align: middle;
    padding: 0.3em 0.2em 0.2em 0.2em;
    border-left: 0px;
    border-right: 0px;
}

.headerbar td img {
    width: 1.9em;
    padding: 0px;
    margin: 0px;
    vertical-align: middle;
}

.headerbar td.helpbutton {
    border-right: 0px;
    padding-top: 0px;
}

.headerbar td.homebutton {
    cursor: pointer;
    border-left: 0px;
}

.headerbar td.hide {
    border-left: 0px;
    border-right: 0px;
    cursor: inherit;
}

.headerbar td.show {
}

.headerbar td div.button {
    display: table-cell;
    font-size: 0.8em;
    vertical-align: bottom;
    height: 100%;
    min-width: 3.5em;
    max-width: 5em;
    text-align: center;
    padding: 0em 0.2em 0em 0.2em;
    color: #ddd;
    cursor: pointer;
}

.headerbar td div.button span {
    display: inline-block;
    width: 100%;
}

.headerbar td div.button span.icon {
    font-size: 1.1em;
    text-decoration: none;
    font-family: CinikiRegular;
    color: #99a;
    max-height: 20px;
    vertical-align: top;
}
/* These can be specific for help or apps by add #m_container or #m_help in front */
div.narrow {
    margin: 0 auto;
    width: 20em;
    padding-top: 1em;
    padding-bottom: 1em;
}
div.mediumflex,
div.medium {
    padding-top: 1em;
    padding-bottom: 1em;
}
div.leftpanel {
    vertical-align: top;
    display: inline-block;
    width: 45% !important;
}
div.rightpanel {
    vertical-align: top;
    display: inline-block;
    width: 45% !important;
    padding-left: 1em;
}

div.xlarge,
div.large {
    padding-top: 1em;
    padding-bottom: 1em;
}

div.wide {
    padding-top: 1em;
    padding-bottom: 1em;
}


h2 {
    display: block;
    font-size: 1.1em;
    font-weight: normal;
    text-align: left;
    padding: 0.2em 0em 0.2em 0.5em;
    margin: 0 auto;
    border: 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    color: #555;
}

h2 span.count {
    position: relative;
    vertical-align: middle;
    top: -0.1em;
    margin-bottom: 0.3em;
    margin-top: -0.3em;
    padding: 0.2em 0.8em 0.2em 0.8em;
    font-size: 0.6em;
}

span.count {
    font-weight: normal;
    color: #777;
    background: #eee;
    display: inline-block;
    border: 1px solid #bbb;
    padding: 0.2em 0.7em 0.2em 0.7em;
    margin: 0px;
}

table.list td span.count {
    font-size: 0.7em;
    position: relative;
    margin-top: -0.3em;
    vertical-align: middle;
    top: -0.2em;
    margin-left: 0.5em;
}

div.narrow table.list,
div.medium table.list {
    width: 100%;
}

div.mediumflex table.list {
    min-width: 40em;
    max-width: 60em;
}

div.large table.list {
    width: 100%;
}

div.xlarge table.list {
    max-width: 100%;
}

table.list {
    text-align: left;
    padding: 0px;
    margin-bottom: 1em;
    table-layout: fixed;
}

table.form {
    table-layout: auto;
}

table.thread {
    table-layout: auto;
}

table.simplegrid {
    table-layout: auto;
    margin-top: 0;
/*  margin-left: auto;
    margin-right: auto; */
    width: 100%;
}

table.simplegrid th.sortable {
    cursor: pointer;
}

div.wide table.datepicker,
div.wide table.simplegrid {
    min-width: 40em;
}

div.wide h2 {
    width: 100%;
    min-width: 10em;
}

table.outline {
    border: 1px solid #ddd;
    padding: 0.1em 0.1em 0.1em 0.1em;
    background-color: rgba(255,255,255,0.4);
}

table.list > thead,
table.list > tbody,
table.list > tfoot {
    width: 100%;
}

table.list > thead > tr,
table.list > tfoot > tr,
table.list > tbody > tr {
    width: 100%;
}

table.border > thead:first-child > tr:first-child > th,
table.border > tbody:first-child > tr:first-child > td,
table.border > tfoot:first-child > tr:first-child > td {
    border-top: 1px solid #bbb;
}

table.border {
    background: #fff;
}

table.border > thead > tr > th:first-child,
table.border > tfoot > tr > td:first-child,
table.border > tbody > tr > td:first-child {
    border-left: 1px solid #bbb;
}

table.border > thead > tr > th:last-child,
table.border > tfoot > tr > td:last-child,
table.border > tbody > tr > td:last-child {
/*  border-right: 1px solid #bbb; */
    border-right: 0px;
}

table.fieldhistory > tbody > tr > td:last-child {
    border-right: 1px solid #bbb; 
}

table.list > tbody > tr > td,
table.list > tfoot > tr > td {
    padding: 0.7em 0.5em 0.7em 0.5em;
}
/* table.simplegrid > tbody > tr > td {
    padding: 0.6em 0.5em 0.5em 0.5em;
} */

table.border > tbody > tr > td,
table.border > tfoot > tr > td {
    border-bottom: 1px solid #bbb;
}

table.border > tbody > tr:last-child > td,
table.border > tfoot > tr:last-child > td {
    border-bottom: 0px;
}

table.fieldhistory > tbody > tr:last-child > td {
    border-bottom: 1px solid #bbb;
}

table.border > tfoot > tr:first-child > td {
    border-top: 1px solid #bbb;
}

table.list > thead > tr > th {
    padding: 0.5em;
    background: #eee;
}

table.border > thead > tr > th {
    border-bottom: 1px solid #bbb;
}

table.list > tbody > tr > td.noborder,
table.list > tfoot > tr > td.noborder {
    border-right: 0px;
}

table.list > tbody > tr > td.addbutton {
    text-align: right;
    width: 1.7em;
    text-align: center;
    padding-right: 0px;
    vertical-align: middle;
    line-height: 1.0em;
}

table.datepicker > tbody > tr > td.prev,
table.datepicker > tbody > tr > td.next,
table.list > tbody > tr > td.buttons,
table.list > tfoot > tr > td.buttons {
    text-align: center;
    vertical-align: middle;
    line-height: 1.0em;
    width: 1.9em;
    padding-right: 0.0em;
    padding-left: 0.0em;
}

table.datepicker > tbody > tr > td.prev {
    text-align: left;
    padding-left: 0.5em;
}

table.datepicker > tbody > tr > td.next {
    text-align: right;
    padding-right: 0.5em;
}

table.datepicker > tbody > tr > td.prev span.icon,
table.datepicker > tbody > tr > td.next span.icon,
table.list > tbody > tr > td.buttons span.icon,
table.list > tfoot > tr > td.buttons span.icon,
table.list > tbody > tr > td.addbutton span.icon {
    font-size: 0.9em;
    color: #aaa; 
}

table.border tr > td.label {
    border-left: 1px solid #bbb;    
    border-right: 0px solid #bbb;   
}

table.list tr.textfield > td.label {
    padding: 0.5em;
    text-align: right;
}

table.form tr.textfield > td.label > label {
    white-space: nowrap;
}

table.simplegrid td.label,
table.simplelist td.label {
    text-align: right;
    color: #bbb;
    font-size: 0.9em;
    width: 20%;
    min-width: 6em;
    padding: 0.9em 0.55em 0.8em 0.55em;
}

table.form td.button,
table.simplebuttons td.button {
    text-align: center; 
    cursor: pointer;
    font-weight: bold; 
    background: #555;
    color: #eee;
    padding: 0.5em 0.5em 0.45em 0.5em;
}

table.form td.save,
table.simplebuttons td.save {
    background: #555;
    color: #eee;
}

table.form td.delete,
table.simplebuttons td.delete {
    background: #f55;
    color: #eee;

}

table.border tr.textfield > td.hidelabel {
    border-left: 1px solid #bbb;    
    border-right: 0px;
}

table.list tr.textfield > td.hidelabel {
    padding: 0.5em 0 0.5em 0.5em;
    width: 5px !important;
    height: 1em;
    overflow: hidden;
}

table.list tr.textfield > td.hidelabel > label {
    display: none;
    overflow: hidden;
}

table.border tr > td.input {
    border-left: 1px solid #bbb;    
}


table.list tr > td.input {
    font-size: 1em;
    width: 100%;
    padding: 0.3em 0.5em 0.3em 0.2em;
    margin: 0px;
    vertical-align: center;
}

table.simplelist tr > td.input {
    width: 50%;
    border-left: 0px;
}

table.list tr > td input {
    width: 100%;
/*  height: 1.2em; */
    padding: 0.4em;
    padding-right: 0;
    font-size: 1.0em;
    color: #555;
    text-align: left;
    margin: 0px;
    border: 0px;
    text-overflow: ellipsis
    white-space: nowrap;
}

table.livesearch tr > td.search {
    padding-left: 0px;
    padding-right: 0px;
}

table.list tr.textfield > td > input.file {
    height: 1.5em;
}


table.list tr.textfield > td.select {
    width: 100%;
    height: 100%;
}

table.form td.select > select {
    width: 100%;
    height: 100%;
    padding: 0.4em;
    font-size: 1.0em;
    color: #555;
    text-align: left;
    margin: 0.4em;
    border: 0px;
    text-overflow: ellipsis
    white-space: nowrap;
    border: 1px solid #bbb;
}

table.list tr.textfield > td.toggle {
    border-left: 0px;
    text-align: left;
    padding: 0.5em;
}

div.narrow table.list tr.textfield > td.textarea,
div.medium table.list tr.textfield > td.textarea,
div.large table.list tr.textfield > td.textarea,
div.xlarge table.list tr.textfield > td.textarea,
div.wide table.list tr.textfield > td.textarea {
    width: 100%;
}

table.list tr.textfield > td.textarea {
    background: #fff;
    padding: 0 0em 0 0em;
    margin: 0px;
    padding: 0.4em; 
}

table.list tr.textfield > td > textarea {
    width: 100%;
    height: 10em;
    padding: 0.4em;
    padding: 0.0em;
    font-size: 1.0em;
    color: #555;
    text-align: left;
    margin: 0em;
    border: 0px;
}

table.list tr.textfield > td > textarea.small {
    height: 3em;
}

table.list tr.textfield > td > textarea.large {
    height: 20em;
}

table.list tr > td.noedit {
    padding: 0.5em;
    width: 95%;
    color: #777;
    line-height: 1.2em;
}

table.border tr > td.historybutton {
    border-right: 1px solid #bbb;   
}

table.list tr > td.historybutton {
    padding: 0.1em 0.5em 0.1em 0.2em;
    padding: 0px;
    cursor: pointer;
    vertical-align: middle;
    text-align: right;
}

table.list tr.textarea > td.historybutton {
    vertical-align: top;
}

span.rbutton_on,
span.rbutton_off {
    display: inline-block;
    border: 1px solid #777;
    padding: 0.25em 0.05em 0.25em 0.05em;
    width: 1.4em;
    margin: 0em 0.25em 0em 0.5em;
    cursor: pointer;
    text-align: center;
    font-size: 1.0em;
    text-decoration: none;
    font-family: CinikiRegular;
}

span.rbutton_on {
    color: #000;
}

span.rbutton_off {
    color: #bbb;
}

td.input span.rbutton_on,
td.input span.rbutton_off,
h2 span.rbutton_off {
    position: relative;
    /* margin-top: -0.3em; */
    /* top: -0.2em; */
    margin-left: 0.5em;
}

h2 span.rbutton_off {
    font-size: 0.7em;
}

table.list tr > td > img.calendarbutton {
    padding: 0.1em 0.5em 0.2em 0.2em;
    cursor: pointer;
    vertical-align: middle;
    text-align: right;
    margin-right: 0px;
    margin-left: auto;
    width: 1.4em;
}

table.border tr.fieldcalendar > td.calendar {
    border-left: 1px solid #bbb;    
    border-right: 1px solid #bbb;   
    border-bottom: 1px solid #bbb;  
}

table.list tr.fieldcalendar > td.calendar {
    text-align: left;
    padding: 0em;
    width: 100%;
    vertical-align: top;
    text-align: center;
}

table.list div.calendar {
    display: inline-block;
    margin: 1px;
    padding: 0px;
    vertical-align: top;
    border: 0px;
    min-width: 12em;
}

table.list table.calendar {
    background: #bbb;
    border: 0px;
    empty-cells: show;
    width: 100%;
    margin: 1px;
    padding: 0px;
    font-size: 0.8em;
    /* border-collapse: collapse; */
    border-top: 1px solid #bbb;
    border-left: 1px solid #bbb;
}

table.list table.calendar td {
    text-align: center;
    padding: 0.25em;
    background: #eee;
    border-right: 1px solid #bbb;
    border-bottom: 1px solid #bbb;
    cursor: pointer;
}

table.list table.calendar td.empty {
    background: #ddd;
    cursor: default;
}

table.list table.calendar td.today {
    background: #dfd;
}

table.list table.calendar td.selected {
    background: #ddf;
    font-weight: bold;
    text-decoration: underline;
}

table.list table.calendar td.newselection {
    background: #fdf;
}

table.list div.calendar table.calendar > thead td {
    background: #bbb;
    font-size: 1em;
}



table.form tr.fieldcolourpicker div.colours,
table.form tr.fieldcolourpicker div.colourpicker {
    display: inline-block;
    border: 0px;
    vertical-align: top;
    width: 50%;
    margin: 0px;
    padding: 0px;
    height: 100%;
}

table.form tr.fieldcolourpicker span.colourswatch {
    margin: 0.3em;
    cursor: pointer;
}

table.form tr.fieldcolourpicker div.colourpicker table.colourpicker {
    border: 1px solid #bbb;
    width: 100%;
}

table.form tr.fieldcolourpicker div.colourpicker table.colourpicker td {
    vertical-align: top;
    text-align: center;
    background: #eee;
    padding: 0.3em;
}

table.form tr.fieldcolourpicker div.colourpicker table.colourpicker td:first-child {
    border-right: 1px solid #bbb;
}

table.form tr.fieldcolourpicker div.colours table.colours {
    border: 1px solid #bbb;
    width: 100%;
}
table.form tr.fieldcolourpicker div.colours table.colours td {
    background: #eee;
    padding: 0.3em;
}

table.list table.fieldhistory tr td {
    padding: 0.5em;
    color: #555;
    text-align: left;
}

table.list > tbody > tr > td.truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

table.list td p {
    padding-top: 1em;
    line-height: 1.4em;
}
table.list td p:first-child {
    padding-top: 0em;
}
table.list td ul {
    margin-top: 1em;
    margin-bottom: 0em;
}
table.list td ul:first-child {
    margin-top: 0em;
}
table.list td dl {
    margin-top: 1em;
    margin-bottom: 0em;
}
table.list td dl:first-child {
    margin-top: 0em;
}
table.list td dl dt {
    display: block;
    clear: left;
    float: left;
}
table.list td dl dd {
    display: block;
    padding-left: 1em;
}


table.list td em {
    font-weight: bold;
}

p {
    margin: 0;
    /* padding: 1em 0.5em 1em 0.5em; */
}


table.list tr > td.helpbutton {
    padding: 0.1em 0.5em 0.1em 0.2em;
    cursor: pointer;
    vertical-align: middle;
    text-align: right;
    width: 1.4em;
}

table.list > tbody > tr.followup > td {
    font-size: 0.9em;
    vertical-align: top;
}

table.form table.fieldhistory {
    padding: 0em;
    width: 100%;
    empty-cells: show;
}

table.list table.fieldhistory tr td {
    padding: 0.5em;
    color: #555;
    text-align: left;
    font-size: 1em;
    background: #eee;
}

table.border table.fieldhistory td {
    border-bottom: 1px solid #777;
}

table.list table.fieldhistory td.fieldvalue {
    text-align: right;
    cursor: pointer;
    white-space: pre-line;
}

table.list td.searchresults {
    text-align: left;
    padding: 0em;
}

table.list td.nosearchresults {
    border-top: 1px solid #bbb; 
    border-left: 1px solid #bbb;    
    border-right: 1px solid #bbb;   
    border-bottom: 1px solid #bbb;  
}

table.list td.nosearchresults {
    text-align: left;
    padding: 0.5em;
}

table.form table.simplegrid,
table.list table.searchresults {
    padding: 0em;
    width: 100%;
    empty-cells: show;
    margin-bottom: 0em;
}

table.list table.searchresults tr td {
    border-left: 1px solid #bbb;    
    border-right: 1px solid #bbb;   
    border-bottom: 1px solid #bbb; 
}

table.list table.searchresults tr td {
    padding: 0.5em;
    color: #555;
    text-align: left;
    font-size: 1em;
    background: #eee;
    cursor: pointer;
}

table.list table.searchresults tr:first-child td {
    border-top: 1px solid #bbb;
}

table.border table.searchresults td {
    border-bottom: 1px solid #bbb;
}
table.border table.searchresults tr:last-child td {
    border-bottom: 0px;
}

table.list table.searchresults td.fieldvalue {
    text-align: right;
    cursor: pointer;
}

table.list table.searchresults td.buttons {
    text-align: right;
    padding: 0.2em 0.5em 0.2em 0.5em;
}

table.list table.searchresults td.buttons > button {
    text-align: center;
    font-size: 0.8em !important;
    padding: 0.2em 0.8em 0.2em 0.8em;
}

table.list td.alert {
    background: #fee;
}

table.simplegrid td.label {
    text-align: right;
}

table.simplegrid td.border {
    border-right: 1px solid #bbb;
}

table.simplegrid td.center {
    text-align: center;
}

table.dayschedule td.addlink,
table.simplegrid td.addlink {
    color: #bbb;
    padding-left: 1.9em;
}

table.dayschedule td.addlink {
    border-right: 0px;
}

table.list td div.dragdrop_cell {
    width: 100%;
    height: 1em;
}

table.simplegrid td.excel_deleted {
    background: #ddd;
}

table.simplegrid td.excel_keep {
    background: #efe;
}

table.list > tbody > tr > td.textbuttons {
    padding: 0.4em;
}

table.list > tbody > tr > td.multiline span.maintext {
    width: 100%;
    display: block;
}

table.list > tbody > tr > td span.subdue {
    font-size: 0.9em;
    font-decoration: normal;
    font-weight: normal;
    color: #999;
}

table.list > tbody > tr > td.multiline {
    padding: 0.5em 0.5em 0.45em 0.5em;
}

table.list > tbody > tr > td.multiline span.subtext {
    width: 100%;
    font-size: 0.8em;
    color: #999;
/*  padding-top: 0.1em; */
    display: block;
}
table.list > tbody > tr > td.multiline > span.singleline {
    overflow: hidden;
    text-overflow: ellipsis;
}

table.list > tbody > tr > td.nobreak {
    white-space: nowrap;
}

table.list > tbody > tr > td.multiline span.subsubtext {
    width: 100%;
    font-size: 0.8em;
    color: #999;
    padding-top: 0.1em;
    display: block;
}

table.list > tbody > tr > td.aligntop,
table.list > tfoot > tr > td.aligntop {
    vertical-align: top;
}

table.list > tbody > tr > td.aligncenter,
table.list > tfoot > tr > td.aligncenter {
    text-align: center;
}

table.list td span.icon {
    font-size: 1.1em;
    text-decoration: none;
    font-family: CinikiRegular;
    color: #777; 
    max-height: 20px;
    vertical-align: top;
}


table.simplegrid td.lightborderright {
    border-right: 1px solid #ddd;
}

table.simplegrid td.thumbnail {
    padding: 0.5em;
    width: 2em;
}

table.simplegrid td.thumbnail img {
}

table.form td.input div.image_preview {
    width: 100%;
    text-align: center;
}

table.form td.input div.image_preview img {
    background-color: #fff;
    padding: 8px;
    border: 1px solid #aaa;
    max-width: 95%;
}

table.datepicker {
    width: 100%;
    table-layout: auto;
}

table.datepicker > tbody > tr > td.date {
    text-align: center;
}

table.datepickersearch > tbody > tr > td.date {
    text-align: left;
}

table.simplelist > tbody > tr > td.search,
table.datepickersearch > tbody > tr > td.search {
    text-align: right;
    width: 40%;
    padding: 0px;
    vertical-align: middle;
    padding-right: 0.5em;
    padding-left: 0.5em;
    margin-left: -0.5em;
}

table.simplelist > tbody > tr > td.search input,
table.datepickersearch > tbody > tr > td.search input {
    width: 100%;
    height: 100%;
    padding: 0.3em;
    padding-right: 0;
    font-size: 1.0em;
    color: #555;
    text-align: left;
    margin: 0.3em;
    text-overflow: ellipsis
    white-space: nowrap;
    border: 1px solid #ddd; 
}

table.form > tbody > tr > td.multiselect,
table.form > tbody > tr > td.multitoggle,
table.form > tbody > tr > td.joinedflags,
table.form > tbody > tr > td.flags {
    padding: 0em 0.25em 0em 0.25em;
}

table.form > tbody > tr > td div.buttons {
    display: inline-block;
    padding-left: 0.6em;
    margin: 0px;
}

table.form > tbody > tr > td div.nopadbuttons {
    padding-left: 0em;
}

table.form > tbody > tr > td.multiselect div,
table.form > tbody > tr > td.multitoggle div {
    display: inline-block;
}

table.form > tbody > tr > td.multiselect span.hint,
table.form > tbody > tr > td.multitoggle span.hint {
    color: #999;
    padding-left: 0.6em;
}

table.form > tbody > tr > td.joinedflags div {
    display: table;
}

table.form span.flag_on {
    color: #000;
}

table.form span.flag_off {
    color: #bbb;
}

table.form td.joinedflags span.flag_on,
table.form td.joinedflags span.flag_off, 
table.form td div span.toggle_on,
table.form td div span.toggle_off {
    display: inline-block;
    border: 1px solid #777;
    font-weight: bold; 
    padding: 0.4em 0.5em 0.4em 0.5em;
    margin: 0.3em 0 0.3em 0;
    cursor: pointer;
    font-size: 0.9em;
}

table.form td div span.toggle_on {
    color: #000;
}

table.form td div span.toggle_off {
    color: #bbb;
}

table.form td span.flag_on span.icon,
table.form td span.flag_off span.icon,
table.form td span.toggle_on span.icon,
table.form td span.toggle_off span.icon {
    color: inherit;
}

table.paneltabs {
    margin-bottom: 0.5em;
}

table.paneltabs > tbody > tr > td {
    padding: 0em;
}

table.paneltabs td div span.toggle_on,
table.paneltabs td div span.toggle_off {
    font-size: 1.0em;
    margin: 0em;
}

span.username {
}

span.age {
    font-size: 0.8em;
    color: #888;
    font-style: italic;
}

input.submit {
    color: #333;
    font-size: 1em;
}

.clickable {
    cursor: pointer;
}

table.services > tbody > tr > td.jobs {
    padding: 0.1em;
}

table.services tr td.jobs span.job {
    display: inline-block;
    vertical-align: middle;
    border: 1px solid #a0a0a0;
    padding-left: 0.5em;
    padding-right: 0.5em;
    padding: 0.2em 0.5em 0.2em 0.5em;
    margin-right: 0.3em;
    margin: 0.1em 0.3em 0.1em 0.0em;
    min-width: 4em;
}

/* Text block markups */
div.wide table.text {
    min-width: 40em;
    table-layout: auto;
}

table.text tr.text td pre {
    overflow-x: scroll;
}

table.text tr.text td p:first-child,
table.text tr.text td pre:first-child {
    padding-top: 0px;
    margin-top: 0px;
}

table.text tr.text td p:last-child,
table.text tr.text td pre:last-child {
    padding-bottom: 0px;
    margin-bottom: 0px;
}

/********** Error screen ********/
#m_error {
    position: absolute;
    top: 0;
    left: 0;
    z-index: 98;
    width: 100%;
    height: 90%;
}

#m_error button {
    width: 10em;
    margin-top: 5px;
    margin-bottom: 5px;
    text-align: center;
    font-size: 1em;
    color: #333;
    cursor: pointer;
}


/********** Loading Spinner **************/
#m_loading {
    width: 100%;
    height: 100%;
    overflow: hidden;
    position: fixed;
    top: 0px;
    left: 0px;
    background: #fff;
    text-align: center;
    vertical-align: middle;
    opacity: .5;
    z-index:99;
}

#m_loading table {
    width: 100%;
    height: 100%;
}

div.scrollable {
    overflow: auto;
    width: 100%;
}
table.form td.textarea,
table.form td.search input,
table.form td.multiselect input,
table.form td.input input {
    box-sizing: border-box;
    border: 1px solid #ddd;
    -webkit-border-radius: 3px;
    -webkit-box-shadow: #eee 0px 1px 1px inset;
}

table.simplelist input,
table.datepicker input {
    -webkit-border-radius: 3px;
    -webkit-box-shadow: #eee 0px 1px 1px inset;
}

input, textarea {
    -webkit-appearance: none;
}

input:focus {
    outline: none;
}

table.form tr.textfield > td > input.search {
    height: 2.0em;
}

h2 {
    text-shadow: #fff 1px 1px 0px;
}

span.count {
    -webkit-border-radius: 1.2em;
    text-shadow: #fff 1px 1px 0px;
}

button, input.button {
    -webkit-border-radius: 1.2em;
    border: 1px solid #ccc;
    background: -webkit-gradient(linear, left top, left bottom, from(#eee), to(#bbb));
    text-shadow: #eee 1px 1px 0px;
    padding: 5px 15px 5px 15px;
}

span.rbutton_on,
span.rbutton_off {
    -webkit-border-radius: 1em;
}
table.form td.joinedflags span.flag_on:first-child,
table.form td.joinedflags span.flag_off:first-child,
table.form td div span.toggle_on:first-child,
table.form td div span.toggle_off:first-child {
    -webkit-border-top-left-radius: 0.5em;
    -webkit-border-bottom-left-radius: 0.5em;
}

table.form td.joinedflags span.flag_on:last-child,
table.form td.joinedflags span.flag_off:last-child,
table.form td div span.toggle_on:last-child,
table.form td div span.toggle_off:last-child {
    -webkit-border-top-right-radius: 0.5em;
    -webkit-border-bottom-right-radius: 0.5em;
}

table.form td.flags span.flag_on,
table.form td.flags span.flag_off {
    -webkit-border-radius: 0.5em;
}

span.rbutton_on,
table.form td div span.toggle_on,
table.form span.flag_on {
    background: -webkit-gradient(linear, left top, left bottom, from(#555), to(#999));
    text-shadow: 1px 1px 0px #555; 
    -webkit-box-shadow: inset 1px 1px 0px 0px #555;
    color: #ddd;
    border: 1px solid #777;
}

span.rbutton_off,
table.form td div span.toggle_off,
table.form span.flag_off {
    background: -webkit-gradient(linear, left top, left bottom, from(#eee), to(#bbb));
    text-shadow: 1px 1px 0px #eee; 
    -webkit-box-shadow: 1px 1px 2px 0px #555;
    color: #777;
    border: 1px solid #777;
}

table.list td > button {
    -webkit-border-radius: 0.5em;
}

table.form > tbody > tr > td.button,
table.simplebuttons > tbody > tr > td.button {
    border: 0px;
    background: -webkit-gradient(linear, left top, left bottom, from(#999), to(#555));
    text-shadow: 0 -1px 1px #555; 
    text-decoration: none; 
}


table.form > tbody > tr > td.delete,
table.simplebuttons > tbody > tr > td.delete {
    border: 0px;
    background: -webkit-gradient(linear,left top,left bottom,color-stop(0, #ec4a0b),color-stop(1, #ad390c));   
    text-shadow: 0 -1px 1px #953403; 
    text-decoration: none; 
}

textarea {
    -webkit-appearance: none;
}

input:-webkit-autofill {
    background: #fff !important;
}

table.list {
    -webkit-border-radius: 3px;
}

table.list > tbody:first-child > tr:first-child > td:first-child > textarea,
table.list > tbody:first-child > tr table,
table.list > tbody:first-child > tr table tr:first-child > td:first-child,
table.header > thead > tr:first-child > th:first-child,
table.noheader > tbody:first-child > tr:first-child > td:first-child,
table.list > tfoot:first-child > tr:first-child > td:first-child {
    -webkit-border-top-left-radius: 3px;
}

table.list > tbody:first-child > tr:first-child > td:last-child > textarea,
table.list > tbody:first-child > tr table,
table.list > tbody:first-child > tr table tr:first-child > td:last-child,
table.header > thead > tr:first-child > th:last-child,
table.noheader > tbody:first-child > tr:first-child > td:last-child,
table.list > tfoot:first-child > tr:first-child > td:last-child {
    -webkit-border-top-right-radius: 3px;
}
table.list > tbody:last-child > tr:last-child > td:first-child > textarea,
table.list > tbody:last-child > tr table,
table.list > tbody:last-child > tr table tr:last-child > td:first-child,
table.list > thead:last-child > tr:last-child > th:first-child,
table.list > tbody:last-child > tr:last-child > th:first-child,
table.list > tbody:last-child > tr:last-child > td:first-child,
table.list > tfoot > tr:last-child > td:first-child {
    -webkit-border-bottom-left-radius: 3px;
}
table.list > tbody:last-child > tr:last-child > td:last-child > textarea,
table.list > tbody:last-child > tr table,
table.list > tbody:last-child > tr table tr:last-child > td:last-child,
table.list > thead:last-child > tr:last-child > th:last-child,
table.list > tbody:last-child > tr:last-child > td:last-child,
table.list > tfoot > tr:last-child > td:last-child {
    -webkit-border-bottom-right-radius: 3px;
}

table.list td > div.colourswatches > span.selected {
    -webkit-box-shadow: #777 1px 1px 3px;
}

body {
    font-size: 100%;
    color: #303030;
    font-family: arial, helvetica;
    padding: 0px;
    margin: 0px;
    border: 0px;
    height: 100%;
}

.headerbar {
    border-bottom: 1px solid #667;
}

#m_error table.list td {
    background: #fff;
}

#m_container {
    margin: 0px;
    border: 0px;
    padding: 0px;
    width: 100%;
    height: 100%;
}

#mc_apps {
    left: 0px;
    width: 100%;
    margin: 0px;
    padding: 0px;
}

div.narrow {
    width: 20em;
    margin: 0 auto;
    padding-top: 1em;
    padding-bottom: 1em;
}

div.medium {
    width: 95%;
    max-width: 40em;
    margin: 0 auto;
}

div.mediumflex {
    min-width: 30em;
    max-width: 50em;
    margin: 0 auto;
}

div.large {
    width: 50em;
    max-width: 95%;
    margin: 0 auto;
}

div.xlarge {
    width: 60em;
    max-width: 95%;
    margin: 0 auto;
}

div.panel {
    text-align: center;
    margin: 0 auto;
    width: 100%;
}

div.wide {
    display: inline-block;
    text-align: center;
    margin: 0 auto;
    padding-left: 1em;
    padding-right: 1em;
}

div.narrow h2,
div.mediumflex h2,
div.medium h2 {
    width: 100%;
}

div.headerbar {
    font-size: 1em;
    margin: 0px;
    padding: 0px;
    height: 2.5em;
    width: 100%;
    border-bottom: 1px solid #ddd;
}

input {
    padding: 0.2em;
}

#m_help {
    float: right;
    min-height: 100%;
}

table.list tr.textfield > td > input.datetime {
    max-width: 12em;
}

table.list tr.textfield > td > input.timeduration {
    max-width: 6em;
}

table.list tr.gridfields > td.input input.integer,
table.list tr.gridfields > td.input input.small,
table.list tr.gridfields > td.input input.date,
table.list tr.gridfields > td.input input.hexcolour,
table.list tr.gridfields > td.input input.time,
table.list tr > td input.integer,
table.list tr > td input.small,
table.list tr > td input.date,
table.list tr > td input.hexcolour,
table.list tr > td input.time {
    max-width: 8em;
}

table.list tr.textfield > td > input.medium {
    max-width: 15em;
}

table.list tr.textfield > td > input.large {
    max-width: 45em;
}

table.list > tbody > tr.followup > td.userdetails {
    border-right: 1px dashed #bbb;
    text-decoration: normal;
    white-space: nowrap;
}

table.list > tbody > tr.followup > td.content {
    text-decoration: normal;
    white-space: pre-wrap;
}

table.list td div.calendar {
    width: 33%;
}
</style>
</head>
<body id="m_body">
<div id='m_container' class="s-normal">
    <table id="mc_header" class="headerbar" cellpadding="0" cellspacing="0">
        <tr>
        <td id="mc_home_button" style="display:none;"><img src="qruqsp-mods/core/ui/themes/default/img/home_button.png"/></td>
        <td id="mc_title" class="title">QRUQSP Installer</td>
        <td id="mc_help_button" style="display:none;"><img src="qruqsp-mods/core/ui/themes/default/img/help_button.png"/></td>
        </tr>
    </table>
    <div id="mc_content">
    <div id="mc_content_scroller" class="scrollable">
    <div id="mc_apps">
        <div id="mapp_installer" class="mapp">
            <div id="mapp_installer_content" class="panel">
                <div class="medium">
                <?php
                    if( $err_code == 'installed' ) {
                        print "<h2 class=''>Installed</h2><div class='bordered error'><p>QRUQSP installed and configured, you can now login and finished installing the database.  </p><p><a href='/manager'>Login</a></p></div>";

                    }
                    elseif( $err_code != '' ) {
                        print "<h2 class='error'>Error</h2><div class='bordered error'><p>Error $err_code - $err_msg</p></div>";
                    }
                ?>
                <?php if( $display_form == 'yes' ) { ?>
                    <form id="mapp_installer_form" method="POST" name="mapp_installer_form">
                        <h2>Database</h2>
                        <table class="list noheader form outline" cellspacing='0' cellpadding='0'>
                            <tbody>
                            <tr class="textfield"><td class="label"><label for="database_host">Host</label></td>
                                <td class="input"><input id="database_host" name="database_host" type="text" value="localhost"/></td></tr>
                            <tr class="textfield"><td class="label"><label for="database_username">User</label></td>
                                <td class="input"><input type="text" id="database_username" name="database_username" value="root"/></td></tr>
                            <tr class="textfield"><td class="label"><label for="database_password">Password</label></td>
                                <td class="input"><input type="password" id="database_password" name="database_password" value=""/></td></tr>
                            <tr class="textfield"><td class="label"><label for="database_name">Name</label></td>
                                <td class="input"><input type="text" id="database_name" name="database_name" value="qruqsp" /></td></tr>
                            </tbody>
                        </table>
                        <h2>System Adminstrator</h2>
                        <table class="list noheader form outline" cellspacing='0' cellpadding='0'>
                            <tbody>
                            <tr class="textfield"><td class="label"><label for="admin_email">Email</label></td>
                                <td class="input"><input type="email" id="admin_email" name="admin_email" /></td></tr>
                            <tr class="textfield"><td class="label"><label for="admin_username">Username</label></td>
                                <td class="input"><input type="text" id="admin_username" name="admin_username" /></td></tr>
                            <tr class="textfield"><td class="label"><label for="admin_password">Password</label></td>
                                <td class="input"><input type="password" id="admin_password" name="admin_password" /></td></tr>
                            <tr class="textfield"><td class="label"><label for="admin_callsign">Callsign</label></td>
                                <td class="input"><input type="text" id="admin_callsign" name="admin_callsign" /></td></tr>
                            <tr class="textfield"><td class="label"><label for="admin_display_name">Display</label></td>
                                <td class="input"><input type="text" id="admin_display_name" name="admin_display_name" placeholder=""/></td></tr>
                            </tbody>
                        </table>
                        <h2>Master Business</h2>
                        <div class="section">
                        <table class="list noheader form outline" cellspacing='0' cellpadding='0'>
                            <tbody>
                            <tr class="textfield"><td class="label"><label for="master_name">Name</label></td>
                                <td class="input"><input type="text" id="master_name" name="master_name" value="QRUQSP System"/></td></tr>
                            <tr class="textfield"><td class="label"><label for="system_email" >System Email</label></td>
                                <td class="input"><input type="text" id="system_email" name="system_email" placeholder="For sending alerts and notifications"/></td></tr>
                            <tr class="textfield"><td class="label"><label for="system_email_name">System Name</label></td>
                                <td class="input"><input type="text" id="system_email_name" name="system_email_name" value="QRUQSP Robot"/></td></tr>
                            </tbody>
                        </table>
                        </div>
                        <h2>Sync</h2>
                        <div class="section">
                        <table class="list noheader form outline" cellspacing='0' cellpadding='0'>
                            <tbody>
                            <tr class="textfield"><td class="label"><label for="sync_code_url">Code URL</label></td>
                                <td class="input"><input type="text" id="sync_code_url" name="sync_code_url" futurevalue="http://qruqsp.com/qruqsp-code" /></td></tr>
                            </tbody>
                        </table>
                        </div>
                        <div style="text-align:center;">
                            <input type="submit" value=" Install " class="button">
                        </div>
                    </form>
                <?php } ?>
            </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</div>
</body>
</html>
<?php
}


//
// Install Procedure
//

function install($qruqsp_root, $modules_dir) {

    $database_host = $_POST['database_host'];
    $database_username = $_POST['database_username'];
    $database_password = $_POST['database_password'];
    $database_name = $_POST['database_name'];
    $admin_email = $_POST['admin_email'];
    $admin_username = $_POST['admin_username'];
    $admin_password = $_POST['admin_password'];
    $admin_callsign = $_POST['admin_callsign'];
    $admin_display_name = $_POST['admin_display_name'];
    $master_name = $_POST['master_name'];
    $system_email = $_POST['system_email'];
    $system_email_name = $_POST['system_email_name'];
    $sync_code_url = preg_replace('/\/$/', '', $_POST['sync_code_url']);

    $manage_api_key = md5(date('Y-m-d-H-i-s') . rand());

    //
    // Build the config file
    //
    $config = array('qruqsp.core'=>array(), 'qruqsp.users'=>array());
    $config['qruqsp.core']['php'] = '/usr/bin/php';
    $config['qruqsp.core']['root_dir'] = $qruqsp_root;
    $config['qruqsp.core']['modules_dir'] = $qruqsp_root . '/qruqsp-mods';
    $config['qruqsp.core']['lib_dir'] = $qruqsp_root . '/qruqsp-lib';
    $config['qruqsp.core']['storage_dir'] = $qruqsp_root . '/qruqsp-storage';
    $config['qruqsp.core']['cache_dir'] = $qruqsp_root . '/qruqsp-cache';
    $config['qruqsp.core']['backup_dir'] = $qruqsp_root . '/qruqsp-backups';

    // Default session timeout to 30 minutes
    $config['qruqsp.core']['session_timeout'] = 1800;

    // Database information
    $config['qruqsp.core']['database'] = $database_name;
    $config['qruqsp.core']['database.names'] = $database_name;
    $config['qruqsp.core']["database.$database_name.hostname"] = $database_host;
    $config['qruqsp.core']["database.$database_name.username"] = $database_username;
    $config['qruqsp.core']["database.$database_name.password"] = $database_password;
    $config['qruqsp.core']["database.$database_name.database"] = $database_name;

    // The master business ID will be set later on, once information is in database
    $config['qruqsp.core']['master_station_id'] = 0;

    $config['qruqsp.core']['alerts.notify'] = $admin_email;
    $config['qruqsp.core']['system.email'] = $system_email;
    $config['qruqsp.core']['system.email.name'] = $system_email_name;

    // Configure packages and modules 
    $config['qruqsp.core']['packages'] = 'qruqsp';

    // Sync settings
    $config['qruqsp.core']['sync.name'] = $master_name;
    $config['qruqsp.core']['sync.url'] = "https://" . $_SERVER['SERVER_NAME'] . "/" . preg_replace('/^\//', '', dirname($_SERVER['REQUEST_URI']) . "qruqsp-sync.php");
    $config['qruqsp.core']['sync.full.hour'] = "13";
    $config['qruqsp.core']['sync.partial.hour'] = "13";
    $config['qruqsp.core']['sync.code.url'] = $sync_code_url;
    $config['qruqsp.core']['sync.log_lvl'] = 0;
    $config['qruqsp.core']['sync.log_dir'] = dirname($qruqsp_root) . "/logs";
    $config['qruqsp.core']['sync.lock_dir'] = dirname($qruqsp_root) . "/logs";
    $config['qruqsp.core']['manage.url'] = "https://" . $_SERVER['SERVER_NAME'] . "/" . preg_replace('/^\//', '', dirname($_SERVER['REQUEST_URI']) . "manager");
    $config['qruqsp.core']['ssl'] = '"off"';

    // Configure users module settings for password recovery
    $config['qruqsp.users']['password.forgot.notify'] = $admin_email;
    $config['qruqsp.users']['password.forgot.url'] = "https://" . $_SERVER['SERVER_NAME'] . "/" . preg_replace('/^\/$/', '', dirname($_SERVER['REQUEST_URI']));

    $config['qruqsp.web'] = array();
    $config['qruqsp.mail'] = array();

    //
    // Setup qruqsp variable, just like qruqsp-mods/core/private/init.php script, but we
    // can't load that script as the config file isn't on disk, and the user is not 
    // in the database
    //
    $qruqsp = array('config'=>$config);
    $qruqsp['request'] = array('api_key'=>$manage_api_key, 'auth_token'=>'', 'method'=>'', 'args'=>array());

    //
    // Check to see if the code already exists on server, if not grab the code and install
    //
    if( !file_exists($qruqsp_root . "/qruqsp-mods/core") ) {
        if( $sync_code_url == '' ) {
            print_page('yes', 'qruqsp.installer.200', "QRUQSP has not been downloaded, please specify a Code URL.");
            exit();
        }
        $remote_versions = file_get_contents($sync_code_url . '/_versions.ini');
        if( $remote_versions === false ) {
            print_page('yes', 'qruqsp.installer.201', "Unable to sync code, please check Code URL.");
            exit();
        }
        $remote_modules = parse_ini_string($remote_versions, true);
        
        # Create directory structure
        if( !file_exists($qruqsp_root . "/qruqsp-mods") ) {
            mkdir($qruqsp_root . "/qruqsp-mods");
        }
        if( !file_exists($qruqsp_root . "/qruqsp-cache") ) {
            mkdir($qruqsp_root . "/qruqsp-cache");
        }
        if( !file_exists($qruqsp_root . "/qruqsp-backups") ) {
            mkdir($qruqsp_root . "/qruqsp-backups");
        }
        if( !file_exists($qruqsp_root . "/qruqsp-storage") ) {
            mkdir($qruqsp_root . "/qruqsp-storage");
        }
        if( !file_exists($qruqsp_root . "/qruqsp-code") ) {
            mkdir($qruqsp_root . "/qruqsp-code");
        }
        if( !file_exists($qruqsp_root . "/qruqsp-lib") ) {
            mkdir($qruqsp_root . "/qruqsp-lib");
        }

        # This code also exists in qruqsp-mods/core/private/syncUpgradeSystem
        foreach($remote_modules as $mod_name => $module) {
            $remote_zip = file_get_contents($sync_code_url . "/$mod_name.zip");
            if( $remote_zip === false ) {
                print_page('yes', 'qruqsp.installer.202', "Unable to get $mod_name.zip, please check Code URL.");
                exit();
            }
            $zipfilename = $qruqsp_root . "/qruqsp-code/$mod_name.zip";
            if( ($bytes = file_put_contents($zipfilename, $remote_zip)) === false ) {
                print_page('yes', 'qruqsp.installer.203', "Unable to save $zipfilename");
                exit();
            }
            if( $bytes == 0 ) {
                print_page('yes', 'qruqsp.installer.204', "Unable to save $zipfilename");
                exit();
            }
            $zip = new ZipArchive;
            $res = $zip->open($zipfilename);
            if( $res === true ) {
                $mpieces = preg_split('/\./', $mod_name);
                $mod_dir = $qruqsp_root . '/' . $mpieces[0] . '-' . $mpieces[1] . '/' . $mpieces[2];
                if( !file_exists($mod_dir) ) {
                    mkdir($mod_dir);
                }
                $zip->extractTo($mod_dir);
                $zip->close();
            } else {
                print_page('yes', 'qruqsp.installer.205', "Unable to open $mod_name.zip");
                exit();
            }
        }
    }

    //
    // Initialize the database connection
    //
    require_once($modules_dir . '/core/private/loadMethod.php');
    qruqsp_core_loadMethod($qruqsp, 'qruqsp', 'core', 'private', 'dbInit');
    $rc = qruqsp_core_dbInit($qruqsp);
    if( $rc['stat'] != 'ok' ) {
        print_page('yes', $rc['err']['code'], "Failed to connect to the database '$database_name', please check your database connection settings and try again.<br/><br/>" . $rc['err']['msg']);
        exit();
    }

    //
    // Run the upgrade script, which will upgrade any existing tables,
    // so we don't have to check first if they exist.
    // 
    qruqsp_core_loadMethod($qruqsp, 'qruqsp', 'core', 'private', 'dbUpgradeTables');
    $rc = qruqsp_core_dbUpgradeTables($qruqsp);
    if( $rc['stat'] != 'ok' ) {
        print_page('yes', $rc['err']['code'], "Failed to connect to the database '$database_name', please check your database connection settings and try again.<br/><br/>" . $rc['err']['msg']);
        exit();
    }

    // FIXME: Add code to upgrade other packages databases


    //
    // Check if any data exists in the database
    //
    $strsql = "SELECT 'num_rows', COUNT(*) FROM qruqsp_core_api_keys, qruqsp_core_users";
    qruqsp_core_loadMethod($qruqsp, 'qruqsp', 'core', 'private', 'dbCount');
    $rc = qruqsp_core_dbCount($qruqsp, $strsql, 'core', 'count');
    if( $rc['stat'] != 'ok' ) {
        print_page('yes', $rc['err']['code'], "Failed to check for existing data<br/><br/>" . $rc['err']['msg']);
        exit();
    }
    if( $rc['count']['num_rows'] != 0 ) {
        print_page('yes', 'qruqsp.installer.96', "Failed to check for existing data.");
        exit();
    }
    $db_exists = 'no';

    //
    // FIXME: Check if api_key already exists for qruqsp-manage, and add if doesn't
    //



    //
    // FIXME: Add the user, if they don't already exist
    //

    //
    // Start a new database transaction
    //
    qruqsp_core_loadMethod($qruqsp, 'qruqsp', 'core', 'private', 'dbTransactionStart');
    qruqsp_core_loadMethod($qruqsp, 'qruqsp', 'core', 'private', 'dbTransactionRollback');
    qruqsp_core_loadMethod($qruqsp, 'qruqsp', 'core', 'private', 'dbTransactionCommit');
    qruqsp_core_loadMethod($qruqsp, 'qruqsp', 'core', 'private', 'dbInsert');
    $rc = qruqsp_core_dbTransactionStart($qruqsp, 'core');
    if( $rc['stat'] != 'ok' ) {
        print_page('yes', $rc['err']['code'], "Failed to setup database<br/><br/>" . $rc['err']['msg']);
        exit();
    }

    if( $db_exists == 'no' ) {
        //
        // Add the user
        //
        $strsql = "INSERT INTO qruqsp_core_users (id, uuid, email, username, password, callsign, avatar_id, perms, status, timeout, "
            . "display_name, date_added, last_updated) VALUES ( "
            . "'1', UUID(), '$admin_email', '$admin_username', SHA1('$admin_password'), '$admin_callsign', 0, 1, 10, 0, "
            . "'$admin_display_name', UTC_TIMESTAMP(), UTC_TIMESTAMP())";
        $rc = qruqsp_core_dbInsert($qruqsp, $strsql, 'users');
        if( $rc['stat'] != 'ok' ) {
            qruqsp_core_dbTransactionRollback($qruqsp, 'core');
            print_page('yes', $rc['err']['code'], "Failed to setup database<br/><br/>" . $rc['err']['msg']);
            exit();
        }

        //
        // Add the master business, if it doesn't already exist
        //
        $strsql = "INSERT INTO qruqsp_core_stations (id, uuid, name, tagline, description, status, date_added, last_updated) VALUES ("
            . "'1', UUID(), '$master_name', '', '', 1, UTC_TIMESTAMP(), UTC_TIMESTAMP())";
        $rc = qruqsp_core_dbInsert($qruqsp, $strsql, 'businesses');
        if( $rc['stat'] != 'ok' ) {
            qruqsp_core_dbTransactionRollback($qruqsp, 'core');
            print_page('yes', $rc['err']['code'], "Failed to setup database<br/><br/>" . $rc['err']['msg']);
            exit();
        }
        $config['qruqsp.core']['master_station_id'] = 1;
        $config['qruqsp.web']['master.domain'] = $_SERVER['HTTP_HOST'];
        $config['qruqsp.web']['poweredby.url'] = "http://qruqsp.com/";
        $config['qruqsp.web']['poweredby.name'] = "QRUQSP";
        $config['qruqsp.mail']['poweredby.url'] = "http://qruqsp.com/";
        $config['qruqsp.mail']['poweredby.name'] = "QRUQSP";

        //
        // Add sysadmin as the owner of the master business
        //
        $strsql = "INSERT INTO qruqsp_core_station_users (uuid, station_id, user_id, permission_group, status, date_added, last_updated) VALUES ("
            . "UUID(), '1', '1', 'owners', '1', UTC_TIMESTAMP(), UTC_TIMESTAMP())";
        $rc = qruqsp_core_dbInsert($qruqsp, $strsql, 'businesses');
        if( $rc['stat'] != 'ok' ) {
            qruqsp_core_dbTransactionRollback($qruqsp, 'core');
            print_page('yes', $rc['err']['code'], "Failed to setup database<br/><br/>" . $rc['err']['msg']);
            exit();
        }

        //
        // Enable modules: bugs, questions for master business
        //
/*        $strsql = "INSERT INTO qruqsp_core_station_modules (station_id, package, module, status, date_added, last_updated) "
            . "VALUES ('1', 'qruqsp', 'bugs', 1, UTC_TIMESTAMP(), UTC_TIMESTAMP())";
        $rc = qruqsp_core_dbInsert($qruqsp, $strsql, 'businesses');
        if( $rc['stat'] != 'ok' ) {
            qruqsp_core_dbTransactionRollback($qruqsp, 'core');
            print_page('yes', $rc['err']['code'], "Failed to setup database<br/><br/>" . $rc['err']['msg']);
            exit();
        } 
*/
        //
        // Enable modules
        //
        $strsql = "INSERT INTO qruqsp_core_station_modules (station_id, package, module, status, date_added, last_updated) "
            . "VALUES ('1', 'qruqsp', 'arps', 1, UTC_TIMESTAMP(), UTC_TIMESTAMP())";
        $rc = qruqsp_core_dbInsert($qruqsp, $strsql, 'businesses');
        if( $rc['stat'] != 'ok' ) {
            qruqsp_core_dbTransactionRollback($qruqsp, 'core');
            print_page('yes', $rc['err']['code'], "Failed to setup database<br/><br/>" . $rc['err']['msg']);
            exit();
        }

        //
        // Setup notification settings
        //
        $strsql = "INSERT INTO qruqsp_bug_settings (station_id, detail_key, detail_value, date_added, last_updated) "
            . "VALUES ('1', 'add.notify.owners', 'yes', UTC_TIMESTAMP(), UTC_TIMESTAMP())";
        $rc = qruqsp_core_dbInsert($qruqsp, $strsql, 'bugs');
        if( $rc['stat'] != 'ok' ) {
            qruqsp_core_dbTransactionRollback($qruqsp, 'core');
            print_page('yes', $rc['err']['code'], "Failed to setup database<br/><br/>" . $rc['err']['msg']);
            exit();
        }

        //
        // Add the api key for the UI
        //
        $strsql = "INSERT INTO qruqsp_core_api_keys (api_key, status, appname, notes, "
            . "last_access, expiry_date, date_added, last_updated) VALUES ("
            . "'$manage_api_key', 1, 'qruqsp-manage', '', 0, 0, UTC_TIMESTAMP(), UTC_TIMESTAMP())";
        $rc = qruqsp_core_dbInsert($qruqsp, $strsql, 'core');
        if( $rc['stat'] != 'ok' ) {
            qruqsp_core_dbTransactionRollback($qruqsp, 'core');
            print_page('yes', $rc['err']['code'], "Failed to setup database<br/><br/>" . $rc['err']['msg']);
            exit();
        }
    }

    // 
    // Save qruqsp-api config file
    //
    $new_config = "";
    foreach($config as $module => $settings) {
        $new_config .= "[$module]\n";
        foreach($settings as $key => $value) {
            $new_config .= "    $key = $value\n";
        }
        $new_config .= "\n";
    }
    $num_bytes = file_put_contents($qruqsp_root . '/qruqsp-api.ini', $new_config);
    if( $num_bytes == false || $num_bytes < strlen($new_config)) {
        unlink($qruqsp_root . '/qruqsp-api.ini');
        qruqsp_core_dbTransactionRollback($qruqsp, 'core');
        print_page('yes', 'qruqsp.installer.99', "Unable to write configuration, please check your website settings.");
        exit();
    }

    //
    // Save qruqsp-manage config file
    //
    $manage_config = ""
        . "[qruqsp.core]\n"
        . "manage_root_url = /qruqsp-mods\n"
        . "themes_root_url = " . preg_replace('/^\/$/', '', dirname($_SERVER['REQUEST_URI'])) . "/qruqsp-mods/core/ui/themes\n"
        . "json_url = " . preg_replace('/^\/$/', '', dirname($_SERVER['REQUEST_URI'])) . "/qruqsp-json.php\n"
        . "api_key = $manage_api_key\n"
        . "site_title = '" . $master_name . "'\n"
        . "";

    $num_bytes = file_put_contents($qruqsp_root . '/qruqsp-manage.ini', $manage_config);
    if( $num_bytes == false || $num_bytes < strlen($manage_config)) {
        unlink($qruqsp_root . '/qruqsp-api.ini');
        unlink($qruqsp_root . '/qruqsp-manage.ini');
        qruqsp_core_dbTransactionRollback($qruqsp, 'core');
        print_page('yes', 'qruqsp.installer.98', "Unable to write configuration, please check your website settings.");
        exit();
    }

    //
    // Save the .htaccess file
    //
    $htaccess = ""
        . "# Block evil spam bots\n"
        . "# List found on : http://perishablepress.com/press/2006/01/10/stupid-htaccess-tricks/#sec1\n"
        . "RewriteBase /\n"
        . "RewriteCond %{HTTP_USER_AGENT} ^Anarchie [OR]\n"
        . "RewriteCond %{HTTP_USER_AGENT} ^ASPSeek [OR]\n"
        . "RewriteCond %{HTTP_USER_AGENT} ^attach [OR]\n"
        . "RewriteCond %{HTTP_USER_AGENT} ^autoemailspider [OR]\n"
        . "RewriteCond %{HTTP_USER_AGENT} ^Xaldon\ WebSpider [OR]\n"
        . "RewriteCond %{HTTP_USER_AGENT} ^Xenu [OR]\n"
        . "RewriteCond %{HTTP_USER_AGENT} ^Zeus.*Webster [OR]\n"
        . "RewriteCond %{HTTP_USER_AGENT} ^Zeus\n"
        . "RewriteRule ^.* - [F,L]\n"
        . "\n"
        . "# Block access to internal code\n"
        . "\n"
        . "Options All -Indexes\n"
        . "RewriteEngine On\n"
        . "# Force redirect to strip www from front of domain names\n"
        . "RewriteCond %{HTTP_HOST} ^www\.(.*)$ [NC]\n"
        . "RewriteRule ^(.*)$ http://%1/$1 [R=301,L]\n"
        . "# Allow access to artweb themes and cache, everything is considered public\n"
        . "RewriteRule ^qruqsp-web-layouts/(.*\.)(css|js|png|eot|ttf|woff|svg)$ qruqsp-mods/web/layouts/$1$2 [L]\n"
        . "RewriteRule ^qruqsp-web-themes/(.*\.)(css|js|html|png|jpg)$ qruqsp-mods/web/themes/$1$2 [L]\n"
        . "RewriteRule ^qruqsp-web-cache/(.*\.)(css|js|gif|jpg|png|mp3|ogg|wav)$ qruqsp-mods/web/cache/$1$2 [L]\n"
        . "RewriteRule ^qruqsp-code/(.*\.)(zip|ini)$ qruqsp-code/$1$2 [L]\n"
        . "RewriteBase /\n"
        . "\n"
        . "AddType text/cache-manifest .manifest\n"
        . "\n"
        . "RewriteCond %{REQUEST_FILENAME} -f [OR]\n"
        . "RewriteCond %{REQUEST_FILENAME} -d\n"
        . "RewriteRule ^manager/(.*)$ qruqsp-manage.php [L]                                            # allow all qruqsp-manage\n"
        . "RewriteRule ^(manager)$ qruqsp-manage.php [L]                                             # allow all qruqsp-manage\n"
        . "RewriteRule ^(qruqsp-mods/[^\/]*/ui/.*)$ $1 [L]                                                  # Allow manage content\n"
        . "RewriteRule ^(qruqsp-web-themes/.*)$ $1 [L]                                              # Allow manage-theme content\n"
        . "RewriteRule ^(qruqsp-mods/web/layouts/.*)$ $1 [L]                                    # Allow web-layouts content\n"
        . "RewriteRule ^(qruqsp-mods/web/themes/.*)$ $1 [L]                                     # Allow web-themes content\n"
        . "RewriteRule ^(qruqsp-mods/web/cache/.*\.(css|js|gif|jpg|png|mp3|ogg|wav))$ $1 [L]                                      # Allow web-cache content\n"
        . "RewriteRule ^(qruqsp-login|qruqsp-sync|qruqsp-json|index|qruqsp-manage).php$ $1.php [L]  # allow entrance php files\n"
        . "RewriteRule ^([_0-9a-zA-Z-]+/)(.*\.php)$ index.php [L]                                  # Redirect all other php requests to index\n"
        . "RewriteRule ^$ index.php [L]                                                              # Redirect all other requests to index\n"
        . "RewriteRule . index.php [L]                                                              # Redirect all other requests to index\n"
        . "\n"
        . "php_value post_max_size 20M\n"
        . "php_value upload_max_filesize 20M\n"
        . "php_value magic_quotes 0\n"
        . "php_flag magic_quotes off\n"
        . "php_value magic_quotes_gpc 0\n"
        . "php_flag magic_quotes_gpc off\n"
        . "php_value session.cookie_lifetime 3600\n"
        . "php_value session.gc_maxlifetime 3600\n"
        . "";

    $num_bytes = file_put_contents($qruqsp_root . '/.htaccess', $htaccess);
    if( $num_bytes == false || $num_bytes < strlen($htaccess)) {
        unlink($qruqsp_root . '/qruqsp-api.ini');
        unlink($qruqsp_root . '/qruqsp-manage.ini');
        unlink($qruqsp_root . '/.htaccess');
        qruqsp_core_dbTransactionRollback($qruqsp, 'core');
        print_page('yes', 'qruqsp.installer.97', "Unable to write configuration, please check your website settings.");
        exit();
    }

    //
    // Create symlinks into scripts
    //
    symlink($qruqsp_root . '/qruqsp-mods/core/scripts/sync.php', $qruqsp_root . '/qruqsp-sync.php');
    symlink($qruqsp_root . '/qruqsp-mods/core/scripts/json.php', $qruqsp_root . '/qruqsp-json.php');
    symlink($qruqsp_root . '/qruqsp-mods/web/scripts/index.php', $qruqsp_root . '/index.php');
    symlink($qruqsp_root . '/qruqsp-mods/core/scripts/manage.php', $qruqsp_root . '/qruqsp-manage.php');
    symlink($qruqsp_root . '/qruqsp-mods/core/scripts/login.php', $qruqsp_root . '/qruqsp-login.php');

    $rc = qruqsp_core_dbTransactionCommit($qruqsp, 'core');
    if( $rc['stat'] != 'ok' ) {
        qruqsp_core_dbTransactionRollback($qruqsp, 'core');
        unlink($qruqsp_root . '/qruqsp-api.ini');
        unlink($qruqsp_root . '/qruqsp-manage.ini');
        unlink($qruqsp_root . '/.htaccess');
        unlink($qruqsp_root . '/qruqsp-json.php');      
        unlink($qruqsp_root . '/qruqsp-manage.php');        
        unlink($qruqsp_root . '/qruqsp-login.php');     
        unlink($qruqsp_root . '/index.php');        
        print_page('yes', $rc['err']['code'], "Failed to setup database<br/><br/>" . $rc['err']['msg']);
        exit();
    }

    print_page('no', 'installed', '');
}

?>
