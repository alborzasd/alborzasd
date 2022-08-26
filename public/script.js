const menuToggle = document.querySelector('.menu-toggle');
const navigation = document.querySelector('.navigation');

menuToggle.addEventListener('click', function() {
    menuToggle.classList.toggle('active');
    navigation.classList.toggle('active');
    if(menuToggle.classList.contains('active')) {
        menuToggle.innerHTML = '<i class="fas fa-times"></i>';
    } else {
        menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
    }
});



//https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_shrink_header_scroll
// add background to header when scroll down
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    var jsHeader = document.getElementById("js-header");
    // var jsNav = document.getElementById("js-nav");
  if (document.body.scrollTop > 290 || document.documentElement.scrollTop > 290) {
    jsHeader.style.backgroundColor = "#fff";
    // jsNav.style.backgroundColor = "#fff"; // does not work on mobile!
    jsHeader.style.boxShadow = "rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.05) 0px 4px 6px -2px"
  } else {
    jsHeader.style.backgroundColor = "rgba(0, 0, 0, 0)";
    // jsNav.style.backgroundColor = "rgba(0, 0, 0, 0)";
    jsHeader.style.boxShadow = "none";
  }
}