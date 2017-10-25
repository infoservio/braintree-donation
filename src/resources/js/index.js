$(document).ready(function() {

    var isBraintreeValid = true;
    var isBraintreeCreated = false;

    var opts = {
        lines: 12, // The number of lines to draw
        length: 18, // The length of each line
        width: 6, // The line thickness
        radius: 30, // The radius of the inner circle
        corners: 1, // Corner roundness (0..1)
        rotate: 0, // The rotation offset
        direction: 1, // 1: clockwise, -1: counterclockwise
        color: '#f62f5e', // #rgb or #rrggbb or array of colors
        speed: 1, // Rounds per second
        trail: 60, // Afterglow percentage
        shadow: false, // Whether to render a shadow
        hwaccel: false, // Whether to use hardware acceleration
        className: 'spinner', // The CSS class to assign to the spinner
        zIndex: 2e9, // The z-index (defaults to 2000000000)
        top: '50%', // Top position relative to parent
        left: '50%' // Left position relative to parent
    };

    var target = document.body;
    var spinner = new Spinner(opts);


    var currentTab = 0;
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

    showSpinner();
    setTimeout(() => {
        stopSpinner();
    $('.step').each((index, item) => {
        if (!$(item).hasClass('active')) {
        hideTab(currentTab);
        currentTab += 1;
        if (!isBraintreeCreated && currentTab === 2) {
            isBraintreeCreated = true;
            createBraintree();
        }
        showTab(currentTab);
        $(item).addClass('active');
        return false;
    }
});
}, 1000);
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

    $('#country').change((e) => {
        if ($('#country').val() !== USA) {
        $('#state-select').addClass('hidden');
        $('#state-input').removeClass('hidden');
    } else {
        $('#state-select').removeClass('hidden');
        $('#state-input').addClass('hidden');
    }
});

    function createBraintree() {
        braintree.dropin.create({
            authorization: 'sandbox_g42y39zw_348pk9cgf3bgyw2b',
            selector: '#dropin-container'
        }, function(err, instance) {
            if (err) {
                isBraintreeValid = false;
                // An error in the create call is likely due to
                // incorrect configuration values or network issues
                return;
            }
            $('.btn').click(() => {
                instance.requestPaymentMethod((err, payload) => {
                if (err) {
                    isBraintreeValid = false;
                    // An appropriate error will be shown in the UI
                    return;
                }
                isBraintreeValid = true;
            alert(payload.nonce);
            $('#nonce').val(payload.nonce);
        });
        });
        });
    }

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

                    if ($(input).attr('id') == 'email') {
                        if (validateEmail($(input).val())) {
                            isValid = true;
                            $(input).removeClass('error');
                        } else {
                            isValid = false;
                            $(input).addClass('error');
                        }
                    }
                }
            }
        });
        }
    });

        if (!isBraintreeValid) {
            isValid = false;
        }

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
    }

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
    }

    function showSpinner() {
        spinner.spin(target);
        $('.overlay').show();
    }

    function stopSpinner() {
        spinner.stop(target);
        $('.overlay').hide();
    }

    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    function validatePhone(phone) {
        var re = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;
        return re.test(phone);
    }

});
