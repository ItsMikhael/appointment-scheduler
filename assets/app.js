/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';

console.log('Hello Webpack Encore! Edit me in assets/app.js');



$(document).ready(function(){

    booking('.timeslots-admin', true);
    booking('.timeslots-user', false);

})

function booking(selector, isAdmin) {
    $(selector).on("click", function () {
        if(!$(this).hasClass('booked')) {
            let date = $('.booking-date').data('id');
            let timeslot = $(this).data('id');
            $.post('booking/ajax', {date: date, timeslot: timeslot});
            if(isAdmin) {
                $(this).toggleClass('btn-secondary');
                $(this).toggleClass('btn-success');
            } else {
                $(this).toggleClass('btn-success');
                $(this).toggleClass('btn-warning');
                $(this).toggleClass('booked')
            }
        }
    })
}