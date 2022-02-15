//Şifre Zorluk Kontrol Etme -- girilen değeri ve minimum şifre uzunluğunu gönder


function passwordStrength(password_id, min, append_element) {


    var strength_bar = password_id + "-strength-bar";

    if (!$("#" + strength_bar).length > 0) {

        $('#' + append_element).append(jQuery("<div/>", {
            id: strength_bar
        }));

        $("#" + strength_bar).append(jQuery("<span/>", {
            id: strength_bar + "-tooltip",
            class: 's-bar-tooltip',
        }))


    }
    var strength_total = passwordStrengthCompute($('#' + password_id).val(), min);

    if (strength_total <= 1) {

        $("#" + strength_bar).removeClass().addClass('strength-bar short bg-red w-30');
        $('#' + strength_bar + '-tooltip').text("En az 8 karakter giriniz");
        $("#" + password_id).removeClass('is-valid').removeClass('is-warning').addClass('is-invalid');

    } else {
        $("#" + password_id).removeClass('is-invalid').removeClass('is-warning').addClass('is-valid');
    }
    if (strength_total === 2) {
        $("#" + strength_bar).removeClass().addClass(' strength-bar weak bg-orange w-40');
        $('#' + strength_bar + '-tooltip').text("Güvenlik: Zayıf");

    }
    if (strength_total === 3) {
        $("#" + strength_bar).removeClass().addClass('strength-bar medium bg-yellow w-60');
        $('#' + strength_bar + '-tooltip').text("Güvenlik: Orta");

    }
    if (strength_total === 4) {
        $("#" + strength_bar).removeClass().addClass('strength-bar strong bg-success w-80');
        $('#' + strength_bar + '-tooltip').text("Güvenlik: Güçlü");

    }
    if (strength_total === 5) {
        $("#" + strength_bar).removeClass().addClass('strength-bar very-strong bg-success w-100');
        $('#' + strength_bar + '-tooltip').text("Güvenlik: Çok Güçlü");

    }

}

function passwordStrengthCompute(password, min) {

    var lowerCaseRegex = new RegExp("[a-z]");
    var upperCaseRegex = new RegExp("[A-Z]");
    var numbersRegex = new RegExp("[0-9]");
    var specialcharsRegex = new RegExp("([!,%,&,@,#,$,^,*,?,_,~,/,.,])");
    var chars, numbers, upperCase, lowerCase, specialChars;

    if (password.length >= min) {
        chars = 1;
    } else {
        chars = -3;
    }
    if (password.match(lowerCaseRegex)) {
        lowerCase = 1;
    } else {
        lowerCase = 0;
    }
    if (password.match(upperCaseRegex)) {
        upperCase = 1;
    } else {
        upperCase = 0;
    }
    if (password.match(numbersRegex)) {
        numbers = 1;
    } else {
        numbers = 0;
    }
    if (password.match(specialcharsRegex)) {
        specialChars = 1;
    } else {
        specialChars = 0;
    }


    return (chars + numbers + lowerCase + upperCase + specialChars);


}

function isSamePassword(first_password_id, second_password_id, min, append_element) {


    var is_same_bar = second_password_id + "-is-same-bar";

    if (!$("#" + is_same_bar).length > 0) {


        $('#' + append_element).append(jQuery("<div/>", {
            id: is_same_bar,
        }));
    }


    if (!$("#" + is_same_bar).length > 0) {
        $(append_element).append(jQuery("<div/>", {
            id: is_same_bar
        }));
    }


    if ($('#' + second_password_id).val() === $('#' + first_password_id).val()) {

        if ($('#' + second_password_id).val().length >= min) {

            $("#" + second_password_id).removeClass('is-invalid').removeClass('is-warning').addClass('is-valid');
            $("#" + is_same_bar).removeClass().addClass('is-same-bar bg-success w-100');
            $('#' + is_same_bar).text("Şifreler uyumlu");

        } else {

            $("#" + second_password_id).removeClass('is-valid').removeClass('is-warning').addClass('is-invalid');
            $("#" + is_same_bar).removeClass().addClass('is-same-bar bg-red w-100');
            $('#' + is_same_bar).text("Şifre en az 8 karakter içermelidir");


        }

    } else {

        $("#" + second_password_id).removeClass('is-valid').removeClass('is-warning').addClass('is-invalid');
        $("#" + is_same_bar).removeClass().addClass('is-same-bar weak bg-red w-100');
        $('#' + is_same_bar).text("Şifreler aynı değil");


    }


}

//Girilen değerin mail, gereklilik, minimum uzunluk şartlarını kontrol eder
function validateEmail(element_id, is_required) {
    var mailformat = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if (is_required) {
        if ($(element_id).val().match(mailformat)) {
            $(element_id).removeClass('is-invalid').removeClass('is-warning').addClass('is-valid');

        } else {
            $(element_id).removeClass('is-valid').removeClass('is-warning').addClass('is-invalid');

        }
    } else {
        if ($(element_id).val().length > 0) {
            if ($(element_id).val().match(mailformat)) {
                $(element_id).removeClass('is-invalid').removeClass('is-warning').addClass('is-valid');
            } else {
                $(element_id).removeClass('is-valid').removeClass('is-warning').addClass('is-invalid');
            }

        } else {
            $(element_id).removeClass('is-valid').removeClass('is-invalid').addClass('is-warning');
        }

    }
}

function validateInput(element_id, min, is_required) {
    if (is_required) {
        if ($(element_id).val().length >= min) {

            $(element_id).removeClass('is-invalid').removeClass('is-warning').addClass('is-valid');

        } else {
            $(element_id).removeClass('is-valid').removeClass('is-warning').addClass('is-invalid');

        }

    } else {

        if ($(element_id).val().length > 0) {

            if ($(element_id).val().length >= min) {
                $(element_id).removeClass('is-invalid').removeClass('is-warning').addClass('is-valid');


            } else {
                $(element_id).removeClass('is-valid').removeClass('is-warning').addClass('is-invalid');
            }

        } else {
            $(element_id).removeClass('is-invalid').removeClass('is-valid').addClass('is-warning');
        }

    }

}

function changeSidebarToggleIcon(element_id) {

    if ($(element_id).hasClass("rotate-180")) {

        $(element_id).removeClass("rotate-180").addClass("rotate-back");
        $(element_id).prop('title', 'Menüyü genişlet');
    }
    else
    {
        $(element_id).removeClass("rotate-back").addClass("rotate-180");
        $(element_id).prop('title', 'Menüyü daralt');
    }

}





