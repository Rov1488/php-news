//Initialize the plugin JQZoomer by calling the function on the top container.
//$(".demo").jqzoomer();

// Get the modal
/*var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("myImg");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}*/

//delet-item
$('.delete').on('click', function () {
    //e.preventDefault();
    let res = confirm('Подтвердите действие');
    if(!res) return false;
});

//select2 bootstrap-5 settings
$( '#multiple-select-clear-field' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
    closeOnSelect: false,
    allowClear: true,
} );

$( '#small-select2-options-single-field' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
    selectionCssClass: 'select2--small',
    dropdownCssClass: 'select2--small',
    //allowClear: true,
} );

$( '#small-select2-options-multiple-field' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
    closeOnSelect: false,
    //allowClear: true,
    selectionCssClass: 'select2--small',
    dropdownCssClass: 'select2--small',
} );
