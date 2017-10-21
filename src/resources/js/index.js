$(document).ready(function() {
    var currentTab = 0;
    var isBraintreeValid = false;
    showTab(currentTab);
    // Radio box border
    $('.method').on('click', function() {
        $('.method').removeClass('blue-border');
        $(this).addClass('blue-border');
    });

    // Validation
    var $cardInput = $('.input-fields input');

    $('.next-btn').click((e) => {

        if (!validate()) {
        return false;
    }

    $('.step').each((index, item) => {
        if (!$(item).hasClass('active')) {
        hideTab(currentTab);
        currentTab += 1;
        showTab(currentTab);
        $(item).addClass('active');
        return false;
    }
});
});

    $('.back-btn').click((e) => {
        $($('.step').get().reverse()).each((index, item) => {
        if ($(item).hasClass('active')) {
        hideTab(currentTab);
        currentTab -= 1;
        showTab(currentTab);
        $(item).removeClass('active');
        return false;
    }
});
});

    $('#edit-btn').click((e) => {
        $('#amount').addClass('hidden');
    $('.edit-amount-input').removeClass('hidden');
    $('#edit-btn').addClass('hidden');
    $('#ok-btn').removeClass('hidden');
    $('#cancel-btn').removeClass('hidden');
});

    $('#cancel-btn').click((e) => {
        $('#amount').removeClass('hidden');
    $('.edit-amount-input').addClass('hidden');
    $('#edit-btn').removeClass('hidden');
    $('#ok-btn').addClass('hidden');
    $('#cancel-btn').addClass('hidden');
});

    $('#ok-btn').click((e) => {
        $('#amount').text($('.edit-amount-input').val() + '$');

    $('#amount').removeClass('hidden');
    $('.edit-amount-input').addClass('hidden');
    $('#edit-btn').removeClass('hidden');
    $('#ok-btn').addClass('hidden');
    $('#cancel-btn').addClass('hidden');
});

    braintree.dropin.create({
        authorization: 'sandbox_g42y39zw_348pk9cgf3bgyw2b',
        selector: '#dropin-container'
    }, function(err, instance) {
        if (err) {
            // An error in the create call is likely due to
            // incorrect configuration values or network issues
            return;
        }
        $('.btn').click(() => {
            instance.requestPaymentMethod((err, payload) => {
            if (err) {
                // An appropriate error will be shown in the UI
                return;
            }
            isBraintreeValid = true;
        $('#nonce').val(payload.nonce);
    });
    });
    });

    function validate() {
        let isValid = true;
        $('.tab').each((index, item) => {
            if (currentTab === index) {
            $(item).find('input').each((index, input) => {
                if ($(input).attr('required')) {
                if ($(input).val() === '') {
                    isValid = false;
                    $(input).addClass('error');
                } else {
                    $(input).removeClass('error');
                }
            }
        });
        }
    });

        return isValid;
    }

    function hideTab(n) {
        if (n - 1 <= 2) {
            let button = $('.next-btn');
            button.text('Next Step');
            button.type = 'button';
        }

        $('.tab').each((index, item) => {
            if (index === n) {
            $(item).hide();
        }
    });
    };

    function showTab(n) {
        if (n === 3) {
            let button = $('.next-btn');
            button.text('Submit');
            button.type = 'submit';
        }

        $('.tab').each((index, item) => {
            if (index === n) {
            $(item).show();
        }
    });
    };

});
