/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


window.$ = window.jQuery = require('jquery');
//window.Popper = Popper;
require('bootstrap');

import 'datatables';
window.DataTable = require('datatables');

import 'jquery-ui/ui/widgets/datepicker.js';
$('#datepicker').datepicker();

import 'jquery-ui/ui/widgets/dialog';

import 'mathjs';
window.math = require('mathjs');

