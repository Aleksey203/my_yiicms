$(document).ready(function(){


	//БЫСТРОЕ РЕДАКТИРОВАНИЕ
	$(".items td.post").live('dblclick',function(){
		sendRequest = true;
		var td = $(this);
		if (!td.has('input').length) {
			var m = td.closest('table').data('module'),
				id = td.parent('tr').data('id'),
				width = td.width(),
				name = td.attr('name'),
				value = td.html();
			//td.width(width).html('<input value="'+value.replace('"',"&quot;")+'" />').find('input').focus().width(width-6).data('value',value);
            var i = td.width(width).html('<input value="'+value.replace(/["]/g,'&quot;')+'" />').find('input').focus().width(width-6).data('value',value).get(0);
            i.setSelectionRange && i.setSelectionRange(value.length,value.length);
		}
	});
	$('.items td input').live('keydown', function(e) {
		var i = $(this);
		//был нажат Enter или Tab
		if (e.keyCode==13 || e.keyCode==9) {
			sendRequest = false;
			e.preventDefault();
			var td = i.closest('td'),
				tr = td.closest('tr'),
				next = (e.keyCode==9) ? td.nextAll('.post').first() : tr.next().children().eq(td.index());
			applyChanges(i);
			next.dblclick();
		//был нажат Esc
		} else if (e.keyCode==27) {
			sendRequest = false;
			e.preventDefault();
			i.closest('td').html(i.data('value'));
		}
	});
	$('.items td input').live('blur', function() {
		if (sendRequest) applyChanges($(this));
	});
	//функция применения изменений для быстрого редактирования
	function applyChanges_old(i) {
		var m = i.closest('table').data('module'),
			td = i.closest('td'),
			name = td.attr('name'),
			id = i.closest('tr').data('id'),
			value = i.val(),
			oldVal = i.data('value');
		td.html(value);
		if (value!=oldVal) $.get("/admin.php", {'m':m,'u':'post','id':id,'name':name,'value':value});
	}

    //функция применения изменений для быстрого редактирования
    function applyChanges(i) {
        var url = i.closest('.grid-view').data('url'),
            id = i.closest('tr').data('id'),
            td = i.closest('td'),
            name = td.data('name'),
            value = i.val(),
            oldVal = i.data('value');
        td.html(value);
        if (value!=oldVal) $.get( "/admin.php/" + url + "/ajax", {'id':id,'name':name,'value':value} );
    }

	//ПЕРЕКЛЮЧАТЕЛИ
	$(".grid-view .active").live('click',function(){
        var a = $(this);
        $.ajax({
            url: a.attr('href'),
            success: function(){
                a.removeClass('active').addClass('non-active');
            }
        });
		return false;
	});

    $(".grid-view .non-active").live('click',function(){
        var a = $(this);
        $.ajax({
            url: a.attr('href'),
            success: function(){
                a.removeClass('non-active').addClass('active');
            }
        });
        return false;
    });

	//УДАЛЕНИЕ id
	$("table tr td .delete").live('click',function(){
		if (confirm('подтверите удаление!')) {
		var a = $(this),
			m = a.closest('table').data('module'),
			id = a.closest('tr').data('id');
			$.get("/admin.php", {'m':'_delete','type':'id','module':m,'id':id},
				function (data) {
					if (data) alert(data);
					else $('tr[data-id="'+id+'"]').remove();
				}
			);
		}
		return false;
	});

	/*  выделение + снять выделени + перемещение ********************************
	tr .level.normal - обычный список
	tr.select .level.select - выделный ряд
	tr .level.drop - ряд для вставки в него или перед ним
	//ВЫДЕЛЕНИЕ ================================================================
	$(".level.normal a").live('click',function(){
		$(this).parents('tr').addClass('select'); //добавляет клас селекта для родителя;
		var id=$(this).parents('tr').attr('name'); //id родитлея - нужно выделить всех детей
		all_child (id); //рекурсивно добавляется клас селекта для всех детей
		//нужно дабавить картинку всем кроме выделеных
		$('tr .level').removeClass('normal').addClass('drop'); //добавляет всем
		$('tr.select th').removeClass('drop').addClass('select'); //убирает у выделеных
		return false;
	});
	//СНЯТЬ ВЫДЕЛЕНИЕ ==========================================================
	$(".level.select a").live('click',function(){
		$('tr.select').removeClass('select'); //убирает select
		$('tr .level').removeClass('drop').removeClass('select').addClass('normal'); //очищаем все а делаем normal
		return false;
	});
	//ПЕРЕМЕЩЕНИЕ (ВСТАВКА) ====================================================
	$(".level.drop a").live('click',function(){
		var m = $('table').attr('name');					//модуль
		var colspan = parseInt($('.colspan').css('width'));	//общий colspan
		var id = $(this).parents('tr').attr('name');		//id родителя/нового соседа
		var select = $('tr.select:first').attr('name');		//id главного селекта
		var p_right = parseInt($('tr[name="'+id+'"] .level a.left').css('width'));		//правый отступ родителя
		var c_right = parseInt($('tr[name="'+select+'"] .level a.left').css('width'));	//правый отступ главного селекта
		var sum = p_right-c_right;	//разница между отступами - определяется куда будет сдвиг
		var movement = 0;			//смещение влево или вправо
		var move = '';
		//определение right или left нажали
		if ($(this).attr('class')=='right') {//смещение right - во внутрь в конец списка
			var last = last_child(id);
			if (last!=$('tr.select:last').attr('name')) {//если на том же месте то ненадо перемещать
				$('tr.select').insertAfter($('tr[name="'+last+'"]')); //переместить после последнего ребенка
			}
			var type= (Math.abs(sum+10)); //определение смещения
			if (sum<-1) move='left';
			if (sum>=0) move='right';
			var insert = 'parent';
			$('tr[name="'+select+'"]').attr('parent',id);//смена родителя у селекта
			$('tr[name="'+select+'"]').clearClass();
			$('tr[name="'+select+'"]').addClass('parent'+id);//смена родителя у селекта
		}
		else {//смещение left - перед
			$('tr.select').insertBefore($(this).parents('tr')); //переместить блоки перед
			var type= Math.abs(sum); //определение смещения
			if (sum<0) move='left';
			if (sum>0) move='right';
			var insert = 'prev';
			$('tr[name="'+select+'"]').attr('parent',$(this).parents('tr').attr('parent'));//смена родителя у селекта
		}
		//отправляем запрос серверу на изменение сортировки
		var getData = {'m':m,'u':'nested_sets','insert':insert,'id':id,'select':select};
		$('select.filter').each(function(){
			getData[this.name] = this.value;
		});
		$.get("/admin.php", getData, function(d){
			d && alert(d);
		});
		//двигаем
		if (move=='left') { //сдвиг влево - только в селектах
			shift ('tr.select .level .left',-type);
			shift ('tr.select .level .right',+type);
		}
		if (move=='right') { //сдвиг вправо - при сдвиге вправо нужно увеличивать общий колспан
			shift ('tr th.colspan',+type);			//увеличить общий колспан
			shift ('tr .level .right',+type);		//увеличить все правые (нужно все кроме селектов)
			shift ('tr.select .level .right',-type);//уменьшить выделенные правые
			shift ('tr.select .level .left',+type);	//увеличить выделенные левые
		}
		//снять выделение
		$('tr.select').removeClass('select'); //убирает select
		$('tr .level').removeClass('drop').removeClass('select').addClass('normal'); //очищаем все а делаем normal
		return false;
	});
*/

	//КОРЗИНА ==================================================================
	$('.product_list th a').live('click',function(){
		var i = $(this).parents('table').find("tr:last").data('i');
		i++;
		var content = $('#template_product').val();
		content = content.replace(/{i}/g,i);
		content = content.replace(/{[\w]*}/g,'');
		$(this).parents('table').append(content);
		return false;
	});
	$('.product_list td a').live('click',function(){
		$(this).parents('tr').remove();
		return false;
	});

	//ФАЙЛЫ ====================================================================
	$('.files.simple .plus').live('click',function(){
		var folder = $(this).closest('.files').attr('name');
		$(this).parents('.files').find('.file').append('<input name="'+folder+'[]" type="file" /><br />');
		return false;
	});
	$('.files.simple .delete').live('click',function(){
		var path = $(this).parent('li').find('.img').attr('href');
		var arr = path.split('/');
		if (confirm('подтверите удаление!!')) {
			$(this).parent('li').remove();
			$.get("/admin.php", {'m':'_delete','type':'file','module':arr[2],'id':arr[3],'key':arr[4],'file':arr[5]},
				function (data) {
					if(data) alert(data);
				}
			);
		}
		return false;
	});
	$('.files.mysql .del').live('click',function(){
		var path = $(this).parents('.files').find('.img a').attr('href');
		var arr = path.split('/');
		if (confirm('подтверите удаление!!')) {
			var files = $(this).closest('.files');
			files.find('.img a').remove();
			files.find('b').remove();
			files.find('input').val('');
			$(this).parent('div').remove();
			$.get("/admin.php", {'m':'_delete','type':'key','module':arr[2],'id':arr[3],'key':arr[4]},
				function (data) {
					if(data) alert(data);
				}
			);
		}
		return false;
	});

	//ПОИСК ====================================================================
	$('.icon.search').click(function(){
		var url = $(this).attr('href');
		var search = $(this).parent('div').find('input').val();
		top.location = url+search;
		return false;
	});



});

//функция для сдвига
function shift (selector,type) {
	$(selector).each(
		function(){
			var c = $(this).css('width');
			c = parseInt(c)+parseInt(type);
			var width = c+'px'
			$(this).css('width',width);
		}
	);
}
/*
//функция для выделения всех детей
function all_child (id) {
	$('tr[parent="'+id+'"]').each(
		function(){
			$(this).addClass('select');
			var i = $(this).attr('name');
			all_child (i);
		}
	);
}

//функция для выделения последнего ребенка
function last_child (id) {
	var i=0,ii=0;
	$('tr[parent="'+id+'"]').each(
		function(){
			i = $(this).attr('name');
			ii =  last_child (i);
		}
	);
	if (ii>0) return (ii);
	if (i>0) return (i);
	return (id);
}
*/
//удаление
function del(type,module,id,key,file) {
	var message;
	if (type=='key') message = 'удалить файл и запись о нём?';
	if (type=='file') message = 'удалить файл?';
	if (confirm(message)) {
		$.get("/admin.php", {type:type, m:'_delete', module:module, id:id, key:key, file:file }, function(data){
			alert(data);
		})
		if (type=='key') {
			alert('1');
			$(this).parents('.files').find('.img a').remove();
			$(this).parent('div').remove();
		}
		//$('#file'+key).hide();
	}
	return false;
}

function get_href (str) {
	var arr = Array();
	arr = str.toString().split('#'.toString() );
	return arr[1];
}

/*

hs.lang = {
	cssDirection: 'ltr',
	loadingText : 'Загрузка...',
	loadingTitle : 'Нажмите для отмены',
	focusTitle : 'Нажмите, чтобы вынести на передний план',
	fullExpandTitle : 'Увеличить до реального размера (f)',
	creditsText : 'Powered by <i>Highslide JS</i>',
	creditsTitle : 'Go to the Highslide JS homepage',
	previousText : 'Предыдущее',
	nextText : 'Следующее',
	moveText : 'Передвинуть',
	closeText : 'Закрыть',
	closeTitle : 'Закрыть (esc)',
	resizeTitle : 'Изменить размер',
	playText : 'Слайдшоу',
	playTitle : 'Слайдшоу (пробел)',
	pauseText : 'Пауза',
	pauseTitle : 'Пауза (пробел)',
	previousTitle : 'Предыдущее (стрелка влево)',
	nextTitle : 'Следующее (стрелка вправо)',
	moveTitle : 'Передвинуть',
	fullExpandText : '1:1',
	number: 'Изображение %1 из %2',
	restoreTitle : 'Нажмите для закрытия изображения, нажмите и передвиньте курсор для перемещения. Используйте стрелки для следующего или предыдущего изображения.'
},

hs.graphicsDir = '/plugins/highslide/graphics/';
hs.align = 'center';
hs.transitions = ['expand', 'crossfade'];
hs.outlineType = 'rounded-black';
hs.wrapperClassName = 'dark borderless controls-in-heading';
hs.fadeInOut = true;
hs.showCredits = false;
hs.dimmingOpacity = 0.75;
hs.allowMultipleInstances = false;
hs.headingEval = 'this.a.title';

if (hs.addSlideshow) {
	hs.addSlideshow({
		interval: 3000,
		repeat: true,
		useControls: true,
		fixedControls: true,
		overlayOptions: {
			opacity: .75,
			position: 'bottom center',
			hideOnMouseOut: true
		}
	});
}

*/
