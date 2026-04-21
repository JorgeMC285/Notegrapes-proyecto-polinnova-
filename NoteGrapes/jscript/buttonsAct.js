function cancelar(){
    let element = document.querySelectorAll(".codForm");
    //alert('Hola');
    element.forEach(function(el){
        el.style.display = "none";
    });
}