(function($){
$(document).ready(function(){
///////////////////////

var slug = window.location.hash.toString();
if (slug.length) {
  slug = slug.slice(1);
  var url = $('#demo-links a[slug='+slug+']').attr('href');
  $('#demo-frame-wrapper').load(url);
} else {
  slug = 'default';
}

$('#demo-links a').each(function(){
  $(this).data('slug', $(this).attr('slug'))
    .bind('click', function(event){
      $('#demo-frame-wrapper').load($(this).attr('href'));
      $(this).parent().find('a').removeAttr('class');
      $(this).addClass('active');
      window.location = window.location.pathname+"#"+$(this).data('slug');
      return false;
    });
  if (slug === $(this).data('slug')) {
    $(this).addClass('active');
  }
});

$('#comp_menu a').each(function(i){
  if (i === 0) {
    $(this).addClass('active');
  }
  $(this).bind('click', function(e){
    $(this).parents('#comp_menu').find('a').removeAttr('class');
    $(this).addClass('active');
    $('#comp_all>div').hide();
    $($(this).attr('href')).show();
    return false;
  });
});

$('tr.tab-row-head td:first-child').bind('click', function(){
  var td_cont = $(this).parent().next().find('td');
  if(td_cont.is(':hidden')) {
    td_cont.show();
    $(this).find('span').addClass('show-cont');
  } else {
    td_cont.hide();
    $(this).find('span').removeClass('show-cont');
  }
});

$('span.show-all').bind('click', function(){
  $(this).parent('div').
    find('tr.tab-row-cont td').show().end().
    find('span.tab-row-name-icon').addClass('show-cont').end().
    find('span.hide-all').show();
  $(this).hide();
});

$('span.hide-all').bind('click', function(){
  $(this).parent('div').find('tr.tab-row-cont td').hide().end().
    find('span.tab-row-name-icon').removeClass('show-cont').end().
    find('span.show-all').show();
  $(this).hide();
});

$('#dialog_html').dialog({autoOpen: false, modal: true, width: 600, position: ['center', 70]});

$('a.value-type').bind('click', function(e){
  e.preventDefault();
  $('#dialog_html').dialog('option', 'title', $(this).text());
  $('#dialog_html').empty();
  $('#dialog_html').load(this.href);
  $('#dialog_html').dialog('open');
});

$('#depends li:has(span)').bind('mouseover', function(){
    $('<div>').addClass('hint').text($(this).find('span').text()).appendTo('#depends');
  }).bind('mouseout', function(){
    $('#depends .hint').remove();
});

$('#show-code-popup').dialog({
    autoOpen: false,
    modal: true,
    width: '90%',
    height: '600',
    position: ['5%', '5%']
});

$('#demo').bind('click', function(e){
  if ($(e.target).attr('id') != 'show-code') {
    return true;
  }
  $('#pre-code').html();
  $('#show-code-popup').empty();
  $('#show-code-popup').html($('#pre-code').html());
  $('#show-code-popup').dialog('open');
  e.preventDefault();
});

///////////////////////////
});
})(jQuery);

