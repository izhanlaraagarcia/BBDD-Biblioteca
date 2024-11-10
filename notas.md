1. Configuracion bbdd
Error: 
Warning: mysqli::__construct(): php_network_getaddresses: getaddrinfo for server failed: Host desconocido. in C:\xampp\htdocs\biblioteca\UF3\controlador\conexion.php on line 10

Fatal error: Uncaught mysqli_sql_exception: php_network_getaddresses: getaddrinfo for server failed: Host desconocido. in C:\xampp\htdocs\biblioteca\UF3\controlador\conexion.php:10 Stack trace: #0 C:\xampp\htdocs\biblioteca\UF3\controlador\conexion.php(10): mysqli->__construct('server', 'user', Object(SensitiveParameterValue), 'bd') #1 C:\xampp\htdocs\biblioteca\UF3\controlador\conexion.php(23): BibliotecaBD::conexionBD() #2 C:\xampp\htdocs\biblioteca\UF3\sesiones\confirmarUsuario.php(42): BibliotecaBD::consultarInsertar('INSERT INTO usu...') #3 {main} thrown in C:\xampp\htdocs\biblioteca\UF3\controlador\conexion.php on line 10



Done
2. 
Crear usuario
confirmar datos(falta configurar la bbdd)
cancelar datos, 
Mensaje de error listo


## Falta
falta configurar la conexion a la base de datos (revisar puertos para poder iniciar mysql desde xamp)
Sí el usuario que accede es el admin, se cargará el  panel de control del ERP 
LibroSphere. 
o El  enlace  Gestión  de  Clientes  dará  acceso  a  un  listado  de  todos  los 
clientes,  en  el  listado  incluiremos  botones  para  poder  actualizar  los 
datos de un cliente o eliminar a un cliente. 
o  El  enlace  Gestión  de  Pedidos  dará  acceso  a  un  listado  de  todos  los 
clientes,  en  el  listado  incluiremos  botones  para  poder  actualizar  los 
datos de un pedido o eliminar un pedido. 
o El enlace Gestión de Libros no será funcional 
         
 
- Sí el usuario que accede no es el administrador se cargarán los libros cómo en 
la UF2. 
o En este caso el botón “Comprar” nos llevara a un formulario para hacer 
el pedido el formulario debe cargar de forma dinámica el titulo del libro, 
el isbn del libro, la fecha de compra y el usuario de la sesión activa que 
realiza el pedido.  
o En  caso  de  confirmación  el  formulario  ingresará  los  datos  en  la  tabla 
pedidos. Confirmará el pedido con la frase “Pedido realizado” y habrá 
un enlace para volver al listado de libros. 