$(document).ready(function() {
	$('form[name=page_edit]').submit(function(){
		if (!isInterger($('input[name=pagenbr]').val())) {
			alert('Please enter a valid Paging Extension');
			return false;
		}
	});
});

//make devlist heights the same
function dev_list_height() {
	var height = 0;
	$('.device_list').height('auto').each(function(){
		height = $(this).height() > height ? $(this).height() : height;
	}).height(height);
}

function dev_list_item_width() {
	var width = 0;
	$('.device_list > span').each(function(){
		width = $(this).width() > width ? $(this).width() : width;
	});

	$('.device_list > span').width(width);
}
function dev_list_sort() {
	$('.device_list').each(function(){
		var dev_list = $(this);
		var list = dev_list.find('span').sort(function(a, b){
			return $(a).data('ext') > $(b).data('ext') ? 1 : -1;
		})
		$.each(list, function(id, item){
			console.log(item);
			dev_list.append(item);
		})
	});
}

/**
 * limit the amount of devices a page can contain, based on the advanced settings
 * key PAGINGMAXPARTICIPANTS
 * @param string id - id of target
 *
 * @returns bool
 */
function dev_limit(id) {
	if (id == 'notselected_dev') {
		return true;
	}

	//if key isnt set, just return true
	if (typeof fpbx.conf.PAGINGMAXPARTICIPANTS == 'undefined') {
		return true;
	}
	return $('#selected_dev > span').length < fpbx.conf.PAGINGMAXPARTICIPANTS;
}

$(document).ready(function(){
	$("#bnavgrid").bootstrapTable({
		method: 'get',
		url: 'ajax.php?module=paging&command=getJSON&jdata=grid',
		cache: false,
		striped: false,
		showColumns: false,
		columns: [
			{
				title: _("Page Groups"),
				field: 'page_group',
				formatter: bnLinkFormatter,
			}
			]
	});
});

function linkFormatter(value){
	html = '<a href="?display=paging&view=form&extdisplay='+value+'"><i class="fa fa-pencil"></i>&nbsp;</a>';
	html += '<a href="?display=paging&action=delete&extdisplay='+value+'" class="delAction"><i class="fa fa-trash"></i>&nbsp;</a>';
	return html;
}
function bnLinkFormatter(value){
	html = '<a href="?display=paging&view=form&extdisplay='+value+'"><i class="fa fa-pencil"></i>&nbsp;'+value+'</a>';
	return html;
}
function defaultCheck(val){
	return val;
}

$('#pagegrid').bootstrapTable({
	onCheck: function(row){
		$.get('ajax.php?module=paging&command=setDefault&ext='+row.page_group,function(data,status){console.log(data)});
	},
});

$('#pagelist').multiselect({
		enableFiltering: true,
		includeSelectAllOption: true,
		enableCaseInsensitiveFiltering: true
});
