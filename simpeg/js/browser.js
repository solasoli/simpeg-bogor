
function isScrollBottom() {
  var documentHeight = $(document).height();
  var scrollPosition = $(window).height() + $(window).scrollTop();
  return (documentHeight == scrollPosition);
} 