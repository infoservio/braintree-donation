$(document).ready(function() {
    let currentTab = 0;
    let isBraintreeValid = false;
    showTab(currentTab);
    // Radio box border
    $('.method').on('click', function() {
        $('.method').removeClass('blue-border');
        $(this).addClass('blue-border');
    });

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
                // Submit payload.nonce to your server
            });
        });
    });

    function validate() {
        let isValid = true;
        $('.tab').each((index, item) => {
            if (currentTab === index) {
                $(item).find('input').each((index, input) => {
                    if($(input).attr('required')) {
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
        if (n-1 <= 2) {
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

});
