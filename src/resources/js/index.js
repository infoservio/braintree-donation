$(document).ready(function () {
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

    $('.success-logo').attr('src', '../img/success.png');

    $(document).keypress(function(e) {
        if(e.which == 13) {
            $('.next-btn').click();
        }
    });

    $(".next-btn").dblclick(function (e) {
        e.preventDefault();
    });

    $(".back-btn").dblclick(function (e) {
        e.preventDefault();
    });

    $('.next-btn').click((e) => {

        if (currentTab === 2) {
            return;
        }

        if (currentTab === 3) {
            console.log('submit');
            showSpinner();
            $('#payForm').submit();
            return;
        }

        if (!validate()) {
            return false;
        }

        clickBtn(1);

    });

    $('.back-btn').click((e) => {
        clickBtn(-1);
    });

    $('#edit-btn').click((e) => {
        $('#sum').addClass('hidden');
        $('.edit-amount-input').removeClass('hidden');
        $('#edit-btn').addClass('hidden');
        $('#ok-btn').removeClass('hidden');
        $('#cancel-btn').removeClass('hidden');
    });

    $('#cancel-btn').click((e) => {
        $('#sum').removeClass('hidden');
        $('.edit-amount-input').addClass('hidden');
        $('#edit-btn').removeClass('hidden');
        $('#ok-btn').addClass('hidden');
        $('#cancel-btn').addClass('hidden');
    });

    $('#ok-btn').click((e) => {
        let amount = $('.edit-amount-input').val();
        if (amount <= 0) {
            $('.edit-amount-input').addClass('error');
            return;
        }
        $('.edit-amount-input').removeClass('error');
        $('#sum').text(amount + '$');
        $('#sum').removeClass('hidden');

        $('#amount').val(amount);

        $('.edit-amount-input').addClass('hidden');
        $('#edit-btn').removeClass('hidden');
        $('#ok-btn').addClass('hidden');
        $('#cancel-btn').addClass('hidden');
    });

    $('#country').change((e) => {
        if ($('#country').val() == defaultCountryId) {
            $('#state-select').removeClass('hidden');
            $('#state-input').addClass('hidden');
        } else {
            $('#state-select').addClass('hidden');
            $('#state-input').removeClass('hidden');
        }
    });

    braintree.dropin.create({
        authorization: btAuthorization,
        container: '#dropin-container',
        paypal: {
            flow: 'vault'
        }
    }, function (err, instance) {
        if (err) {
            // An error in the create call is likely due to
            // incorrect configuration values or network issues
            return;
        }
        $('.next-btn').click((e) => {
            if (currentTab === 2) {
                instance.requestPaymentMethod((err, payload) => {
                    if (err) {
                        // An appropriate error will be shown in the UI
                        return;
                    }
                    $('#nonce').val(payload.nonce);

                    createResultPage();

                    clickBtn(1);
                });
            }
        });
    })

    function validate() {
        let isValid = true;
        let isBraintreeValid = true;

        $('.tab').each((index, item) => {
            if (currentTab === index) {
                $(item).find('input').each((index, input) => {
                    console.log($(input).attr('id'));
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

                            if ($(input).attr('id') == 'phone') {
                                if (validatePhone($(input).val())) {
                                    isValid = true;
                                    $(input).removeClass('error');
                                } else {
                                    isValid = false;
                                    $(input).addClass('error');
                                }
                            }

                            if ($(input).attr('id') == 'postalCode') {
                                if (validatePostalCode($(input).val())) {
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
        return isValid;
    }

    function createResultPage() {
        let state = ($('#state-select').hasClass('hidden') ? ($('#state-input').val()) : $('#state-select option:selected').text());

        $('#resultFirstName').text($('#firstName').val());
        $('#resultLastName').text($('#lastName').val());
        $('#resultEmail').text($('#email').val());
        $('#resultPhone').text($('#phone').val());
        $('#resultCompany').text($('#company').val());
        $('#resultCountry').text($('#country option:selected').text());
        $('#resultState').text(state);
        $('#resultCity').text($('#city').val());
        $('#resultAddress').text($('#address').val());
        $('#resultPostalCode').text($('#postalCode').val());
        let extendedAddress = $('#extendedAddress').val() ? $('#extendedAddress').val() : '-';
        $('#resultExtendedAddress').text(extendedAddress);
    }

    function clickBtn(next) {
        if (next === -1) {
            $($('.step').get().reverse()).each((index, item) => {
                if ($(item).hasClass('active')) {
                    changeTab(next);
                    $(item).removeClass('active');
                    return false;
                }
            });
        } else {
            $(".btn").attr('disabled', 'disabled');
            showSpinner();
            setTimeout(() => {
                $(".btn").removeAttr('disabled');
                stopSpinner();
                $('.step').each((index, item) => {
                    if (!$(item).hasClass('active')) {
                        changeTab(next);
                        $(item).addClass('active');
                        return false;
                    }
                });
            }, 1000);
        }
    }

    function changeTab(next) {
        hideTab(currentTab);
        currentTab += next;
        showTab(currentTab);
    }

    function hideTab(n) {
        if (n - 1 <= 2) {
            let button = $('.next-btn');
            button.text('Next Step');
            button.attr('type', 'button');
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
            button.attr('type', 'submit');
        }

        $('.tab').each((index, item) => {
            if (index > 3) {
                return false;
            }

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

    function validatePostalCode(postalCode) {
        var re = /^\d{5}(?:[-\s]\d{4})?$/;
        return re.test(postalCode);
    }

});
