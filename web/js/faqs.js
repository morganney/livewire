$(document).ready(function() {
  $('#faqs li').click(function() {
    $(this).find('p').slideToggle();
    $(this).toggleClass("down");
  });
});


