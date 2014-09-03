
$('#shareme').sharrre({
  share: {
    googlePlus: true,
    facebook: true,
    twitter: true,
    digg: true,
    delicious: true,
    stumbleupon: true,
    linkedin: true,
    pinterest: true
  },
  buttons: {
    googlePlus: {size: 'tall', annotation:'bubble'},
    facebook: {layout: 'box_count'},
    twitter: {count: 'vertical'},
    digg: {type: 'DiggMedium'},
    delicious: {size: 'tall'},
    stumbleupon: {layout: '5'},
    linkedin: {counter: 'top'},
    pinterest: {media: 'http://sharrre.com/img/example1.png', description: $('#shareme').data('text'), layout: 'vertical'}
  },
  enableHover: false,
  enableCounter: false,
  enableTracking: true
});


