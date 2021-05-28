/*!
* Start Bootstrap - Simple Sidebar v6.0.0 (https://startbootstrap.com/template/simple-sidebar)
* Copyright 2013-2021 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-simple-sidebar/blob/master/LICENSE)
*/
//
// Scripts
//

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});

document.getElementById("gh-toggler").onclick = function (){
    var children = [].slice.call(this.children);

    children.forEach(element => {
        if(element.classList.contains('left-dor')){
            if(element.classList.contains('bxs-chevron-left')){
                element.classList.remove('bxs-chevron-left');
                element.classList.add('bxs-chevron-down');
            }else {
                element.classList.add('bxs-chevron-left');
                element.classList.remove('bxs-chevron-down');
            }


        }

    });

}
