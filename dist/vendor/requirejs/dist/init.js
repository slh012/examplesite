$(document).ready(function(e){e(window).bind("load resize",function(){var t=e(window).height();e("#wrapper, #grid, #navBg").css({"min-height":t}),e("#content").css({"min-height":t-168})}),e("#grid").hide(),e(document.documentElement).keyup(function(t){t.keyCode==71&&e("#grid").fadeToggle(100)}),e(window).bind("load resize",function(){var t=e(window).height(),n=e("#nav").outerHeight();e("#nav").css("position",t<n?"":"fixed")}),e(".off-canvas-button").click(function(){e(this).toggleClass("open"),e("#nav").toggleClass("open")})});