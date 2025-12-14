(function () {
    'use strict';

    // Wait for jQuery to be loaded
    if (typeof jQuery === 'undefined') {
        console.error('jQuery is not loaded! Please check if jQuery file is loaded correctly.');
        return;
    }

    // Use jQuery ready function
    jQuery(document).ready(function ($) {
        console.log('Backend.js loaded successfully');

        // Hid Placeholder On Form Focus
        var placeholderInputs = $('[placeholder]');
        if (placeholderInputs.length > 0) {
            placeholderInputs.focus(function () {
                $(this).attr('data-text', $(this).attr('placeholder'));
                $(this).attr('placeholder', '');
            }).blur(function () {
                $(this).attr('placeholder', $(this).attr('data-text'));
            });
            console.log('Placeholder handler attached to ' + placeholderInputs.length + ' input(s)');
        }

        // Add Asterisk On Required Field
        var requiredInputs = $('input[required="required"]');
        requiredInputs.each(function () {
            // Check if asterisk already exists to avoid duplicates
            if ($(this).next('.asterisk').length === 0) {
                $(this).after('<span class="asterisk">*</span>');
            }
        });
        console.log('Asterisk added to ' + requiredInputs.length + ' required input(s)');

        // Convert Password Field To Text Field On Hover
        $('.show-pass').hover(function () {
            // Find the password field in the same container (sibling)
            var passField = $(this).siblings('.password');
            if (passField.length > 0) {
                passField.attr('type', 'text');
            }
        }, function () {
            // Find the password field in the same container (sibling)
            var passField = $(this).siblings('.password');
            if (passField.length > 0) {
                passField.attr('type', 'password');
            }
        });
        console.log('Password show/hide handler attached to ' + $('.show-pass').length + ' icon(s)');
    });

    // Confirmation Message On Button
    $('.confirm').click( function () {
        return confirm('Are You Sure?');
    });
    
    //Category View Option
    $('.cat h3').click(function () {

        $(this).next('.full-view').fadeToggle(200);

    });

    $('.option span').click(function () {
        
        $(this).addClass('active').siblings('span').removeClass('active');

        if ($(this).data('view' === 'full')) {

            $('.cat .full-view').fadeIn(200);

        } else {

            $('.cat .full-view').fadeOut(200);

        }

    });

});
