$( function() {
    $( "#sortable" ).sortable({
        cancel: ".disable-sort-item",
        update: function( event, ui ) {
            $('#sortable li').each(function (index) {
                $(this).find('input').val(index + 1)
            });
        }
    });
    $( "#sortable" ).disableSelection();
});