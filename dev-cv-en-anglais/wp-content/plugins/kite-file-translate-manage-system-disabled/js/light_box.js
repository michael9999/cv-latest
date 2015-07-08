var j=jQuery.noConflict();
j(document).ready(function()
{
	var mY = 0;
	var mX = 0;

	j(document).mousemove(function(event) {
		mY = event.pageY;
		mX = event.pageX;
	});

	j('.newFrm').click(function(event)
	{
		//var val = j(this).attr('href');
		//var title = j(this).attr('title');
                var val = j(this).attr('href');
                var id=j(this).attr('id');
                var id_array=id.split("_");
                var title = j("#title_id_"+id_array[2]).val();
                j(".lightBoxTbl").addClass("show")
                var data=j("#l_info_"+id_array[2]).html();
		loadOverlay();
                showDialog(title,data);
		event.preventDefault();return false;
	});



});

function showDialog(title,data)
{
	j('#loadingTxt').fadeOut();
       
	j('#lightText').html(data);
	j('#lightBoxTitle').html(title);
	j('#lightBox').fadeIn('slow');
	j('html, body').animate({scrollTop:0}, 'slow');
}

function loadOverlay()
{
	j('#black_overlay').css({height:j(document).height(), width:j(document).width()}).show();
	j('#loadingTxt').fadeIn('slow');
	j('html, body').animate({top:'0px'},200);
}

function hideOverlay()
{
	j('#loadingTxt,#lightBox').fadeOut('slow');
	j('#black_overlay').hide();
}

