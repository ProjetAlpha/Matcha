document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.sidenav');
  var instances = M.Sidenav.init(elems, {
    inDuration: 350,
    outDuration: 350,
    edge: 'left'
  });
  var elems = document.querySelectorAll('select');
  var instances = M.FormSelect.init(elems, {});

  var elems = document.querySelectorAll('.collapsible');
  var instances = M.Collapsible.init(elems, {
    inDuration: 350,
    outDuration: 350
  });

  //console.log(elems.chips());
});