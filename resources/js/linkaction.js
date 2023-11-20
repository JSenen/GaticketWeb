
   // Obtener los elementos de los enlaces por su ID
   var resolverLink = document.getElementById('resolver-link');
   var resueltoLink = document.getElementById('resuelto-link');
 
   // Agregar un evento de clic a cada enlace
   resolverLink.addEventListener('click', function(event) {
     event.preventDefault(); // Prevenir el comportamiento predeterminado del enlace
     ejecutarAccion('resolver');
   });
 
   resueltoLink.addEventListener('click', function(event) {
     event.preventDefault(); // Prevenir el comportamiento predeterminado del enlace
     ejecutarAccion('resuelto');
   });
 
   // Función para ejecutar la acción deseada
   function ejecutarAccion(accion) {
     // Realizar la solicitud AJAX POST al archivo PHP
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../model/linkaction_model.php', true);
     xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
     xhr.onreadystatechange = function() {
       if (xhr.readyState === 4 && xhr.status === 200) {
         // Se ha completado la solicitud y se ha obtenido una respuesta válida
         console.log(xhr.responseText); // Puedes hacer algo con la respuesta aquí
       }
     };
     xhr.send('accion=' + accion);
   }