# Descuento de Cuota de Alta en WooCommerce

Este plugin personalizado de WooCommerce permite aplicar un descuento del 100% en la cuota de alta (`sign-up fee`) a ciertos usuarios, según una lista de correos electrónicos almacenada en un archivo CSV.

## Requisitos

- WordPress con WooCommerce instalado.
- Un archivo CSV llamado `usuarios.csv` que contiene los correos electrónicos de los usuarios que deben recibir el descuento, ubicado en una carpeta llamada `usuarios_activos` dentro del tema activo.

## Instalación

1. **Ubicación del Archivo CSV:**
   - Asegúrate de tener un archivo CSV llamado `usuarios.csv` en la carpeta `/wp-content/themes/tu-tema/usuarios_activos/`.
   - El archivo CSV debe tener una estructura simple con los correos electrónicos de los usuarios en la primera columna. La primera fila puede ser un encabezado.

2. **Agregar el Código Personalizado:**
   - Abre el archivo `functions.php` de tu tema activo ubicado en `/wp-content/themes/tu-tema/functions.php`.
   - Copia y pega el código PHP proporcionado en este archivo al final del mismo.

## Configuración

1. **Verificar el Nombre de la Cuota de Alta:**
   - Asegúrate de que el nombre de la cuota de alta en tu WooCommerce coincida con el valor de `$nombre_cuota` en el código. Por defecto, está configurado como `'Sign-up Fee'`. Si es diferente, cambia este valor en el código.

2. **Modificar el Archivo CSV:**
   - Añade o elimina correos electrónicos en el archivo `usuarios.csv` según sea necesario. Asegúrate de que los correos electrónicos estén bien formateados.

## Uso

- Cuando un usuario registrado inicia sesión y agrega un producto con una cuota de alta al carrito, el plugin verificará si su correo electrónico está en la lista del archivo CSV.
- Si el correo electrónico del usuario está en la lista, el plugin aplicará un descuento del 100% a la cuota de alta.
- Si el correo electrónico del usuario **NO** está en la lista, el precio de la cuota de alta se mantendrá como se configuró originalmente en WooCommerce.

## Notas de Desarrollo

- **Sanitización y Validación:** Se aplica sanitización y validación tanto al leer el archivo CSV como al comprobar el correo electrónico del usuario para evitar errores y posibles problemas de seguridad.
- **Filtro de Total de Carrito:** El filtro `woocommerce_cart_calculate_fees` se utiliza para aplicar los cambios en las cuotas del carrito.
- **Posibles Ajustes:** Si cambias el nombre de la cuota de alta o los detalles del archivo CSV, asegúrate de actualizar el código en `functions.php`.

## Mantenimiento

- Revisa el archivo `usuarios.csv` regularmente para mantener actualizada la lista de usuarios que deben recibir el descuento.
- Asegúrate de que WooCommerce y WordPress estén actualizados para evitar posibles incompatibilidades.

## Troubleshooting

- **El descuento no se aplica:** Asegúrate de que el nombre de la cuota de alta en WooCommerce coincide con el nombre en el código (`$nombre_cuota`).
- **Errores en el CSV:** Verifica que todos los correos electrónicos en `usuarios.csv` estén correctamente formateados.
- **Revisar los registros de errores:** Si estás experimentando problemas, revisa el archivo de registros de errores de WordPress para obtener más detalles. Este archivo generalmente se encuentra en `/wp-content/debug.log` si el modo de depuración está habilitado en `wp-config.php`.

