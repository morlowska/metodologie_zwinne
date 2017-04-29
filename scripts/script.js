$(document).ready(function () {
    $('.err').click(function() {
        this.remove();
    });

    regErr = getParam('err');
    if (regErr == '1') {
        $("#header").after("<div class='err'>Wypełnij wszystkie pola!</div>");
        $('.err').click(function() {
            this.remove();
        });
    }
    else if (regErr == '2') {
        $("#header").after("<div class='err'>Niepoprawny adres E-mail.</div>");
        $('.err').click(function() {
            this.remove();
        });
    }
    else if (regErr == '3') {
        $("#header").after("<div class='err'>Problem z połączeniem się z bazą danych.</div>");
        $('.err').click(function() {
            this.remove();
        });
    }
    else if (regErr == '4') {
        $("#header").after("<div class='err'>Błąd podczas rejestracji.</div>");
        $('.err').click(function() {
            this.remove();
        });
    }
    else if (getParam('scs')) {
        $("#header").after("<div class='info'>Rejestracja przebiegła pomyślnie!</div>");
        $('.info').click(function() {
            this.remove();
        });
    }
});

/* Funkcja pobierająca wartość parametru GET
 * @param name - nazwa parametru metody GET
 * @return wartość parametru GET lub false w przypadku jego braku
 */
function getParam(name) {
    if (window.location.href.match(/.*\?.*/)) {
        var params = window.location.href.split('?')[1].split('&')
        for (i in params)
            if (params[i].split('=')[0] == name)
                return params[i].split('=')[1];
        return false;
    } else
        return false;
}