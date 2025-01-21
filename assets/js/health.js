// Health measurements handler
$(document).ready(function() {
    // Update health output when the health progress slider changes
    $('#healthProgress').on('input change', function() {
        const value = $(this).val();
        $('#healthOutput').text(value);
    });

    // Initialize the value on page load
    const initialValue = $('#healthProgress').val();
    $('#healthOutput').text(initialValue);

    // Skills progress handler
    $(document).on('input change', '#skillProgress', function() {
        const value = parseInt($(this).val());
        const $output = $(this).siblings('#skillOutput');
        $output.text(value);
    });

    const skillValue = $('#skillProgress').val();
    $('#skillOutput').text(skillValue);
    
    // $('.hoppie-entry').each(function() {
    // Update health output when the health progress slider changes
    $(document).on('input change', '#hoppieProgress', function() {
        const value = parseInt($(this).val());
        const $output = $(this).siblings('#hoppieOutput');
        $output.text(value);
    });

    // Initialize the value on page load
    const hoppieValue = $('#hoppieProgress').val();
    $('#hoppieOutput').text(hoppieValue);

    // Update mental health output when the mental progress slider changes
    $('#mentalProgress').on('input change', function() {
        const value = $(this).val();
        $('#mental').text(value);
    });

    // Initialize mental health value on page load
    const initialMentalValue = $('#mentalProgress').val();
    $('#mental').text(initialMentalValue);
    
});