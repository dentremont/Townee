jQuery(document).ready(function() {

$('.all').jcarousel({
   vertical:true,
   visible:4,
   wrap: "both"
});
$(".tagSelect").click(function() {
		if( ! $(this).hasClass('checked') ) {
			$(this).addClass('checked');
			var input = $(this).attr("for");
			$(input).attr("checked", "checked");
		} else {
			$(this).removeClass('checked');
			var input = $(this).attr("for");
			$(input).attr("checked", "false");
		}
});
$(function() {
	var foo = $( ".sortable" ).sortable({
		connectWith: ".sortable",
		handle: ".portlet-header",
		update: function(event, ui) {
			var widgetOrder = $(this).sortable('toArray');
			var favs = $.post('users/favorites', {favorites:widgetOrder});
		}
	});
});
$('#townSelect').change(function() {
  var town = $('#townSelect').val();
  $.post('http://town.ee/home/location', {selected_town: town}, function() {
  	//location.reload();
  	window.location = "http://" + town + ".town.ee";
  });
  window.location = "http://" + town + ".town.ee";
});

});

