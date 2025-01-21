$(document).ready(function() {
    const $acceptButton = $('#acceptAgreement');
    const $agreementContent = $('.agreement-content');
    let hasAcceptedAgreement = false;
    // Disable accept button initially
    $acceptButton.prop('disabled', true);
    // Handle checkbox change
    $(document).on('change', '#acceptCheck', function() {
        hasAcceptedAgreement = $(this).is(':checked');
        $acceptButton.prop('disabled', !hasAcceptedAgreement);
    });

    // Handle agreement acceptance
    $acceptButton.click(function() {
        if (hasAcceptedAgreement) {
            // localStorage.setItem('agreementAccepted', 'true');
            window.location.href = 'registration.php';
        }
    });
});