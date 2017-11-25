$.fn.digits = function(){
    return this.each(function(){
        $(this).text( $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") );
    })
};

$(document).ready(function () {
    // set main color
    document.body.style.setProperty('--main-color', mainColor);

    var isBraintreeCreated = false;

    var opts = {
        lines: 12, // The number of lines to draw
        length: 18, // The length of each line
        width: 6, // The line thickness
        radius: 30, // The radius of the inner circle
        corners: 1, // Corner roundness (0..1)
        rotate: 0, // The rotation offset
        direction: 1, // 1: clockwise, -1: counterclockwise
        color: mainColor, // #rgb or #rrggbb or array of colors
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

    $('#sum').digits();

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

        if (currentTab === paymentOrder) {
            return;
        }

        if (currentTab === 2) {
            createResultPage();
        }

        if (currentTab === 3) {
            console.log('submit');
            $('.btn').unbind('mouseout');
            showSpinner();
            $('#payForm').submit();
            return;
        }

        if (!validate()) {
            return false;
        }

        $('.next-btn').unbind('mouseout');

        clickBtn(1);

    });

    $('.back-btn').click((e) => {
        clickBtn(-1);
    });

    $('#edit-btn').click((e) => {
        // init
        let amount = $('#sum').text();
        amount = amount.replace('$ ', '');
        amount = amount.replace(/,/g, '');
        $('.edit-amount-input').val(amount);
        $('.edit-amount-input').removeClass('error');


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
        $('#sum').text('$ ' + amount);
        $('#sum').digits()
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
            $('#state-input').removeAttr('required');
        } else {
            $('#state-select').addClass('hidden');
            $('#state-input').removeClass('hidden');
            $('#state-input').attr('required', true);
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
            if (currentTab === paymentOrder) {
                instance.requestPaymentMethod((err, payload) => {
                    if (err) {
                        // An appropriate error will be shown in the UI
                        $('.payment-error').removeClass('hidden');
                        return;
                    }
                    $('.payment-error').addClass('hidden');
                    $('#nonce').val(payload.nonce);

                    clickBtn(1);
                });
            }

            if (currentTab === 2) {
                createResultPage();
            }
        });
    })

    function validate() {
        let isValid = [];

        $('.tab').each((index, item) => {
            if (currentTab === index) {
                $(item).find('input').each((index, input) => {
                    if ($(input).attr('required')) {
                        if ($(input).val() === '') {
                            console.log({name: $(input).attr('id'), value: $(input).val()});
                            isValid[index] = false;
                            $(input).addClass('error');
                        } else {
                            $(input).removeClass('error');

                            if ($(input).attr('id') == 'email') {
                                if (validateEmail($(input).val())) {
                                    isValid[index] = true;
                                    $(input).removeClass('error');
                                } else {
                                    isValid[index] = false;
                                    $(input).addClass('error');
                                }
                            }

                            // if ($(input).attr('id') == 'phone') {
                            //     if (validatePhone($(input).val())) {
                            //         isValid[index] = true;
                            //         $(input).removeClass('error');
                            //     } else {
                            //         isValid[index] = false;
                            //         $(input).addClass('error');
                            //     }
                            // }

                            // if ($(input).attr('id') == 'postalCode') {
                            //     if (validatePostalCode($(input).val())) {
                            //         isValid[index] = true;
                            //         $(input).removeClass('error');
                            //     } else {
                            //         isValid[index] = false;
                            //         $(input).addClass('error');
                            //     }
                            // }
                        }
                    }
                });
            }
        });
        let result = true;
        isValid.forEach(item => {
            if (!item)
                result = item;
        });
        return result;
    }

    function createResultPage() {
        let state = ($('#state-select').hasClass('hidden') ? ($('#state-input').val()) : $('#state-select option:selected').text());

        $('#resultFirstName').text($('#firstName').val());
        $('#resultLastName').text($('#lastName').val());
        $('#resultEmail').text($('#email').val());
        $('#resultPhone').text($('#phone').val());
        $('#resultCountry').text($('#country option:selected').text());
        $('#resultState').text(state);
        $('#resultCity').text($('#city').val());
        $('#resultAddress').text($('#address').val());
        $('#resultPostalCode').text($('#postalCode').val());
        
        let company = $('#company').val() ? $('#company').val() : '-';
        $('#resultCompany').text(company);

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
            $('.btn').attr('disabled', 'disabled');

            showSpinner();
            setTimeout(() => {
                $('.btn').removeAttr('disabled');
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
        disableBackButton();
        showTab(currentTab);
    }

    function disableBackButton() {
        if (currentTab > 0) {
            $('.back-btn').attr('disabled', false);
        }  else {
            $('.back-btn').attr('disabled', true);
        }
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

    // function validatePostalCode(postalCode) {
    //     var re = /^\d{3,5}(?:[-\s]\d{4})?$/;
    //     return re.test(postalCode);
    // }

});
