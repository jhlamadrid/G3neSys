//función para colocar dataTable la lista de usuarios
  $('#lista_usuarios').DataTable({
    bFilter: true,
    bInfo: false,
    "ordering": false,
    "lengthMenu": [[10, 20, 50, 100, -1],[10, 20, 50, 100, "Todos"]]
  });
