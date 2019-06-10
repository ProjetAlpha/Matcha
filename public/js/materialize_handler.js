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
  var elems = document.querySelectorAll('.collapsible');
  var instances = M.Collapsible.init(elems, {
    inDuration: 350,
    outDuration: 350,
    accordion: false
  });
  var elems = document.querySelectorAll('.dropdown-trigger');
  var instances = M.Dropdown.init(elems, {
    inDuration: 350,
    outDuration: 350,
    coverTrigger: false,
    constrainWidth: false
  });
  //var elems = document.querySelectorAll('.materialboxed');
  //var instances = M.Materialbox.init(elems, options);
  //console.log(elems.chips());
});