/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';
console.log('test connect');

//timer
 let dom = document.getElementById('timerTrail');
 let dateLaunch = new Date(2020,10,21);
 console.log(dom)

 const setDate = () =>{

     const date = new Date()
     let s = Math.floor((dateLaunch.getTime() - date.getTime())/1000) ; 
     setTimeout(setDate,1000);
     console.log(s)
     dom.innerHTML = s + "  s";
 }

setDate();


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
import Test from './component/Test';
import Apimeteo from './component/ApiMeteo';
import TimerTrail from './component/TimerTrail';

 //api meteo
ReactDOM.render(<Router><Apimeteo /></Router>, document.getElementById('apiMeteo'));





