/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';
console.log('test connect');

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

// console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
// console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
// alert('hello');



// =============================================================================
// swup
// =============================================================================
// import Swup from 'swup';
// const swup = new Swup(); // only this line when included with script tag

// import SwupFadeTheme from '@swup/fade-theme';
// const swup = new Swup({
//     plugins: [new SwupFadeTheme()]
//   });

import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router } from 'react-router-dom';
import '../css/app.css';
import ApiMeteo from './component/ApiMeteo';
import Test from './component/Test';

ReactDOM.render(<Router><ApiMeteo /></Router>, document.getElementById('apiMeteo'));
ReactDOM.render(<Router><Test /></Router>, document.getElementById('apiMeteo'));
