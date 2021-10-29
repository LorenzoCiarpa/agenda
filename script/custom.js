//START getGroups
function getGroups(){

    $.getJSON( "php/query.php", { command: 'getGroups' }, function( json ) {

        $.each( json.gruppi, function( i, group ) {

            var user_html =
                "<li class='gruppo' " + "\
                    data-id=" + group.id +
                    " data-nome='" + group.nome + "'" +
                ">" +

                    "<a>" +

                        "<h1>" +
                            group.nome +
                        "</h1>" +

                    "</a>" +

                "</li>";

            $("#ul-gruppi").append( user_html );
            $("#ul-gruppi-appuntamento").append( user_html );
            $("#ul-gruppi-sinistro").append( user_html );

        });

    });

}
//END getGroups

//START setGroup
function setGroup(gruppo_nome){

    $.ajax({
        url: "php/query.php",
        data: {
            "command": 'setGroup',
            "gruppo_nome": gruppo_nome
        },
        cache:false,
        type: "GET"
    }).always(function(gruppo_id) {
        console.log('grp_id: ' + gruppo_id);

        var group_html =
            "<li class='gruppo' " + "\
                data-id=" + gruppo_id +
                " data-nome='" + gruppo_nome + "'" +
            ">" +

                "<a>" +

                    "<h1>" +
                        gruppo_nome +
                    "</h1>" +

                "</a>" +

            "</li>";

        $("#ul-gruppi").append( group_html );
        $("#ul-gruppi-appuntamento").append( group_html );
        $("#ul-gruppi-sinistro").append( group_html );

        $('#ul-gruppi').listview('refresh');
        $('#ul-gruppi-appuntamento').listview('refresh');
        $('#ul-gruppi-sinistro').listview('refresh');

        $('#collapsible-gruppi').collapsible( "collapse" );
    });

}
//END setGroup

//START deleteGroup
function deleteGroup(gruppo_id){

    $.ajax({
        url: "php/query.php",
        data: {
            "command": 'deleteGroup',
            "gruppo_id": gruppo_id
        },
        cache: false,
        type: "GET"
    }).always(function() {
        $('li.gruppo[data-id="' + gruppo_id + '"]').hide();
        alert('Gruppo eliminato con successo.');
    });

}
//END deleteGroup

//START getUsers
function getUsers(gruppo_id, gruppo_nome, popup){

    $('#ul-utenti').empty();
    $('#gruppo-nome-h1').empty();

    $("#ul-utenti").append('<input id="gruppo-id" type="hidden" value="' + gruppo_id + '">');
    $("#gruppo-nome-h1").append(gruppo_nome);

    $.getJSON( "php/query.php", { command: 'getUsers', gruppo_id: gruppo_id }, function( json ) {

        $.each( json.utenti, function( i, user ) {

            var user_html =
                "<li class='utente'" +
                    " data-id=" + user.id +
                    " data-nome='" + user.nome + "'" +
                    " data-cognome='" + user.cognome + "'" +
                    " data-luogo_residenza='" + user.luogo_residenza + "'" +
                    " data-data_nascita='" + user.data_nascita + "'" +
                    " data-descrizione='" + window.btoa( user.descrizione ) + "'" +
                    " data-numero_telefono='" + user.numero_telefono + "'" +
                    " data-mail='" + user.mail + "'" +
                ">" +

                    "<a>" +

                        "<h1>" +
                            user.nome + " " + user.cognome +
                        "</h1>" +

                        "<p class='utente-descrizione'>" +

                        "</p>" +

                    "</a>" +

                "</li>";

            if(popup == 'date'){
              $("#ul-utenti-appuntamento").append( user_html );
            } else if (popup == 'claim'){
              $("#ul-utenti-sinistro").append( user_html );
            } else {
              $("#ul-utenti").append( user_html );
            }

        });

    })
    .complete(function() {

        if(popup == 'date'){

          $('#ul-utenti-appuntamento').listview('refresh');

          $('#interfaccia-utenti-appuntamento').show(300);
          $('#interfaccia-gruppi-appuntamento').hide(300);

        } else if(popup == 'claim'){

          $('#ul-utenti-sinistro').listview('refresh');

          $('#interfaccia-utenti-sinistro').show(300);
          $('#interfaccia-gruppi-sinistro').hide(300);

        } else {

          $('#ul-utenti').listview('refresh');

          $('#interfaccia-gruppi').hide(1000);
          $('#interfaccia-utenti').show(1000);

        }


    });

}
//END getUsers

//START getUsers
function getUser(utente_id){

    $.getJSON( "php/query.php", { command: 'getUser', utente_id: utente_id }, function( json ) {

      $.each( json.utente, function( i, user ) {

          $('#popup-utente-img').attr('data-id', user.id);

          $('#popup-utente-nome').val(user.nome);
          $('#popup-utente-cognome').val(user.cognome);

          $('#popup-utente-luogo_residenza').val(user.luogo_residenza);
          $('#popup-utente-data_nascita').val(user.data_nascita);
          $('#popup-utente-descrizione').val(user.descrizione);
          $('#popup-utente-numero_telefono').val(user.numero_telefono);
          $('#popup-utente-mail').val(user.mail);

          getFiles(utente_id);
          getClaims(utente_id);

      });

    })
    .complete(function() {
      $('#popup-utente-aggiungi').show();
      $('#popup-utente').popup('open');
    });

}
//END getUser

//START setUser
function setUser(gruppo_id, user_nome, user_cognome, user_luogo_residenza, user_data_nascita, user_descrizione, user_numero_telefono, user_mail){

    $.ajax({
        url: "php/query.php",
        data: {
            "command": 'setUser',
            "gruppo_id": gruppo_id,
            "user_nome": user_nome,
            "user_cognome": user_cognome,
            "user_luogo_residenza": user_luogo_residenza,
            "user_data_nascita": user_data_nascita,
            "user_descrizione": user_descrizione,
            "user_numero_telefono": user_numero_telefono,
            "user_mail": user_mail
        },
        cache: false,
        type: "GET"
    }).always(function(user_id) {
        var user_html =
            "<li class='utente' " + "\
                data-id=" + user_id +
                " data-nome='" + user_nome + "'" +
                " data-cognome='" + user_cognome + "'" +
                " data-luogo_residenza='" + user_luogo_residenza + "'" +
                " data-data_nascita='" + user_data_nascita + "'" +
                " data-descrizione='" + window.btoa( user_descrizione ) + "'" +
                " data-numero_telefono='" + user_numero_telefono + "'" +
                " data-mail='" + user_mail + "'" +
            ">" +

                "<a>" +

                    "<h1>" +
                        user_nome + " " + user_cognome +
                    "</h1>" +

                    "<p class='utente-descrizione'>" +

                    "</p>" +

                "</a>" +

            "</li>";

        $("#ul-utenti").append(user_html);
        $('#collapsible-utenti').collapsible( "collapse" );
        $('#ul-utenti').listview('refresh');
    });

}
//END setUser

//START deleteUser
function deleteUser(utente_id){

    $.ajax({
        url: "php/query.php",
        data: {
            "command": 'deleteUser',
            "utente_id": utente_id
        },
        cache: false,
        type: "GET"
    }).always(function() {
        $('li.utente[data-id="' + utente_id + '"]').hide();
        $('#calendar').fullCalendar( 'refetchEvents' );

        alert('Utente eliminato con successo.');
    });

}
//END deleteUser

//START updateUser
function updateUser(utente_id, user_nome, user_cognome, user_luogo_residenza, user_data_nascita, user_descrizione, user_numero_telefono, user_mail){

    $.ajax({
        url: "php/query.php",
        data: {
            "command": 'updateUser',
            "utente_id": utente_id,
            "user_nome": user_nome,
            "user_cognome": user_cognome,
            "user_luogo_residenza": user_luogo_residenza,
            "user_data_nascita": user_data_nascita,
            "user_descrizione": user_descrizione,
            "user_numero_telefono": user_numero_telefono,
            "user_mail": user_mail
        },
        cache: false,
        type: "GET"
    }).always(function() {

        var li_utente = $('li.utente[data-id="' + utente_id + '"]');

        li_utente.attr('data-nome', user_nome);
        li_utente.attr('data-cognome', user_cognome);
        li_utente.attr('data-luogo_residenza', user_luogo_residenza);
        li_utente.attr('data-data_nascita', user_data_nascita);
        li_utente.attr('data-descrizione', window.btoa(user_descrizione) );
        li_utente.attr('data-numero_telefono', user_numero_telefono);
        li_utente.attr('data-mail', user_mail);

        li_utente.find('h1').html(user_nome + ' ' + user_cognome);

        alert('Utente modificato con successo.');
    });

}
//END updateUser

//START viewUser
function viewUser(user_id, user_nome, user_cognome, user_luogo_residenza, user_data_nascita, user_descrizione, user_numero_telefono, user_mail){

    $('#popup-utente-img').attr('data-id', user_id);

    $('#popup-utente-nome').val(user_nome);
    $('#popup-utente-cognome').val(user_cognome);
    $('#popup-utente-luogo_residenza').val(user_luogo_residenza);
    $('#popup-utente-data_nascita').val(user_data_nascita);
    $('#popup-utente-descrizione').val( window.atob(user_descrizione) );
    $('#popup-utente-numero_telefono').val(user_numero_telefono);
    $('#popup-utente-mail').val(user_mail);

    getFiles(user_id);
    getClaims(user_id);

    $('#popup-utente-aggiungi').show();
    $('#popup-utente').popup('open');
}
//END viewUser

//START getNextDates
function getNextDates(){

    $("#ul-appuntamenti").empty();

    $.getJSON( "php/query.php", { command: 'getNextDates' }, function( json ) {

        $.each( json.appuntamenti, function( i, appuntamento ) {

            var date_html =
                  "<li class='appuntamento'" +
                    " date-id=" + appuntamento.id +
                    " date-utente_id='" + appuntamento.utente_id + "'" +
                    " date-title='" + appuntamento.title + "'" +
                    " date-start='" + appuntamento.start + "'" +
                    " date-luogo='" + appuntamento.luogo + "'" +
                    " date-descrizione='" + appuntamento.descrizione + "'" +
                  ">" +

                  "<a>" +

                        "<h1>" +
                            appuntamento.title +
                        "</h1>" +

                        "<p>" +
                            appuntamento.start.split(' ')[0] +
                        "</p>" +

                        "<p class='ui-li-aside'><strong>"+
                            appuntamento.start.split(' ')[1].slice(0, 5) +
                        "</strong></p>"+

                  "</a>" +

                "</li>";

            $("#ul-appuntamenti").append( date_html );

        });

    })
    .complete(function() {
        $('#ul-appuntamenti').listview('refresh');
    });

}
//END getNextDates

//START setDate
function setDate(utente_id, datetime, luogo, descrizione){

    $.ajax({
        url: "php/query.php",
        data: {
            "command": 'setDate',
            "appuntamento_utente_id": utente_id,
            "appuntamento_datetime": datetime,
            "appuntamento_luogo": luogo,
            "appuntamento_descrizione": descrizione
        },
        cache:false,
        type: "GET"
    }).always(function(appuntamento_id) {
        $('#calendar').fullCalendar( 'refetchEvents' );
        getNextDates();
        fixUsers();
        alert('Appuntamento creato con successo.');
    });

}
//END setDate

//START deleteDate
function deleteDate(appuntamento_id){

    $.ajax({
        url: "php/query.php",
        data: {
            "command": 'deleteDate',
            "appuntamento_id": appuntamento_id
        },
        cache:false,
        type: "GET"
    }).always(function() {
        $('#calendar').fullCalendar( 'refetchEvents' );
        getNextDates();

        alert('Appuntamento eliminato con successo.');
    });

}
//END deleteDate

//START updateDate
function updateDate(appuntamento_id, datetime, luogo, descrizione){

    $.ajax({
        url: "php/query.php",
        data: {
            "command": 'updateDate',
            "appuntamento_id": appuntamento_id,
            "appuntamento_datetime": datetime,
            "appuntamento_luogo": luogo,
            "appuntamento_descrizione": descrizione
        },
        cache:false,
        type: "GET"
    }).always(function() {
        $('#calendar').fullCalendar( 'refetchEvents' );
        getNextDates();

        alert('Appuntamento modificato con successo.');
    });

}
//END updateDate

//START viewDate
function viewDate(appuntamento_id, appuntamento_utente_id, appuntamento_title, appuntamento_start, appuntamento_luogo, appuntamento_descrizione){

    $('#popup-appuntamento-seleziona').hide();
    $('#popup-appuntamento-more').show();

    $('#popup-appuntamento-img').attr('data-id', appuntamento_id);

    $('#popup-appuntamento-title').attr('data-utente_id', appuntamento_utente_id);
    $('#popup-appuntamento-title').val(appuntamento_title);
    $('#popup-appuntamento-title').button("refresh");

    $('#popup-appuntamento-data').val(  appuntamento_start.split(' ')[0]  );
    $('#popup-appuntamento-orario').val(  appuntamento_start.split(' ')[1]  );

    if(appuntamento_luogo != "null"){
      $('#popup-appuntamento-luogo').val(appuntamento_luogo);
    }else{
      $('#popup-appuntamento-luogo').val('');
    };

    if(appuntamento_descrizione != "null"){
      $('#popup-appuntamento-descrizione').val(appuntamento_descrizione);
    }else{
      $('#popup-appuntamento-descrizione').val('');
    };

    $('#popup-appuntamento').popup('open');

}
//END viewDate

//START getFiles
function getFiles(utente_id){

    $("#ul-files").empty();

    $.getJSON( "php/query.php", { command: 'getFiles', utente_id: utente_id }, function( json ) {

        $.each( json.files, function( i, file ) {
            var date_html =
                  "<li class='file'" +
                    " date-id=" + file.id +
                    " date-nome='" + file.nome + "'" +
                  ">" +

                  "<a>" +

                        "<h1>" +
                            file.nome +
                        "</h1>" +

                  "</a>" +

                "</li>";

            $("#ul-files").append( date_html );

        });

    })
    .complete(function() {
        $('#ul-files').listview('refresh');
    });

}
//END getFiles

//START viewFile
function viewFile(file_id, file_nome, utente_id){
    $('#popup-file-nome').empty().append( file_nome );
    $('#popup-file-id').val( file_id );
    $('#popup-file-utente_id').val( utente_id );

    $('#popup-file').popup('open');
}
//END viewFile

//START deleteFile
function deleteFile(file_id, utente_id){
    $.ajax({
        url: "php/query.php",
        data: {
            "command": 'deleteFile',
            "file_id": file_id
        },
        cache:false,
        type: "GET"
    }).always(function() {
        getFiles(utente_id);
        alert('File eliminato con successo.');
    });
}
//END deleteFile

//START getClaims
function getClaims(utente_id){

    $("#ul-sinistri").empty();

    $.getJSON( "php/query.php", { command: 'getClaims', utente_id: utente_id }, function( json ) {

        $.each( json.sinistri, function( i, sinistro ) {
            var date_html =
                  "<li class='sinistro'" +
                    " date-id=" + sinistro.id +
                    " date-utente_id=" + sinistro.utente_id +

                    " date-data='" + sinistro.data + "'" +
                    " date-luogo='" + sinistro.luogo + "'" +
                    " date-compagnia_utente='" + sinistro.compagnia_utente + "'" +
                    " date-compagnia_controparte='" + sinistro.compagnia_controparte + "'" +
                    " date-diagnosi='" + sinistro.diagnosi + "'" +

                    " date-fisici_visite ='" + sinistro.fisici_visite + "'" +
                    " date-fisici_esami ='" + sinistro.fisici_esami + "'" +
                    " date-fisici_certificazione ='" + sinistro.fisici_certificazione + "'" +
                    " date-fisici_parte ='" + sinistro.fisici_parte + "'" +
                    " date-fisici_controparte ='" + sinistro.fisici_controparte + "'" +

                    " date-materiali_preventivo ='" + sinistro.materiali_preventivo + "'" +
                    " date-materiali_perizia ='" + sinistro.materiali_perizia + "'" +
                    " date-materiali_liquidazione ='" + sinistro.materiali_liquidazione + "'" +

                    " date-attivo=" + sinistro.attivo +
                  ">" +

                  "<a>" +

                        "<h1>" +
                            sinistro.data +
                        "</h1>" +

                  "</a>" +

                "</li>";

            $("#ul-sinistri").append( date_html );

        });

    })
    .complete(function() {
        $('#ul-sinistri').listview('refresh');
    });

}
//END getClaims

//START getActiveClaims
function getActiveClaims(){

    $("#ul-sinistri-attivi").empty();

    $.getJSON( "php/query.php", { command: 'getActiveClaims' }, function( json ) {

        $.each( json.sinistri, function( i, sinistro ) {
            var date_html =
                  "<li class='sinistro'" +
                    " date-id=" + sinistro.id +
                    " date-utente_id=" + sinistro.utente_id +

                    " date-data='" + sinistro.data + "'" +
                    " date-luogo='" + sinistro.luogo + "'" +
                    " date-compagnia_utente='" + sinistro.compagnia_utente + "'" +
                    " date-compagnia_controparte='" + sinistro.compagnia_controparte + "'" +
                    " date-diagnosi='" + sinistro.diagnosi + "'" +

                    " date-fisici_visite ='" + sinistro.fisici_visite + "'" +
                    " date-fisici_esami ='" + sinistro.fisici_esami + "'" +
                    " date-fisici_certificazione ='" + sinistro.fisici_certificazione + "'" +
                    " date-fisici_parte ='" + sinistro.fisici_parte + "'" +
                    " date-fisici_controparte ='" + sinistro.fisici_controparte + "'" +

                    " date-materiali_preventivo ='" + sinistro.materiali_preventivo + "'" +
                    " date-materiali_perizia ='" + sinistro.materiali_perizia + "'" +
                    " date-materiali_liquidazione ='" + sinistro.materiali_liquidazione + "'" +

                    " date-attivo=" + sinistro.attivo +

                    " date-nome='" + sinistro.nome + "'" +
                    " date-cognome='" + sinistro.cognome + "'" +
                  ">" +

                  "<a>" +

                        "<h1>" +
                            sinistro.nome + " " + sinistro.cognome + " - " + sinistro.data +
                        "</h1>" +

                  "</a>" +

                "</li>";

            $("#ul-sinistri-attivi").append( date_html );

        });

    })
    .complete(function() {
        $('#ul-sinistri-attivi').listview().listview('refresh');
    });

}
//END getActiveClaims

//START getUnactiveClaims
function getUnactiveClaims(){

    $("#ul-sinistri-non-attivi").empty();

    $.getJSON( "php/query.php", { command: 'getUnactiveClaims' }, function( json ) {

        $.each( json.sinistri, function( i, sinistro ) {
            var date_html =
                  "<li class='sinistro'" +
                    " date-id=" + sinistro.id +
                    " date-utente_id=" + sinistro.utente_id +

                    " date-data='" + sinistro.data + "'" +
                    " date-luogo='" + sinistro.luogo + "'" +
                    " date-compagnia_utente='" + sinistro.compagnia_utente + "'" +
                    " date-compagnia_controparte='" + sinistro.compagnia_controparte + "'" +
                    " date-diagnosi='" + sinistro.diagnosi + "'" +

                    " date-fisici_visite ='" + sinistro.fisici_visite + "'" +
                    " date-fisici_esami ='" + sinistro.fisici_esami + "'" +
                    " date-fisici_certificazione ='" + sinistro.fisici_certificazione + "'" +
                    " date-fisici_parte ='" + sinistro.fisici_parte + "'" +
                    " date-fisici_controparte ='" + sinistro.fisici_controparte + "'" +

                    " date-materiali_preventivo ='" + sinistro.materiali_preventivo + "'" +
                    " date-materiali_perizia ='" + sinistro.materiali_perizia + "'" +
                    " date-materiali_liquidazione ='" + sinistro.materiali_liquidazione + "'" +

                    " date-attivo=" + sinistro.attivo +

                    " date-nome='" + sinistro.nome + "'" +
                    " date-cognome='" + sinistro.cognome + "'" +
                  ">" +

                  "<a>" +

                        "<h1>" +
                            sinistro.nome + " " + sinistro.cognome + " - " + sinistro.data +
                        "</h1>" +

                  "</a>" +

                "</li>";

            $("#ul-sinistri-non-attivi").append( date_html );

        });

    })
    .complete(function() {
        $('#ul-sinistri-non-attivi').listview().listview('refresh');
    });

}
//END getUnactiveClaims

//START setClaim
function setClaim(
  utente_id,
  sinistro_data,
  sinistro_luogo,
  sinistro_compagnia_utente,
  sinistro_compagnia_controparte,
  sinistro_diagnosi,
  sinistro_fisici_visite,
  sinistro_fisici_esami,
  sinistro_fisici_certificazione,
  sinistro_fisici_parte,
  sinistro_fisici_controparte,
  sinistro_materiali_preventivo,
  sinistro_materiali_perizia,
  sinistro_materiali_liquidazione,
  sinistro_attivo
){

    $.ajax({
        url: "php/query.php",
        data: {
            "command": 'setClaim',
            "sinistro_utente_id": utente_id,
            "sinistro_data": sinistro_data,
            "sinistro_luogo": sinistro_luogo,
            "sinistro_compagnia_utente": sinistro_compagnia_utente,
            "sinistro_compagnia_controparte": sinistro_compagnia_controparte,
            "sinistro_diagnosi": sinistro_diagnosi,
            "sinistro_fisici_visite": sinistro_fisici_visite,
            "sinistro_fisici_esami": sinistro_fisici_esami,
            "sinistro_fisici_certificazione": sinistro_fisici_certificazione,
            "sinistro_fisici_parte": sinistro_fisici_parte,
            "sinistro_fisici_controparte": sinistro_fisici_controparte,
            "sinistro_materiali_preventivo": sinistro_materiali_preventivo,
            "sinistro_materiali_perizia": sinistro_materiali_perizia,
            "sinistro_materiali_liquidazione": sinistro_materiali_liquidazione,
            "sinistro_attivo": sinistro_attivo
        },
        cache:false,
        type: "GET"
    }).always(function(sinistro_id) {
        getActiveClaims();
        getUnactiveClaims();
        fixUsers();
        alert('Sinistro creato con successo.');
    });

}
//END setClaim

//START deleteClaim
function deleteClaim(sinistro_id){

    $.ajax({
        url: "php/query.php",
        data: {
            "command": 'deleteClaim',
            "sinistro_id": sinistro_id
        },
        cache:false,
        type: "GET"
    }).always(function() {
        getActiveClaims();
        getUnactiveClaims();
        alert('Sinistro eliminato con successo.');
    });

}
//END deleteClaim

//START updateClaim
function updateClaim(
    sinistro_id,
    sinistro_data, sinistro_luogo,
    sinistro_compagnia_utente, sinistro_compagnia_controparte,
    sinistro_diagnosi,
    sinistro_fisici_visite, sinistro_fisici_esami, sinistro_fisici_certificazione,
    sinistro_fisici_parte, sinistro_fisici_controparte,
    sinistro_materiali_preventivo, sinistro_materiali_perizia, sinistro_materiali_liquidazione,
    sinistro_attivo
  ){

    $.ajax({
        url: "php/query.php",
        data: {
            "command": 'updateClaim',
            "sinistro_id": sinistro_id,
            "sinistro_data": sinistro_data,
            "sinistro_luogo": sinistro_luogo,
            "sinistro_compagnia_utente": sinistro_compagnia_utente,
            "sinistro_compagnia_controparte": sinistro_compagnia_controparte,
            "sinistro_diagnosi": sinistro_diagnosi,
            "sinistro_fisici_visite": sinistro_fisici_visite,
            "sinistro_fisici_esami": sinistro_fisici_esami,
            "sinistro_fisici_certificazione": sinistro_fisici_certificazione,
            "sinistro_fisici_parte": sinistro_fisici_parte,
            "sinistro_fisici_controparte": sinistro_fisici_controparte,
            "sinistro_materiali_preventivo": sinistro_materiali_preventivo,
            "sinistro_materiali_perizia": sinistro_materiali_perizia,
            "sinistro_materiali_liquidazione": sinistro_materiali_liquidazione,
            "sinistro_attivo": sinistro_attivo
        },
        cache:false,
        type: "GET"
    }).always(function() {
        getActiveClaims();
        getUnactiveClaims();
        alert('Sinistro modificato con successo.');
    });

}
//END updateClaim

//START viewClaim
function viewClaim(
      sinistro_id, sinistro_utente_id, sinistro_title,
      sinistro_data, sinistro_luogo,
      sinistro_compagnia_utente, sinistro_compagnia_controparte,
      sinistro_diagnosi,
      sinistro_fisici_visite, sinistro_fisici_esami, sinistro_fisici_certificazione,
      sinistro_fisici_parte, sinistro_fisici_controparte,
      sinistro_materiali_preventivo, sinistro_materiali_perizia, sinistro_materiali_liquidazione,
      sinistro_attivo
    ){

    //Nascondi, Mostra
    $('#popup-sinistro-seleziona').hide();
    $('#popup-sinistro-more').show();

    //Sinistro ID
    $('#popup-sinistro-img').attr('data-id', sinistro_id);

    //Nome e Cognome
    $('#popup-sinistro-title').attr('data-utente_id', sinistro_utente_id);
    $('#popup-sinistro-title').val(sinistro_title);
    $('#popup-sinistro-title').button("refresh");

    //Data, Luogo, Compagnia { Utente, Controparte }, Diagnosi
    if(sinistro_data != "null"){
      $('#popup-sinistro-data').val(sinistro_data);
    }else{
      $('#popup-sinistro-data').val('');
    };
    if(sinistro_luogo != "null"){
      $('#popup-sinistro-luogo').val(sinistro_luogo);
    }else{
      $('#popup-sinistro-luogo').val('');
    };
    if(sinistro_compagnia_utente != "null"){
      $('#popup-sinistro-compagnia-utente').val(sinistro_compagnia_utente);
    }else{
      $('#popup-sinistro-compagnia-utente').val('');
    };
    if(sinistro_compagnia_controparte != "null"){
      $('#popup-sinistro-compagnia-controparte').val(sinistro_compagnia_controparte);
    }else{
      $('#popup-sinistro-compagnia-controparte').val('');
    };
    if(sinistro_diagnosi != "null"){
      $('#popup-sinistro-diagnosi').val(sinistro_diagnosi);
    }else{
      $('#popup-sinistro-diagnosi').val('');
    };

    //Danni Fisici { Visite, Esami, Certificazione, Parte, Controparte }
    if(sinistro_fisici_visite != "null"){
      $('#popup-sinistro-fisici-visite').val(sinistro_fisici_visite);
    }else{
      $('#popup-sinistro-fisici-visite').val('');
    };
    if(sinistro_fisici_esami != "null"){
      $('#popup-sinistro-fisici-esami').val(sinistro_fisici_esami);
    }else{
      $('#popup-sinistro-fisici-esami').val('');
    };
    if(sinistro_fisici_certificazione != "null"){
      $('#popup-sinistro-fisici-certificazione').val(sinistro_fisici_certificazione);
    }else{
      $('#popup-sinistro-fisici-certificazione').val('');
    };
    if(sinistro_fisici_parte != "null"){
      $('#popup-sinistro-fisici-parte').val(sinistro_fisici_parte);
    }else{
      $('#popup-sinistro-fisici-parte').val('');
    };
    if(sinistro_fisici_controparte != "null"){
      $('#popup-sinistro-fisici-controparte').val(sinistro_fisici_controparte);
    }else{
      $('#popup-sinistro-fisici-controparte').val('');
    };

    //Danni Materiali { Preventivo, Perizia, Liquidazione }
    if(sinistro_materiali_preventivo != "null"){
      $('#popup-sinistro-materiali-preventivo').val(sinistro_materiali_preventivo);
    }else{
      $('#popup-sinistro-materiali-preventivo').val('');
    };
    if(sinistro_materiali_perizia != "null"){
      $('#popup-sinistro-materiali-perizia').val(sinistro_materiali_perizia);
    }else{
      $('#popup-sinistro-materiali-perizia').val('');
    };
    if(sinistro_materiali_liquidazione != "null"){
      $('#popup-sinistro-materiali-liquidazione').val(sinistro_materiali_liquidazione);
    }else{
      $('#popup-sinistro-materiali-liquidazione').val('');
    };

    //Attivo
    if(sinistro_attivo == '1'){
      $('#popup-sinistro-attivo').val('1').trigger("change");
    }else{
      $('#popup-sinistro-attivo').val('0').trigger("change");
    }

    $('#popup-sinistro').popup('open');

}
//END viewClaim

function fixUsers(){
  $('#interfaccia-gruppi').show(1000);
  $('#interfaccia-utenti').hide(1000);
}

function getCookie(name) {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    }
    else
    {
        begin += 2;
        var end = document.cookie.indexOf(";", begin);
        if (end == -1) {
        end = dc.length;
        }
    }
    // because unescape has been deprecated, replaced with decodeURI
    //return unescape(dc.substring(begin + prefix.length, end));
    return decodeURI(dc.substring(begin + prefix.length, end));
}

var deleteCookie = function(name) {
    document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/';
};
